<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    public function login()
    {
        return view('livewire.auth.login');
    }

    public function loginUser(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email,'password' => $request->password]) == 0){
            
            return redirect()->back()->with('error', 'Wrong Password Or Email');
        }else{ 
            return redirect()->route('dashboard');
        }
        
        
    }
    
}
