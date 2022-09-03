<?php
namespace App\Http\Livewire\Projects;

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
        $this->userIds = $this->project->users->pluck('id')->toArray();
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
        
        return redirect()->with(['message' => 'The project was updated!'])->route('projects.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.projects.form', [
            'title' => 'Edit Project',
        ]);
    }
}
