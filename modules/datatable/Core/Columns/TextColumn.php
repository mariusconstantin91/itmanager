<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class TextColumn
 */
class TextColumn extends DataTableColumn
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'text';

    /**
     * The text which should come afer the column value
     *
     * @var string
     */
    public string $suffix = '';

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
            return "<a href='$route' class='text-blue-700'>$data $this->suffix</a>";
        }

        return $data . ' ' . $this->suffix;
    }

    /**
     * Set the suffix of the column
     *
     * @param string $suffix
     * @return $this
     */
    public function setSuffix(string $suffix): TextColumn
    {
        $this->suffix = $suffix;

        return $this;
    }
}
