<?php

namespace Modules\DataTable\Core\Filters;

use Closure;
use Exception;
use Modules\DataTable\Core\Abstracts\DataTableFilter;

/**
 * Class MultipleColumn
 */
class MultipleColumnFilter extends DataTableFilter
{
    /**
     * The type
     *
     * @var string
    */
    public string $type = 'multiple';

    /**
     * The options
     *
     * @var array
    */
    public array $options = [];

    /**
     * Set the query
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function setQuery($query, $value)
    {
        return $query->where($this->attribute, $value);
    }

    /**
     * The view
     *
     * @return string
     */
    public function view()
    {
        return 'datatable::filters.multiple-column-filter';
    }

    /**
     * Set the options
     *
     * @param  array|\Closure  $options
     * @return $this
     *
     * @throws \Exception
     */
    public function setOptions(array|Closure $options): self
    {
        if ($options instanceof Closure) {
            $options = $options();
        }

        if (is_array($options) || is_object($options)) {
            $this->options = collect($options)
                ->mapWithKeys(function ($label, $value) {
                    if (is_string($label)) {
                        return [$value => $label];
                    }

                    if (is_numeric($value) &&
                        (is_array($label) || is_object($label))
                    ) {
                        $label = (object) $label;
                        if (isset($label->label) && isset($label->value)) {
                            return [$label->value => $label->label];
                        }
                    }

                    return [$value => null];
                })
                ->filter(function ($value) {
                    return !is_null($value);
                })
                ->toArray();

            return $this;
        }

        return throw new Exception(
            "The options passed are not formed correctly for filter $this->label"
        );
    }

    /**
     * Set the options nullable value
     *
     * @param  string  $nullValueLabel
     * @return $this
     */
    public function setOptionsNullValue(string $nullValueLabel = null)
    {
        $this->options =
            [null => $nullValueLabel ?? $this->placeholder] + $this->options;

        return $this;
    }

    /**
     * Get the options
     *
     * @return array
     */
    public function options()
    {
        return $this->options;
    }
}
