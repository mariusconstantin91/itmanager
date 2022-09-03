<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    /**
     * Return the view for home
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.home');
    }
}
