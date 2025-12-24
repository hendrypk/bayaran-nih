<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index () {
        $roles = Role::withCount('users')->get();
        return view ('role.index', compact('roles'));
    }

    public function form()
    {
        return view ('role.form');
    }

    public function detail ($id) {
        {
            $role = Role::findOrFail($id);
            $permissions = Permission::orderBy('group_name', 'asc')->orderBy('name', 'asc')->get();
            $groupedPermissions = $permissions->groupBy('group_name');
    
            return view('role.detail', compact('role', 'groupedPermissions'));
        }
    }
}


