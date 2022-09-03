<?php

namespace Modules\DataTable\Core\Traits;

/**
 * Trait HasSearch
 */
trait HasSearch
{
    /**
     * Enable search
     *
     * @var bool
    */
    public bool $enableSearch = true;

    /**
     * Search
     *
     * @var string|null
    */
    public ?string $search = null;

    /**
     * Check if if is searchable
     *
     * @return bool
     */
    public function isSearchable(): bool
    {
        return $this->enableSearch &&
            $this->columns()
                ->where('searchable', true)
                ->count();
    }

    /**
     * Set the search
     *
     * @param  string  $search
     * @return $this
     */
    public function setSearch(string $search)
    {
        $this->search = $search;

        return $this;
    }
}
