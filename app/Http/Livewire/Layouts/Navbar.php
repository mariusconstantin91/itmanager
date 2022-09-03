<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Navbar extends Component
{
    /**
     * Return the view for navbar
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.layouts.navbar');
    }
}
