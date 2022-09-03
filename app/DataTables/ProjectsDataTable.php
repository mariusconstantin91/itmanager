<?php
namespace App\DataTables;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Core\Facades\Filter;

/**
 * Class ProjectsDataTable
 *
 * @package App\DataTables
 */
class ProjectsDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
    */
    public string $model = Project::class;

     /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'ProjectsDataTable';

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
            Column::text('name'),
            Column::selectArray('importance')
                ->setOptions([
                    Project::LOWEST => 'Lowest',
                    Project::LOW => 'Low',
                    Project::MEDIUM => 'Medium',
                    Project::HIGH => 'High',
                    Project::HIGHEST => 'Highest',
                ])
                ->setSearchable(false),
            Column::text('client.name')
                ->setSortRelationship('clients', 'clients.name', 'client_id', 'clients.id'),
            Column::selectArray('status')
                ->setOptions([
                    'not_started' => 'Not started',
                    'in_progess' => 'In progress',
                    'finished' => 'Finished'
                ])
                ->setSearchable(false),
            Column::text('budget')->setSuffix('EUR'),
            Column::date('start_date')
                ->setFormat('Y-m-d'),
            Column::date('deadline_date')
                ->setFormat('Y-m-d'),
        ]);

        // Set your filters
        $this->setFilters([
            Filter::text('name', 'name', 'Name'),
            Filter::multiple('importance', 'importance', 'Importance')
                ->setOptions([
                    Project::LOWEST => 'Lowest',
                    Project::LOW => 'Low',
                    Project::MEDIUM => 'Medium',
                    Project::HIGH => 'High',
                    Project::HIGHEST => 'Highest',
                ]),
            Filter::date('start_date', 'start_date', 'Start Date')
                ->setFormat('Y-m-d')
                ->enableRange(),
            Filter::date('deadline_date', 'deadline_date', 'Deadline Date')
                ->setFormat('Y-m-d')
                ->enableRange(),
            Filter::text('budget', 'budget', 'Buget'),
        ]);

        if (auth()->user()->hasRole('user')) {
            $this->setActions([
                Action::link('View')->setRoute('projects.show', ['project' => 'id']),
            ]);
        } else {
            $this->setActions([
                Action::link('View')->setRoute('projects.show', ['project' => 'id']),
                Action::edit('projects.edit', ['project' => 'id']),
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
        $entity->load(['timeEntries', 'tasks']);
        if ($entity->timeEntries->count()) {
            session()->flash('messageError', 'The project has time entries, please delete them before deleteing it!');
            return false;
        }

        if ($entity->tasks->count()) {
            session()->flash('messageError', 'The project has tasks, please delete them before deleteing it!');
            return false;
        }

        $entity->tags()->sync([]);
        $entity->skills()->sync([]);
        $entity->users()->sync([]);

        return true;
    }
}
