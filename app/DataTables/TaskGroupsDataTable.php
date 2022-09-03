<?php
namespace App\DataTables;

use App\Models\TaskGroup;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Abstracts\DataTable;

/**
 * Class TaskGroupsDataTable
 *
 * @package App\DataTables
 */
class TaskGroupsDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
    */
    public string $model = TaskGroup::class;

     /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'TagsDataTable';

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
            Column::text('name')->setSortable(true),
            Column::text('created_at')->setVisibility(false),
        ]);

        // Set your filters
        $this->setFilters([]);

        if (auth()->user()->hasRole('user')) {
            // Set your actions
            $this->setActions([
                Action::link('View')->setRoute('task_groups.show', ['taskGroup' => 'id']),
            ]);
        } else {
            $this->setActions([
                Action::link('View')->setRoute('task_groups.show', ['taskGroup' => 'id']),
                Action::edit('task_groups.edit', ['taskGroup' => 'id']),
                Action::delete(),
            ]);
        }
    }

    /**
     * The Query builder which return the data for the table
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Before delete action
     *
     * @param $entity
     * @return string|bool
     */
    public function beforeDeleteActionPerformed($entity)
    {
        $entity->load(['tasks']);
        if ($entity->tasks->count()) {
            session()->flash('messageError', 'The task group has tasks, please deasign them before deleteing it!');
            return false;
        }

        return true;
    }
}
