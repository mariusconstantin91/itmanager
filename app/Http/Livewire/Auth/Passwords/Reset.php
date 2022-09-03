<?php

namespace App\Http\Livewire\Auth\Passwords;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class Reset extends Component
{
    /**
     * The token used to identify the user
     *
     * @var string
     */
    public $token;

    /**
     * The email of the user
     *
     * @var string
     */
    public $email;

    /**
     * The new password of the user
     *
     * @var string
     */
    public $password;

    /**
     * The conifrmation password of the user
     *
     * @var string
     */
    public $passwordConfirmation;

    /**
     * Hook funciton of the component set the inital values of properties
     *
     * @param string $token
     * @return void
     */
    public function mount($token)
    {
        $this->email = request()->query('email', '');
        $this->token = $token;
    }

    /**
     * The logic for reset password
     *
     * @return void
     */
    public function resetPassword()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|same:passwordConfirmation',
        ]);

        $response = $this->broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
            ],
            function ($user, $password) {
                $user->password = Hash::make($password);

                $user->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));

                $this->guard()->login($user);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            session()->flash(trans($response));

            return redirect('/');
        }

        $this->addError('email', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Return the view for reset password
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.auth.passwords.reset');
    }
}
