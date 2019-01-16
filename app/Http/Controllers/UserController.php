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

    public function listOKR(Request $request, User $user)
    {
        $now = now()->toDateString();
        $okrs = [];

        $pages = $user->objectives()
            ->where('started_at', '<=', $now)
            ->where('finished_at', '>=', $now)
            ->orderBy('finished_at')->paginate(5);
        $total = $pages->count();

        if ($request->input('st_date', '') || $request->input('fin_date', '')) {
            #::query 開始查詢該模型
            $builder = Objective::query()->where('model_id', '=', $user->id);
    
            #判斷起始日期搜索是否為空        
            if ($search = $request->input('st_date', '')) {
                $builder->where(function ($query) use ($search) {
                    $query->where('finished_at', '>=', $search);
                });
            }
            #判斷終點日期搜索是否為空        
            if ($search = $request->input('fin_date', '')) {
                $builder->where(function ($query) use ($search) {
                    $query->where('started_at', '<=', $search);
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
            #使用分頁(依照單頁O的筆數上限、利用append記錄搜尋資訊)
            $total = $builder->get()->count();
            $pages = $builder->paginate(5)
                ->appends([
                    'st_date' => $request->input('st_date', ''),
                    'fin_date' => $request->input('fin_date', ''),
                    'order' => $request->input('order', '')
                ]);

        }
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
            'owner' => $user,
            'pages' => $pages,
            'okrs' => $okrs,
            'total' => $total,
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
        ];
        return view('user.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, User $user)
    {
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
        if ($user->id != auth()->user()->id) return redirect()->to(url()->previous());

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
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/avatar/' . auth()->user()->id, $filename);

            $user->update(['avatar' => '/storage/avatar/' . auth()->user()->id . '/' . $filename]);
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
