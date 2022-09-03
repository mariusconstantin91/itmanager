<?php
namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\DataTables\UsersDataTable;
use App\DataTables\DocumentsDataTable;
use App\DataTables\ProjectsDataTable;
use App\DataTables\TasksDataTable;
use App\DataTables\TimeEntriesDataTable;
use App\Models\Comment;
use App\Models\TimeEntry;
use Carbon\Carbon;

class Show extends Component
{
    /**
     * The main entity of the component
     *
     * @var Task
     */
    public Task $task;

    /**
     * The comments of the task
     *
     * @var array
     */
    public array $comments = [];

    /**
     * The new comment fields
     *
     * @var string
     */
    public string $newComment = '';

    /**
     * The new time entry fields
     *
     * @var array
     */
    public array $newTimeEntry = [
        'start_at',
        'end_at',
        'description',
    ];

     /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'newComment' => ['required'],
    ];
    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        $this->task->load('comments.user', 'project', 'users', 'tags', 'skills', 'taskGroups', 'timeEntries');

        $this->comments = $this->task->comments->sortBy('created_at')->map(function ($comment) {
                return [
                    'comment_id' => $comment->id,
                    'comment' => $comment->comment,
                    'user' => $comment->user->name,
                    'user_id' => $comment->user_id,
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('Y-m-d'),
                ];
        })->toArray();
    }

    /**
     * Return the view for task show
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        $taskId = $this->task->id;
        $datatableUsers = (new UsersDataTable())->setQuery(function ($query) use ($taskId) {
            return $query->whereHas('tasks', function ($query) use ($taskId) {
                $query->where('tasks.id', $taskId);
            });
        });

        $datatableTimeEntries = (new TimeEntriesDataTable())->setQuery(function ($query) use ($taskId) {
            return $query->where('task_id', $taskId);
        });

        $trackedTime = 0;
        foreach ($this->task->timeEntries as $timeEntry) {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $timeEntry->start_at);
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $timeEntry->end_at);
            $trackedTime += $endDate->diffInMinutes($startDate);
        }

        return view('livewire.tasks.show', [
            'datatableUsers' => $datatableUsers,
            'datatableTimeEntries' => $datatableTimeEntries,
            'trackedTime' => $trackedTime,
        ]);
    }

    /**
     * Add a new comment to the database
     *
     * @return void
     */
    public function addComment()
    {
        $validatedData = $this->validate([
            'newComment' => ['required'],
        ]);
        
        $comment = Comment::create([
            'comment' => $this->newComment,
            'task_id' => $this->task->id,
            'user_id' => auth()->user()->id,
        ]);

        $this->comments[] = [
            'comment_id' => $comment->id,
            'comment' => $this->newComment,
            'user' => auth()->user()->name,
            'user_id' => auth()->user()->id,
            'date' => Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('Y-m-d'),
        ];

        $this->syncInput('newComment', '');
    }

    /**
     * Delete a comment
     *
     * @param mixed $index
     * @return void
     */
    public function deleteComment($index)
    {
        $this->resetErrorBag('comments.' . $index . '.comment');
        unset($this->comments[$index]);
    }

    /**
     * Add a new time entry to the database
     *
     * @return void
     */
    public function addTimeEntry()
    {
        $this->validate(
            [
                'newTimeEntry.start_at' => ['required', 'date_format:Y-m-d H:i'],
                'newTimeEntry.end_at' => ['required', 'date_format:Y-m-d H:i', 'after:start_at'],
                'newTimeEntry.description' => ['required'],
            ],
            [],
            [
                'newTimeEntry.start_at' => 'start at',
                'newTimeEntry.end_at' => 'end at',
                'newTimeEntry.description' => 'description',
            ]
        );
        
        TimeEntry::create([
            'project_id' => $this->task->project_id,
            'user_id' => auth()->user()->id,
            'task_id' => $this->task->id,
            'start_at' => $this->newTimeEntry['start_at'],
            'end_at' => $this->newTimeEntry['end_at'],
            'description' => $this->newTimeEntry['description'],
        ]);

        $this->syncInput('newTimeEntry', [
            'start_at' => '',
            'end_at' => '',
            'description' => '',
        ]);

        $this->emit('refresh');

        session()->flash('messageTimeEntry', 'The time entry was added!');
    }
}
