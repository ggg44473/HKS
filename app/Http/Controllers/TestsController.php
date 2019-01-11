<?php

namespace App\Http\Controllers;

use App\User;
use App\Objective;
use App\KeyResultRecord;
use App\Charts\AchieveRates;
use App\Charts\SampleChart;

class TestsController extends Controller
{
    public function index()
    {
        // 一些練習圖表與取值方法筆記
        // $data = Objective::all()
        // ->groupBy('user_id')
        // ->map(function ($item) {
        //     return count($item);  
        // });
        // $today_users = User::whereDate('created_at', today())->count();
        // $yesterday_users = User::whereDate('created_at', today()->subDays(1))->count();
        // $users_2_days_ago = User::whereDate('created_at', today()->subDays(2))->count();
        
        // $chart = new AchieveRates;
        // $chart->labels(['2 days ago', 'Yesterday', 'Today']);
        // $chart->dataset('My dataset', 'line', [$users_2_days_ago, $yesterday_users, $today_users]);

        // return view('test', ['chart' => $chart]);
    }

    public function chart(Objective $objective)
    {
        $datas = $this->getRelatedKRrecord($objective);
        $chart = new SampleChart;
        $chart->subtitle('KR 達成率變化圖',22,'#216869',true, "'Helvetica Neue','Helvetica','Arial',sans-serif");
        foreach($datas as $data){
            $chart->labels($data['update']);
            $chart->dataset($data['kr_id'], 'line', $data['accomplish']);
        }
        return view('test', ['chart' => $chart]);
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


    // foreach($collection as $collect)
    // {
    //     $merged = collect($collect)->merge(['rate'=>$collect->accomplishRate()])->toArray();
} 