<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\ImportanceInterface;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model implements ImportanceInterface
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
            if (!$authUser || $authUser->hasAnyRole(['admin'])) {
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
        'status',
        'priority',
        'estimate',
        'story_points',
        'description',
        'deadline',
    ];

    /**
     * Get the project for task.
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the time entries for task.
     *
     * @return HasMany
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    /**
     * Get the comments for the task.
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the skills for the task.
     *
     * @return BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'task_skill')->withPivot(['importance']);
    }

    /**
     * Get the tags for the task.
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag')->withPivot(['importance']);
    }

    /**
     * Get the users for the task.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    /**
     * Get the task groups for the task.
     *
     * @return BelongsToMany
     */
    public function taskGroups()
    {
        return $this->belongsToMany(TaskGroup::class, 'task_group_task', 'task_id', 'task_group_id');
    }
}
