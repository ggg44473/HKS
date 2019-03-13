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
use App\Project;
use App\Permission;
use App\Follow;
use Notification;
use App\Notifications\DepartmentNotification;
use Aws\Api\Validator;

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
        $this->authorize('view', $company);

        $okrsWithPage = $company->getOkrsWithPage($request);
        $company['okrs'] = $okrsWithPage['okrs'];

        $data = [
            'user' => auth()->user(),
            'company' => $company,
            'pageInfo' => $okrsWithPage['pageInfo'],
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
        ];

        return view('organization.company.okr', $data);
    }

    public function storeObjective(ObjectiveRequest $request, Company $company)
    {
        $this->authorize('storeObjective', $company);

        $objective = $company->addObjective($request, $company);
        return redirect()->to(url()->previous() . '#oid-' . $objective->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company = Company::where('id', auth()->user()->company_id)->first();
        $company['okrs'] = $company ? $company->getOkrsWithPage($request)['okrs'] : null;

        $departments = Department::where(['company_id' => auth()->user()->company_id, 'parent_department_id' => null])->get();
        foreach ($departments as $department) {
            $department['okrs'] = $department ? $department->getOkrsWithPage($request)['okrs'] : null;
        }

        $invitations = auth()->user()->invitation->where('model_type', Company::class);

        $data = [
            'company' => $company,
            'departments' => $departments,
            'invitations' => $invitations
        ];

        return view('organization.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $this->authorize('create', Company::class);

        $attr['name'] = $request->input('company_name');
        $attr['description'] = $request->input('company_description');
        $attr['user_id'] = auth()->user()->id;
        $company = Company::create($attr);

        $company->addAvatar($request);
        $company->createPermission(1);

        auth()->user()->update(['company_id' => $company->id]);

        return redirect()->route('company.index');
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
        $this->authorize('update', $company);

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
        $company = auth()->user()->company;
        $this->authorize('delete', $company);

        $company->delete();

        return redirect()->route('company.index');
    }

    /**
     * 發送邀請
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function inviteMember(Request $request, Company $company)
    {
        $this->authorize('memberSetting', $company);
        $company->sendInvitation($request);

        return redirect()->route('company.member', $company);
    }

    /**
     * 取消邀請
     *
     * @param  \App\Company $company
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function cancelInvite(Company $company, User $member)
    {
        $this->authorize('memberSetting', $company);
        $company->deleteInvitation($member);

        return redirect()->route('company.member.setting', $company);
    }

    /**
     * 拒絕邀請
     *
     * @param  \App\Company $company
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function rejectInvite(Company $company, User $member)
    {
        $company->deleteInvitation($member);

        return redirect()->route('company.index');
    }

    /**
     * 同意邀請
     *
     * @param  \App\Company $company
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function agreeInvite(Company $company, User $member)
    {
        $company->deleteInvitation($member);
        $company->createPermission(4);
        $member->update(['company_id' => $company->id]);

        return redirect()->route('company.index');
    }

    /**
     * 搜尋使用者名稱或信箱
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchNoncompany()
    {
        $results = User::where('company_id', null)->get();

        return response()->json($results);
    }

    /**
     * 搜尋使用者名稱或信箱
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = User::where('company_id', auth()->user()->company_id)->get();

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
        $this->authorize('memberSetting', $company);
        $userIds = preg_split("/[,]+/", $request->invite);
        foreach ($userIds as $userId) {
            User::where('id', $userId)->update(['company_id' => auth()->user()->company_id]);
        }

        return redirect()->route('company.member');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMember(Request $request, User $member)
    {
        $this->authorize('memberSetting', $member->company);

        $member->company->updateMember($request, $member);
        
        return redirect()->route('company.member');
    }

    /**
     * Remove company_id, department_id and position from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyMember(User $member)
    {
        $this->authorize('memberSetting', $member->company);
        Permission::where('user_id', $member->id)->delete();
        Follow::where('user_id', $member->id)->delete();
        Follow::where(['model_type' => User::class, 'model_id' => $member->id])->delete();
        $member->update(['company_id' => null, 'department_id' => null, 'position' => null]);

        return redirect()->route('company.member');
    }

    /**
     * Display a listing of the member.
     *
     * @return \Illuminate\Http\Response
     */
    public function member(Request $request)
    {
        $company = auth()->user()->company;
        $this->authorize('view', $company);
        $company['okrs'] = $company ? $company->getOkrsWithPage($request)['okrs'] : null;

        $departments = Department::where(['company_id' => auth()->user()->company_id, 'parent_department_id' => null])->get();
        foreach ($departments as $department) {
            $department['okrs'] = $department ? $department->getOkrsWithPage($request)['okrs'] : null;
        }

        $data = [
            'members' => $company->sortMember($request),
            'company' => $company,
            'departments' => $departments,
        ];

        return view('organization.member', $data);
    }

    /**
     * 變更最高權限管理者
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeAdmin(Request $request)
    {
        $this->authorize('adminCange', [auth()->user(), auth()->user()->company]);

        $company->changeAdmin($request);

        return redirect()->back();
    }

    /**
     * 刪除最高權限管理者
     *
     * @param  \Illuminate\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAdmin(Request $request)
    {
        $user = auth()->user();
        $this->authorize('adminCange', [$user, $user->company]);

        foreach ($user->permissions()->where(['model_type' => Project::class, 'role_id' => 1])->with('model')->get() as $permission) {
            if ($request->input('project' . $permission->model->id) == $user->id) return redirect()->back();
            else {
                $permission->where('user_id', $request->input('project' . $permission->model->id))->update(['role_id' => 1]);
                $permission->model->users()->detach($user);
                $permission->delete();
            }
        }

        if ($request->department == $user->id) return redirect()->back();
        else Permission::where(['user_id' => $request->department, 'model_type' => Department::class])->update(['role_id' => 1]);

        if ($request->invite == $user->id) return redirect()->back();
        else Permission::where(['user_id' => $request->invite, 'model_type' => Company::class])->update(['role_id' => 1]);

        $user->update(['company_id' => null, 'department_id' => null]);
        $user->permissions()->delete();
        $user->invitation->delete();
        Follow::where('user_id', $user->id)->delete();
        Follow::where(['model_type' => User::class, 'model_id' => $user->id])->delete();

        return redirect()->back();
    }

    public function importUser(){
        return view('organization.company.import');
    }

    public function handleImportUser(Request $request){
        // $validator = Validator::make($request->all(),[
        //     'file'=>'required',
        // ]);

        // if($validator->fails()){
        //     return redirect()->back()->withErrors($validator);
        // }

        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv',explode("\n",$csvData));
        $header = array_shift($rows);
        $user = auth()->user();
        foreach($rows as $row){  
            // 註冊設定
            User::create([
                'name' => $row[0], 
                'email' => $row[1],
                'email_verified_at' => now(),
                'password' => bcrypt('cmoney'),
                'company_id' => $user->company_id,
                //'department_id' => $row['department'], 
                'position' =>$row[2], 
                'enable' =>true,             
            ]);

            // 權限設定
            $newmember = User::where('email', $row[1])->first();
            Permission::create([
                'user_id' => $newmember->id, 
                'model_type' => Company::class, 
                'model_id' => $user->company_id,
                'role_id' => 4
            ]);
        }

        //flash('已匯入會員清單');
        return redirect()->back();
    }    

}
