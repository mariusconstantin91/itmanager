<?php
namespace App\Http\Livewire\Auth\Passwords;

use Livewire\Component;

class Confirm extends Component
{
    /**
     * The password string
     *
     * @var string
    */
    public $password = '';

    /**
     * The action for confirm
     *
     * @return void
     */
    public function confirm()
    {
        $this->validate([
            'password' => 'required|password',
        ]);

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(url('/'));
    }

    /**
     * The render function
     *
     * @return Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('livewire.auth.passwords.confirm');
    }
}
