<?php
namespace App\Http\Livewire\TaskGroups;

use Livewire\Component;
use App\Models\TaskGroup;
use App\DataTables\TasksDataTable;

class Show extends Component
{
    /**
     * The main entity of the component
     *
     * @var TaskGroup
     */
    public TaskGroup $taskGroup;

    /**
     * Return the view for taskGroup show
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        $taskGroupId = $this->taskGroup->id;
        $datatableTasks = (new TasksDataTable())->setQuery(function ($query) use ($taskGroupId) {
            return $query->whereHas('taskGroups', function ($query) use ($taskGroupId) {
                $query->where('task_groups.id', $taskGroupId);
            });
        });

        return view('livewire.task_groups.show', [
            'datatableTasks' => $datatableTasks,
        ]);
    }
}
