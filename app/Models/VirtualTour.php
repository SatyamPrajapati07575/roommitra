<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualTour extends Model
{
    use HasFactory;

    protected $primaryKey = 'tour_id';
    
    public function getRouteKeyName()
    {
        return 'tour_id';
    }

    protected $fillable = [
        'room_id',
        'tour_title',
        'tour_description',
        'tour_images',
        'tour_videos',
        'tour_360_images',
        'duration_minutes',
        'is_active',
        'view_count',
        'highlights',
    ];

    protected $casts = [
        'tour_images' => 'array',
        'tour_videos' => 'array',
        'tour_360_images' => 'array',
        'highlights' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Methods
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getFormattedDurationAttribute()
    {
        if ($this->duration_minutes < 60) {
            return $this->duration_minutes . ' minutes';
        }
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($minutes > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $hours . ' hour' . ($hours > 1 ? 's' : '');
    }

    public function getTotalImagesAttribute()
    {
        $count = 0;
        if ($this->tour_images) {
            $count += count($this->tour_images);
        }
        if ($this->tour_360_images) {
            $count += count($this->tour_360_images);
        }
        return $count;
    }

    public function getTotalVideosAttribute()
    {
        return $this->tour_videos ? count($this->tour_videos) : 0;
    }
}
