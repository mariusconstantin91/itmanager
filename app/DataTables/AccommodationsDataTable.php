<?php

namespace App\DataTables;

use App\Models\Location;
use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Facades\Filter;
use Modules\DataTable\Core\Abstracts\DataTable;

/**
 * Class AccommodationsDataTable
 */
class AccommodationsDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
     */
    public string $model = Accommodation::class;

     /**
     * The name of the table from database
     *
     * @var string
     */
    public string $table = 'accommodation';

    /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'AccommodationDataTable';

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
            Column::text('hm')
                ->setLabel('<input class="selectAll" type="checkbox">')
                ->setRenderCallback(function ($entity) {
                    return "<input id='$entity->id' type='checkbox' class='select-record'>";
                }, true)
                ->setSortable(false),
                Column::boolean('status')->setTrueString('Active')->setFalseString('False')->setSortable(false),
                Column::text('type')->setSortable(false),
            Column::text('name')->setSortable(false),
            Column::text('location.name')->setSortable(false)->setLabel('Location'),
            Column::text('provider.name')->setSortable(false)->setLabel('Provider'),
            Column::text('rating')->setSortable(false),
        ]);

        // Set your filters
        $this->setFilters([]);

        // Set your actions
        $this->setActions([
            Action::edit('accommodations.edit', ['accommodation' => 'id']),
        ]);
    }

    /**
     * The Query builder which return the data for the table
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Builder $query): Builder
    {
        return $query;
    }
}
