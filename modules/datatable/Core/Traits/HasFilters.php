<?php

namespace Modules\DataTable\Core\Traits;

use Modules\DataTable\Core\Collections\FiltersCollection;

/**
 * Trait HasFilters
 */
trait HasFilters
{
    /**
     * Enagle filers
     *
     * @var bool
    */
    public bool $enableFilters = false;

    /**
     * Enable reset filters
     *
     * @var bool
    */
    public bool $enableResetFilters = true;

    /**
     * The filters
     *
     * @var \Modules\DataTable\Core\Collections\FiltersCollection
    */
    public FiltersCollection $filters;

    /**
     * Return the filters
     *
     * @return \Modules\DataTable\Core\Collections\FiltersCollection
     */
    public function filters(): FiltersCollection
    {
        return $this->filters;
    }

    /**
     * Set filters
     *
     * @param  array  $filters
     * @return $this
     */
    public function setFilters(array $filters): self
    {
        $this->filters = FiltersCollection::make($filters);

        return $this;
    }

    /**
     * Check if is filterable
     *
     * @return bool
     */
    public function isFilterable(): bool
    {
        return $this->enableFilters &&
            $this->columns()
                ->where('filterable', true)
                ->count() &&
            $this->filters->isNotEmpty();
    }

    /**
     * Show reset filter button
     *
     * @return bool
     */
    public function showResetFiltersButton(): bool
    {
        return $this->enableResetFilters && $this->isFilterable();
    }
}
