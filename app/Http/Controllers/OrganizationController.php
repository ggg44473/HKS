<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Department;

class OrganizationController extends Controller
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
        $data = [];
        if (auth()->user()->company_id > 0) {
            $data['company'] = Company::where('id', auth()->user()->company_id)->first();
            $departments = Department::where(['company_id' => auth()->user()->company_id, 'parent_department_id' => null])->get();
            $data['departments'] = $departments;
        }
        return view('organization.index', $data);
    }
}
