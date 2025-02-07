<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'venue_id',
        'subtotal',
        'discount_total',
        'total',
        'fpx_id',
        'status',
        'is_bchair',
        'total_chair'
    ];

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
}
