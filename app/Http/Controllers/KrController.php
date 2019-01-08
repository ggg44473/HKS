<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\KeyResultRequest;
use App\KeyResult;

class KrController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\KeyResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KeyResultRequest $request)
    {
        $attr['objective_id'] = $request->input('krs_owner');
        $attr['title'] = $request->input('krs_title');
        $attr['confidence'] = $request->input('krs_conf');
        $attr['initial_value'] = $request->input('krs_init');
        $attr['target_value'] = $request->input('krs_tar');
        $attr['current_value'] = $request->input('krs_now');
        $attr['weight'] = $request->input('krs_weight');

        KeyResult::create($attr);
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
     * @param  KeyResult $keyresult
     * @return \Illuminate\Http\Response
     */
    public function destroy(KeyResult $keyresult)
    {
        $keyresult->delete();
        return redirect()->route('user.okr', auth()->user()->id);
    }
}
