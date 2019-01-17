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
        $attr['name'] = $request->name;
        $user->update($attr);
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
