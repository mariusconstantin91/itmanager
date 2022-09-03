<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Sidebar extends Component
{
    /**
     * Return the view for sidebar
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.layouts.sidebar');
    }
}
