<?php
namespace App\Http\Livewire\Documents;

use App\Models\Document;
use Livewire\Component;
use App\Http\Livewire\Traits\SearchDropdownExtendedTrait;
use App\Http\Livewire\Traits\SelectFormatedTrait;
use App\Models\User;
use Livewire\WithFileUploads;

abstract class Action extends Component
{
    use SearchDropdownExtendedTrait, SelectFormatedTrait, WithFileUploads;

    /**
     * The main entity of the component
     *
     * @var Document
     */
    public Document $document;

    /**
     * The the file of the document
     *
     * @var file
     */
    public $file = null;

    /**
     * Property populated with the options for users
     *
     * @var array
     */
    public $userOptions = [];

    /**
     * The rules for validation of the form
     *
     * @var array
     */
    protected $rules = [
        'file' => ['sometimes'],
        'document.user_id' => ['required', 'numeric'],
        'document.status' => ['required', 'in:approved,rejected,pending'],
        'document.type' => ['required'],
        'document.name' => ['required'],
        'document.path' => ['sometimes'],
        'document.approved_by_id' => ['sometimes'],
    ];

    /**
     * Custom attributes for validation
     *
     * @var array
     */
    protected $validationAttributes = [
        'document.user_id' => 'user',
    ];

    /**
     * Status options
     *
     * @var array
     */
    public $statusOptions = Document::STATUS_OPTIONS;

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();

    /**
     * Catch the updated event for user input, set the results filtered by search word
     *
     * @return void
     */
    public function userUpdated($name, $value)
    {
        $this->items[$name] = User::where('name', 'like', $value . '%')
            ->take(10)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Approve the document
     *
     * @return void
     */
    public function approveDocument()
    {
        $this->document->status = 'approved';
        $this->document->approved_by_id = auth()->id();
        $this->document->unsetRelation('approveUser');
    }

    /**
     * Approve the document
     *
     * @return void
     */
    public function rejectDocument()
    {
        $this->holiday->status = 'rejected';
        $this->holiday->unsetRelation('approveUser');
    }
}
