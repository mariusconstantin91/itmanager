<?php
/**
 * Trait which add the functionality for formated multi select (the name and the model should be the same!)
 * - Add this trait on component and add the $searchSelectsMulti property with the names of the selects
 * - Add the property fot the search input and the updated hook for it in the compoment
 */
namespace App\Http\Livewire\Traits;

trait SelectFormatedMultiTrait
{
    /**
     * Array with the choosen option
     *
     * @var array
     */
    public $choosenOptionSelectMulti = [];

    /**
     * Array with the values from inputs
     *
     * @var array
     */
    public $inputSelectMulti = [];

    /**
     * Generate the needed properties on mount
     *
     * @return void
     */
    public function mountSelectMulti()
    {
        foreach ($this->searchSelectsMulti as $searchSelect) {
            $this->choosenOptionSelectMulti[$searchSelect] = [];
            $this->inputSelectMulti[$searchSelect] = '';
        }
    }

    /**
     * Call on first initialization of the component
     *
     * @param string $name
     * @param string $optionsProperty - the name of the options properties for the select
     * @return void
     */
    public function initSelectMulti($name, string $optionsProperty)
    {
        $values = $this->getPropertyValue($name);
        foreach ($values as $item) {
            if (isset($this->$optionsProperty[$item])) {
                $this->choosenOptionSelectMulti[$name][] = $this->$optionsProperty[$item];
            }
        }
    }

    /**
     * Save the choosen item
     *
     * @param string $name
     * @param $id
     * @param string $primaryKey
     * @param string $nameAttribute
     * @return void
     */
    public function selectItemSelectMulti(string $name, $id, string $optionName, string $input)
    {
        $this->$input = '';
        $this->{'updated'.$input}();
        if (!in_array($optionName, $this->choosenOptionSelectMulti[$name])) {
            $this->choosenOptionSelectMulti[$name][] = $optionName;
            $items = $this->getPropertyValue($name);
            $items[] = $id;
            $this->fill([$name => $items]);
        }
    }

    /**
     * Remove the choosen item
     *
     * @param string $name
     * @param string $index
     * @return void
     */
    public function removeItemSelectMulti(string $name, $index)
    {
        unset($this->choosenOptionSelectMulti[$name][$index]);
        $items = $this->getPropertyValue($name);
        unset($items[$index]);
        $this->fill([$name => $items]);
    }
}
