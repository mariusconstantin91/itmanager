<?php
namespace App\Http\Livewire\Tags;

use Illuminate\Validation\Rule;

class Edit extends Action
{
    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'tag.name' => [
            'required',
        ],
    ];

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->addExtraRules();
        
        $this->validate();

        $this->tag->save();

        return redirect()->with(['message' => 'The tag was updated!'])->route('settings.tags.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.tags.form', [
            'title' => 'Edit Tag',
        ]);
    }

    /**
     * Add extra/dinamically rules
     *
     * @return void
     */
    public function addExtraRules()
    {
        $this->rules['tag.name'][] = Rule::unique('tags', 'name')->ignore($this->tag->id);
    }
}
