<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attendee extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'bookings');
    }
    //
}
