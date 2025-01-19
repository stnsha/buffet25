<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'waze_link',
        'gmap_link'
    ];

    public function capacities()
    {
        return $this->hasMany(Capacity::class, 'venue_id', 'id');
    }
}
