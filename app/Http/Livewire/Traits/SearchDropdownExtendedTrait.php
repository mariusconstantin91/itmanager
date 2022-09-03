<?php
/**
 * Trait which add the functionality for search dropdown functionality
 * Extend to support for dinamically elements(array with multiple dropdowns with the ability to add delete them)
 * Add this trait on component and add the $searchDropDownsExtended property with names of the wire:models
 * and updated{model} hook for each dropdown
 */
namespace App\Http\Livewire\Traits;

trait SearchDropdownExtendedTrait
{
    /**
     * Array with options for each dropdown
     *
     * @var array
     */
    public $items = [];

    /**
     * Array with the choosen keys for each dropdown
     *
     * @var array
     */
    public $choosenKey = [];

    /**
     * Array with the choosen option
     *
     * @var array
     */
    public $choosenOption = [];

    /**
     * Array with the search text input names
     *
     * @var array
     */
    public $inputNames = [];

    /**
     * Generate the needed properties on mount
     *
     * @return void
     */
    public function mountDropDownExtended()
    {
        foreach ($this->searchDropDownsExtended as $searchDropDown) {
            $this->inputNames = [
                str_replace('.', '_', $searchDropDown) => '',
            ];

            $this->items[$searchDropDown] = [];
        }
    }

    /**
     * Populate the text of the input on edit pages
     *
     * @param string $name
     * @param string $text
     * @return void
     */
    public function initSearchDropdown(string $name, string $text)
    {
        $this->inputNames[str_replace('.', '_', $name)] = $text;
    }

    /**
     * Reset the dropdown to initial values
     *
     * @param string $name
     * @return void
     */
    public function resetSearchDropdown(string $name)
    {
        /* $inputName = $this->getInputName($name); */
        $item = $this->getPropertyValue($name);
        if ($item) {
            if (isset($this->items[$name][$item])) {
                $this->inputNames[str_replace('.', '_', $name)] = $this->items[$name][$item];
            }
        } else {
            $this->inputNames[str_replace('.', '_', $name)] = '';
            $this->items[$name] = [];
            $this->fill([$name => null]);
        }
    }

    /**
     * Show the options on click
     *
     * @param string $name
     * @return void
     */
    public function showClick(string $name, string $functionOptions)
    {
        $this->$functionOptions($name, $this->inputNames[str_replace('.', '_', $name)]);
    }

    /**
     * Save the choosen item
     *
     * @param string $name
     * @param $id
     * @return void
     */
    public function selectItem(string $name, $id)
    {
        if ($this->items[$name][$id]) {
            $this->fill([$name => $id ?? null]);
            $this->inputNames[str_replace('.', '_', $name)] = $this->items[$name][$id] ?? null;
        }
    }
}
