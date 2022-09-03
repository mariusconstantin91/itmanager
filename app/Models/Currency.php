<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'iso',
        'sign',
    ];

    /**
     * Get the users fot the currency.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the rates for the currency.
     */
    public function rates()
    {
        return $this->hasMany(CurrencyRate::class, 'currency_1_id');
    }

    /**
     * Get the rverse rates for the currency.
     */
    public function reverseRates()
    {
        return $this->hasMany(CurrencyRate::class, 'currency_2_id');
    }
}
