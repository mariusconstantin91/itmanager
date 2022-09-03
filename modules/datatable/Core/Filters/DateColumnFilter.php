<?php

namespace Modules\DataTable\Core\Filters;

/**
 * Class DateColumn
 */
class DateColumnFilter extends DatetimeColumnFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'date';

    /**
     * The format
     *
     * @var string
    */
    public string $format = 'm/d/Y';

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
