<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'venue_id',
        'name',
        'normal_price',
        'description',
    ];

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetails::class, 'price_id', 'id');
    }
}
