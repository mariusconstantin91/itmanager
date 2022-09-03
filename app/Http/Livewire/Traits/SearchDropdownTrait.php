<?php
/**
 * Trait which add the functionality for search dropdown functionality
 * Add this trait on component and add the $searchDropDowns property with names of the wire:models
 * and updated{model} hook for each dropdown
 */
namespace App\Http\Livewire\Traits;

trait SearchDropdownTrait
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
     * Generate the needed properties on mount
     *
     * @return void
     */
    public function mountDropDown()
    {
        foreach ($this->searchDropDowns as $searchDropDown) {
            $inputName = $this->getInputName($searchDropDown);
            $item = $this->getPropertyValue($searchDropDown);
            $this->$inputName = '';
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
        $inputName = $this->getInputName($name);
        $this->$inputName = $text;
    }

    /**
     * Reset the dropdown to initial values
     *
     * @param string $name
     * @return void
     */
    public function resetSearchDropdown(string $name)
    {
        $inputName = $this->getInputName($name);
        $item = $this->getPropertyValue($name);
        if ($item) {
            if (isset($this->items[$name][$item])) {
                $this->$inputName = $this->items[$name][$item];
            }
        } else {
            $this->$inputName = '';
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
    public function showClick(string $name)
    {
        $inputName = $this->getInputName($name);

        $updated = 'updated' . ucwords($inputName);
        $this->$updated();
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
        $inputName = $this->getInputName($name);

        if ($this->items[$name][$id]) {
            $this->fill([$name => $id ?? null]);
            $this->$inputName = $this->items[$name][$id] ?? null;
        }
    }

    /**
     * Transform the input name from dotted/snake case value in cammel case and add Input at the end
     *
     * @param string $name
     * @return string
     */
    public function getInputName(string $name)
    {
        $name = str_replace('.', ' ', $name);
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return lcfirst($name . 'Input');
    }
}
