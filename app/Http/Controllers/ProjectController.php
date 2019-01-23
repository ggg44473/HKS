<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Requests\ObjectiveRequest;
use App\User;
use App\ProjectUser;
use App\Invitation;

class ProjectController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::where('isdone', false)->get();
        foreach ($projects as $project) {
            $project['okrs'] = $project->getOkrsWithPage($request)['okrs'];
        }

        $projectDone = Project::where('isdone', true)->get();
        foreach ($projectDone as $project) {
            $project['okrs'] = $project->getOkrsWithPage($request)['okrs'];
        }
        $invitations = auth()->user()->invitation->where('model_type', get_class($project));

        $data = [
            'projects' => $projects,
            'done' => $projectDone,
            'invitations' => $invitations
        ];
        return view('project.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
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
        $attr['user_id'] = auth()->user()->id;

        $project = Project::create($attr);
        $project->addAvatar($request);
        ProjectUser::create(['project_id' => $project->id, 'user_id' => auth()->user()->id]);

        return redirect()->route('project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('project.edit', ['project' => $project]);
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

        return redirect()->route('project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        ProjectUser::where('project_id', $project->id)->delete();
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
        $okrsWithPage = $project->getOkrsWithPage($request);

        $data = [
            'user' => auth()->user(),
            'owner' => $project,
            'okrs' => $okrsWithPage['okrs'],
            'pageInfo' => $okrsWithPage['pageInfo'],
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
        ];

        return view('project.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, Project $project)
    {
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
        $project->isdone = !$project->isdone;
        $project->save();

        return redirect()->route('project');
    }

    /**
     * Show the form for inviting a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberSetting(Project $project)
    {
        $data = [
            'project' => $project,
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
        $project->sendInvitation($request);

        return redirect()->route('project.member.setting', $project);
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
        $project->deleteInvitation($member);

        return redirect()->route('project.member.setting', $project);
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
        ProjectUser::create(['project_id' => $project->id, 'user_id' => $member->id]);

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
        $results = User::where('company_id', $project->company->id)->get();

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
        ProjectUser::where([['project_id', $project->id], ['user_id', $member->id]])->delete();

        return redirect()->route('project.member.setting', $project);
    }
}
