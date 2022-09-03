<?php
namespace App\Http\Livewire\Skills;

use Livewire\Component;
use App\DataTables\SkillsDataTable;

class Index extends Component
{
    /**
     * Return the view for tag index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.skills.index', [
            'datatable' => new SkillsDataTable(),
        ]);
    }
}
