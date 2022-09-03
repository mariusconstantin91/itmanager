<?php

namespace Modules\DataTable\Core\Traits;

/**
 * Trait HasPagination
 */
trait HasPagination
{
    /**
     * Sort by column
     *
     * @var string
    */
    public string $sortBy;

    /**
     * Sort direction
     *
     * @var string
    */
    public string $sortDir;

    /**
     * Pagination
     *
     * @var bool
    */
    public bool $paginate = true;

    /**
     * The lenght of the page
     *
     * @var int
    */
    public int $pageLength = 10;

    /**
     * Has query strings
     *
     * @var bool
    */
    public bool $hasQueryStrings = true;

    /**
     * Page menu
     *
     * @return int[]
     */
    public function pageLengthMenu(): array
    {
        return [10, 25, 50, 100];
    }
}
