<?php
namespace App\DataTables;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Core\Facades\Filter;

/**
 * Class TasksDataTable
 *
 * @package App\DataTables
 */
class TasksDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
    */
    public string $model = Task::class;

     /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'TasksDataTable';

   /**
     * Default sort order : 'desc' | 'asc'
     *
     * @var string
     */
    public string $sortDir = 'desc';

    /**
     * The column name for defaut sort
     *
     * @var string
     */
    public string $sortBy = 'created_at';

    /**
     * Display Search, Filters, Sorting and Pagination properties in url
     *
     * @var bool
     */
    public bool $hasQueryStrings = true;

    /**
     * Enable the pagination: true | false
     *
     * @var bool
     */
    public bool $paginate = true;

   /**
     * The number of items per page 10 | 25 | 50 | 100
     *
     * @var int
     */
    public int $pageLength = 10;

    /**
     * Enable search
     *
     * @var bool
     */
    public bool $enableSearch = true;

    /**
     * Enable Sorting
     *
     * @var bool
     */
    public bool $enableSorting = true;

    /**
     * Enable Filters
     *
     * @var bool
     */
    public bool $enableFilters = true;

   /**
     * Enable Reset Filters Button
     *
     * @var bool
     */
    public bool $enableResetFilters = true;

    /**
     * The initial setup for datatable, function call when the compoment is initialized
     *
     * @return void
     */
    public function init()
    {
        // Set your columns
        $this->setColumns([
            Column::ID()->setVisibility(false),
            Column::text('created_at')->setVisibility(false),
            Column::text('project.name')
                ->setSortRelationship('projects', 'projects.name', 'project_id', 'projects.id'),
            Column::text('name'),
            Column::selectArray('priority')
                ->setOptions([
                    Task::LOWEST => 'Lowest',
                    Task::LOW => 'Low',
                    Task::MEDIUM => 'Medium',
                    Task::HIGH => 'High',
                    Task::HIGHEST => 'Highest',
                ])
                ->setSearchable(false),
            Column::text('estimate')->setLabel('Estiamte(min)'),
            Column::view('tags')
                ->setSortable(false)
                ->setView('datatable::columns.tasks_tags'),
            Column::view('skills')
                ->setSortable(false)
                ->setView('datatable::columns.tasks_skills'),
            Column::view('users')
                ->setSortable(false)
                ->setView('datatable::columns.tasks_users'),
            Column::selectArray('status')
                ->setOptions([
                    'todo' => 'To do',
                    'open' => 'Open',
                    'in_progess' => 'In progress',
                    'ready_for_code_review' => 'Ready for code review',
                    'code_reviewed' => 'Code Reviewed',
                    'ready_for_testing' => 'Ready for testing',
                    'testing' => 'Testing',
                    'done' => 'Done'
                ])
                ->setSearchable(false),
        ]);

        // Set your filters
        $this->setFilters([
            Filter::text('name', 'name', 'Name'),
            Filter::multiple('priority', 'priority', 'Priority')
                ->setOptions([
                    Task::LOWEST => 'Lowest',
                    Task::LOW => 'Low',
                    Task::MEDIUM => 'Medium',
                    Task::HIGH => 'High',
                    Task::HIGHEST => 'Highest',
                ]),
            Filter::multiple('status', 'status', 'Status')
                ->setOptions([
                    'done' => 'Done',
                    'testing' => 'Testing',
                    'ready_for_testing' => 'Ready for testing',
                    'code_reviewed' => 'Code Reviewed',
                    'ready_for_code_review' => 'Ready for code review',
                    'in_progess' => 'In progress',
                    'open' => 'Open',
                    'todo' => 'To do',
                ]),
            Filter::text('project', 'name', 'Project', 'project', 'name'),
            Filter::text('tags', 'name', 'Tags', 'tags', 'name'),
            Filter::text('skills', 'name', 'Skills', 'skills', 'name'),
            Filter::text('users', 'name', 'Users', 'users', 'name'),
        ]);

        // Set your actions
        $this->setActions([
            Action::link('View')->setRoute('tasks.show', ['task' => 'id']),
            Action::edit('tasks.edit', ['task' => 'id']),
            Action::delete(),
        ]);
    }

    /**
     * The Query builder which return the data for the table
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Builder $query): Builder
    {
        return $query->with(['tags', 'skills', 'users']);
    }

    /**
     * Before delete action
     *
     * @param $entity
     * @return string|bool
     */
    public function beforeDeleteActionPerformed($entity)
    {
        $entity->load(['timeEntries', 'comments']);
        if ($entity->timeEntries->count()) {
            session()->flash('messageError', 'The task has time entries, please delete them before deleteing it!');
            return false;
        }

        $entity->comments->each(function ($comment) {
            $comment->delete();
        });

        $entity->tags()->sync([]);
        $entity->skills()->sync([]);
        $entity->users()->sync([]);
        $entity->taskGroups()->sync([]);

        return true;
    }
}
