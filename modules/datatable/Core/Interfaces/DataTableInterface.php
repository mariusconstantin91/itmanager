<?php

namespace Modules\DataTable\Core\Interfaces;

use Illuminate\Support\Collection;

/**
 * Class DataTable
 */
interface DataTableInterface
{
    /**
     * Check if the searchable flag is true
     *
     * @return bool
     */
    public function isSearchable(): bool;

    /**
     * Check if is filtrable flag is true
     *
     * @return bool
     */
    public function isFilterable(): bool;

    /**
     * Sort by logic
     *
     * @param  string  $columnAttribute
     * @param  string  $dir
     * @return bool
     */
    public function sortBy(string $columnAttribute, string $dir = 'asc'): bool;

    /**
     * Get the column
     *
     * @param  string  $columnAttribute
     * @return mixed|null
     */
    public function getColumn(string $columnAttribute): mixed;

    /**
     * Get Columns
     *
     * @return \Illuminate\Support\Collection
     */
    public function columns(): Collection;

    /**
     * Get the page lengt menu
     *
     * @return int[]
     */
    public function pageLengthMenu(): array;

    /**
     * Tha data for the view
     *
     * @return array
     */
    public function viewData(): array;

    /**
     * Get Query
     *
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public function query(): mixed;
}
