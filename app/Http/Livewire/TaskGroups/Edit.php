<?php
namespace App\Http\Livewire\TaskGroups;

use Illuminate\Validation\Rule;

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

        $this->taskGroup->save();

        return redirect()->with(['message' => 'The task group was updated!'])->route('task_groups.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.task_groups.form', [
            'title' => 'Edit Task Group',
        ]);
    }
}
