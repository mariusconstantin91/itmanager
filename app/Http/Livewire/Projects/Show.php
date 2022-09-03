<?php
namespace App\Http\Livewire\Projects;

use App\DataTables\TasksDataTable;
use App\Models\Project;
use Livewire\Component;
use App\DataTables\UsersDataTable;
use App\DataTables\TimeEntriesDataTable;
use App\Models\TaskGroup;
use Carbon\Carbon;

class Show extends Component
{
    /**
     * The main entity of the component
     *
     * @var Project
     */
    public Project $project;

    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        $this->project->load('client', 'timeEntries', 'tasks', 'tags', 'skills', 'users');
    }

    /**
     * Return the view for project show
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        $projectId = $this->project->id;
        $datatableUsers = (new UsersDataTable())->setQuery(function ($query) use ($projectId) {
            return $query->whereHas('projects', function ($query) use ($projectId) {
                $query->where('projects.id', $projectId);
            });
        });
        
        $datatableTimeEntries = (new TimeEntriesDataTable())->setQuery(function ($query) use ($projectId) {
            return $query->whereHas('task', function ($query) use ($projectId) {
                $query->where('tasks.project_id', $projectId);
            });
        });

        
        $datatableTaskEntries = (new TasksDataTable())->setQuery(function ($query) use ($projectId) {
            return $query->where('project_id', $projectId);
        });

        $trackedTime = 0;
        foreach ($this->project->timeEntries as $timeEntry) {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $timeEntry->start_at);
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $timeEntry->end_at);
            $trackedTime += $endDate->diffInMinutes($startDate);
        }

        $taskGroups = TaskGroup::whereHas('tasks', function ($query) use ($projectId) {
            $query->where('tasks.project_id', $projectId);
        });

        return view('livewire.projects.show', [
            'datatableUsers' => $datatableUsers,
            'datatableTimeEntries' => $datatableTimeEntries,
            'datatableTaskEntries' => $datatableTaskEntries,
            'trackedTime' => $trackedTime,
            'taskGroups' => $taskGroups,
        ]);
    }
}
