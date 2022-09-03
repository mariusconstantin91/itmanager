<?php
/**
 * Trait which add the functionality for formated select (the name and the model should be the same!)
 * - Add this trait on component and add the $searchSelects property with the names of the selects
 */
namespace App\Http\Livewire\Traits;

trait SelectFormatedTrait
{
    /**
     * Array with the choosen option
     *
     * @var array
     */
    public array $choosenOptionSelect = [];

    /**
     * Generate the needed properties on mount
     *
     * @return void
     */
    public function mountSelect()
    {
        /* foreach ($this->searchSelects as $searchSelect) {
            $this->choosenOptionSelect[str_replace('.', '_', $searchSelect)] = '';
        } */
    }

    /**
     * Function call when the component is loaded first time
     * Used to show the default value
     *
     * @param string $name
     * @param string $optionsProperty
     * @return void
     */
    public function initSelect(string $name, string $optionsProperty)
    {
        $item = $this->getPropertyValue($name);
        $this->choosenOptionSelect[str_replace('.', '_', $name)] =
            isset($this->$optionsProperty[$item]) ? $this->$optionsProperty[$item] : '';
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
    public function selectItemSelect(string $name, $id, string $optionName)
    {
        $this->choosenOptionSelect[str_replace('.', '_', $name)] = $optionName;
        $this->fill([$name => $id]);
    }
}
