<?php

namespace Modules\DataTable\Core\Filters;

use Modules\DataTable\Core\Abstracts\DataTableFilter;

/**
 * Class TextColumn
 */
class TextColumnFilter extends DataTableFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'text';

    /**
     * Set query
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function setQuery($query, $search)
    {
        if ($this->relationship) {
            return $query->whereHas($this->relationship, function ($query) use (
                $search
            ) {
                $query->where($this->attribute, 'like', "%{$search}%");
            });
        }

        return $query->where(
            $query->getModel()->getTable() . '.' . $this->attribute,
            'like',
            "%$search%"
        );
    }

    /**
     * Set the view
     *
     * @return string
     */
    public function view()
    {
        return 'datatable::filters.text-column-filter';
    }
}
