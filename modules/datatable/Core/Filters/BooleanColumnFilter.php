<?php

namespace Modules\DataTable\Core\Filters;

use Modules\DataTable\Core\Abstracts\DataTableFilter;

/**
 * Class BooleanColumn
 */
class BooleanColumnFilter extends DataTableFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'boolean';

    /**
     * Set query
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function setQuery($query, $value)
    {
        if ($value === null) {
            return $query;
        }

        return $query->where($this->attribute, $value);
    }

    /**
     * Return the value
     *
     * @return mixed|null
     */
    public function value()
    {
        if ($this->value === null) {
            return null;
        }

        return (bool) $this->value;
    }

    /**
     * The view for the filter
     *
     * @return string
     */
    public function view()
    {
        return 'datatable::filters.boolean-column-filter';
    }
}
