<?php
namespace App\Http\Livewire\Contacts;

use App\Models\Contact;
use Livewire\Component;
use App\DataTables\HolidaysDataTable;
use App\DataTables\DocumentsDataTable;
use App\DataTables\ProjectsDataTable;
use App\DataTables\TasksDataTable;

class Show extends Component
{
    /**
     * The main entity of the component
     *
     * @var Contact
     */
    public Contact $contact;

    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        $this->contact->load('country');
    }

    /**
     * Return the view for contact show
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.contacts.show');
    }
}
