<?php
namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use App\Models\Tag;
use App\Models\Skill;
use App\Models\User;
use App\Models\TaskGroup;
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
        $this->task = new Task();
        $this->tagOptions = Tag::get()->take(10)->pluck('name', 'id')->toArray();
        $this->skillOptions = Skill::get()->take(10)->pluck('name', 'id')->toArray();
        $this->userOptions = User::get()->take(10)->pluck('name', 'id')->toArray();
        $this->taskGroupOptions = TaskGroup::get()->take(10)->pluck('name', 'id')->toArray();
        parent::mount();
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
            $this->task->save();

            $this->task->users()->sync($this->userIds);
            $this->task->taskGroups()->sync($this->taskGroupIds);

            $tags = [];
            $tagsDB = Tag::whereIn('name', collect($this->tagItems)->pluck('name')->toArray())->get();
            foreach ($this->tagItems as $tag) {
                $tagId = $tagsDB->where('name', $tag['name'])->first()->id;
                $tags[$tagId] = ['importance' => $tag['importance']];
            }

            $this->task->tags()->sync($tags);

            $skills = [];
            $skillsDB = Skill::whereIn('name', collect($this->skillItems)->pluck('name')->toArray())->get();
            foreach ($this->skillItems as $skill) {
                $skillId = $skillsDB->where('name', $skill['name'])->first()->id;
                $skills[$skillId] = ['importance' => $skill['importance']];
            }

            $this->task->skills()->sync($skills);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->with(['message' => 'The task was created!'])->route('tasks.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.tasks.form', [
            'title' => 'Add Task',
        ]);
    }
}
