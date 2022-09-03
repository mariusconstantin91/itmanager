<?php

namespace Modules\DataTable\Core\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class ActionsCollection
 */
class ActionsCollection extends Collection
{
    /**
     * Get the element in colection
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
