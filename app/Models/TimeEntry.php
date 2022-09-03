<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TimeEntry extends Model
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
        'description',
        'start_at',
        'end_at',
        'user_id',
        'project_id',
        'task_id',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    /**
     * Get the project for the time entry.
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the task for the time entry.
     *
     * @return BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user for the time entry.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate the duration of the time entry
     *
     * @return integer
     */
    public function duration() :int
    {
        if (!($this->start_at || $this->end_at)) {
            return 0;
        }

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_at);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_at);

        return $startDate->diffInMinutes($endDate);
    }
}
