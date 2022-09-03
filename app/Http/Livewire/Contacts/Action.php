<?php
namespace App\Http\Livewire\Contacts;

use App\Models\Contact;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Models\Client;
use App\Models\Country;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait;

    /**
     * The main entity of the component
     *
     * @var Contact
     */
    public Contact $contact;

    /**
     * Array for search selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchDropDownsExtended = [
        'contact.country_id',
        'contact.client_id',
    ];

    /**
     * Property populated with the options for locations
     *
     * @var array
     */
    public $countryOptions = [];

    /**
     * Property populated with the options for locations
     *
     * @var array
     */
    public $clientOptions = [];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'contact.name' => ['required'],
        'contact.email' => ['required', 'email'],
        'contact.phone' => ['required'],
        'contact.client_id' => ['required'],
        'contact.main_contact' => ['boolean'],
        'contact.position' => ['sometimes'],
        'contact.city' => ['sometimes'],
        'contact.postalcode' => ['sometimes'],
        'contact.address_line_1' => ['sometimes'],
        'contact.address_line_2' => ['sometimes'],
        'contact.country_id' => ['sometimes'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'contact.country_id' => 'country',
        'contact.client_id' => 'client',
    ];


    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

    /**
     * Catch the updated event for country input, set the results filtered by search word
     *
     * @return void
     */
    public function countryUpdated($name, $value)
    {
        $this->items[$name] = Country::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for client input, set the results filtered by search word
     *
     * @return void
     */
    public function clientUpdated($name, $value)
    {
        $this->items[$name] = Client::where('name', 'like', $value. '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
