<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\Objective;

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
        $departments = Department::where('id', $departmentId)->first();
        $colors = ['#06d6a0','#ef476f','#ffd166','#6eeb83','#f7b32b','#fcf6b1','#a9e5bb','#59c3c3','#d81159'];
        $okrs = [];

        $objectives = Objective::where(['owner_type'=>'department','owner_id' => $departmentId])->orderBy('finished_at')->get();
        foreach ($objectives as $obj) {
            //  單一OKR圖表
            $datas = $obj->getRelatedKRrecord();
            $chart = new SampleChart;
            if(!$datas){
                $chart->labels([0]);
                $chart->dataset('None', 'line',[0]);
            }
            $chart->title('KR 達成率變化圖',22,'#216869',true, "'Helvetica Neue','Helvetica','Arial',sans-serif");
            foreach($datas as $data){
                $chart->labels($data['update']);
                $chart->dataset($data['kr_id'], 'bar', $data['accomplish']);
            }

            // 打包單張OKR
            $okrs[] = [
                "objective" => $obj,
                "keyresults" => $obj->keyresults()->getResults(),
                "actions" => $obj->actions()->getResults(),
                "chart" => $chart,
            ];
        }
        
        $data = [
            'user' => auth()->user(),
            'department' => $departments,
            'okrs' => $okrs,
            'colors' => $colors,
        ];

        return view('organization.department.okr', $data);
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
        if(auth()->user()->company_id > 0){
            $company = Company::where('id',auth()->user()->company_id)->first();
            $department = Department::where('company_id',$company->id)->get();
            $data=[
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
        $attr['admin'] = auth()->user()->id;
        $attr['company_id'] = auth()->user()->company_id;
        if( substr( $request->department_parent, 0, 10 ) === "department"){
            $attr['parent_department_id'] = preg_replace('/[^\d]/','',$request->department_parent);
        }
        $department = Department::create($attr);

        if($request->hasFile('department_img_upload')){
            $file = $request->file('department_img_upload');
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/department/'.$department->id, $filename);
            $department->update(['image'=>'/storage/department/'.$department->id.'/'.$filename]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
