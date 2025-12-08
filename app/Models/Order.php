<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'items', 'total', 'paid', 'payment_provider', 'payment_reference'
    ];

    protected $casts = [
        'items' => 'array',
        'paid' => 'boolean',
        'total' => 'decimal:2'
    ];
}
