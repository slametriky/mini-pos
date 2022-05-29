<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Hash;
use Session;
use DB;
use App\Models\User;


class AuthController extends Controller
{


    public function showFormLogin()
    {       
        if (Auth::check()) { 
            return redirect()->intended(route('products.index'));
        }
        return view('login');
    }
   
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        $credentials = $request->only('email', 'password');
     
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
     
            return redirect()->intended(route('products.index'));
        }
     
        return back()->with([
            'error' => 'email atau Password salah',
        ]);
  
    }

}
