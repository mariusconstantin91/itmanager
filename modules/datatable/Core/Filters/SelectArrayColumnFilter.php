<?php

namespace Modules\DataTable\Core\Filters;

use Modules\DataTable\Core\Abstracts\DataTableFilter;

/**
 * Class Select with an array Column
 */
class SelectArrayColumnFilter extends DataTableFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'selectArray';
    
    /**
     * The options of the select
     *
     * @var array
    */
    public array $options = [];
    
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
        return 'datatable::filters.select-array-column-filter';
    }

    /**
     * Set the options
     *
     * @param  array  $options
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
