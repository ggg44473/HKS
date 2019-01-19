<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Requests\ObjectiveRequest;

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
        $projects = Project::all();
        foreach($projects as $project){
            $project['okrs'] = $project->getOkrsWithPage($request)['okrs'];
        }
        // dd($projects);
        
        $data = [
            'projects' => $projects,
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
}
