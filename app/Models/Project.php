<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\ImportanceInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model implements ImportanceInterface
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
                $builder->whereHas('users', function ($query) use ($authUser) {
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
        'start_date',
        'deadline_date',
        'soft_deadline_date',
        'budget',
        'importance',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'deadline_date' => 'date:Y-m-d',
        'soft_deadline_date' => 'date:Y-m-d',
    ];

    /**
     * Get the client of the project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class)->withoutGlobalScope('restriction');
    }

    /**
     * Get the time entries of the project.
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    /**
     * Get the tasks of the project.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the tags for the project
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tag')->withPivot(['importance']);
    }

    /**
     * Get the skills for the project
     *
     * @return BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skill')->withPivot(['importance']);
    }

    /**
     * Get the users for the project
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

     /*
    |--------------------------------------------------------------------------
    | ACCESORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    public function budget(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>$value / 100,
            set: fn ($value) =>$value * 100
        );
    }
}
