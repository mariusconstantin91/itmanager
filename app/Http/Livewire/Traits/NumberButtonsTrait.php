<?php
/**
 * Trait which add the functionality for number buttons input type
 */
namespace App\Http\Livewire\Traits;

trait NumberButtonsTrait
{
    /**
     * Increase the value of the name property
     *
     * @param string $name
     * @return void
     */
    public function increase(string $name)
    {
        $this->syncInput($name, (float) $this->getPropertyValue($name) + 1);
    }

    /**
     * Decrease the value of the name property
     *
     * @param string $name
     * @return void
     */
    public function decrease(string $name)
    {
        $this->syncInput($name, (float) $this->getPropertyValue($name) - 1);
    }
}
