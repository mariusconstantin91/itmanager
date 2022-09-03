<?php
namespace App\Http\Livewire\TimeEntries;

use App\Models\TimeEntry;

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
        $this->timeEntry = new TimeEntry();
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

        $this->timeEntry->start_at = $this->startAt.':00';
        $this->timeEntry->end_at = $this->endAt.':00';
        
        $this->timeEntry->save();

        return redirect()->with(['message' => 'The time entry was created!'])->route('time_entries.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.time_entries.form', [
            'title' => 'Add Time Entry',
        ]);
    }
}
