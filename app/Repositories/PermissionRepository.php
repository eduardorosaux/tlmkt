<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    public function all()
    {
        return $permissions = Permission::all();
    }
}
