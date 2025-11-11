<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmenityMaster extends Model
{
    use HasFactory;

    protected $table = 'amenities_master';
    protected $primaryKey = 'amenity_id';

    protected $fillable = [
        'amenity_name',
        'amenity_key',
        'icon_class',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    // Scope for active amenities
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered amenities
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
