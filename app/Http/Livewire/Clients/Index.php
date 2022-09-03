<?php
namespace App\Http\Livewire\Clients;

use Livewire\Component;
use App\DataTables\ClientsDataTable;
use App\Models\Client;

class Index extends Component
{
    
    /**
     * The message with the error
     *
     * @var string
     */
    public $errorMessage = '';

    /**
     * Return the view for tag index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.clients.index', [
            'datatable' => new ClientsDataTable(),
        ]);
    }
}
