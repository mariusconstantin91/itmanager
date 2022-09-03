<?php

namespace Modules\DataTable\Core\Filters;

use Carbon\Carbon;
use Exception;
use Modules\DataTable\Core\Abstracts\DataTableFilter;

/**
 * Class DatetimeColumn
 */
class DatetimeColumnFilter extends DataTableFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'datetime';

    /**
     * The format
     *
     * @var string
    */
    public string $format = 'm/d/Y H:i:S';

    /**
     * The range
     *
     * @var bool
    */
    public bool $range = false;

    /**
     * The start date attribute
     *
     * @var string
    */
    public string $start_date_attribute;

    /**
     * The end date attribute
     *
     * @var string
    */
    public string $end_date_attribute;

    /**
     * Set query
     *
     * @param $query
     * @param  array  $value
     * @return mixed
     */
    public function setQuery($query, $value)
    {
        $value = $this->getDateInterval($value);
        if (!isset($this->start_date_attribute)) {
            $this->start_date_attribute = $this->attribute;
        }
        if (!isset($this->end_date_attribute)) {
            $this->end_date_attribute = $this->attribute;
        }

        if ($this->range) {
            if (isset($value['start_date'])) {
                $query->whereDate(
                    $this->start_date_attribute,
                    '>=',
                    Carbon::parse($value['start_date'])->toDateString()
                );
            }

            if (isset($value['end_date'])) {
                $query->whereDate(
                    $this->end_date_attribute,
                    '<=',
                    Carbon::parse($value['end_date'])->toDateString()
                );
            }

            return $query;
        }

        if (isset($value['start_date'])) {
            $query->whereDate(
                $this->start_date_attribute,
                Carbon::parse($value['start_date'])->toDateString()
            );
        }

        return $query;
    }

    /**
     * Get the date interval
     *
     * @param $dates
     * @return null[]
     */
    public function getDateInterval($dates)
    {
        $dates = explode(' to ', $dates);

        if (isset($dates[0])) {
            try {
                $start_date = Carbon::parse($dates[0])->format($this->format);
            } catch (Exception $exception) {
                $start_date = null;
            }
        } else {
            $start_date = null;
        }

        if (isset($dates[1])) {
            try {
                $end_date = Carbon::parse($dates[1])->format($this->format);
            } catch (Exception $exception) {
                $end_date = null;
            }
        } else {
            $end_date = null;
        }

        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }

    /**
     * Set the format
     *
     * @param  string  $format
     * @return $this
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * The view
     *
     * @return string
     */
    public function view()
    {
        return 'datatable::filters.datetime-column-filter';
    }

    /**
     * Enable range
     *
     * @return $this
     */
    public function enableRange(): self
    {
        $this->range = true;

        return $this;
    }

    /**
     * Disable range
     *
     * @return $this
     */
    public function disableRange(): self
    {
        $this->range = false;

        return $this;
    }

    /**
     * Set start date attribute
     *
     * @param  string  $start_date_attribute
     * @return $this
     */
    public function setStartDateAttribute(string $start_date_attribute): self
    {
        $this->start_date_attribute = $start_date_attribute;

        return $this;
    }

    /**
     * Set end date attribute
     *
     * @param  string  $end_date_attribute
     * @return $this
     */
    public function setEndDateAttribute(string $end_date_attribute): self
    {
        $this->end_date_attribute = $end_date_attribute;

        return $this;
    }
}
