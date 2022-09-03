<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class EmailColumn
 */
class EmailColumn extends DataTableColumn
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'email';

    /**
     * Resolve Data
     *
     * @param $data
     * @param $entity
     * @return string
     */
    public function resolveData($data, $entity): string
    {
        $route = $this->getRoute($entity);

        return "<a href='" .
            ($route ?? 'mailto:$data') .
            "' class='link-info'>$data</a>";
    }
}
