<?php
namespace App\Http\Livewire\TimeEntries;

use App\Models\TimeEntry;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait, SelectFormatedTrait;

    /**
     * The main entity of the component
     *
     * @var TimeEntry
     */
    public TimeEntry $timeEntry;

    /**
     * Start time
     *
     * @var string
     */
    public string $startAt = '';

    /**
     * End time
     *
     * @var string
     */
    public string $endAt = '';

    /**
     * Duration of the task in minutes
     *
     * @var integer
     */
    public int $duration = 0;


    /**
     * Array for search selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchDropDownsExtended = [
        'task_entry.client_id',
    ];

    /**
     * Array for search formated selects, it contains the name of them
     *
     * @var array
     */
    public $searchSelects = [
        'task_entry.status',
        'task_entry.importance',
    ];

    /**
     * Property populated with the options for users
     *
     * @var array
     */
    public $userOptions = [];

    /**
     * Property populated with the options for tasks
     *
     * @var array
     */
    public $taskOptions = [];

    /**
     * Property populated with the options for project
     *
     * @var array
     */
    public $projectOptions = [];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'timeEntry.description' => ['required'],
        'timeEntry.project_id' => ['required'],
        'timeEntry.user_id' => ['required'],
        'timeEntry.task_id' => ['required'],
        'startAt' => ['required', 'date', 'date_format:Y-m-d H:i'],
        'endAt' => ['required', 'date', 'date_format:Y-m-d H:i', 'after:startAt'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'timeEntry.project_id' => 'project',
        'timeEntry.user_id' => 'user',
        'timeEntry.task_id' => 'task',
    ];

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

    /**
     * Catch the updated event for project input, set the results filtered by search word
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

    /**
     * Catch the updated event for user input, set the results filtered by search word
     *
     * @return void
     */
    public function userUpdated($name, $value)
    {
        $this->items[$name] = User::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for task input, set the results filtered by search word
     *
     * @return void
     */
    public function taskUpdated($name, $value)
    {
        $this->items[$name] = Task::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for start at
     *
     * @return void
     */
    public function updatedStartAt(): void
    {
        if (!($this->startAt && $this->endAt)) {
            $this->duration = 0;
            return;
        }

        $startDate = Carbon::createFromFormat('Y-m-d H:i', $this->startAt);
        $endDate = Carbon::createFromFormat('Y-m-d H:i', $this->endAt);

        $this->duration = $startDate->diffInMinutes($endDate);
    }

    /**
     * Catch the updated event for end at
     *
     * @return void
     */
    public function updatedEndAt(): void
    {
        if (!($this->startAt && $this->endAt)) {
            $this->duration = 0;
            return;
        }

        $startDate = Carbon::createFromFormat('Y-m-d H:i', $this->startAt);
        $endDate = Carbon::createFromFormat('Y-m-d H:i', $this->endAt);

        $this->duration = $startDate->diffInMinutes($endDate);
    }
}
