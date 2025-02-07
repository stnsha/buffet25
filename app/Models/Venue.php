<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function capacities(): HasMany
    {
        return $this->hasMany(Capacity::class, 'venue_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'venue_id', 'id');
    }
}
