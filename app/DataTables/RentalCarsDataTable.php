<?php
namespace App\DataTables;

use App\Models\RentalCar;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Abstracts\DataTable;

/**
 * Class RentalsDataTable
 *
 * @package App\DataTables
 */
class RentalCarsDataTable extends DataTable
{
    /**
     * Model assosciated with this table.
     *
     * @var string
     */
    public string $model = RentalCar::class;

    /**
     * Name of data table class.
     *
     * @var string
     */
    public string $name = 'RentalCarsDataTable';

    /**
     * Initial sort direction of default column.
     * Valid options: `desc` or `asc`
     *
     * @var string
     */
    public string $sortDir = 'desc';

    /**
     * Default colunn to sort by.
     *
     * @var string
     */
    public string $sortBy = 'created_at';

    /**
     * Wether to show full sort and filter queries in the URL.
     *
     * @var bool
    */
    public bool $hasQueryStrings = true;

    /**
     * Enable pagination.
     *
     * @var bool
     */
    public bool $paginate = true;

    /**
     * If pagination is true, maximum number of entities per page.
     *
     * @var int
     */
    public int $pageLength = 10;

    /**
     * Enable or disable search functionality.
     *
     * @var bool
     */
    public bool $enableSearch = true;

    /**
     * Enable or disable sorting functionality.
     *
     * @var bool
     */
    public bool $enableSorting = true;

    /**
     * Enable or disable filter functionality.
     *
     * @var bool
     */
    public bool $enableFilters = true;

    /**
     * Enable or disable resetting of filters.
     *
     * @var bool
     */
    public bool $enableResetFilters = true;

    /**
     * Initialisation method.
     *
     * @return void
     */
    public function init()
    {
        // Set your columns
        $this->setColumns([
            Column::ID()->setVisibility(false),
            Column::text('hm')->setLabel('<input class="selectAll" type="checkbox">')
                ->setRenderCallback(function ($entity) {
                    return "<input id='$entity->id' type='checkbox' class='select-record'>";
                }, true)
                ->setSortable(false),
            Column::text('name')->setSortable(false),
            Column::text('provider_id', 'provider.name', 'Provider')->setSortable(false),
            Column::text('pax')->setSortable(false),
            Column::boolean('active')->setLabel('Status')->setTrueString('Active')->setFalseString('Inactive'),
        ]);

        // Set your filters
        $this->setFilters([]);

        // Set your actions
        $this->setActions([
            Action::edit('rentalcars.edit', ['rentalCar' => 'id']),
        ]);
    }

    /**
     * Query builder method.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Builder $query): Builder
    {
        return $query;
    }
}
