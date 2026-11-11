<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    #create user
    public function store(Request $request): RedirectResponse{

        $validate = $request->validate([
            "name"=> 'required|string|min:3|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|max:100|min:6',
        ]);

        $validate['password'] = Hash::make($validate['password']);

        User::create($validate);

        return redirect()->route('login')->with('success','User created succesfully');
    }


    #Login
    public function authenticate(Request $request): RedirectResponse{

    $validate = $request->validate([
        'email' => 'required|email|max:100',
        'password' => 'required|max:100|min:6',
    ]);

    if(Auth::attempt($validate)){
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Login successfully');
    }

    return back()->withErrors([
        'email' => 'the provided credentials do not match our records',
    ])->onlyInput('email');
    
    }

    public function logout(Request $request): RedirectResponse{

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
