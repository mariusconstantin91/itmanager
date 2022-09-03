<?php
namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use App\DataTables\TasksDataTable;

class Index extends Component
{
    /**
     * Return the view for contact index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.tasks.index', [
            'datatable' => new TasksDataTable(),
        ]);
    }
}
