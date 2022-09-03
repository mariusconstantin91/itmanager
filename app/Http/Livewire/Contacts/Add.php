<?php
namespace App\Http\Livewire\Contacts;

use App\Models\Contact;

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
        $this->contact = new Contact();
        $this->contact->main_contact = false;
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

        $this->contact->save();

        return redirect()->with(['message' => 'The contact was created!'])->route('contacts.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.contacts.form', [
            'title' => 'Add Contact',
        ]);
    }
}
