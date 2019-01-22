<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Company;
use App\User;
use App\Objective;
use App\Charts\SampleChart;
use App\Http\Requests\ObjectiveRequest;
use App\Department;

class CompanyController extends Controller
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
    public function listOKR(Request $request)
    {
        $company = Company::where('id', auth()->user()->company_id)->first();

        $okrsWithPage = $company->getOkrsWithPage($request);

        $data = [
            'user' => auth()->user(),
            'owner' => $company,
            'okrs' => $okrsWithPage['okrs'],
            'pageInfo' => $okrsWithPage['pageInfo'],
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
        ];

        return view('organization.company.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, Company $company)
    {
        $objective = $company->addObjective($request);
        return redirect()->to(url()->previous() . '#oid-' . $objective->id);
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
     * @param  App\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $attr['name'] = $request->input('company_name');
        $attr['description'] = $request->input('company_description');
        $attr['user_id'] = auth()->user()->id;
        $company = Company::create($attr);

        $company->addAvatar($request);

        User::where('id', auth()->user()->id)->update(['company_id' => $company->id]);

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
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company = auth()->user()->company()->first();
        $data = [
            'company' => $company,
        ];
        return view('organization.company.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $company = Company::find(auth()->user()->company_id);
        $attr['name'] = $request->company_name;
        $attr['description'] = $request->company_description;
        $company->update($attr);

        $company->addAvatar($request);

        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $users = User::where('company_id', auth()->user()->company_id)->get();
        foreach ($users as $user) {
            $user->update(['company_id' => null, 'department_id' => null]);
        }
        auth()->user()->company()->first()->delete();

        return redirect('company.index');
    }

    /**
     * Show the form for inviting a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function invite()
    {
            $data = [
                'members'=>User::where([['company_id',auth()->user()->company_id],['id','!=',auth()->user()->id]])->get(),
                'departments'=>Department::where('company_id',auth()->user()->company_id)->get(),
            ];

        return view('organization.inviteMember', $data);
    }

    /**
     * 搜尋使用者名稱或信箱
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        // $keyword = '%' . $request->keywords . '%';
        // $results = User::where('email', 'like', $keyword)->orWhere('name', 'like', $keyword)->get();
        $results = User::where('company_id', null)->get();

        return response()->json($results);
    }

    /**
     * Store a newly created member in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMember(Request $request)
    {
        $userIds = preg_split("/[,]+/", $request->invite);
        foreach($userIds as $userId){
            User::where('id', $userId)->update(['company_id' => auth()->user()->company_id]);
        }
        
        return redirect()->route('company.invite');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMember(Request $request)
    {
        $members = User::where('company_id',auth()->user()->company_id)->get();
        foreach ($members as $member) {
            $attr['department_id'] = $request->input('department' . $member->id);
            $attr['position'] = $request->input('position' . $member->id);
            $member->update($attr);
        }

        return redirect()->route('company.invite');
    }
    
    /**
     * Remove company_id, department_id and position from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyMember(User $member)
    {
        $member->update(['company_id'=>null, 'department_id'=>null, 'position'=>null]);

        return redirect()->route('company.invite');
    }
}
