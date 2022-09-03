<?php
namespace App\Http\Livewire\Projects;

use App\Models\Project;

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
        $this->project = new Project();
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

        $this->project->save();
        $this->project->users()->sync($this->userIds);

        return redirect()->with(['message' => 'The project was created!'])->route('projects.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.projects.form', [
            'title' => 'Add Project',
        ]);
    }
}
