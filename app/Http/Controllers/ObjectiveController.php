<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ObjectiveRequest;
use App\User;
use App\Objective;

class ObjectiveController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id','=',auth()->user()->id)->first();
        $data = [
            'user' => $user,
        ];
        return view('okrs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ObjectiveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObjectiveRequest $request)
    {
        $attr['user_id'] = auth()->user()->id;
        $attr['title'] = $request->input('obj_title');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        Objective::create($attr);

        return redirect()->route('user.okr', auth()->user()->id);
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
    public function edit(Objective $objective)
    {
        // $user = User::where('id','=',auth()->user()->id)->first();        
        // //使用者的krs
        // $data = [
        //     'user' => $user,
        //     'objective' => $objective,
        // ];
        // return view('okrs.edit_objective',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ObjectiveRequest $request, Objective $objective)
    {
        // $objAttr['title'] =  $request->input('obj_title');
        // $objAttr['started_at'] = $request->input('st_date');
        // $objAttr['finished_at'] = $request->input('fin_date');
        // $objective->update($objAttr);
       
        // return redirect()->route('user.okr', auth()->user()->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Objective $objective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objective $objective)
    {
        $objective->delete();
        return redirect()->route('user.okr', auth()->user()->id);
    }
}
