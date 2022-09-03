<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class ListColumn
 *
 * @package Modules\DataTable\Core\Columns
 */
class ListColumn extends DataTableColumn
{
    /**
     *  The type
     *
    * @var string
    */
    public string $type = 'list';

    /**
     * The separator for values
     *
    * @var string
    */
    public string $separator = ', ';

    public string $beforeString = '';

    public string $afterString = '';

    /**
     * Resolve Data
     *
     * @param $data
     * @param $entity
     * @return string
     */
    public function resolveData($data, $entity): string
    {
        $data = !empty($data) ? $this->beforeString . (is_string($data) ? $data :
            implode($this->separator, $data ?? [])) . $this->afterString : '';

        if ($route = $this->getRoute($entity)) {
            return "<a href='$route' class='link-info'>$data</a>";
        }

        return $data;
    }

    /**
     *  Set the separator
     *
     * @param string $separator
     * @return $this
     */
    public function setSeparator(string $separator): self
    {
        $this->separator = $separator;

        return $this;
    }

    public function setBeforeString(string $beforeString): self
    {
        $this->beforeString = $beforeString;

        return $this;
    }

    public function setAfterString(string $afterString): self
    {
        $this->afterString = $afterString;

        return $this;
    }
}
