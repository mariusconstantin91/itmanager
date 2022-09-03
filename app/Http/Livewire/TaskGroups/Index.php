<?php
namespace App\Http\Livewire\TaskGroups;

use Livewire\Component;
use App\DataTables\TaskGroupsDataTable;

class Index extends Component
{
    /**
     * Return the view for tag index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.task_groups.index', [
            'datatable' => new TaskGroupsDataTable(),
        ]);
    }
}
