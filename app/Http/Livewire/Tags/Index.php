<?php
namespace App\Http\Livewire\Tags;

use Livewire\Component;
use App\DataTables\TagsDataTable;

class Index extends Component
{
    /**
     * Return the view for tag index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.tags.index', [
            'datatable' => new TagsDataTable(),
        ]);
    }
}
