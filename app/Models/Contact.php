<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Contact extends Model
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
            } elseif ($authUser->hasAnyRole(['pr_manager'])) {
                $builder->whereHas('client.projects.users', function ($query) use ($authUser) {
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
        'email',
        'phone',
        'city',
        'postalcode',
        'address_line_1',
        'address_line_2',
        'main_contact',
        'position',
        'country_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'main_contact' => 'boolean',
    ];

    /**
     * Get the client of the contact.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the country of the contact.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
