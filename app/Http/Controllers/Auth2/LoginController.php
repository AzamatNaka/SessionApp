<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function login(Request $request){
        if(Auth::check()){
            return redirect()->intended('/sessions');
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($validated)) {
            $session = new Session;
            $session->user_id = Auth::user()->id;
            $session->ip_address = $request->ip();
            $session->save();
            return redirect()->intended('/sessions');
        }

        return back()->withErrors('Incorrect email or password');
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('login.form');
    }
}
