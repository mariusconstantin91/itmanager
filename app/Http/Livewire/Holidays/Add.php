<?php
namespace App\Http\Livewire\Holidays;

use App\Models\Holiday;

class Add extends Action
{
    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        $this->holiday = new Holiday();
        $this->holiday->status = 'pending';
        parent::mount();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();

        if ($this->holiday->status != 'approved') {
            $this->holiday->approved_by_id = null;
        }
        
        $this->holiday->save();

        return redirect()->with(['message' => 'The holiday was created!'])->route('holidays.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.holidays.form', [
            'title' => 'Add Holiday',
        ]);
    }
}
