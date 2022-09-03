<?php
namespace App\Http\Livewire\Tags;

use App\Models\Tag;

class Add extends Action
{
    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'tag.name' => [
            'required',
            'unique:tags,name',
        ],
    ];

    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        parent::mount();
        $this->tag = new Tag();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();

        $this->tag->save();

        return redirect()->with(['message' => 'The tag was created!'])->route('settings.tags.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.tags.form', [
            'title' => 'Add Tag',
        ]);
    }
}
