<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
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
                $builder->where(function ($query) use ($authUser) {
                    $query->whereHas('user.projects.users', function ($query) use ($authUser) {
                        $query->where('users.id', $authUser->id)
                            ->orWhere('user_id', $authUser->id);
                    });
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
        'comment',
        'task_id',
        'user_id',
    ];

    /**
     * Get the task for the time entry.
     *
     * @return BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class)->withoutGlobalScope('restriction');
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
}
