<?php
namespace App\Http\Livewire\TaskGroups;

use App\Models\TaskGroup;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Models\Project;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait;

    /**
     * The main entity of the component
     *
     * @var TaskGroup
     */
    public TaskGroup $taskGroup;

    /**
     * Array for search selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchDropDownsExtended = [
        'task.project_id',
    ];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'taskGroup.name' => [
            'required',
        ],
        'taskGroup.description' => [
            'required'
        ],
        'taskGroup.project_id' => [
            'required', 'numeric',
        ],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'taskGroup.project_id' => 'project',
    ];

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

    /**
     * Catch the updated event for country input, set the results filtered by search word
     *
     * @return void
     */
    public function projectUpdated($name, $value)
    {
        $this->items[$name] = Project::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
