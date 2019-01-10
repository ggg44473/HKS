<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Objective;
 

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
            $okrs[] = [
                "objective" => $obj,
                "keyresults" => $obj->keyresults()->getResults(),
                "actions" => $obj->actions()->getResults(),
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
        
        $avatar = User::where('id','=',auth()->user()->id)->first();        
        
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
            
            $user->update(['avatar'=>$filename]);
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
