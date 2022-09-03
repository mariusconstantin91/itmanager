<?php
namespace App\Http\Livewire\Accommodations;

use App\Models\Accommodation;
use Livewire\Component;

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
        $this->accommodation = new Accommodation();
        $this->accommodation->type = 'hotel';
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
        $this->accommodation->margin = 0;
        $this->accommodation->save();

        $this->accommodation->languages()->sync($this->languageIds);
        $this->accommodation->tags()->sync($this->tagIds);

        return redirect()->with(['message' => 'The accommodation was created!'])->route('accommodations.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.accommodations.form', [
            'title' => 'Add Accommodation',
        ]);
    }
}
