<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'price_id',
        'price',
        'quantity',
        'subtotal',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function hasPrice(): BelongsTo
    {
        return $this->belongsTo(Price::class, 'price_id', 'id');
    }
}
