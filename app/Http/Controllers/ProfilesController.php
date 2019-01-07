<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Objective;

class ProfilesController extends Controller
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
    public function index(User $user)
    {
        $okrs = [];
        $objectives = Objective::where('user_id','=',auth()->user()->id)->orderBy('finished_at')->get();
        foreach ($objectives as $obj) {
            $okrs[] = [
                "objective" => $obj,
                "keyresults" => $obj->keyresults()->getResults(),
            ];
        }
        $user = User::where('id','=',auth()->user()->id)->first();
        $data = [
            'user' => $user,
            'okrs' => $okrs,
        ];
        return view('okrs.profile', $data);   
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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

        return redirect()->route('profile.index');
    }

    // /**
    //  * 取得storage目錄下的檔案
    //  *
    //  * @param Request $request
    //  * @return mixed
    //  */
    // public function get(Request $request)
    // {	
    //     $filename = $request->get('filename', '');
    //     $file = Storage::get($filename);
    //     return response($file, 200)->header('Content-Type', Storage::mimeType($filename));
    // }

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
