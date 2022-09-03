<?php
namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\DataTables\UsersDataTable;

class Index extends Component
{
    /**
     * Return the view for user index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.users.index', [
            'datatable' => new UsersDataTable(),
        ]);
    }
}
