<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visit extends Model
{
    use HasFactory;

    protected $primaryKey = 'visit_id';
    
    public function getRouteKeyName()
    {
        return 'visit_id';
    }

    protected $fillable = [
        'user_id',
        'room_id',
        'visit_type',
        'preferred_date',
        'preferred_time',
        'alternative_date',
        'alternative_time',
        'visitor_name',
        'visitor_phone',
        'visitor_email',
        'special_requirements',
        'status',
        'confirmed_date',
        'confirmed_time',
        'owner_notes',
        'owner_responded_at',
        'meeting_link',
        'meeting_id',
        'meeting_password',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'alternative_date' => 'date',
        'confirmed_date' => 'date',
        'owner_responded_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePhysical($query)
    {
        return $query->where('visit_type', 'physical');
    }

    public function scopeVirtual($query)
    {
        return $query->where('visit_type', 'virtual');
    }

    // Accessors
    public function getFormattedPreferredDateTimeAttribute()
    {
        if ($this->preferred_date && $this->preferred_time) {
            return Carbon::parse($this->preferred_date->format('Y-m-d') . ' ' . $this->preferred_time)->format('d M Y, h:i A');
        }
        return null;
    }

    public function getFormattedConfirmedDateTimeAttribute()
    {
        if ($this->confirmed_date && $this->confirmed_time) {
            return Carbon::parse($this->confirmed_date->format('Y-m-d') . ' ' . $this->confirmed_time)->format('d M Y, h:i A');
        }
        return null;
    }

    public function getFormattedAlternativeDateTimeAttribute()
    {
        if ($this->alternative_date && $this->alternative_time) {
            return Carbon::parse($this->alternative_date->format('Y-m-d') . ' ' . $this->alternative_time)->format('d M Y, h:i A');
        }
        return null;
    }

    // Helper method to get time in HH:MM format for form inputs
    public function getPreferredTimeForInputAttribute()
    {
        return $this->preferred_time ? substr($this->preferred_time, 0, 5) : '';
    }

    public function getAlternativeTimeForInputAttribute()
    {
        return $this->alternative_time ? substr($this->alternative_time, 0, 5) : '';
    }

    public function getConfirmedTimeForInputAttribute()
    {
        return $this->confirmed_time ? substr($this->confirmed_time, 0, 5) : '';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'confirmed' => 'success',
            'completed' => 'primary',
            'cancelled' => 'danger',
            'rescheduled' => 'info'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getVisitTypeBadgeAttribute()
    {
        return $this->visit_type === 'virtual' ? 'info' : 'success';
    }
}
