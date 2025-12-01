<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('dashboard.auth.login');
    }

    public function login (Request $request){
        if(Auth::guard('admin')->attempt(['email' => $request->email , 'password' => $request->password])){
            return redirect()->route('admin');            
        }
        return redirect()->back()->withErrors('Password atau Email Salah!');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout(); // Logout admin
        $request->session()->invalidate(); // Hapus semua sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF untuk keamanan

        return redirect()->route('login-form-admin'); // Arahkan kembali ke halaman login
    }
}
