<?php
namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Http\Livewire\Traits\SelectFormatedMultiTrait;
use App\Models\Client;
use App\Models\User;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait, SelectFormatedTrait, SelectFormatedMultiTrait;

    /**
     * The main entity of the component
     *
     * @var Project
     */
    public Project $project;

    /**
     * Array for search selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchDropDownsExtended = [
        'project.client_id',
    ];

    /**
     * Array for search formated selects, it contains the name of them
     *
     * @var array
     */
    public $searchSelects = [
        'project.status',
        'project.importance',
    ];

    /**
     * Array for search formated selects, it contains the name of them
     *
     * @var array
     */
    public $searchSelectsMulti = [
        'userIds',
    ];

     /**
     * Search input property for users, used by multiple select
     *
     * @var string
     */
    public $userInput = '';

     /**
     * Property to keep the selected users ids
     *
     * @var array
     */
    public $userIds = [];

    /**
     * Property populated with the options for users
     *
     * @var array
     */
    public $userOptions = [];


    /**
     * Property populated with the options for locations
     *
     * @var array
     */
    public $countryOptions = [];

    /**
     * Property populated with the options for locations
     *
     * @var array
     */
    public $clientOptions = [];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'project.name' => ['required'],
        'project.client_id' => ['required'],
        'project.status' => ['required', 'in:not_started,in_progess,finished'],
        'project.start_date' => ['required', 'date', 'date_format:Y-m-d'],
        'project.deadline_date' => ['required', 'date', 'after:soft_deadline_date', 'after:start_date', 'date_format:Y-m-d'],
        'project.soft_deadline_date' => ['required', 'date', 'after:start_date', 'date_format:Y-m-d'],
        'project.budget' => ['numeric'],
        'project.importance' => ['required', 'numeric', 'gte:0', 'lte:4' ],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'project.client_id' => 'client',
    ];

    /**
     * Status options
     *
     * @var array
     */
    public $statusOptions = [
        'not_started' => 'Not started',
        'in_progess' => 'In progress',
        'finished' => 'Finished',
    ];

    /**
     * Importance options
     *
     * @var array
     */
    public $importanceOptions = [
        Project::LOWEST => 'Lowest',
        Project::LOW => 'Low',
        Project::MEDIUM => 'Medium',
        Project::HIGH => 'High',
        Project::HIGHEST => 'Highest',
    ];

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

     /**
     * Generate the needed properties on mount
     *
     * @return void
     */
    public function mount()
    {
        $this->mountSelectMulti();
        $this->userOptions = User::get()->take(10)->pluck('name', 'id')->toArray();
    }

    /**
     * Catch the updated event for client input, set the results filtered by search word
     *
     * @return void
     */
    public function clientUpdated($name, $value)
    {
        $this->items[$name] = Client::where('name', 'like', $value . '%')
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
    public function updatedUserInput()
    {
        $builder = User::take(10);
        if ($this->userInput) {
            $builder = $builder->where('name', 'like', $this->userInput . '%');
        }

        $this->userOptions = $builder->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
