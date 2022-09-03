<?php
namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Models\Country;
use App\Models\Holiday;
use App\Models\Role;
use App\Models\Skill;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait, SelectFormatedTrait;

    /**
     * The main entity of the component
     *
     * @var User
     */
    public User $user;

    /**
     * Property populated with the options for roles
     *
     * @var array
     */
    public $rolesOptions = [
        Role::ADMIN => 'Admin',
        Role::HR_MANAGER => 'HR manager',
        Role::PR_MANAGER => 'PR manager',
        Role::USER => 'User'
    ];

    /**
     * Property populated with the options for country
     *
     * @var array
     */
    public $countryOptions = [];

    /**
     * Property populated with the options for status
     *
     * @var array
     */
    public $statusOptions = Holiday::STATUS_OPTIONS;

    /**
     * Property keeps the password of the user
     *
     * @var array
     */
    public $password = '';

    /**
     * Property keeps the password confirmation of the user
     *
     * @var array
     */
    public $passwordConfirmation = '';

    /**
     * Priority options
     *
     * @var array
     */
    public $importanceOptions = [
        User::LOWEST => 'Lowest',
        User::LOW => 'Low',
        User::MEDIUM => 'Medium',
        User::HIGH => 'High',
        User::HIGHEST => 'Highest',
    ];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'user.name' => ['required'],
        'user.email' => ['required', 'email'],
        'user.role_id' => ['required'],
        'user.phone' => ['required'],
        'user.position' => ['sometimes'],
        'user.city' => ['sometimes'],
        'user.postalcode' => ['sometimes'],
        'user.address_line_1' => ['sometimes'],
        'user.address_line_2' => ['sometimes'],
        'user.country_id' => ['sometimes'],
        'user.salary' => ['sometimes', 'numeric'],
        'passwordConfirmation' => ['min:6'],
        'password' => ['min:6', 'required_with:passwordConfirmation', 'same:passwordConfirmation'],
        'skillItems.*.name' => ['required'],
        'skillItems.*.importance' => ['required'],
        'holidayItems.*.status' => ['required'],
        'holidayItems.*.start_date' => ['required', 'date_format:Y-m-d'],
        'holidayItems.*.end_date' => ['required', 'date_format:Y-m-d', 'after:start_date'],
        'holidayItems.*.note' => ['sometimes'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'user.country_id' => 'country',
        'user.role_id' => 'role',
        'skillItems.*.name' => 'skill name',
        'skillItems.*.importance' => 'skill importance',
        'holidayItems.*.status' => 'status',
        'holidayItems.*.start_date' => 'start date',
        'holidayItems.*.end_date' => 'end date',
        'holidayItems.*.note' => 'note',
    ];

    /**
     * Array with the skill items of the user
     *
     * @var array
     */
    public $skillItems = [];

    /**
     * An empty element for a skill Item
     *
     * @var array
     */
    public $skillItemEmpty = [
        'name' => '',
        'importance' => '',
    ];

    /**
     * Array with the holidays items of the user
     *
     * @var array
     */
    public $holidayItems = [];

    /**
     * An empty element for a skill Item
     *
     * @var array
     */
    public $holidayItemEmpty = [
        'id' => null,
        'approved_by_id' => null,
        'approved_by_name' => null,
        'status' => '',
        'start_date' => '',
        'end_date' => '',
        'note' => '',
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
     * Add a new line in skills items table
     *
     * @return void
     */
    public function addSkillNewLine()
    {
        $this->skillItems[] = $this->skillItemEmpty;
    }

    /**
     * Delete a line from skills items line
     *
     * @param int | string $index
     * @return void
     */
    public function deleteSkillLine($index)
    {
        $this->resetErrorBag('skillItems.' . $index . '.name');
        $this->resetErrorBag('skillItems.' . $index . '.importance');

        unset($this->skillItems[$index]);
    }

    /**
     * Add a new line in holidays items table
     *
     * @return void
     */
    public function addHolidayNewLine()
    {
        $this->holidayItems[] = $this->holidayItemEmpty;
    }

    /**
     * Delete a line from holidays items line
     *
     * @param int | string $index
     * @return void
     */
    public function deleteHolidayLine($index)
    {
        $this->resetErrorBag('holidayItems.' . $index . '.status');
        $this->resetErrorBag('holidayItems.' . $index . '.start_date');
        $this->resetErrorBag('holidayItems.' . $index . '.end_date');
        $this->resetErrorBag('holidayItems.' . $index . '.note');

        unset($this->holidayItems[$index]);
    }

    /**
     * Approve holidays items line
     *
     * @param int | string $index
     * @return void
     */
    public function approveHolidayLine($index)
    {
        $this->holidayItems[$index]['approved_by_id'] = auth()->user()->id;
        $this->holidayItems[$index]['approved_by_name'] = auth()->user()->name;
        $this->holidayItems[$index]['status'] = 'approved';
        $this->choosenOptionSelect[str_replace('.', '_', 'holidayItems.' . $index . '.status')] = 'Approved';
    }

    /**
     * Catch the updated event for skill input, set the results filtered by search word
     *
     * @return void
     */
    public function skillUpdated($name, $value)
    {
        $this->items[$name] = Skill::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'name')
            ->toArray();
    }
}
