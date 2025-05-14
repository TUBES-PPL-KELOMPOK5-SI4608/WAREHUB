<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;



class AuthController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username'=>'required|unique:users',
            'password'=> 'required',
            'role'=> 'required|in:admin,manager',
        ]);

        User::create([
            'username'=>$request->username,
            'password'=> Hash::make ($request->password),
            'role'=> $request->role,
        ]);

        return redirect('/login')->with('success','Akun berhasil dibuat');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request-> validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();

            if (Auth::user()->role=='admin'){

                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'login',
                    'description' => 'Admin logged in',
                ]);
                return redirect()->intended('/dashboard');

            }else{

                return redirect()->intended('/audit/auth');
            }
        }

        return back()->withErrors([
            'username'=>'Username atau password salah'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
}
