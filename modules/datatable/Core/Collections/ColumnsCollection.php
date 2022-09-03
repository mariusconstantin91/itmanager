<?php

namespace Modules\DataTable\Core\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class ColumnsCollection
 */
class ColumnsCollection extends Collection
{
    /**
     * Get the column from collection
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
}
