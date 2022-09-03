<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TaskGroup extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        $authUser = auth()->user();
        static::addGlobalScope('restriction', function (Builder $builder) use ($authUser) {
            if ($authUser->hasAnyRole(['admin'])) {
                $builder;
            } elseif ($authUser->hasAnyRole(['pr_manager', 'user'])) {
                $builder->whereHas('project.users', function ($query) use ($authUser) {
                    $query->where('users.id', $authUser->id);
                });
            } else {
                $builder->where('clients.id', -1); // always false
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'project_id',
    ];

    /**
     * Get the tasks for the task group.
     *
     * @return BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_group_task');
    }

    /**
     * Get the project for task group.
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
