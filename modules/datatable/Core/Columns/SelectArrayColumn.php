<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class TextColumn
 */
class SelectArrayColumn extends DataTableColumn
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'selectArray';

    /**
     * The options form which is choosen the text
     *
     * @var array
    */
    public array $options = [];

    /**
     * Resolve Data
     *
     * @param $data
     * @param $entity
     * @return mixed
     */
    public function resolveData($data, $entity): mixed
    {
        $entity;
        return isset($this->options[$data]) ? $this->options[$data] : $data;
    }

    /**
     * Set the options for the column
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options = []): self
    {
        $this->options = $options;

        return $this;
    }
}
