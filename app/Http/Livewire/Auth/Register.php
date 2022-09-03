<?php
namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    /**
     * The name of the user
     *
     * @var string
    */
    public $name = '';

    /**
     * The email of the user
     *
     * @var string
    */
    public $email = '';

    /**
     * The password of the user
     *
     * @var string
    */
    public $password = '';

    /**
     * The password confirmation input
     *
     * @var string
    */
    public $passwordConfirmation = '';
    
    public function register()
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
        ]);

        $user = User::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(url('/'));
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
