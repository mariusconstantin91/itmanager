<?php
namespace App\Models;

use App\Models\Interfaces\ImportanceInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements ImportanceInterface
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        $authUser = auth()->user();
        if ($authUser) {
            static::addGlobalScope('restriction', function (Builder $builder) use ($authUser) {
                if ($authUser->hasAnyRole(['admin', 'pr_manager', 'hr_manager'])) {
                    $builder;
                } else {
                    $builder->where('users.id', $authUser->id);
                }
            });
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'city',
        'postal_code',
        'address_line_1',
        'address_line_2',
        'hours_per_week',
        'salary',
        'position',
        'status',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    * Get the country for user.
    *
    * @return BelongsTo
    */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the currency for user.
     *
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the documents for user.
     *
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the documents approved by user.
     *
     * @return HasMany
     */
    public function approvedByDocuments()
    {
        return $this->hasMany(Document::class, 'approved_by_id');
    }

    /**
     * Get the holidays for user.
     *
     * @return HasMany
     */
    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    /**
     * Get the holidays approved by user.
     *
     * @return HasMany
     */
    public function approvedByHolidays()
    {
        return $this->hasMany(Holiday::class, 'approved_by_id');
    }

    /**
     * Get the comments for the user.
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // @codingStandardsIgnoreStart
    /**
     * Get the role for user.
     *
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    // @codingStandardsIgnoreEnd

    /**
     * Get the alerts of the user.
     *
     * @return BelongsToMany
     */
    public function alerts()
    {
        return $this->belongsToMany(Alert::class, 'alert_user');
    }

    /**
     * Get the projects for the users.
     *
     * @return BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }

    /**
     * Get the skills for the users.
     *
     * @return BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill')->withPivot(['importance']);
    }

    /**
     * Get the tags for the user.
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'user_tag')->withPivot(['importance']);
    }

    /**
     * Get the tasks for the user.
     *
     * @return BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }

    /**
     * Get the time entries for user.
     *
     * @return HasMany
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    /**
     * Mutator for hashing the password on save
     *
     * @param string $value The value
     *
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    /**
     * Check the role of the user
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole(string $role): bool
    {
        switch ($role) {
            case 'admin':
                return $this->role_id == 1;
            case 'hr_manager':
                return $this->role_id == 2;
            case 'pr_manager':
                return $this->role_id == 3;
            case 'user':
                return $this->role_id == 4;
            
            default:
                return false;
        }
    }

    /**
     * Check the role of the user
     *
     * @param array $roles
     * @return boolean
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }
}
