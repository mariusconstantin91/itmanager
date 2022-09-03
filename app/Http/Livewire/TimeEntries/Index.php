<?php
namespace App\Http\Livewire\TimeEntries;

use Livewire\Component;
use App\DataTables\TimeEntriesDataTable;

class Index extends Component
{
    /**
     * Return the view for time entries index
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        $userAuth = auth()->user();
        $dataTable = new TimeEntriesDataTable();
        if ($userAuth->hasRole('user')) {
            $dataTable->setQuery(function ($query) use ($userAuth) {
                return $query->where('user_id', $userAuth->id);
            });
        }
        return view('livewire.time_entries.index', [
            'datatable' => $dataTable,
        ]);
    }
}
