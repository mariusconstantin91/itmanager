<?php
namespace App\Http\Livewire\Documents;

use Illuminate\Support\Str;

class Edit extends Action
{
    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        if (!$this->document->path) {
            $this->rules['file'][] = ['required', 'max:10240', 'mimes:pdf,doc,docx'];
        }

        $this->validate();

        if ($this->file) {
            $name = $this->file->store('documents', 'public');
            $this->document->path = $name;
        }

        if ($this->document->status != 'approved') {
            $this->document->approved_by_id = null;
        }
        $this->document->save();
        
        return redirect()->with(['message' => 'The document was updated!'])->route('documents.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.documents.form', [
            'title' => 'Edit Document',
        ]);
    }
}
