<?php
namespace App\Http\Livewire\Skills;

use App\Models\Skill;

class Add extends Action
{
    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'skill.name' => [
            'required',
            'unique:skills,name',
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
        $this->skill = new Skill();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();

        $this->skill->save();

        return redirect()->with(['message' => 'The skill was created!'])->route('settings.skills.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.skills.form', [
            'title' => 'Add Skill',
        ]);
    }
}
