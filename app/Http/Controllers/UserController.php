<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Objective;
use App\Charts\SampleChart;
 

class UserController extends Controller
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
    public function listOKR(User $user)
    {
        $colors = ['#06d6a0','#ef476f','#ffd166','#6eeb83','#f7b32b','#fcf6b1','#a9e5bb','#59c3c3','#d81159'];
        $okrs = [];

        $objectives = Objective::where('user_id','=',$user->id)->orderBy('finished_at')->get();
        foreach ($objectives as $obj) {
            //  單一OKR圖表
            $datas = $this->getRelatedKRrecord($obj);
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
            'user' => $user,
            'okrs' => $okrs,
            'colors' => $colors,
        ];

        return view('okrs.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings(User $user)
    {
        if($user->id != auth()->user()->id) return redirect()->to(url()->previous());
                
        $data = [
            'user' => $user,
        ];

        return view('okrs.settings', $data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $filename = date('YmdHis').'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/avatar/'.auth()->user()->id, $filename);
            
            $user->update(['avatar'=>'/storage/avatar/'.auth()->user()->id.'/'.$filename]);
        }

        return redirect()->route('user.settings', auth()->user()->id);
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

    function getRelatedKRrecord(Objective $objective)
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
