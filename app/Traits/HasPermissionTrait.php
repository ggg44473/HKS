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

}
