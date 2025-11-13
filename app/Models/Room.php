<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'room_id';
    
    public function getRouteKeyName()
    {
        return 'room_id';
    }

    protected $fillable = [
        'owner_id',
        'room_number',
        'room_title',
        'slug',
        'room_description',
        'room_price',
        'security_deposit',
        'min_stay_months',
        'sharing_prices',
        'room_capacity',
        'total_beds',
        'room_size',
        'floor',
        'ac',
        'lift',
        'parking',
        'bathroom_type',
        'kitchen',
        'kitchen_type',
        'address_line1',
        'address_line2',
        'locality',
        'city',
        'state',
        'pincode',
        'nearby_landmarks',
        'latitude',
        'longitude',
        'entry_time',
        'exit_time',
        'check_in',
        'check_out',
        'check_in_time',
        'check_out_time',
        'restrictions',
        'is_verified',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            $room->slug = static::generateUniqueSlug($room->room_title);
        });

        static::updating(function ($room) {
            if ($room->isDirty('room_title')) {
                $room->slug = static::generateUniqueSlug($room->room_title, $room->room_id);
            }
        });
    }

    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, function ($query) use ($ignoreId) {
            $query->where('room_id', '!=', $ignoreId);
        })->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected $casts = [
        'sharing_prices' => 'array',
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',

        'ac' => 'boolean',
        'lift' => 'boolean',
        'parking' => 'boolean',
        'kitchen' => 'boolean',
        'is_verified' => 'boolean',
        'status' => 'string',

    ];

    // 🔗 Relationships

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id', 'room_id');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class, 'room_id', 'room_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'room_id', 'room_id');
    }

    public function amenities()
    {
        return $this->hasMany(RoomAmenity::class, 'room_id', 'room_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'room_id', 'room_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'room_id', 'room_id');
    }

    public function virtualTour()
    {
        return $this->hasOne(VirtualTour::class, 'room_id', 'room_id');
    }

    public function activeVirtualTour()
    {
        return $this->hasOne(VirtualTour::class, 'room_id', 'room_id')->where('is_active', true);
    }
}
