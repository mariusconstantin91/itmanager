<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\ImportanceInterface;

class Skill extends Model implements ImportanceInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the projects for the skill.
     *
     * @return BelongsTo
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skill')->withPivot(['importance']);
    }

    /**
     * Get the users for the skill.
     *
     * @return BelongsTo
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill')->withPivot(['importance']);
    }

    /**
     * Get the tasks for the skill.
     *
     * @return BelongsTo
     */
    public function tasks()
    {
        return $this->belongsToMany(User::class, 'task_skill')->withPivot(['importance']);
    }
}
