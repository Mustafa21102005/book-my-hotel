<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    /** @use HasFactory<\Database\Factories\DiscountFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, mixed>
     */
    protected $fillable = [
        'code',
        'points_required',
        'discount_percent',
        'expires_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'date'
        ];
    }

    /**
     * Get the redeemed discounts that belong to this discount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function redeemed_discounts()
    {
        return $this->hasMany(RedeemedDiscount::class);
    }
}
