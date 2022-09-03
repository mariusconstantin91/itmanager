<?php
namespace App\Http\Livewire\Holidays;

class Edit extends Action
{
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
        
        return redirect()->with(['message' => 'The holiday was updated!'])->route('holidays.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.holidays.form', [
            'title' => 'Edit Holiday',
        ]);
    }
}
