<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $table = 'room_images';
    // Primary key is 'id' (default) - table uses $table->id()

    protected $fillable = [
        'room_id',
        'image_type',
        'image_url',
        'is_featured',
    ];

    /**
     * Relationship: Belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    /**
     * Scope to get only featured image.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

}
