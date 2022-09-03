<?php
namespace App\Http\Livewire\Contacts;

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

        $this->contact->save();
        
        return redirect()->with(['message' => 'The contact was updated!'])->route('contacts.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.contacts.form', [
            'title' => 'Edit Contact',
        ]);
    }
}
