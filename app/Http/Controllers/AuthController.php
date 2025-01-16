<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller{
    public function loginForm(){
        $data = [
            'title' => 'Login Page'
        ];
        return view('auth.login');
    }
}
