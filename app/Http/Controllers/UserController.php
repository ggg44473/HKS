<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Objective;
use App\Charts\SampleChart;
use App\Http\Requests\ObjectiveRequest;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, User $user)
    {
        $okrs = [];
        $colors = ['#06d6a0','#ef476f','#ffd166','#6eeb83','#f7b32b','#fcf6b1','#a9e5bb','#59c3c3','#d81159'];
        
        #::query 開始查詢該模型
        $builder = Objective::query()->where('model_id','=',$user->id);
        #判斷搜索是否為空        
        if ($search = $request->input('search', '')) { 
            #定義模糊查詢                
            $like = '%' . $search . '%';                                           
            $builder->where(function ($query) use ($like) {                         
                    $query->where('title', 'like', $like)   #查詢Objective目標
                        #第一個參數是模型關聯的方法名 , 第二個參數繼承上一步的query , 第三個參數使用模糊查詢字
                        ->orWhereHas('keyresults', function ($query) use ($like) {        
                            $query->where('title', 'like', $like);           
                        });
                });
        }
        #判斷起始日期搜索是否為空        
        if ($search = $request->input('st_date', '')) {                                     
            $builder->where(function ($query) use ($search) {                         
                    $query->where('started_at', '>=', $search);
                });
        }
        
        #判斷終點日期搜索是否為空        
        if ($search = $request->input('fin_date', '')) {                                     
            $builder->where(function ($query) use ($search) {                         
                    $query->where('finished_at', '<=', $search);
                });
        }
        #判斷使用內建排序與否
        if ($order = $request->input('order', '')) { 
            #判斷value是以 _asc 或者 _desc 结尾來排序
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                #判斷是否為指定的接收的參數
                if (in_array($m[1], ['started_at', 'finished_at', 'updated_at'])) {   
                    #開始排序              
                    $builder->orderBy($m[1], $m[2]);   
                }
            }
        }
        #使用分頁(依照單頁O的筆數上限)
        $pages = $builder->paginate(5);    

        foreach ($pages as $obj) {
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
                $chart->dataset($data['kr_id'], 'line', $data['accomplish']);
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
            'pages' => $pages,
            'owner' => $user,
            'okrs' => $okrs,
            'colors' => $colors,
            'filters' => ['search' => $search, 'order' => $order],
        ];
        return view('user.okr', $data);
    }

    public function listOKR(User $user)
    {
        $now =  now()->toDateString();
        $colors = ['#06d6a0','#ef476f','#ffd166','#6eeb83','#f7b32b','#fcf6b1','#a9e5bb','#59c3c3','#d81159'];
        $okrs = [];
        $pages = $user->objectives()
        ->where('started_at', '<=', $now)
        ->where('finished_at', '>=', $now)        
        ->orderBy('finished_at')->paginate(5);
 
        foreach ($pages as $obj) {
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
                $chart->dataset($data['kr_id'], 'line', $data['accomplish']);
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
            'owner' => $user,
            'pages' => $pages,
            'okrs' => $okrs,
            'colors' => $colors,
        ];

        return view('user.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, User $user) {
        $user->addObjective($request);
        return redirect()->route('user.okr', $user->id);
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

        return view('user.settings', $data);
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

}
