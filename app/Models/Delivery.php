<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'recipient_name',
        'address',
        'phone_number',
        'price',
        'image',
        'payment_status',
        'quantity',
        'delivery_status',
        'created_at',
        'updated_at'
    ];
}
