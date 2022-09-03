<?php
namespace App\Http\Livewire\Tasks;

use App\Models\Tag;
use App\Models\Skill;
use App\Models\User;
use App\Models\TaskGroup;
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
        parent::mount();
        $this->task->load('tags', 'skills', 'users', 'taskGroups');
        $this->task->deadline = $this->task->deadline;
        $this->userIds = $this->task->users->pluck('id')->toArray();
        $this->taskGroupIds = $this->task->taskGroups->pluck('id')->toArray();

        $users = $this->task->users->pluck('name', 'id')->toArray();
        $taskGroups = $this->task->taskGroups->pluck('name', 'id')->toArray();

        $this->userOptions = $users + User::take(10)->get()->pluck('name', 'id')->toArray();
        $this->taskGroupOptions = $taskGroups + TaskGroup::take(10)->get()->pluck('name', 'id')->toArray();

        foreach ($this->task->tags as $tag) {
            $this->tagItems[] = [
                'name' => $tag->name,
                'importance' => $tag->pivot->importance,
            ];
        }

        foreach ($this->task->skills as $skill) {
            $this->skillItems[] = [
                'name' => $skill->name,
                'importance' => $skill->pivot->importance,
            ];
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
        
        return redirect()->with(['message' => 'The task was updated!'])->route('tasks.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.tasks.form', [
            'title' => 'Edit Task',
        ]);
    }
}
