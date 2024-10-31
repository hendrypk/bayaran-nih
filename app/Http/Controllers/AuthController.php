<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
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

        $infologin = [
            'username' => $request->name,
            'password' => $request->password
        ];

        // if(Auth::attempt($infologin)){
        //     return redirect('profile')->with('success','Login');
        // }

        if(Auth::attempt($infologin)){
            $user = Auth::user(); // Mendapatkan objek user yang telah diotentikasi
            return redirect()->route('employee.app')->with('success', 'Login successful');
        }

         // Check for unregistered name
         $user = Employee::where('username', $request->name)->first();
         if (!$user) {
             $error = 'Username ' . $request->name . ' not registered. Please contact administrator or check your username address.';
             return redirect('login')->withErrors(['name' => $error]);
         }

        // Login failed
        $error = 'Password does not match. Please check your password';
        // Return error message
        return redirect('/login')->withErrors(['password' => $error]);
    }

//log out 
public function logout (){
        Auth::logout();
        return redirect('/login');
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
