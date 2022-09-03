<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'message',
        'read',
        'read_at',
    ];

    protected $dates = [
        'read_at'
    ];

    /**
     * Get the users for the alert.
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'alert_user');
    }
}
