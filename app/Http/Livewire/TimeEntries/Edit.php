<?php
namespace App\Http\Livewire\TimeEntries;

use Carbon\Carbon;

class Edit extends Action
{

    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        parent::mount();
        
        $this->startAt = '';
        if ($this->timeEntry->start_at) {
            $this->startAt = Carbon::createFromFormat('Y-m-d H:i:s', $this->timeEntry->start_at)->format('Y-m-d H:i');
        }

        $this->endAt = '';
        if ($this->timeEntry->end_at) {
            $this->endAt = Carbon::createFromFormat('Y-m-d H:i:s', $this->timeEntry->end_at)->format('Y-m-d H:i');
        }

        $this->duration = $this->timeEntry->duration();
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
        
        return redirect()->with(['message' => 'The time entry was updated!'])->route('time_entries.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.time_entries.form', [
            'title' => 'Edit Time Entry',
        ]);
    }
}
