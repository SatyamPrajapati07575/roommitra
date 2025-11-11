<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $primaryKey = 'city_id';

    protected $fillable = [
        'state_id',
        'city_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }
}
