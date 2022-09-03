<?php
namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Core\Facades\Filter;

/**
 * Class UsersDataTable
 *
 * @package App\DataTables
 */
class UsersDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
    */
    public string $model = User::class;

     /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'UsersDataTable';

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
            Column::text('role.name')
            ->setSortRelationship('roles', 'roles.name', 'role_id', 'roles.id'),
            Column::text('position'),
            Column::text('email'),
            Column::text('phone'),
            Column::text('country.name')
                ->setSortRelationship('countries', 'countries.name', 'country_id', 'countries.id'),
            Column::text('city'),
            Column::text('salary', 'salary', 'Salary($)'),
        ]);

        // Set your filters
        $this->setFilters([
            Filter::text('name', 'name', 'Name'),
            Filter::text('role', 'name', 'Role', 'role', 'name'),
            Filter::text('position', 'position', 'Position'),
            Filter::text('email', 'email', 'Email'),
            Filter::text('phone', 'phone', 'Phone'),
            Filter::text('country', 'name', 'Country', 'country', 'name'),
            Filter::text('city', 'city', 'City'),
        ]);

        if (auth()->user()->hasRole('user')) {
            // Set your actions
            $this->setActions([
                Action::link('View')->setRoute('users.show', ['user' => 'id']),
                Action::edit('users.edit', ['user' => 'id']),
            ]);
        } else {
            // Set your actions
            $this->setActions([
                Action::link('View')->setRoute('users.show', ['user' => 'id']),
                Action::edit('users.edit', ['user' => 'id']),
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
        return $query->with(['country', 'role']);
    }
}
