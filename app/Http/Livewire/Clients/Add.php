<?php
namespace App\Http\Livewire\Clients;

use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\DB;

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
        $this->client = new Client();
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

            foreach ($this->contactItems as $contactItem) {
                $this->client->contacts()->create($contactItem);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->with(['message' => 'The client was created!'])->route('clients.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.clients.form', [
            'title' => 'Add Client',
        ]);
    }
}
