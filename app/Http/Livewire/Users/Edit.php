<?php
namespace App\Http\Livewire\Users;

use App\Models\Holiday;
use App\Models\Skill;
use Exception;
use Illuminate\Support\Facades\DB;

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
        $this->user->load('skills', 'holidays.approveUser');
        foreach ($this->user->skills as $skill) {
            $this->skillItems[] = [
                'name' => $skill->name,
                'importance' => $skill->pivot->importance,
            ];
        }

        foreach ($this->user->holidays->sortByDesc('start_date') as $holiday) {
            $holidayItem = $holiday->toArray();
            $holidayItem['approved_by_name'] = optional($holiday->approveUser)->name;
            $holidayItem['start_Date'] = $holiday->start_date;
            $holidayItem['end_Date'] = $holiday->end_date;
            $this->holidayItems[] = $holidayItem;
        }
    }
    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();

        if ($this->password) {
            $this->user->password = $this->password;
        }
        try {
            $this->user->save();
            $skills = [];
            $skillsDB = Skill::whereIn('name', collect($this->skillItems)->pluck('name')->toArray())->get();
            foreach ($this->skillItems as $skill) {
                $skillId = $skillsDB->where('name', $skill['name'])->first()->id;
                $skills[$skillId] = ['importance' => $skill['importance']];
            }

            $this->user->skills()->sync($skills);
            
            $holidayIds = collect($this->holidayItems)->pluck('id')->toArray();
            
            Holiday::whereNotIn('id', $holidayIds)
                ->where('user_id', $this->user->id)
                ->get()
                ->each(function ($holiday) {
                    $holiday->delete();
                });

            foreach ($this->holidayItems as $holidayItem) {
                if ($holidayItem['id']) {
                    Holiday::find($holidayItem['id'])->update($holidayItem);
                } else {
                    $this->user->holidays()->create($holidayItem);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        return redirect()->with(['message' => 'The user was updated!'])->route('users.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.users.form', [
            'title' => 'Edit User',
        ]);
    }
}
