<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Document extends Model
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
            if (!$authUser || $authUser->hasAnyRole(['admin', 'pr_manager', 'hr_manager'])) {
                $builder;
            } else {
                $builder->where('user_id', $authUser->id);
            }
        });
    }
    
    /**
     * The available statuses
     */
    const STATUS_OPTIONS = [
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'pending' => 'Pending'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'path',
        'status',
        'user_id',
    ];

    /**
     * Get the user for document.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user which approved for document.
     *
     * @return BelongsTo
     */
    public function approveUser()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }
}
