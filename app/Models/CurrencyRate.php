<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rate',
    ];

    /**
     * Get the main currency for currency rate.
     *
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_1_id');
    }

    /**
     * Get the main currency for currency rate.
     *
     * @return BelongsTo
     */
    public function reverseCurrency()
    {
        return $this->belongsTo(Currency::class, 'currency_2_id');
    }
}
