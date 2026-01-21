<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(CreatesNewUsers $creator)
    {
        $user = $creator->create([
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>$this->password,
            'password_confirmation'=>$this->password_confirmation,
        ]);

        // auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
