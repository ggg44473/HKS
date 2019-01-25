<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\Objective;
use App\Http\Requests\ObjectiveRequest;
use App\Charts\SampleChart;
use App\User;

class DepartmentController extends Controller
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
    public function listOKR(Request $request, Department $department)
    {
        $okrsWithPage = $department->getOkrsWithPage($request);
        $department['okrs'] = $department->getOkrsWithPage($request)['okrs'];

        $data = [
            'user' => auth()->user(),
            'department' => $department,
            'pageInfo' => $okrsWithPage['pageInfo'],
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
        ];

        return view('organization.department.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, Department $department)
    {
        $objective = $department->addObjective($request);
        return redirect()->to(url()->previous() . '#oid-' . $objective->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Department $department)
    {
        $data['parent'] = $department->parent;
        $department['okrs'] = $department->getOkrsWithPage($request)['okrs'];
        $data['department'] = $department;
        $data['children'] = $department->children;
            
        return view('organization.department.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRoot()
    {
        $company = Company::where('id', auth()->user()->company_id)->first();
        $departments = Department::where('company_id', $company->id)->get();
        $data = [
            'parent' => $company,
            'self' => '',
            'children' => $departments,
        ];

        return view('organization.department.create', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Department $department)
    {
        $data = [
            'parent' => '',
            'self' => $department,
            'children' => $department->children,
        ];

        return view('organization.department.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr['name'] = $request->department_name;
        $attr['description'] = $request->department_description;
        $attr['user_id'] = auth()->user()->id;
        $attr['company_id'] = auth()->user()->company_id;
        if (substr($request->department_parent, 0, 4) == "self" || substr($request->department_parent, 0, 10) === "department") {
            $attr['parent_department_id'] = preg_replace('/[^\d]/', '', $request->department_parent);
        }
        $department = Department::create($attr);

        $department->addAvatar($request);

        return redirect()->route('company.index');
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
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('organization.department.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $attr['name'] = $request->department_name;
        $attr['description'] = $request->department_description;
        $department->update($attr);

        $department->addAvatar($request);

        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        foreach ($department->users as $user) {
            $user->update(['department_id' => null]);
        }
        $department->delete();

        return redirect()->route('company.index');
    }

    /**
     * Show the form for inviting a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function memberSetting(Department $department)
    {
        $data = [
            'department'=>$department,
            'members'=>$department->users,
        ];

        return view('organization.department.memberSetting', $data);
    }

    /**
     * 回傳同公司、無部門的所有人
     *
     * @param  \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function search(Company $company)
    {
        $results = User::where([['company_id', $company->id],['department_id', null]])->get();

        return response()->json($results);
    }

    /**
     * Store a newly created member in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMember(Request $request, Department $department)
    {
        $userIds = preg_split("/[,]+/", $request->invite);
        foreach($userIds as $userId){
            $user = User::where('id', $userId)->first();
            if($user->company_id == $department->company_id){
                $user->update(['department_id' => $department->id]);
            }
        }
        
        return redirect()->route('department.member.setting', $department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMember(Request $request, Department $department)
    {
        foreach ($department->users as $member) {
            $attr['department_id'] = $request->input('department' . $member->id);
            $attr['position'] = $request->input('position' . $member->id);
            $member->update($attr);
        }

        return redirect()->route('department.member.setting', $department);
    }
    
    /**
     * Remove company_id, department_id and position from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyMember(Department $department, User $member)
    {
        $member->update(['department_id'=>null, 'position'=>null]);

        return redirect()->route('department.member.setting', $department);
    }

    /**
     * Display a listing of the member.
     *
     * @return \Illuminate\Http\Response
     */
    public function member(Request $request, Department $department)
    {
        $department['okrs'] = $department->getOkrsWithPage($request)['okrs'];

        $data = [
            'department' => $department,
        ];

        return view('organization.department.member', $data);
    }
}
