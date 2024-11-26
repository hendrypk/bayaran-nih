<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

//Log In
public function login (Request $request){
    Session::flash('name', $request->name);
    $request->validate([
        'name'=>'required',
        'password'=>'required'
    ],[
        'name.required'=>'name not registered',
        'password.required'=>'password did not match'
    ]);

    $username = $request->name;
    $password = $request->password;

    // $loginAdmin = [
    //     'name' => $username, 
    //     'password' => $password  // Only include email and password here
    // ];
    
    // // Check if the user exists in the users table by email
    // $admin = User::where('name', $username)->first();
    // if ($admin) {
    //     // Attempt login with 'web' guard using the modified credentials array
    //     if (Auth::guard('web')->attempt($loginAdmin)) {
    //         return redirect()->route('employee.app')->with('success', 'You have successfully logged in as administrator!');
    //     }
    //     return back()->with('error', 'Login failed, please check your password.');
    // }
    
    // // Return an error if the user does not exist
    // return back()->with('error', 'User not found.');
    

    $infoLogin = [
        'username' => $username,
        'password' => $password
    ];

    $admin = User::where('username', $username)->first();
    if($admin) {
        if(auth::guard('web')->attempt($infoLogin)) {
            return redirect()->route('home')->with('success'. 'You are success login as administrator!');
        }
        return back()->with('error', 'Login failed, please check your password.');
    }

    $employee = Employee::where('username', $username)->first();
    if($employee) {
        if(auth::guard('employee')->attempt($infoLogin)) {
            return redirect()->route('employee.app');
        }
        return back()->with('error', 'Login failed, please check your password.');
    }
    return back()->with('error', 'Username not registered. Please contact the administrator or check your username.');
}

// public function login (Request $request){
//         Session::flash('name', $request->name);
//         $request->validate([
//             'name'=>'required',
//             'password'=>'required'
//         ],[
//             'name.required'=>'name not registered',
//             'password.required'=>'password did not match'
//         ]);

//         $infologin = [
//             'username' => $request->name,
//             'password' => $request->password
//         ];

//         // if(Auth::attempt($infologin)){
//         //     return redirect('profile')->with('success','Login');
//         // }

//         if(Auth::attempt($infologin)){
//             $user = Auth::user(); // Mendapatkan objek user yang telah diotentikasi
//             return redirect()->route('employee.app')->with('success', 'Login successful');
//         }

//          // Check for unregistered name
//          $user = Employee::where('username', $request->name)->first();
//          if (!$user) {
//              $error = 'Username ' . $request->name . ' not registered. Please contact administrator or check your username address.';
//              return redirect('login')->withErrors(['name' => $error]);
//          }

//         // Login failed
//         $error = 'Password does not match. Please check your password';
//         // Return error message
//         return redirect('/login')->withErrors(['password' => $error]);
//     }

//log out 
public function logout (){
        Auth::logout();
        return redirect()->route('login');
    }

//Reoister
public function register(){
    return view('auth.register');
}

//Register Submit
    function create(Request $request){
        Session::flash('email', $request->email);
        Session::flash('name', $request->name);
        $data = $request->validate([
            'name' => 'required|regex:/^\S*$/|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ],[
            'name.required' => 'username harus diisi',
            'name.unique' => 'username already exist',
            'name.regex:/^\S*$/' => 'username contains invalid characters',
            'email.required' => 'email wajib diisi',
            'email.email' => 'email invalid',
            'email.unique' => 'email already exist',
            'password.required' => 'password wajib diisi',
            'password.min' => 'minum password 8 characters'
        ]);

        // Konversi nama menjadi huruf kecil
        $data['name'] = strtolower($data['name']);
        
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('login')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
