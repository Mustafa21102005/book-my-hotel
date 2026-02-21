<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Hotel extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\HotelFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manager_id',
        'name',
        'description',
        'region',
        'country',
        'city',
        'street',
        'breakfast',
        'wifi',
        'pool',
        'gym',
        'pets_allowed',
        'environment'
    ];

    /**
     * Get the manager of the hotel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the rooms of the hotel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the reviews of the hotel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the bookings of the hotel, through its rooms.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Room::class);
    }

    /**
     * Get the promotions of the hotel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    /**
     * Get the active promotion of the hotel.
     *
     * This method will return the promotion with the highest discount
     * percentage that is currently active.
     *
     * @return \App\Models\Promotion|null
     */
    public function activePromotion()
    {
        return $this->promotions()
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->orderByDesc('discount_percent')
            ->first();
    }
}
