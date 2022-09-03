<?php

namespace Modules\DataTable\Core\Abstracts;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Modules\DataTable\Core\Columns\TextColumn;
use Modules\DataTable\Core\Traits\HasActions;
use Modules\DataTable\Core\Traits\HasColumns;
use Modules\DataTable\Core\Traits\HasFilters;
use Modules\DataTable\Core\Traits\HasPagination;
use Modules\DataTable\Core\Traits\HasSearch;
use Modules\DataTable\Core\Traits\Serializable;

/**
 * Class DataTable
 */
abstract class DataTable
{
    use Serializable;
    use HasColumns, HasActions, HasFilters, HasPagination, HasSearch;

    /**
     * The serialization of the datatable
     *
     * @var string
    */
    private static string $serializationSecretKey = 'datatables_' . self::class;

    /**
     * Table name
     *
     * @var string
    */
    public string $name = 'table';

    /**
     * The id
     *
     * @var string
    */
    public string $id;

    /**
     * Closure to get the data
     *
     * @var \Closure
    */
    public Closure $customQuery;

    /**
     * Model of the datatable
     *
     * @var string
    */
    public string $model;

    /**
     * The table
     *
     * @var string
    */
    public string $table;

    /**
     * DataTable Constructor
     */
    public function __construct(string $id = null)
    {
        $this->id = $id ?? uniqid();
        $this->init();

        if ($this->hasActions() && !$this->columns()->get('actions')) {
            $this->columns()->add(
                (new TextColumn('actions'))
                    ->setLabel('')
                    ->setSortable(false)
                    ->setFilterable(false)
            );
        }

        if ($this->model) {
            $this->table = (new $this->model)->getTable();
        }
    }

    /**
     * Set the id
     *
     * @param  string  $id
     * @return string
     */
    public function setId(string $id): string
    {
        $this->id = $id ?? uniqid();

        return $this->id;
    }

    /**
     * Data sent to view
     *
     * @return array
     */
    public function viewData(): array
    {
        return [
            'datatable' => $this,
            'records' => $this->getRecordsFromQuery(),
        ];
    }

    /**
     * Logic to get the records
     *
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getRecordsFromQuery()
    {
        $query = $this->newQuery()
            ->where(function ($query) {
                $query->when(
                    $this->isFilterable() && $this->filters()->hasValues(),
                    function ($query) {
                        foreach ($this->filters()->whereNotNullValue() as $filter
                        ) {
                            $query = $filter->query($query);
                        }
                    }
                );

                return $query;
            })
            ->where(function ($query) {
                $query->when($this->isSearchable() && $this->search, function (
                    $query
                ) {
                    foreach ($this->getQueryableAttributes() as $index => $name
                    ) {
                        $query->{$index === 0 ? 'where' : 'orWhere'}(
                            $name,
                            'like',
                            "%$this->search%"
                        );
                    }
                });

                return $query;
            })
            ->when($this->columns()->get($this->sortBy), function ($query) {
                return $this->sortRelation($query);
            });

        return $this->paginate
            ? $query->paginate($this->pageLength)
            : $query->get();
    }

    /**
     * Get Query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery(): mixed
    {
        $query = (new $this->model())->query();
        
        if (method_exists($this::class, 'query')) {
            $query = $this->query($query);
        }
        
        if (isset($this->customQuery)) {
            $query = ($this->customQuery)($query);
        }

        return $query;
    }

    /**
     * Attributes for query
     *
     * @return array
     */
    protected function getQueryableAttributes()
    {
        $model = new $this->model();

        return $this->columns()
            ->filter(function ($item) {
                return $item->searchable || $item->filterable;
            })
            ->whereNull('renderCallback')
            ->whereIn(
                'attribute',
                collect([
                    $model->getKeyName(),
                    $model->getCreatedAtColumn(),
                    $model->getUpdatedAtColumn(),
                ])
                    ->merge($model->getFillable())
                    ->diff($model->getHidden())
                    ->unique()
                    ->values()
            )
            ->pluck('attribute')
            ->toArray();
    }

    /**
     * Set the query
     *
     * @param  \Closure  $customQuery
     * @return $this
     */
    public function setQuery(Closure $customQuery): self
    {
        $this->customQuery = $customQuery;

        return $this;
    }

    /**
     * Get the collection queryable attributes
     *
     * @return array
     */
    protected function getCollectionQueryableAttributes()
    {
        return $this->columns()
            ->where('searchable', true)
            ->whereNotIn('attribute', $this->getQueryableAttributes())
            ->pluck('attribute')
            ->toArray();
    }

    /**
     * Sort the records after a relation column
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function sortRelation($query)
    {
        if ($this->columns()->get($this->sortBy)->relationships) {
            return $query
                ->select(
                    $this->table . '.*',
                    $this->columns()->get($this->sortBy)->sortColumn .
                        ' as sort_column'
                )
                ->leftJoin(
                    $this->columns()->get($this->sortBy)->relatedTable,
                    $this->columns()->get($this->sortBy)->firstJoinCondition,
                    '=',
                    $this->columns()->get($this->sortBy)->secondJoinCondition
                )
                ->orderByRaw('sort_column' . ' ' . $this->sortDir);
        }

        return $query->orderBy(
            $this->columns()->get($this->sortBy)->attribute,
            $this->sortDir
        );
    }
}
