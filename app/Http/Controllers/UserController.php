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

        $objectives = $user->objectives()->orderBy('finished_at')->get();
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
            'user' => $user,
            'okrs' => $okrs,
            'colors' => $colors,
        ];

        return view('okrs.index', $data);
    }

    public function storeObjective(ObjectiveRequest $request, User $user) {
        $user->addObjective($request);
        return redirect()->back();
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
