<?php
namespace App\Http\Livewire\Comments;

use Livewire\Component;
use App\DataTables\CommentsDataTable;

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
        $dataTable = new CommentsDataTable();
        if ($userAuth->hasRole('user')) {
            $dataTable->setQuery(function ($query) use ($userAuth) {
                return $query->where('user_id', $userAuth->id);
            });
        }

        return view('livewire.comments.index', [
            'datatable' => $dataTable,
        ]);
    }
}
