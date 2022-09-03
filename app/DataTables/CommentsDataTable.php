<?php
namespace App\DataTables;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Core\Facades\Filter;

/**
 * Class CommentsDataTable
 *
 * @package App\DataTables
 */
class CommentsDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
    */
    public string $model = Comment::class;

     /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'CommentsDataTable';

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
            Column::ID('id', 'comments.id')->setVisibility(false),
            Column::text('created_at')->setVisibility(false),
            Column::text('task.name')
                ->setSortRelationship('tasks', 'tasks.name', 'task_id', 'tasks.id'),
            Column::text('user.name')
                ->setSortRelationship('users', 'users.name', 'user_id', 'users.id'),
            Column::text('comment'),
        ]);

        // Set your filters
        $this->setFilters([
            Filter::text('task', 'name', 'Task', 'task', 'name'),
            Filter::text('user', 'name', 'User', 'user', 'name'),
        ]);

        // Set your actions
        $this->setActions([
            Action::edit('comments.edit', ['comment' => 'id']),
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
        return $query->with(['user', 'task']);
    }
}
