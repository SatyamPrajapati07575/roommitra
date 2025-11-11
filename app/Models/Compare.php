<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;

class Compare extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
    ];

    /**
     * Get the user that owns the compare.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the room that is being compared.
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}
