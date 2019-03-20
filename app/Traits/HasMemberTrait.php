<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\User;
use App\Department;
use App\Company;
use App\Permission;
use Notification;
use App\Notifications\DepartmentNotification;

trait HasMemberTrait
{
    public function updateMember(Request $request)
    {
        foreach(auth()->user()->company->users as $member){
            if($request->exists('department' . $member->id)){
                if($request->input('department'.$member->id) != $member->department_id){
                    if ($request->input('department'.$member->id) != null) {
                        if ($permission = $member->permissions()->where('model_type', Department::class)->first()) {
                            $permission->update(['role_id' => 4, 'model_id' => $request->input('department'.$member->id)]);
                        } else {
                            Permission::create(['user_id' => $member->id, 'model_type' => Department::class, 'model_id' => $request->input('department'.$member->id), 'role_id' => 4]);
                        }
                        Notification::send($member, new DepartmentNotification(Department::find($request->input('department'.$member->id))));
                    } else {
                        Notification::send($member, new DepartmentNotification($member->department, 'out'));
                        Permission::where(['user_id' => $member->id, 'model_type' => Department::class])->delete();
                        $member->update(['department_id' => null, 'position' => null]);
                    }
                }
            }
            if ($request->exists('department' . $member->id)) $member->update(['department_id' => $request->input('department'.$member->id)]);
            if ($request->exists('position' . $member->id)) $member->update(['position' => $request->input('position'.$member->id)]);
            if ($request->exists('permission' . $member->id)) $member->permissions()->where(['model_type' => get_class($this), 'model_id' => $this->id])->update(['role_id' => $request->input('permission'.$member->id)]);
        }
    }

    public function sortMember($request)
    {
        $builder = $this->users();
        if (get_class($this) == Company::class) $attr = ['name', 'email', 'department_id', 'position'];
        else $attr = ['name', 'email', 'position'];
        if ($request->input('order', '')) {
            # 排序
            if ($order = $request->input('order', '')) { 
                # 判斷value是以 _asc 或者 _desc 结尾來排序
                if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                    # 判斷是否為指定的接收的參數
                    if (in_array($m[1], $attr)) {   
                        # 開始排序              
                        $builder->orderBy($m[1], $m[2]);
                    }
                }
            }
        } else {
            # 預設
            $builder->orderBy('id');
        }

        return $builder->paginate(10)->appends(['order' => $request->input('order', '')]);
    }

    public function changeAdmin($request)
    {
        Permission::where(['user_id' => $request->invite, 'model_type' => get_class($this), 'model_id' => $this->id])->update(['role_id' => 1]);
        Permission::where(['user_id' => auth()->user()->id, 'model_type' => get_class($this), 'model_id' => $this->id])->update(['role_id' => 2]);
    }
}
