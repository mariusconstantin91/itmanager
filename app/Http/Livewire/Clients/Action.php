<?php
namespace App\Http\Livewire\Clients;

use App\Models\Client;
use App\Models\Country;
use Livewire\Component;

abstract class Action extends Component
{
    /**
     * The main entity of the component
     *
     * @var Client
     */
    public Client $client;

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected array $rules = [
        'client.name' => [
            'required'
        ],
        'client.source' => [
            'sometimes'
        ],
        'contactItems.*.name' => ['required'],
        'contactItems.*.main_contact' => ['boolean'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected array $validationAttributes = [
        'contactItems.*.name' => 'name',
        'contactItems.*.main_contact' => 'main contact',
    ];

    /**
     * Array of RentalCarReturnFee items for reference with AlpineJS.
     *
     * @var array
     */
    public array $contactItems = [];

    /**
     * Example array and keys for generating an empty item.
     *
     * @var string[]
     */
    public array $contactItemEmpty = [
        'name' => '',
        'phone' => '',
        'email' => '',
        'country_id' => '',
        'city' => '',
        'postalcode' => '',
        'address_line_1' => '',
        'address_line_2' => '',
        'main_contact' => false,
        'position' => '',
    ];

    public array $countryOptions = [];

     /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        parent::mount();
        $this->countryOptions = Country::all()->pluck('name', 'id')->toArray();
    }

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

    /**
     * Add a new line in contact items array
     *
     * @return void
     */
    public function addNewLine() :void
    {
        $this->contactItems[] = $this->contactItemEmpty;
    }

    /**
     * Delete a line from contact items line
     *
     * @param int | string $index
     * @return void
     */
    public function deleteLine(int | string $index) :void
    {
        unset($this->contactItems[$index]);
    }
}
