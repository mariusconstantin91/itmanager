<?php

namespace Modules\DataTable\Core\Columns;

use Carbon\Carbon;
use Exception;
use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class DateColumn
 */
class DateColumn extends DataTableColumn
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'date';

    /**
     * Date format of the column
     *
     * @var string
    */
    public string $format = 'Y-m-d';

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

        try {
            $data = Carbon::parse($data)->format($this->format);
        } catch (Exception $exception) {
            logger('Error parse data DateColumn');
        }

        return $route ? "<a href='$route' class='link-info'>$data</a>" : $data;
    }

    /**
     * Set date format
     *
     * @param  string  $format
     * @return $this
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }
}
