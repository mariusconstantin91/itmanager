<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class MultipleColumn
 */
class MultipleColumn extends DataTableColumn
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'multiple';

    /**
     * The separator for values
     *
     * @var string
    */
    public string $separator = ', ';

    /**
     * Resolve Data
     *
     * @param $data
     * @param $entity
     * @return string
     */
    public function resolveData($data, $entity): string
    {
        $data = implode($this->separator, $data);

        if ($route = $this->getRoute($entity)) {
            return "<a href='$route' class='link-info'>$data</a>";
        }

        return $data;
    }

    /**
     * Set the separator
     *
     * @param  string  $separator
     * @return $this
     */
    public function setSeparator(string $separator): self
    {
        $this->separator = $separator;

        return $this;
    }
}
