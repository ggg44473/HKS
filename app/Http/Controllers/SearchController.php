<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
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
    public function index(Request $request)
    {
        #判斷公司是否存在到要查詢
        $usersCount = 0;
        $projectsCount = 0;
        if (auth()->user()->company_id) {
            #判斷搜索是否為空        
            if ($search = $request->input('search', '')) {
                $company = Company::query()->where('id', '=', auth()->user()->company_id)->first();
                $usersBuilder = $company->users();
                $projectsBuilder = auth()->user()->projects();
            #定義模糊查詢                
                $like = '%' . $search . '%';

                $usersBuilder->where(function ($query) use ($like) {
                    $query->where('name', 'iLike', $like)
                        ->orWhere('email', 'iLike', $like)
                        ->orWhere('position', 'iLike', $like)
                        ->orWhereHas('department', function ($query) use ($like) {
                            $query->where('name', 'iLike', $like);
                        });
                   ;
                });
                $projectsBuilder->where(function ($query) use ($like) {
                    $query->where('name', 'iLike', $like)
                        ->orWhere('description', 'iLike', $like);
                });

                $usersCount = $usersBuilder->getResults()->count();
                $projectsCount = $projectsBuilder->getResults()->count();
            }
        }
        //     ->orWhere('email', 'like', $like)
        // #第一個參數是模型關聯的方法名 , 第二個參數繼承上一步的query , 第三個參數使用模糊查詢字
            // ->orWhereHas('keyresults', function ($query) use ($like) {
            //     $query->where('title', 'like', $like);
            // });
       
        $data = [
            'usersCount' => $usersCount,
            'projectsCount' => $projectsCount,
            'members' => $usersCount != 0 ? $usersBuilder->getResults() : 'false',
            'projects' => $projectsCount != 0 ? $projectsBuilder->getResults() : 'false',
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
