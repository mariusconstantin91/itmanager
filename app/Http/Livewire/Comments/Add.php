<?php
namespace App\Http\Livewire\Comments;

use App\Models\Comment;

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
        $this->comment = new Comment();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();
        
        $this->comment->save();

        return redirect()->with(['message' => 'The comment was created!'])->route('comments.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.comments.form', [
            'title' => 'Add Comment',
        ]);
    }
}
