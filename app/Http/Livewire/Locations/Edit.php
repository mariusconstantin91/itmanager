<?php

namespace App\Http\Livewire\Locations;

use Livewire\Component;

class Edit extends Component
{
    /**
     * Return the view for location edit
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.locations.edit');
    }
}
