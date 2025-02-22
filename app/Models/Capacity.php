<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capacity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'venue_id',
        'venue_date',
        'full_capacity',
        'baby_chair',
        'min_capacity',
        'available_capacity',
        'total_paid',
        'total_reserved',
        'status',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
}
