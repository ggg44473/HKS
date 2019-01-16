<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Objective;
use App\Charts\SampleChart;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $okrs = [];
        
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
       
        #使用分頁(依照單頁O的筆數上限)
        $pages = $builder->paginate(5)->appends(['search' =>$request->input('search', '')]);

        foreach ($pages as $obj) {
            #打包單張OKR
            $okrs[] = [
                "objective" => $obj,
                "keyresults" => $obj->keyresults()->getResults(),
                "actions" => $obj->actions()->getResults(),
                "chart" => $obj->getChart(),
            ];
        }

        $data = [
            'pages' => $pages,
            'owner' => $user,
            'okrs' => $okrs,
        ];
        return view('search', $data);
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
