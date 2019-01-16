<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Company;
use App\User;
use App\Objective;
use App\Charts\SampleChart;
use App\Http\Requests\ObjectiveRequest;
use App\Department;

class CompanyController extends Controller
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
    public function listOKR()
    {
        $company = Company::where('id',auth()->user()->company_id)->first();
        $colors = ['#06d6a0','#ef476f','#ffd166','#6eeb83','#f7b32b','#fcf6b1','#a9e5bb','#59c3c3','#d81159'];
        $okrs = [];

        $objectives = $company->objectives()->get();
        foreach ($objectives as $obj) {
            //  單一OKR圖表
            $datas = $obj->getRelatedKrRecord();
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
            'owner' => $company,
            'okrs' => $okrs,
            'colors' => $colors,
        ];

        return view('organization.company.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, Company $company)
    {
        $company->addObjective($request);
        return redirect()->route('company.okr');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $attr['name'] = $request->input('company_name');
        $attr['description'] = $request->input('company_description');
        $attr['user_id'] = auth()->user()->id;
        $company = Company::create($attr);

        if($request->hasFile('company_img_upload')){
            $file = $request->file('company_img_upload');
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/company/'.$company->id, $filename);
            $company->update(['avatar'=>'/storage/company/'.$company->id.'/'.$filename]);
        }
        
        User::where('id',auth()->user()->id)->update(['company_id' => $company->id]);

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
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company = auth()->user()->company()->first();
        $data = [
            'company' => $company,
        ];
        return view('organization.company.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $company = Company::find(auth()->user()->company_id);
        $attr['name'] = $request->company_name;
        $attr['description'] = $request->company_description;
        $company->update($attr);

        if($request->hasFile('company_img_upload')){
            $file = $request->file('company_img_upload');
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/company/'.$company->id, $filename);
            $company->update(['avatar'=>'/storage/company/'.$company->id.'/'.$filename]);
        }

        return redirect()->route('organization');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $users = User::where('company_id',auth()->user()->company_id)->get();
        foreach ($users as $user) {
            $user->update(['company_id'=>null, 'department_id'=>null]);            
        }
        auth()->user()->company()->first()->delete();

        return redirect('organization');
    }

    /**
     * Show the form for inviting a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function invite()
    {
        return view('organization.inviteMember');
    }

    /**
     * 搜尋使用者名稱或信箱
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = '%' . $request->keywords . '%';
        $results = User::where('email', 'like', $keyword)->orWhere('name', 'like', $keyword)->get();

        return response()->json($results);
    }

    function getRelatedKrRecord(Objective $objective)
    {
        //宣告
        $merged=collect();
        $kr_record=array();
        $kr_record_array=array();
        // 抓出相關KR歷史紀錄
        $collections = $objective->keyResultRecords()->getResults()->groupBy('key_results_id');
        // 算出達成率並存成array(KR_ID，ACV_RATE，UPDATE)
        foreach($collections as $collection){
            // 需要達成率合併
            foreach($collection as $collect){
                $merged->push(collect($collect)->merge(['rate'=>$collect->accomplishRate()])->toArray());
            }
            $kr_id = $merged->pluck('key_results_id')->first();
            $kr_date = $merged->pluck('updated_at')->all();
            $kr_acop = $merged->pluck('history_confidence')->all();
            $kr_conf = $merged->pluck('rate')->all();
            $merged=collect();
            $kr_record=array('kr_id'=>$kr_id,'update'=>$kr_date,'confidence'=>$kr_acop,'accomplish'=>$kr_conf);            
            array_push($kr_record_array,$kr_record);
        }      
        return $kr_record_array;
    }
}
