<?php
namespace App\Http\Livewire\Comments;

use App\Models\Comment;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Models\Task;
use App\Models\User;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait, SelectFormatedTrait;

    /**
     * The main entity of the component
     *
     * @var Comment
     */
    public Comment $comment;

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
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'comment.comment' => ['required'],
        'comment.user_id' => ['required'],
        'comment.task_id' => ['required'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'comment.user_id' => 'user',
        'comment.task_id' => 'task',
    ];

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

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
}
