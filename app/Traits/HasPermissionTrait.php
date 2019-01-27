<?php

namespace App\Traits;

use App\Permission;


trait HasPermissionTrait
{
    /**
     * Returns all invitation for this model.
     */
    public function model()
    {
        return $this->morphMany(Permission::class, 'model');
    }

    public function createPermission($roleId)
    {
        Permission::create([
            'user_id'=>auth()->user()->id,
            'model_type'=>get_class($this),
            'model_id'=>$this->id,
            'role_id'=>$roleId,
        ]);
    }
}
