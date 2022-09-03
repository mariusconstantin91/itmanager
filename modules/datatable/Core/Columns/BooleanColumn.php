<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class BooleanColumn
 */
class BooleanColumn extends DataTableColumn
{
    /**
     * Type column
     *
     * @var string
    */
    public string $type = 'boolean';

    /**
     * True string
     *
     * @var string
    */
    public string $true_string = 'Yes';

    /**
     * False string
     *
     * @var string
    */
    public string $false_string = 'No';

    /**
     * Resolve Data
     *
     * @param $data
     * @param $entity
     * @return string
     */
    public function resolveData($data, $entity): string
    {
        $data = $data ? $this->true_string : $this->false_string;

        if ($route = $this->getRoute($entity)) {
            return "<a href='$route' class='link-info'>$data</a>";
        }

        return $data;
    }

    /**
     * Set false string
     *
     * @param  string  $false_string
     * @return $this
     */
    public function setFalseString(string $false_string): self
    {
        $this->false_string = $false_string;

        return $this;
    }

    /**
     * Set true string
     *
     * @param  string  $true_string
     * @return $this
     */
    public function setTrueString(string $true_string): self
    {
        $this->true_string = $true_string;

        return $this;
    }
}
