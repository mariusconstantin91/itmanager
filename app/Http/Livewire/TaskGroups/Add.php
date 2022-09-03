<?php
namespace App\Http\Livewire\TaskGroups;

use App\Models\TaskGroup;

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
        parent::mount();
        $this->taskGroup = new TaskGroup();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();

        $this->taskGroup->save();

        return redirect()->with(['message' => 'The task group was created!'])->route('task_groups.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.task_groups.form', [
            'title' => 'Add Task Group',
        ]);
    }
}
