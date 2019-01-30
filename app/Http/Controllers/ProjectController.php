<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Requests\ObjectiveRequest;
use App\User;
use App\Invitation;
use App\Permission;

class ProjectController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = auth()->user()->projects->where('isdone', false);
        foreach ($projects as $project) {
            $project['okrs'] = $project->getOkrsWithPage($request)['okrs'];
        }

        $projectDone = auth()->user()->projects->where('isdone', true);
        foreach ($projectDone as $project) {
            $project['okrs'] = $project->getOkrsWithPage($request)['okrs'];
        }
        $invitations = auth()->user()->invitation->where('model_type', Project::class);

        $data = [
            'projects' => $projects,
            'done' => $projectDone,
            'invitations' => $invitations
        ];
        return view('project.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr['name'] = $request->project_name;
        $attr['description'] = $request->project_description;
        $attr['company_id'] = auth()->user()->company_id;

        $project = Project::create($attr);
        $project->addAvatar($request);
        $project->users()->attach(auth()->user());
        $project->createPermission(1);

        return redirect()->route('project');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $attr['name'] = $request->project_name;
        $attr['description'] = $request->project_description;
        $project->update($attr);

        $project->addAvatar($request);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->users()->detach();
        $project->invitation()->delete();
        $project->delete();
        
        return redirect('project');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOKR(Request $request, Project $project)
    {
        $this->authorize('viewProject', $project);

        $okrsWithPage = $project->getOkrsWithPage($request);
        $project['okrs'] = $okrsWithPage['okrs'];

        $data = [
            'project' => $project,
            'pageInfo' => $okrsWithPage['pageInfo'],
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
        ];

        return view('project.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, Project $project)
    {
        $this->authorize('storeObjective', $project);

        $objective = $project->addObjective($request);
        return redirect()->to(url()->previous() . '#oid-' . $objective->id);
    }

    /**
     * 完成/取消專案
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function done(Project $project)
    {
        $this->authorize('done', $project);

        $project->isdone = !$project->isdone;
        $project->save();

        if ($project->isdone) return redirect()->back();
        else return redirect()->to(url()->previous() . '#closeProject');
    }

    /**
     * Show the form for inviting a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function member(Request $request, Project $project)
    {
        $builder = $project->users();

        if ($request->input('order', '')) {
            
            # 排序
            if ($order = $request->input('order', '')) { 
                # 判斷value是以 _asc 或者 _desc 结尾來排序
                if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                    # 判斷是否為指定的接收的參數
                    if (in_array($m[1], ['name', 'email', 'position'])) {   
                        # 開始排序              
                        $builder->orderBy($m[1], $m[2]);
                    }
                }
            }
        } else {
            # 預設
            $builder->orderBy('id');
        }

        $pages = $builder->paginate(10)->appends([
            'order' => $request->input('order', ''),
        ]);

        $data = [
            'project' => $project,
            'members' => $pages,
        ];

        return view('project.member', $data);
    }

    /**
     * 發送邀請
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function inviteMember(Request $request, Project $project)
    {
        $this->authorize('memberSetting', $project);

        $project->sendInvitation($request);

        return redirect()->route('project.member', $project);
    }

    /**
     * 取消邀請
     *
     * @param  \App\Project $project
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function cancelInvite(Project $project, User $member)
    {
        $this->authorize('memberSetting', $project);

        $project->deleteInvitation($member);

        return redirect()->route('project.member', $project);
    }

    /**
     * 拒絕邀請
     *
     * @param  \App\Project $project
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function rejectInvite(Project $project, User $member)
    {
        $project->deleteInvitation($member);

        return redirect()->route('project');
    }

    /**
     * 同意邀請
     *
     * @param  \App\Project $project
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function agreeInvite(Project $project, User $member)
    {
        $project->deleteInvitation($member);
        $project->users()->attach($member);
        $project->createPermission(3);

        return redirect()->route('project');
    }

    /**
     * 回傳公司不屬於此專案的所有成員
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function search(Project $project)
    {
        $p_members = $project->users->toArray();
        $p_member_ids = array_column($p_members, 'id');

        $c_members = $project->company->users->toArray();
        $c_member_ids = array_column($c_members, 'id');

        $ids = array_diff($c_member_ids, $p_member_ids);
        $results = User::find($ids);

        return response()->json($results);
    }

    /**
     * Remove department_id and position from storage.
     *
     * @param  \App\Project $project
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function destroyMember(Project $project, User $member)
    {
        $this->authorize('memberSetting', $project);
        Permission::where(['user_id'=>$member->id,'model_type'=>Project::class,'model_id'=>$project->id])->delete();
        $project->users()->detach($member);

        return redirect()->route('project.member', $project);
    }
}
