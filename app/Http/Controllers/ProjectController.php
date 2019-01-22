<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Requests\ObjectiveRequest;
use App\User;
use App\ProjectUser;

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

        $data = [
            'projects' => $projects,
            'done' => $projectDone
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
     * @param  Project $project
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
     * @param  Project $project
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
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
    public function invite(Project $project)
    {
        $data = [
            'project' => $project,
        ];

        return view('project.invite', $data);
    }

    /**
     * 回傳公司所有成員
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = User::where('company_id', auth()->user()->company_id)->get();

        return response()->json($results);
    }

    /**
     * Store a newly created member in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMember(Request $request, Project $project)
    {
        $userIds = preg_split("/[,]+/", $request->invite);
        foreach ($userIds as $userId) {
            ProjectUser::create(['project_id' => $project->id, 'user_id' => $userId]);
        }

        return redirect()->route('project.invite', $project);
    }

    /**
     * Remove company_id, department_id and position from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyMember(Project $project, User $member)
    {
        ProjectUser::where([['project_id', $project->id], ['user_id', $member->id]])->delete();

        return redirect()->route('project.invite', $project);
    }
}
