<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    const ADMIN = 1;
    const HR_MANAGER = 2;
    const PR_MANAGER = 3;
    const USER = 4;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * Get the users for the role.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
