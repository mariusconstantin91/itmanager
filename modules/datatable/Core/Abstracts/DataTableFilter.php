<?php

namespace Modules\DataTable\Core\Abstracts;

use Closure;
use Illuminate\Support\Str;
use Modules\DataTable\Core\Traits\Serializable;

/**
 * Class DataTableFilter
 */
abstract class DataTableFilter
{
    use Serializable;

    /**
     * The serialization of the datatable
     *
     * @var string
    */
    private static string $serializationSecretKey =
        'datatables_filters_' . self::class;

    /**
     *  The type of column
     *
     * @var string
    */
    public string $type;

    /**
     * The name of column
     *
     * @var string
    */
    public string $name;

    /**
     * The attributes of column
     *
     * @var string
    */
    public string $attribute;

    /**
     * The label of column
     *
     * @var string|mixed|null
    */
    public ?string $label = null;

    /**
     * The placeholer for filters
     *
     * @var string|null
    */
    public ?string $placeholder = null;

    /**
     * The icon for filters
     *
     * @var string|null
    */
    public ?string $icon = null;

    /**
     * The value for filter
     *
     * @var mixed|null
    */
    public mixed $value = null;

    /**
     * The relationship
     *
     * @var string|null
     */
    public ?string $relationship = null;

    /**
     * The column
     *
     * @var string|null
    */
    public ?string $column = null;
    
    /**
     * The callback query for the filter
     *
     * @var \Closure
    */
    protected Closure $queryCallback;

    /**
     * The constructor of the filter
     *
     * @param  string  $name
     * @param  string  $attribute
     * @param  string|null  $label
     */
    public function __construct(
        string $name,
        string $attribute,
        string $label = null,
        string $relationship = null,
        string $column = null
    )
    {
        $this->name = $name;
        $this->attribute = $attribute;
        $this->relationship = $relationship;
        $this->column = $column;
        $this->label = $label;
        $this->placeholder = $label ?? $this->makeLabel($name);
    }

    /**
     * Create the label from name
     *
     * @param $name
     * @return string
     */
    protected function makeLabel($name): string
    {
        return ucwords(Str::replace(['-', '_', '.'], ' ', $name));
    }

    /**
     * Set the placeholder
     *
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Set the value
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $this->validateValue($value);

        return $this;
    }

    /**
     * Set the icon
     *
     * @param $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Validation for the value of the filter
     *
     * @param $value
     * @return bool|float|int|mixed[]|string|null
     */
    protected function validateValue($value)
    {
        if (is_bool($value)) {
            return (bool) $value;
        } elseif (is_numeric($value) ||
            (is_string($value) && !empty(($value = trim($value))))
        ) {
            return $value;
        } elseif (is_array($value)) {
            return collect($value)
                ->map(function ($value) {
                    if (is_string($value) && !empty(($value = trim($value)))) {
                        return $value;
                    } elseif (is_numeric($value)) {
                        return $value;
                    }

                    return null;
                })
                ->toArray();
        }

        return null;
    }

    /**
     * The query for the filter
     *
     * @param $query
     * @return mixed
     */
    public function query($query)
    {
        if ($q = $this->resolveQueryCallback($query, $this->value())) {
            return $q;
        } elseif (method_exists($this::class, 'setQuery')) {
            return $this->setQuery($query, $this->value());
        }

        return $query;
    }

    /**
     * Apply the call back for query
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function resolveQueryCallback($query, $value): mixed
    {
        if (isset($this->queryCallback)) {
            return $this->queryCallback->call($this, $query, $value, $this);
        }

        return null;
    }

    /**
     * Get the value
     *
     * @return mixed|null
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Set the query callback
     *
     * @param  \Closure  $queryCallback
     * @return $this
     */
    public function setQueryCallback(Closure $queryCallback): self
    {
        $this->queryCallback = $queryCallback;

        return $this;
    }

    /**
     * Render the filter
     *
     * @return string
     */
    public function render()
    {
        return view($this->view(), ['filter' => $this])->render();
    }
}
