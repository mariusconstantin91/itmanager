<?php

namespace Modules\DataTable\Core\Filters;

use Modules\DataTable\Core\Abstracts\DataTableFilter;

/**
 * Class TextColumn
 */
class IDColumnFilter extends DataTableFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'id';

    /**
     * The name
     *
     * @var string
    */
    public string $name = 'id';

    /**
     * The attribute
     *
     * @var string
    */
    public string $attribute = 'id';

    /**
     * The label
     *
     * @var string|null
    */
    public ?string $label = 'ID';

    /**
     * The constuct
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     * @param  string|null  $label
     */
    public function __construct(
        string $name = null,
        string $attribute = null,
        string $label = null
    )
    {
        parent::__construct(
            $name ?? $this->name,
            $attribute ?? $this->attribute,
            $label ?? $this->label
        );
    }

    /**
     * Set the query
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function setQuery($query, $value)
    {
        return $query->where($this->attribute, $value);
    }

    /**
     * The view
     *
     * @return string
     */
    public function view()
    {
        return 'datatable::filters.id-column-filter';
    }
}
