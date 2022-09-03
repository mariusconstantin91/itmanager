<?php
namespace App\Http\Livewire\RentalCars;

use App\Models\Currency;
use App\Models\Location;
use App\Models\Provider;
use App\Models\RentalCar;
use Livewire\Component;

abstract class Action extends Component
{
    /**
     * The main entity of the component.
     *
     * @var RentalCar
     */
    public RentalCar $rentalCar;

    /**
     * Rules for validation and automatic binding of properties.
     *
     * @var string[][]
     */
    protected $rules = [
        'rentalCar.name' => ['required', 'string', 'min:3'],
        'rentalCar.pax' => ['required', 'numeric'],
        'rentalCar.insurance' => ['required', 'numeric'],
        'rentalCar.assistance' => ['required', 'numeric'],
        'rentalCar.price' => ['required', 'numeric'],
        'rentalCar.price_peak' => ['required', 'numeric'],
        'rentalCar.margin' => ['required', 'numeric'],
        'rentalCar.active' => ['boolean'],
        'rentalCar.provider_id' => ['required', 'integer'],
        'rentalCar.currency_id' => ['required', 'integer'],
        'returnFeeItems' => ['array'],
        'returnFeeItems.*.fee' => ['required', 'numeric'],
        'returnFeeItems.*.pick_up_location_id' => ['required', 'numeric'],
        'returnFeeItems.*.drop_off_location_id' => ['required', 'numeric'],
    ];

    /**
     * Custom error messages for fields with unclear naming.
     *
     * @var string[]
     */
    protected $messages = [
        'rentalCar.provider_id.required' => 'Please select a provider.',
        'rentalCar.currency_id.required' => 'Please select a currency.',
        'returnFeeItems.*.pick_up_location_id.required' => 'Please select a pick-up location.',
        'returnFeeItems.*.drop_off_location_id.required' => 'Please select a drop-off location.',
    ];

    /**
     * Array of RentalCarReturnFee items for reference with AlpineJS.
     *
     * @var array
     */
    public $returnFeeItems = [];

    /**
     * Example array and keys for generating an empty item.
     *
     * @var string[]
     */
    public $returnFeeItemEmpty = [
        'fee' => '',
        'pick_up_location_id' => '',
        'drop_off_location_id' => '',
    ];

    /**
     * Array of Currencies formatted for the select component.
     *
     * @return array<\Illuminate\Support\TKey, \Illuminate\Support\TValue>
     */
    public function getProviderOptionsProperty()
    {
        return Provider::all(['id', 'name'])
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            })->all();
    }

    /**
     * Array of Currencies formatted for the select component.
     *
     * @return array<\Illuminate\Support\TKey, \Illuminate\Support\TValue>
     */
    public function getCurrencyOptionsProperty()
    {
        return Currency::all(['id', 'name'])
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            })->all();
    }

    /**
     * Array of Locations formatted for the select component.
     *
     * @return array<\Illuminate\Support\TKey, \Illuminate\Support\TValue>
     */
    public function getLocationOptionsProperty()
    {
        return Location::all(['id', 'name'])
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            })->all();
    }

    /**
     * Helper method to add a new item when editing form.
     *
     * @return void
     */
    public function addNewLine()
    {
        $this->returnFeeItems[] = $this->returnFeeItemEmpty;
    }

    /**
     * Helper method to remove an item from array when editing the form.
     *
     * @param int | string $index
     * @return void
     */
    public function deleteLine($index)
    {
        unset($this->returnFeeItems[$index]);
    }
}
