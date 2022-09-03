<?php

namespace App\DataTables;

use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Facades\Filter;

/**
 * Class LocationsDataTable
 */
class LocationsDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
     */
    public string $model = Location::class;

     /**
     * The name of the table from database
     *
     * @var string
     */
    public string $table = 'locations';

    /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'LocationsDataTable';

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
            Column::text('hm')
                ->setLabel('<input class="selectAll" type="checkbox">')
                ->setRenderCallback(function ($entity) {
                    return "<input id='$entity->id' type='checkbox' class='select-record'>";
                }, true)
                ->setSortable(false),
            Column::text('name'),
            Column::text('region.name')
                ->setSortRelationship(
                    'regions',
                    'regions.name',
                    'locations.region_id',
                    'regions.id'
                )
                ->setLabel('Region'),
            Column::boolean('has_beach')
                ->setTrueString('Yes')
                ->setFalseString('No'),
            Column::boolean('just_activity')
                ->setLabel('Stop')
                ->setTrueString('Yes')
                ->setFalseString('No'),
        ]);

        // Set your filters
        $this->setFilters([
            Filter::text('name', 'name', 'Name')->setIcon(
                'fa-solid fa-magnifying-glass'
            ),
            Filter::text('region', 'name', 'Region', 'region', 'name'),
            Filter::boolean('has_beach', 'has_beach')->setValue(false),
            Filter::boolean('just_activity', 'just_activity')->setValue(false),
        ]);

        // Set your actions
        $this->setActions([
            Action::edit('locations.edit', ['location' => 'id']),
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
