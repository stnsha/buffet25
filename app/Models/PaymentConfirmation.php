<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentConfirmation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'ref_no',
        'status',
        'reason',
        'bill_code',
        'amount',
    ];
}
