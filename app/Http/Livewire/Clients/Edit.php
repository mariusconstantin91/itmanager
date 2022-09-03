<?php
namespace App\Http\Livewire\Clients;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $this->client->load('contacts');
        $this->contactItems = $this->client->contacts->except([
                'id',
                'client_id',
                'created_at',
                'updated_at',
            ])->toArray();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->client->save();

            $this->client->contacts()->delete();

            foreach ($this->contactItems as $contactItem) {
                $this->client->contacts()->create($contactItem);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->with(['message' => 'The client was updated!'])->route('clients.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.clients.form', [
            'title' => 'Edit Client',
        ]);
    }
}
