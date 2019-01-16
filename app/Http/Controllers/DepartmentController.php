<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\Objective;
use App\Http\Requests\ObjectiveRequest;
use App\Charts\SampleChart;
use App\User;

class DepartmentController extends Controller
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
    public function listOKR($departmentId)
    {
        $department = Department::where('id', $departmentId)->first();
        $okrs = [];

        $objectives = $department->objectives()->get();
        foreach ($objectives as $obj) {
            #打包單張OKR
            $okrs[] = [
                "objective" => $obj,
                "keyresults" => $obj->keyresults()->getResults(),
                "actions" => $obj->actions()->getResults(),
                "chart" => $obj->getChart(),
            ];
        }

        $data = [
            'user' => auth()->user(),
            'owner' => $department,
            'okrs' => $okrs,
        ];

        return view('organization.department.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, Department $department)
    {
        $department->addObjective($request);
        return redirect()->route('department.okr', $department->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'company' => '',
            'departments' => [],
        ];
        if (auth()->user()->company_id > 0) {
            $company = Company::where('id', auth()->user()->company_id)->first();
            $department = Department::where('company_id', $company->id)->get();
            $data = [
                'company' => $company,
                'departments' => $department,
            ];
        }

        return view('organization.department.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr['name'] = $request->input('department_name');
        $attr['description'] = $request->input('department_description');
        $attr['user_id'] = auth()->user()->id;
        $attr['company_id'] = auth()->user()->company_id;
        if (substr($request->department_parent, 0, 10) === "department") {
            $attr['parent_department_id'] = preg_replace('/[^\d]/', '', $request->department_parent);
        }
        $department = Department::create($attr);

        if ($request->hasFile('department_img_upload')) {
            $file = $request->file('department_img_upload');
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/department/' . $department->id, $filename);
            $department->update(['avatar' => '/storage/department/' . $department->id . '/' . $filename]);
        }

        return redirect()->route('organization');
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
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('organization.department.edit', ['department'=>$department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $attr['name'] = $request->department_name;
        $attr['description'] = $request->department_description;
        $department->update($attr);

        if($request->hasFile('department_img_upload')){
            $file = $request->file('department_img_upload');
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/department/'.$department->id, $filename);
            $department->update(['avatar'=>'/storage/department/'.$department->id.'/'.$filename]);
        }

        return redirect()->route('organization');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $users = User::where(['company_id'=>auth()->user()->company_id,'department_id'=>$department->id])->get();
        foreach ($users as $user) {
            $user->update(['department_id'=>null]);            
        }
        $department->delete();

        return redirect('organization');
    }
}
