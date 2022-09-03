<?php
namespace App\Http\Livewire\Documents;

use Livewire\Component;
use App\DataTables\DocumentsDataTable;

class Index extends Component
{
    /**
     * Return the view for document index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.documents.index', [
            'datatable' => new DocumentsDataTable(),
        ]);
    }
}
