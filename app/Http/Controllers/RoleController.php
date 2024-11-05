<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
//Index
    public function index () {
        $roles = Role::all();
        return view ('role.index', compact('roles'));
    }

//Detail
    public function detail ($id) {
        {
            $role = Role::findOrFail($id);
            $permissions = Permission::orderBy('group_name', 'asc')->orderBy('name', 'asc')->get();
            $groupedPermissions = $permissions->groupBy('group_name');
    
            return view('role.detail', compact('role', 'groupedPermissions'));
        }
    }


//Create
public function create() {
    $permissions = Permission::orderBy('group_name', 'asc')->orderBy('name', 'asc')->get();
    $groupedPermissions = $permissions->groupBy('group_name');

    return view('role.add', compact('groupedPermissions'));
}

//Store
    public function store(Request $request) {
        $data = $request->validate([
            'role_id' => 'nullable|exists:roles,id', 
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id', 
        ]);
    
        if (isset($data['role_id']) && !empty($data['role_id'])) {
            $role = Role::findOrFail($data['role_id']);
            $role->update(['name' => $data['name']]);
        } else {
            $role = Role::create([
                'name' => $data['name'],
                'guard_name' => 'web', 
            ]);
        }
    
        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
        return redirect()->route('role.index')->with('success', 'Role saved successfully.');
    }
    

//Edit
public function edit ($id) {
    $role = Role::findOrFail($id);
    $permissions = Permission::orderBy('group_name', 'asc')->orderBy('name', 'asc')->get();
    $groupedPermissions = $permissions->groupBy('group_name');

    return view('role.edit', compact('role', 'groupedPermissions'));
}

//Update
    public function update (Request $request, $id) {
        $data = $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
    
        $role = Role::findOrFail($id);

        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
    
        if ($role) {
            $role->update(['name' => $data['name']]);
            
            return redirect()->route('role.detail', $id)->with('success', 'Role updated successfully.');

        } else {
            $role = Role::create([
                'name' => $data['name'],
                'guard_name' => 'web', // Ensure to specify the guard name here
            ]);
        }
        
        return redirect()->route('role.index')->with('success', 'Role saved successfully.');
    }

//Delte
public function delete($id) {
    $role = Role::findOrFail($id);
    $role->delete();
    return response()->json([
        'success' => true,
        'message' => 'Role has been deleted.',
        'redirect' => route('role.index') 
    ]);
}




    // loadModal
    // function loadModal(Request $request)
    // {
    //     if (!$request->ajax()) {
    //         return 'Not Ajax Request';
    //     }

    //     if ($request->type == 'update') {
    //         $data = [
    //             'action' => route('role.save', $request->role_id),
    //             'role' => Role::find($request->role_id),
    //             'permissions' => $permissions,
    //             'modal_title' => 'Update Role'
    //         ];
    //     } else { // create
    //         $data = [
    //             'action' => route('role.save'),
    //             'permissions' => $permissions,
    //             'modal_title' => 'Create Role'
    //         ];
    //     }
    //     return view('role.modal', $data);
    // }
    
}


