<?php

namespace Modules\DataTable\Core\Filters;

use Modules\DataTable\Core\Abstracts\DataTableFilter;

/**
 * Class EmailColumn
 */
class EmailColumnFilter extends DataTableFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'email';

    /**
     * Set the query
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function setQuery($query, $value)
    {
        return $query->where($this->attribute, 'like', "%$value%");
    }

    /**
     * The view
     *
     * @return string
     */
    public function view()
    {
        return 'datatable::filters.email-column-filter';
    }
}
