<?php
namespace App\Http\Livewire\Accommodations;

use Livewire\Component;
use App\DataTables\AccommodationsDataTable;

class Index extends Component
{
    /**
     * Return the view for contact index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.accommodations.index', [
            'datatable' => new AccommodationsDataTable(),
        ]);
    }
}
