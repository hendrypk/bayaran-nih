<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Division;
use App\Models\Role;
use App\Models\User;
class UserController extends Controller
{
    public function index() {
        $users = User::with('roles')->get();
        $roles = Role::all();
        $divisions = Division::all();
        $departments = Department::all();
        return view('user.index', compact('users', 'roles', 'divisions', 'departments'));
    }
}

