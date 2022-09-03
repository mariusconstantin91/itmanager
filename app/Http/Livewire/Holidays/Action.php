<?php
namespace App\Http\Livewire\Holidays;

use App\Models\Holiday;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Models\Client;
use App\Models\User;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait, SelectFormatedTrait;

    /**
     * The main entity of the component
     *
     * @var Holiday
     */
    public Holiday $holiday;

    /**
     * Property populated with the options for users
     *
     * @var array
     */
    public $userOptions = [];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'holiday.user_id' => ['required', 'numeric'],
        'holiday.status' => ['required', 'in:approved,rejected,pending'],
        'holiday.start_date' => ['required', 'date', 'date_format:Y-m-d'],
        'holiday.end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        'holiday.note' => ['sometimes'],
        'holiday.approved_by_id' => ['sometimes'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'holiday.user_id' => 'user',
    ];

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

    /**
     * Catch the updated event for user input, set the results filtered by search word
     *
     * @return void
     */
    public function userUpdated($name, $value)
    {
        $this->items[$name] = User::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Approve the holiday
     *
     * @return void
     */
    public function approveHoliday()
    {
        $this->holiday->status = 'approved';
        $this->holiday->unsetRelation('approveUser');
        $this->holiday->approved_by_id = auth()->id();
    }

    /**
     * Approve the holiday
     *
     * @return void
     */
    public function rejectHoliday()
    {
        $this->holiday->status = 'rejected';
        $this->holiday->unsetRelation('approveUser');
    }
}
