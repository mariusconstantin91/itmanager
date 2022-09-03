<?php
namespace App\Http\Livewire\Users;

use App\Models\Skill;
use App\Models\User;
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
        $this->user = new User();
        parent::mount();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->rules['password'][] = 'required';
        $this->validate();
        try {
            if ($this->password) {
                $this->user->password = $this->password;
            }

            $this->user->save();

            $skills = [];
            $skillsDB = Skill::whereIn('name', collect($this->skillItems)->pluck('name')->toArray())->get();
            foreach ($this->skillItems as $skill) {
                $skillId = $skillsDB->where('name', $skill['name'])->first()->id;
                $skills[$skillId] = ['importance' => $skill['importance']];
            }

            $this->user->skills()->sync($skills);
            
            foreach ($this->holidayItems as $holidayItem) {
                $this->user->holidays()->create($holidayItem);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }


        return redirect()->with(['message' => 'The user was created!'])->route('users.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.users.form', [
            'title' => 'Add User',
        ]);
    }
}
