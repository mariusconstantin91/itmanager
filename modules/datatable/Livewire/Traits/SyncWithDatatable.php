<?php

namespace Modules\DataTable\Livewire\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Trait SyncWithDatatable
 */
trait SyncWithDatatable
{
    /**
     * $syncItem = [ * | search | filters | sort | pagination | queryString |
     * queryStringSearch | queryStringFilters | queryStringSort | queryStringPagination |
     * cacheDataTable | getCachedDataTable ]
     *
     * @param  string  $syncItem
     * @return void
     */
    protected function syncWithDataTable(string $syncItem = '*'): void
    {
        if (in_array($syncItem, ['*', 'search']) &&
            $this->datatable->isSearchable()
        ) {
            $this->datatable->setSearch($this->search);
        }

        if (in_array($syncItem, ['*', 'filters']) &&
            $this->datatable->isFilterable()
        ) {
            $this->filters = $this->datatable->filters
                ->setValues($this->filters)
                ->toArray();
        }

        if (in_array($syncItem, ['*', 'sort']) &&
            $this->datatable->isSortable()
        ) {
            if (!$this->sortBy ||
                !$this->sortDir ||
                !$this->datatable->sortBy($this->sortBy, $this->sortDir)
            ) {
                $this->sortBy = $this->datatable->sortBy;
                $this->sortDir = $this->datatable->sortDir;
            }
        }

        if (in_array($syncItem, ['*', 'pagination'])) {
            if ($this->pageLength) {
                $this->datatable->pageLength = $this->pageLength;
            } else {
                $this->pageLength = $this->datatable->pageLength;
            }
        }

        if (in_array($syncItem, ['search', 'filters', 'pagination'])) {
            $this->resetPage();
        }

        if (in_array($syncItem, [
                'queryString',
                'queryStringSearch',
                'queryStringFilters',
                'queryStringSort',
                'queryStringPagination',
            ])
        ) {
            if (!$this->datatable->hasQueryStrings) {
                $this->queryString = [];
            } else {
                if (in_array($syncItem, ['queryString', 'queryStringSearch']) &&
                    $this->datatable->isSearchable()
                ) {
                    $this->queryString = collect($this->queryString)
                        ->merge([
                            'search' => [
                                'as' => "{$this->datatable->name}_search",
                                'except' => '',
                            ],
                        ])
                        ->toArray();

                    $this->search = request()->query(
                        "{$this->datatable->name}_search",
                        $this->search
                    );
                }

                if (in_array($syncItem, [
                        'queryString',
                        'queryStringFilters',
                    ]) &&
                    $this->datatable->isFilterable()
                ) {
                    $this->queryString = collect($this->queryString)
                        ->merge([
                            'filters' => [
                                'as' => "{$this->datatable->name}_filters",
                            ],
                        ])
                        ->toArray();

                    $this->filters = request()->query(
                        "{$this->datatable->name}_filters",
                        $this->filters
                    );
                }

                if (in_array($syncItem, ['queryString', 'queryStringSort']) &&
                    $this->datatable->isSortable()
                ) {
                    $this->queryString = collect($this->queryString)
                        ->merge([
                            'sortBy' => [
                                'as' => "{$this->datatable->name}_sortBy",
                            ],
                            'sortDir' => [
                                'as' => "{$this->datatable->name}_sortDir",
                            ],
                        ])
                        ->toArray();

                    $this->sortBy = request()->query(
                        "{$this->datatable->name}_sortBy",
                        $this->sortBy
                    );
                    $this->sortDir = request()->query(
                        "{$this->datatable->name}_sortDir",
                        $this->sortDir
                    );
                }

                if (in_array($syncItem, [
                        'queryString',
                        'queryStringPagination',
                    ]) &&
                    $this->datatable->paginate
                ) {
                    $this->queryString = collect($this->queryString)
                        ->merge([
                            'pageLength' => [
                                'as' => "{$this->datatable->name}_perPage",
                                'except' => '10',
                            ],
                        ])
                        ->toArray();

                    $this->pageLength = request()->query(
                        "{$this->datatable->name}_perPage",
                        $this->pageLength
                    );
                }
            }
        }

        if (in_array($syncItem, ['cacheDataTable'])) {
            Cache::forget($this->datatableId);
            Cache::put($this->datatableId, $this->datatable);
        }

        if (in_array($syncItem, ['getCachedDataTable'])) {
            $this->datatable = Cache::get($this->datatableId);
        }
    }
}
