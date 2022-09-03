<?php
namespace App\Http\Livewire\Holidays;

use Livewire\Component;
use App\DataTables\HolidaysDataTable;

class Index extends Component
{
    /**
     * Return the view for holiday index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.holidays.index', [
            'datatable' => new HolidaysDataTable(),
        ]);
    }
}
