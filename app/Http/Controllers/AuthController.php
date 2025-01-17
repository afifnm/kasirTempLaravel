<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller{
    public function loginForm(){
        $data = [
            'title' => 'Login Page'
        ];
        return view('auth.login');
    }
    public function login(Request $request){
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
        if(Auth::attempt($request->only('email','password'))){
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with([
                'alert'   => 'Email and Password wrong!',
                'icon'    => 'warning'
            ]);
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}