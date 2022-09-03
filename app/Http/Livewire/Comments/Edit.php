<?php
namespace App\Http\Livewire\Comments;

use Carbon\Carbon;

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

        $this->comment->save();
        
        return redirect()->with(['message' => 'The comment was updated!'])->route('comments.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.comments.form', [
            'title' => 'Edit Comment',
        ]);
    }
}
