<?php
namespace App\Http\Livewire\Clients;

use App\DataTables\ContactsDataTable;
use App\Models\Client;
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
     * @var Client
     */
    public Client $client;

    /**
     * Return the view for client show
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        $clientId = $this->client->id;

        $datatableProjects = (new ProjectsDataTable())->setQuery(function ($query) use ($clientId) {
            return $query->where('client_id', $clientId);
        });

        $datatableContacts = (new ContactsDataTable())->setQuery(function ($query) use ($clientId) {
            return $query->where('client_id', $clientId);
        });

        return view('livewire.clients.show', [
        'datatableProjects' => $datatableProjects,
        'datatableContacts' => $datatableContacts,
        ]);
    }
}
