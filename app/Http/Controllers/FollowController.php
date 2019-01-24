<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;

class FollowController extends Controller
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
        return view('follow.index');
    }

    public function follow($type, $owner)
    {
        $attr['user_id'] = auth()->user()->id;
        $attr['model_type'] = $type;
        $attr['model_id'] =  $owner;
        Follow::create($attr);

        return redirect()->back();
    }

    public function cancel($type, $owner)
    {
        $attr['user_id'] = auth()->user()->id;
        $attr['model_type'] = $type;
        $attr['model_id'] =  $owner;
        Follow::where($attr)->delete();

        return redirect()->back();
    }
}
