<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    protected $redirectTo = '/home';    
    
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('welcome');
    }
}
