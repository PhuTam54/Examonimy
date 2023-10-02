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

    const PENDING = 0;
    const CONFIRMED = 1;
    const SHIPPING = 2;
    const SHIPPED = 3;
    const COMPLETE = 4;
    const CANCEL = 5;

    public function Products() {
        return $this->belongsToMany(Product::class, "order_details")->withPivot(["qty", "price"]);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }
}
