<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Header extends Component
{
    /**
     * Return the view for header
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.layouts.header');
    }
}
