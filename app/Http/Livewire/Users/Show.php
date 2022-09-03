<?php
namespace App\Http\Livewire\Users;

use App\Models\User;
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
     * @var User
     */
    public User $user;

    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        $this->user->load('role', 'country', 'skills');
    }

    /**
     * Return the view for user show
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        $userId = $this->user->id;
        $datatableHolidays = (new HolidaysDataTable())->setQuery(function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        });

        $datatableDocuments = (new DocumentsDataTable())->setQuery(function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        });

        $datatableProjects = (new ProjectsDataTable())->setQuery(function ($query) use ($userId) {
            return $query->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            });
        });

        $datatableTasks = (new TasksDataTable())->setQuery(function ($query) use ($userId) {
            return $query->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            });
        });

        return view('livewire.users.show', [
            'datatableHolidays' => $datatableHolidays,
            'datatableDocuments' => $datatableDocuments,
            'datatableProjects' => $datatableProjects,
            'datatableTasks' => $datatableTasks,
        ]);
    }
}
