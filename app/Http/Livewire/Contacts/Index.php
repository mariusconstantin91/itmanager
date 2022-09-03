<?php
namespace App\Http\Livewire\Contacts;

use Livewire\Component;
use App\DataTables\ContactsDataTable;

class Index extends Component
{
    /**
     * Return the view for contact index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.contacts.index', [
            'datatable' => new ContactsDataTable(),
        ]);
    }
}
