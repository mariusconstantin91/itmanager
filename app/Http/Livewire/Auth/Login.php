<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    /**
     * The email of the user
     *
     * @var string
     */
    public string $email = '';

    /**
     * The password of the user
     *
     * @var string
     */
    public string $password = '';

    /**
     * The remember me checkbox value
     *
     * @var bool
     */
    public bool $remember = false;

    /**
     * Validation rules for the login form
     *
     * @var array
     */
    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    /**
     * The logic for the authentication
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function authenticate()
    {
        $this->validate();

        if (!Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )
        ) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        return redirect()->intended(url('/'));
    }

    /**
     * Return the view for login
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.auth.login');
    }
}
