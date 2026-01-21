<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class RegisterUserController extends Controller
{
    public function register()
    {
        return view('livewire.auth.register');
    }

    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        $cart = Cart::create([
            'name' =>  $user->name,
            'user_id' => $user->id
        ]);
                
        return redirect()->route('login');
    }
}
