<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Division;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class UserController extends Controller
{
//Index 
    public function index() {
        $users = User::with('roles')->get();
        $roles = Role::all();
        $divisions = Division::all();
        $departments = Department::all();
        return view('user.index', compact('users', 'roles', 'divisions', 'departments'));
    }

//Store
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:20',
            'username' => 'required|string|regex:/^[a-z]+$/|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8', 
            'role_id' => 'required|exists:roles,id', 
        ]);

        // Create the user
        $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'division' => $request->division,
                'department' => $request->department,
        ]);

        // Assign the role
        // $user->assignRole($request->role_id);
        $user->roles()->sync([$request->role_id]);

        return redirect()->route('user.index')->with('success', 'User added successfully.');
    }

//Update
    public function update(Request $request, $id) {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:20',
            'username' => 'required|string|regex:/^[a-z]+$/|unique:users,username,' . $id, // Ignore current username in validation
            'email' => 'required|email|unique:users,email,' . $id, // Ignore current email in validation
            'password' => 'nullable|string|min:8', // Password is optional on update
            'role_id' => 'required|exists:roles,id', // Ensure a valid role is selected
        ]);

        // Find the user
        $user = User::findOrFail($id);

        // Update user fields
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->division_id = $request->division;
        $user->department_id =  $request->department;

        // Only update the password if it's provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Assign the role
        $user->roles()->sync([$request->role_id]); // Sync the role (adjust based on your logic)

        // Save the user
        $user->save();

        // Redirect with success message
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

//Delete
    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User has been deleted.',
            'redirect' => route('user.index') 
        ]);
    }



}

