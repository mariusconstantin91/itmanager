<?php
namespace App\Http\Livewire\Accommodations;

use App\Models\Accommodation;
use App\Models\Location;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownTrait;
use App\Http\Livewire\Traits\NumberButtonsTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Http\Livewire\Traits\SelectFormatedMultiTrait;
use App\Models\AccommodationCategory;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Provider;
use App\Models\Tag;

abstract class Action extends Component
{
    use SearchDropdownTrait, NumberButtonsTrait, SelectFormatedTrait, SelectFormatedMultiTrait;

    /**
     * The main entity of the component
     *
     * @var Accommodation
     */
    public Accommodation $accommodation;

    /**
     * Array for search selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchDropDowns = [
        'accommodation.location_id',
        'accommodation.provider_id',
        'accommodation.currency_id',
    ];

    /**
     * Array for simple selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchSelects = [
        'accommodation.type',
        'accommodation.rating',
        'accommodation.accommodation_category_id',
    ];

    /**
     * Array for multi selects/dropdowns, it contains the name of them
     *
     * @var array
     */
    public $searchSelectsMulti = [
        'languageIds',
        'tagIds',
    ];

    /**
     * Search input property for languages, used by multiple select
     *
     * @var string
     */
    public $languageInput = '';

    /**
     * Search input property for tags, used by multiple select
     *
     * @var string
     */
    public $tagInput = '';

    /**
     * Property to keep the selected tag ids
     *
     * @var array
     */
    public $tagIds = [];

    /**
     * Property to keep the selected language ids
     *
     * @var array
     */
    public $languageIds = [];

    /**
     * Property populated with the options for locations
     *
     * @var array
     */
    public $locationOptions = [];

    /**
     * Property populated with the options for provider
     *
     * @var array
     */
    public $providerOptions = [];

    /**
     * Property populated with the options for currencies
     *
     * @var array
     */
    public $currencyOptions = [];

    /**
     * Property populated with the options for languages
     *
     * @var array
     */
    public $languageOptions = [];

    /**
     * Property populated with the options for tags
     *
     * @var array
     */
    public $tagOptions = [];

    /**
     * Property populated with the options for type
     *
     * @var array
     */
    public $typeOptions = [
        'hotel' => 'Hotel',
        'casa' => 'Casa',
    ];

    /**
     * Property populated with the options for rating when type is hotel
     *
     * @var array
     */
    public $ratingOptionsHotel = [
        '1_star' => '1 Star',
        '2_star' => '2 Star',
        '3_star' => '3 Star',
        '4_star' => '4 Star',
        '5_star' => '5 Star',
    ];

    /**
     * Property populated with the options for rating when type is casa
     *
     * @var array
     */
    public $ratingOptionsCasa = [
        'buddy' => 'Buddy casas',
        'buddy' => 'Buddy casas',
        'premium' => 'Premium casas',
        'boutique' => 'Boutique casas',
    ];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'accommodation.name' => ['required'],
        'accommodation.accommodation_category_id' => ['required'],
        'accommodation.type' => ['required', 'in:hotel,casa'],
        'accommodation.currency_id' => ['required'],
        'accommodation.rating' => ['required'],
        'accommodation.location_id' => ['required'],
        'accommodation.provider_id' => ['required'],
        'accommodation.discount_children' => ['numeric'],
        'accommodation.discount_infants' => ['numeric'],
        'accommodation.checkin' => ['date_format:H:i'],
        'accommodation.checkout' => ['date_format:H:i'],
        'languageIds' => ['required'],
        'tagIds' => ['required'],
    ];

    /**
     * Custom messages for valiation
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'accommodation_category_id' => 'category',
        'currency_id' => 'currency',
        'provider_id' => 'provider',
    ];

    /**
     * Generate the needed properties on mount
     *
     * @return void
     */
    public function mount()
    {
        parent::mount();
        $this->mountDropDown();
        /* $this->mountSelect(); */
        $this->languageOptions = Language::get()->take(10)->pluck('name', 'id')->toArray();
        $this->mountSelectMulti();
        $this->tagOptions = Tag::get()->take(10)->pluck('name', 'id')->toArray();
    }

    /**
     * Catch the updated event for location input, set the results filtered by search word
     *
     * @return void
     */
    public function locationUpdated()
    {
        $this->items['accommodation.location_id'] = Location::where('name', 'like', $this->accommodationLocationIdInput . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for provider input, set the results filtered by search word
     *
     * @return void
     */
    public function providerUpdated()
    {
        $this->items['accommodation.provider_id'] = Provider::where('type', 'accommodations')
            ->where('name', 'like', $this->accommodationProviderIdInput . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for currency input, set the results filtered by search word
     *
     * @return void
     */
    public function currencyUpdated()
    {
        $this->items['accommodation.currency_id'] = Currency::where('name', 'like', $this->accommodationCurrencyIdInput . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for accommodation, handle the type change logic
     *
     * @return void
     */
    public function updatedAccommodation()
    {
        if ($this->accommodation->isDirty('type') && !array_key_exists($this->accommodation->rating, $this->ratingOptions)) {
            $this->accommodation->rating = '';
            $this->choosenOptionSelect['accommodation.rating'] = '';
            $this->accommodation->type = '';
            $this->choosenOptionSelect['accommodation.accommodation_category_id'] = '';
        }
    }

    /**
     * Catch the updated event for language input, set the results filtered by search word
     *
     * @return void
     */
    public function updatedLanguageInput()
    {
        $builder = Language::take(10);
        if ($this->languageInput) {
            $builder = $builder->where('name', 'like', $this->languageInput . '%');
        }

        $this->languageOptions = $builder->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Catch the updated event for tags input, set the results filtered by search word
     *
     * @return void
     */
    public function updatedTagInput()
    {
        $builder = Tag::take(10);
        if ($this->tagInput) {
            $builder = $builder->where('name', 'like', $this->tagInput . '%');
        }

        $this->tagOptions = $builder->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

    /**
     * Computed property to rating options based on type
     *
     * @return array
     */
    public function getRatingOptionsProperty()
    {
      
        if ($this->accommodation->type == 'casa') {
            return $this->ratingOptionsCasa;
        }

        return $this->ratingOptionsHotel;
    }

    /**
     * Computed property to category options based on type
     *
     * @return array
     */
    public function getCategoryOptionsProperty()
    {
        if ($this->accommodation->type == 'casa') {
            return AccommodationCategory::get()->where('type', 'casa')->pluck('name', 'id')->toArray();
        }

        return AccommodationCategory::get()->where('type', 'hotel')->pluck('name', 'id')->toArray();
    }
}
