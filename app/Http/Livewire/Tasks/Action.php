<?php
namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Http\Livewire\Traits\NumberButtonsTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Http\Livewire\Traits\SelectFormatedMultiTrait;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\TaskGroup;
use App\Models\User;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait;
    use NumberButtonsTrait;
    use SelectFormatedTrait;
    use SelectFormatedMultiTrait;

    /**
     * The main entity of the component
     *
     * @var Task
     */
    public Task $task;

    /**
     * Array for search selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchDropDownsExtended = [
        'task.project_id',
    ];

    /**
     * Array for selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchSelects = [
        'task.importance',
        'task.status',
        'task.story_points',
    ];

    /**
     * Array for multi selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchSelectsMulti = [
        'userIds',
        'taskGroupIds',
        'suggestionsProjectsId',
        'suggestionsRelatedTaskId',
    ];

    /**
     * Search input property for users, used by multiple select
     *
     * @var string
     */
    public $userInput = '';

    /**
     * Search input property for task groups, used by multiple select
     *
     * @var string
     */
    public $taskGroupInput = '';

    /**
     * Property to keep the selected user ids
     *
     * @var array
     */
    public $userIds = [];

    /**
     * Property to keep the selected taskGroup ids
     *
     * @var array
     */
    public $taskGroupIds = [];

    /**
     * Property populated with the options for projects
     *
     * @var array
     */
    public $projectOptions = [];

    /**
     * Search input property for projects, used by multiple select
     *
     * @var string
     */
    public $suggestionsProjectInput = '';

    /**
     * Property used to keep the suggested projects
     *
     * @var array
     */
    public array $suggestionsProjectsId = [];

    /**
     * Property populated with the options for suggested projects
     *
     * @var array
     */
    public $suggestedProjectOptions = [];

    /**
     * Search input property for relatedtasks, used by multiple select
     *
     * @var string
     */
    public $suggestionsRelatedTasksInput = '';

    /**
     * Property used to keep the suggested related tasks
     *
     * @var array
     */
    public array $suggestionsRelatedTaskId = [];

    /**
     * Property populated with the options for suggested related task options
     *
     * @var array
     */
    public $suggestedRelatedTaskOptions = [];

    /**
     * Property populated with the suggested users with their score
     *
     * @var array
     */
    public $usersWithScore = [];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'task.name' => [
            'required',
        ],
        'task.status' => [
            'required', 'in:todo,open,in_progess,ready_for_code_review,code_reviewed,ready_for_testing,testing,done',
        ],
        'task.priority' => [
            'required', 'numeric',
        ],
        'task.estimate' => [
            'required', 'numeric',
        ],
        'task.story_points' => [
            'required', 'numeric',
        ],
        'task.project_id' => [
            'required', 'numeric',
        ],
        'task.description' => [
            'required',
        ],
        'task.deadline' => [
            'required', 'date_format:Y-m-d',
        ],
        'userIds' => [
            'required',
        ],
        'taskGroupIds' => [
            'sometimes',
        ],
        'tagItems.*.name' => ['required'],
        'tagItems.*.importance' => ['required'],
        'skillItems.*.name' => ['required'],
        'skillItems.*.importance' => ['required'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'task.project_id' => 'project',
        'userIds' => 'users',
        'taskGroupIds' => 'task groups',
        'tags.*.name' => 'tag name',
        'tags.*.importance' => 'tag importance',
        'skillItems.*.name' => 'skill name',
        'skillItems.*.importance' => 'skill importance',
    ];

    /**
    * Priority options
    *
    * @var array
    */
    public $importanceOptions = [
        Task::LOWEST => 'Lowest',
        Task::LOW => 'Low',
        Task::MEDIUM => 'Medium',
        Task::HIGH => 'High',
        Task::HIGHEST => 'Highest',
    ];

    /**
    * Status options
    *
    * @var array
    */
    public $statusOptions = [
        'todo' => 'To do',
        'open' => 'Open',
        'in_progess' => 'In progress',
        'ready_for_code_review' => 'Ready for code review',
        'code_reviewed' => 'Code reviewed',
        'ready_for_testing' => 'Ready for testing',
        'testing' => 'Testing',
        'done' => 'Done'
    ];

    /**
    * Story points options
    *
    * @var array
    */
    public $storyPointsOptions = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '5' => '5',
        '8' => '8',
        '13' => '13',
        '21' => '21',
        '34' => '34',
    ];

    /**
     * Array with the tag items of the task
     *
     * @var array
     */
    public $tagItems = [];

    /**
     * An empty element for a tag Item
     *
     * @var array
     */
    public $tagItemEmpty = [
        'name' => '',
        'importance' => '',
    ];

    /**
     * Array with the skill items of the task
     *
     * @var array
     */
    public $skillItems = [];

    /**
     * An empty element for a skill Item
     *
     * @var array
     */
    public $skillItemEmpty = [
        'name' => '',
        'importance' => '',
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
        $this->suggestedProjectOptions = Project::take(10)->get()->pluck('name', 'id')->toArray();
        $this->suggestedRelatedTaskOptions = Task::take(10)->where('project_id', $this->task->project_id)->get()->pluck('name', 'id')->toArray();
    }

    /**
     * Add a new line in tags items table
     *
     * @return void
     */
    public function addTagNewLine()
    {
        $this->tagItems[] = $this->tagItemEmpty;
    }

    /**
     * Delete a line from tags items line
     *
     * @param int | string $index
     * @return void
     */
    public function deleteTagLine($index)
    {
        $this->resetErrorBag('tagItems.' . $index . '.name');
        $this->resetErrorBag('tagItems.' . $index . '.importance');

        unset($this->tagItems[$index]);
    }

    /**
     * Add a new line in skills items table
     *
     * @return void
     */
    public function addSkillNewLine()
    {
        $this->skillItems[] = $this->skillItemEmpty;
    }

    /**
     * Delete a line from skills items line
     *
     * @param int | string $index
     * @return void
     */
    public function deleteSkillLine($index)
    {
        $this->resetErrorBag('skillItems.' . $index . '.name');
        $this->resetErrorBag('skillItems.' . $index . '.importance');

        unset($this->skillItems[$index]);
    }

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

    /**
     * Catch the updated event for tag input, set the results filtered by search word
     *
     * @return void
     */
    public function tagUpdated($name, $value)
    {
        $this->items[$name] = Tag::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'name')
            ->toArray();
    }

    /**
     * Catch the updated event for skill input, set the results filtered by search word
     *
     * @return void
     */
    public function skillUpdated($name, $value)
    {
        $this->items[$name] = Skill::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'name')
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

    /**
     * Catch the updated event for taskGroup input, set the results filtered by search word
     *
     * @return void
     */
    public function updatedTaskGroupInput()
    {
        $builder = TaskGroup::take(10);
        if ($this->taskGroupInput) {
            $builder = $builder->where('name', 'like', $this->taskGroupInput . '%');
        }

        $this->taskGroupOptions = $builder->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for suggestes project input, set the results filtered by search word
     *
     * @return void
     */
    public function updatedSuggestionsProjectInput()
    {
        $builder = Project::take(10);
        if ($this->suggestionsProjectInput) {
            $builder = $builder->where('name', 'like', $this->suggestionsProjectInput . '%');
        }

        $this->suggestedProjectOptions = $builder->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for suggestes task input, set the results filtered by search word
     *
     * @return void
     */
    public function updatedsuggestionsRelatedTasksInput()
    {
        $builder = Task::take(10)->where('project_id', $this->task->project_id);
        if ($this->suggestionsRelatedTasksInput) {
            $builder = $builder->where('name', 'like', $this->suggestionsRelatedTasksInput . '%');
        }

        $this->suggestedRelatedTaskOptions = $builder->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Call when the modal is closed
     *
     * @return void
     */
    public function closeSuggestionsModal()
    {
        $this->usersWithScore = [];
    }

    /**
     * Function which contains the algoritm to suggest users
     *
     * @return void
     */
    public function makeSuggestions()
    {
        // lines -> users competence on a skill Low -> High
        // columns -> task required competence on a skill Low -> High
        // cell -> the score for the match
        $scorringMatrix = [
            [100, 85, 60, 40, 25],
            [75, 100, 85, 60, 40],
            [55, 75, 100, 85, 60],
            [35, 55, 75, 100, 85],
            [23, 35, 55, 75, 100],
        ];

        $builderUsers = User::with('skills', 'tasks')->where('role_id', 4)->take(100);

        //filter users after projects
        if (count($this->suggestionsProjectsId)) {
            $builderUsers = $builderUsers->where(function ($query) {
                $query->whereDoesntHave('projects')
                    ->orWhereHas('projects', function ($query) {
                        return $query->where(function ($query) {
                            return $query->whereIn('projects.id', $this->suggestionsProjectsId)
                                ->orWhere('projects.id', $this->task->project_id);
                        });
                    });
            });
        } else {
            $builderUsers = $builderUsers = $builderUsers->where(function ($query) {
                $query->whereDoesntHave('projects')
                    ->orWhereHas('projects', function ($query) {
                        return $query->where('projects.id', $this->task->project_id);
                    });
            });
        }

        $users = $builderUsers->get();

        $usersScore = [];
        foreach ($users as $user) {
            //check if user is on related tasks
            $related = false;
            foreach ($user->tasks as $userTasks) {
                if (in_array($userTasks->id, $this->suggestionsRelatedTaskId)) {
                    $related = true;
                }
            }

            //calculate the score
            $scoreUser = 0;
            foreach ($user->skills as $skillUser) {
                foreach ($this->skillItems as $skillTask) {
                    if ($skillTask['name'] == $skillUser->name) {
                        $scoreMatrix = $scorringMatrix[$skillUser->pivot->importance][$skillTask['importance']];
                        if ($related) {
                            $scoreUser += $scoreMatrix + 0.25 * $scoreMatrix;
                        } else {
                            $scoreUser += $scoreMatrix;
                        }
                    }
                }
            }

            if ($scoreUser != 0) {
                $usersScore[] = [
                    'user' => $user,
                    'score' => $scoreUser,
                ];
            }
        }

        $this->usersWithScore = collect($usersScore)->sortByDesc('score')->values()->toArray();
    }
}
