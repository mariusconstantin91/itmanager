<?php
namespace App\Http\Livewire\RentalCars;

use Livewire\Component;
use App\DataTables\RentalCarsDataTable;

class Index extends Component
{
    /**
     * Return the view for contact index.
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.rentalcars.index', [
            'datatable' => new RentalCarsDataTable(),
        ]);
    }
}
