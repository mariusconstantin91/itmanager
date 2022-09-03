<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class TextColumn
 */
class IDColumn extends DataTableColumn
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
     * The displayed label
     *
     * @var string
    */
    public string $label = 'ID';

    /**
     * Flag for filtrable
     *
     * @var bool
    */
    public bool $filterable = true;

    /**
     * The constuctor
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
     * Resolve Data
     *
     * @param $data
     * @param $entity
     * @return mixed
     */
    public function resolveData($data, $entity): mixed
    {
        if ($route = $this->getRoute($entity)) {
            return "<a href='$route' class='link-info'>$data</a>";
        }

        return $data;
    }
}
