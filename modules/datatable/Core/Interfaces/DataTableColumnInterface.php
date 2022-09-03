<?php

namespace Modules\DataTable\Core\Interfaces;

use Closure;
use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class DataTableColumn
 */
interface DataTableColumnInterface
{
    /**
     * Set the type
     *
     * @param  string  $type
     * @return \Modules\DataTable\Core\Abstracts\DataTableColumn
     */
    public function setType(string $type): DataTableColumn;

    /**
     * Set the attribute
     *
     * @param  string  $attribute
     * @return \Modules\DataTable\Core\Abstracts\DataTableColumn
     */
    public function setAttribute(string $attribute): DataTableColumn;

    /**
     * Set the label
     *
     * @param  string  $label
     * @return \Modules\DataTable\Core\Abstracts\DataTableColumn
     */
    public function setLabel(string $label): DataTableColumn;

    /**
     * Set the render callback
     *
     * @param  \Closure  $renderCallback
     * @param  bool  $skipCustomFormatting
     * @return \Modules\DataTable\Core\Abstracts\DataTableColumn
     */
    public function setRenderCallback(
        Closure $renderCallback,
        bool $skipCustomFormatting
    ): DataTableColumn;

    /**
     * Set the sortable flag
     *
     * @param  bool  $sortable
     * @return \Modules\DataTable\Core\Abstracts\DataTableColumn
     */
    public function setSortable(bool $sortable): DataTableColumn;

    /**
     * Set the filtrable flag
     *
     * @param  bool  $filterable
     * @return \Modules\DataTable\Core\Abstracts\DataTableColumn
     */
    public function setFilterable(bool $filterable): DataTableColumn;

    /**
     * Render the entity
     *
     * @param $entity
     * @return null
     */
    public function render($entity);

    /**
     * Resolv the render callback
     *
     * @param $entity
     * @return mixed
     */
    public function resolveRenderCallback($entity): mixed;

    /**
     * Resolve Data
     *
     * @param $data
     * @param $entity
     */
    public function resolveData($data, $entity);
}
