<?php

namespace Modules\DataTable\Core\Columns;

use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class TextColumn
 */
class ViewColumn extends DataTableColumn
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'view';

    /**
     * The view which will be rended for column
     *
     * @var string
     */
    public string $viewName = '';
    
    /**
     * The parameters of the view
     *
     * @var array
     */
    public array $viewParameters = [];

    /**
     * Resolve Data
     *
     * @param $data
     * @param $entity
     * @return mixed
     */
    public function resolveData($data, $entity): mixed
    {
        $viewParameters = $this->viewParameters + [
                'entity' => $entity,
                'data' => $data
            ];

        return view($this->viewName, $viewParameters)->render();
    }

    /**
     * Set the view of the column
     *
     * @param string $viewName
     * @param array $viewParameters
     * @return $this
     */
    public function setView(string $viewName, array $viewParameters = []): ViewColumn
    {
        $this->viewName = $viewName;
        $this->viewParameters = $viewParameters;

        return $this;
    }
}
