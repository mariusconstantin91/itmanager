<?php

namespace App\Http\Livewire\Locations;

use App\DataTables\LocationsDataTable;
use Livewire\Component;

class Index extends Component
{
    /**
     * Return the view for location index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.locations.index', [
            'datatable' => new LocationsDataTable(),
        ]);
    }
}
