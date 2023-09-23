<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = [
        "user_id",
        "grand_total",
        "status",
        "full_name",
        "tel",
        "address",
        "payment_method",
        "shipping_method",
        "is_paid",
    ];
}
