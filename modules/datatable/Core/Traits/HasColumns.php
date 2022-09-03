<?php

namespace Modules\DataTable\Core\Traits;

use Modules\DataTable\Core\Abstracts\DataTableColumn;
use Modules\DataTable\Core\Collections\ColumnsCollection;

/**
 * Trait HasColumns
 */
trait HasColumns
{
    /**
     * Enable sorting
     *
     * @var bool
    */
    public bool $enableSorting = true;

    /**
     * Columns
     *
     * @var \Modules\DataTable\Core\Collections\ColumnsCollection
    */
    public ColumnsCollection $columns;

    /**
     * Set the columns
     *
     * @return $this
     */
    public function setColumns(array $columns): self
    {
        $this->columns = ColumnsCollection::make($columns);

        return $this;
    }

    /**
     * Check if the current column is sorting
     *
     * @param  \Modules\DataTable\Core\Abstracts\DataTableColumn  $column
     * @param  string  $direction
     * @return bool
     */
    public function isCurrentSortingColumn(
        DataTableColumn $column,
        string $direction
    ): bool
    {
        return $this->sortBy === $column->name && $this->sortDir === $direction;
    }

    /**
     * Check if it is sortable
     *
     * @return bool
     */
    public function isSortable()
    {
        return $this->enableSorting;
    }

    /**
     * Logic for sort by
     *
     * @param  string  $name
     * @param  string  $dir
     * @return bool
     */
    public function sortBy(string $name, string $dir = 'asc'): bool
    {
        if ($this->columns()->get($name) &&
            $this->columns()->get($name)->sortable
        ) {
            $this->sortBy = $name;
            $this->sortDir = $dir;

            return true;
        }

        return false;
    }

    /**
     * Get Columns
     *
     * @return \Modules\DataTable\Core\Collections\ColumnsCollection
     */
    public function columns(): ColumnsCollection
    {
        return $this->columns;
    }
}
