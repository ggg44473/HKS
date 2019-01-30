<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\Objective;
use App\Http\Requests\ObjectiveRequest;
use App\Charts\SampleChart;
use App\User;
use App\Permission;

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
        $this->authorize('view', $department);

        $okrsWithPage = $department->getOkrsWithPage($request);
        $department['okrs'] = $okrsWithPage['okrs'];

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
        $this->authorize('storeObjective', $department);

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
        $this->authorize('view', $department);

        $data['parent'] = $department->parent;
        $department['okrs'] = $department->getOkrsWithPage($request)['okrs'];
        $data['department'] = $department;
        $data['children'] = $department->children;
            
        return view('organization.department.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Department::class);

        $attr['name'] = $request->department_name;
        $attr['description'] = $request->department_description;
        $attr['user_id'] = auth()->user()->id;
        $attr['company_id'] = auth()->user()->company_id;
        
        $department = Department::create($attr);
        $department->addAvatar($request);

        return redirect()->route('company.index');
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
        $this->authorize('update', $department);

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
        $this->authorize('delete', $department);

        foreach ($department->users as $user) {
            $user->update(['department_id' => null]);
        }
        $department->delete();

        return redirect()->route('company.index');
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
        $this->authorize('memberSetting', $department);

        $userIds = preg_split("/[,]+/", $request->invite);
        foreach($userIds as $userId){
            $user = User::where('id', $userId)->first();
            if($user->company_id == $department->company_id){
                $user->update(['department_id' => $department->id]);
                Permission::create(['user_id' => $user->id, 'model_type'=>Department::class,'model_id'=>$department->id,'role_id'=>4]);
            }
        }

        return redirect()->route('department.member', $department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMember(Request $request, Department $department, User $member)
    {
        $this->authorize('memberSetting', $department);

        $attr['department_id'] = $request->input('department');
        if ($request->input('department') != $department->id ) {
            if ($permission = $member->permissions()->where('model_type', Department::class)->first()) {
                $permission->update(['role_id' => 4]);
            } else {
                Permission::create(['user_id' => $member->id, 'model_type' => Department::class, 'model_id' => $request->input('department'), 'role_id' => 4]);
            }
        }
        $attr['position'] = $request->input('position');
        $member->update($attr);
        $member->permissions()->where('model_type', Department::class)->update(['role_id' => $request->input('permission')]);

        return redirect()->route('department.member', $department);
    }
    
    /**
     * Remove company_id, department_id and position from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyMember(Department $department, User $member)
    {
        $this->authorize('memberSetting', $department);
        Permission::where(['user_id'=>$member->id,'model_type'=>Department::class,'model_id'=>$department->id])->delete();
        $member->update(['department_id'=>null, 'position'=>null]);

        return redirect()->route('department.member', $department);
    }

    /**
     * Display a listing of the member.
     *
     * @return \Illuminate\Http\Response
     */
    public function member(Request $request, Department $department)
    {
        $this->authorize('view', $department);

        $department['okrs'] = $department->getOkrsWithPage($request)['okrs'];

        $builder = $department->users();
        if ($request->input('order', '')) {
            
            # 排序
            if ($order = $request->input('order', '')) { 
                # 判斷value是以 _asc 或者 _desc 结尾來排序
                if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                    # 判斷是否為指定的接收的參數
                    if (in_array($m[1], ['name', 'email', 'position'])) {   
                        # 開始排序              
                        $builder->orderBy($m[1], $m[2]);
                    }
                }
            }
        } else {
            # 預設
            $builder->orderBy('id');
        }

        $pages = $builder->paginate(10)->appends([
            'order' => $request->input('order', ''),
        ]);

        $data = [
            'department' => $department,
            'members' => $pages,
        ];

        return view('organization.department.member', $data);
    }
}
