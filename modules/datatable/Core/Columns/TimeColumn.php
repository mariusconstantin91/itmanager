<?php

namespace Modules\DataTable\Core\Columns;

use Carbon\Carbon;
use Exception;
use Modules\DataTable\Core\Abstracts\DataTableColumn;

/**
 * Class TimeColumn
 */
class TimeColumn extends DataTableColumn
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'time';

    /**
     * The format
     *
     * @var string
    */
    public string $format = 'H:i:s';

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
            logger('Error parse data in time column');
        }

        return $route ? "<a href='$route' class='link-info'>$data</a>" : $data;
    }

    /**
     * Set the format of the column
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
