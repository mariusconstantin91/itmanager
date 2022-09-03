<?php

namespace Modules\DataTable\Core\Filters;

/**
 * Class TimeColumn
 */
class TimeColumnFilter extends DatetimeColumnFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'time';

    /**
     * The format
     *
     * @var string
    */
    public string $format = 'H:i:S';

    /**
     * The range
     *
     * @var bool
    */
    public bool $range = false;

    /**
     * The view
     *
     * @return string
     */
    public function view()
    {
        return 'datatable::filters.datetime-column-filter';
    }
}
