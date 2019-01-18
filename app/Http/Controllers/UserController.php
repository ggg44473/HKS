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
        $okrsWithPage = $user->getOkrsWithPage($request);

        $data = [
            'owner' => $user,
            'okrs' => $okrsWithPage['okrs'],
            'pageInfo' => $okrsWithPage['pageInfo'],
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
        ];
        return view('user.okr', $data);
    }

    public function listAction(Request $request, User $user)
    {
        $builder = $user->actions();

        if ($request->input('order', '')) {

            #Action是否完成
            $builder->where('isdone', '=', $request->input('isdone', ''));
            
            #Action狀態
            $now = now()->toDateString();
            switch ($request->input('state', '')) {
                case 'now':
                    $builder->where('started_at', '<=', $now)
                        ->where('finished_at', '>=', $now);
                    break;
                case 'back':
                    $builder->where('finished_at', '<=', $now);
                    break;
                case 'future':
                    $builder->where('started_at', '>=', $now);
                    break;
            }
            
            #Action排序
            if ($order = $request->input('order', '')) { 
                # 判斷value是以 _asc 或者 _desc 结尾來排序
                if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                    # 判斷是否為指定的接收的參數
                    if (in_array($m[1], ['started_at', 'finished_at', 'priority'])) {   
                        # 開始排序              
                        $builder->orderBy($m[1], $m[2]);
                    }
                }
            }
        } else {
            #預設
            $now = now()->toDateString();
            $builder->where('started_at', '<=', $now)
                ->where('finished_at', '>=', $now)
                ->orderBy('finished_at');
        }
        $pages = $builder->paginate(10)->appends([
            'state' => $request->input('state', ''),
            'isdone' => $request->input('isdone', ''),
            'order' => $request->input('order', '')
        ]);

        $data = [
            'owner' => $user,
            'actions' => $pages,
            'pageInfo' => [
                'link' => $pages->render(),
                'totalItem' => $pages->total()
            ],
            'state' => $request->input('state', ''),
            'isdone' => $request->input('isdone', ''),
            'order' => $request->input('order', ''),
        ];
        return view('user.action', $data);
    }

    public function storeObjective(ObjectiveRequest $request, User $user)
    {
        $objective = $user->addObjective($request);
        return redirect()->to(url()->previous() . '#oid-' . $objective->id);
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
        $attr['name'] = $request->name;
        $user->update($attr);
        $user->addAvatar($request);

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
