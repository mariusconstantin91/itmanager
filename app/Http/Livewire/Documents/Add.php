<?php
namespace App\Http\Livewire\Documents;

use App\Models\Document;
use Illuminate\Support\Str;

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
        $this->document = new Document();
        $this->document->status = 'pending';
        parent::mount();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->rules['file'][] = ['required', 'max:10240', 'mimes:pdf,doc,docx'];
        $this->validate();

        if ($this->file) {
            $name = $this->file->store('documents', 'public');
            $this->document->path = $name;
        }

        if ($this->document->status != 'approved') {
            $this->document->approved_by_id = null;
        }
        
        $this->document->save();

        return redirect()->with(['message' => 'The document was created!'])->route('documents.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.documents.form', [
            'title' => 'Add Document',
        ]);
    }
}
