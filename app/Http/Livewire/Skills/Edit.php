<?php
namespace App\Http\Livewire\Skills;

use Illuminate\Validation\Rule;

class Edit extends Action
{
    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'skill.name' => [
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

        $this->skill->save();

        return redirect()->with(['message' => 'The skill was updated!'])->route('settings.skills.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.skills.form', [
            'title' => 'Edit Skill',
        ]);
    }

    /**
     * Add extra/dinamically rules
     *
     * @return void
     */
    public function addExtraRules()
    {
        $this->rules['skill.name'][] = Rule::unique('skills', 'name')->ignore($this->skill->id);
    }
}
