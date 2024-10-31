<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showLinkRequestForm(){
        return view('auth.forgot-password');
    }

    // Handle forgot password request
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        // Mencari employee berdasarkan email
        $employee = Employee::where('email', $request->email)->first();
    
        if (!$employee) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        $token = \Str::random(60);

        PasswordResetToken::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        $data = [
            'email' => $request->email
        ];

        return redirect()->route('password.request')->with('success', 'Berhasil');
    
        // Mengirim email reset password menggunakan broker yang benar
        // $status = Password::broker('employees')->sendResetLink(
        //     $request->only('email')
        // );
    
        // if ($status === Password::RESET_LINK_SENT) {
        //     return response()->json(['message' => 'Link reset password berhasil dikirim.']);
        // }
    
        // return response()->json(['message' => 'Gagal mengirim link reset password.'], 400);
    }
    

    //Show Reset Form
    public function showResetForm(){
        return view('auth.reset-password');
    }
    // Handle reset password request
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::broker('employees')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($employee, $password) {
                $employee->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password berhasil direset.']);
        }

        return response()->json(['message' => 'Gagal mereset password.'], 400);
    }
}
