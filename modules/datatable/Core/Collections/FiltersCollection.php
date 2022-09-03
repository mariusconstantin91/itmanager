<?php

namespace Modules\DataTable\Core\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class FiltersCollection
 */
class FiltersCollection extends Collection
{
    /**
     * Get the filter from collection
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::first(
            $this->items,
            function ($item) use ($key) {
                return $item->name === $key;
            },
            $default
        );
    }

    /**
     * Set the filters from collection
     *
     * @param  array  $values
     * @return \Modules\DataTable\Core\Collections\FiltersCollection|\Illuminate\Support\Collection|m.\Modules\DataTable\Core\Collections\FiltersCollection.mapWithKeys
     */
    public function setValues(array $values)
    {
        if (empty($values)) {
            $this->each(function ($filter) {
                $filter->setValue(null);
            });
        }

        foreach ($values as $filter => $value) {
            $filterIndex = $this->search(function ($item) use ($filter) {
                return $item->name === $filter;
            });

            if (is_numeric($filterIndex)) {
                $this->items[$filterIndex]->setValue($value);
            }
        }

        return $this->getValues();
    }

    /**
     * Get the filters from collection
     *
     * @return \Modules\DataTable\Core\Collections\FiltersCollection|\Illuminate\Support\Collection|m.\Modules\DataTable\Core\Collections\FiltersCollection.mapWithKeys
     */
    public function getValues()
    {
        return $this->mapWithKeys(function ($filter) {
            return [$filter->name => $filter->value()];
        });
    }

    /**
     * Check if it has values
     *
     * @return bool
     */
    public function hasValues()
    {
        return $this->filter(function ($item) {
            return !is_null($item->value());
        })->isNotEmpty();
    }

    /**
     * Where not null values
     *
     * @return \Modules\DataTable\Core\Collections\FiltersCollection|m.\Modules\DataTable\Core\Collections\FiltersCollection.filter
     */
    public function whereNotNullValue()
    {
        return $this->filter(function ($item) {
            return !is_null($item->value());
        });
    }
}
