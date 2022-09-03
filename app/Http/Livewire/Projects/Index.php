<?php
namespace App\Http\Livewire\Projects;

use Livewire\Component;
use App\DataTables\ProjectsDataTable;

class Index extends Component
{
    /**
     * Return the view for project index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.projects.index', [
            'datatable' => new ProjectsDataTable(),
        ]);
    }
}
