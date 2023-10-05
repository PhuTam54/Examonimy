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

    public function getGrandTotal() {
        return "$".number_format($this->grand_total, 2);
    }

    public function getIsPaid() {
        return $this->is_paid?
            "<span class='bg-success p-2 small'>Has paid</span>":
            "<span class='bg-secondary p-2 small'>Not pay</span>";
    }

    public function getStatus() {
        switch ($this->status) {
            case self::PENDING: return "<span class='text-secondary'>Pending</span>";
            case self::CONFIRMED: return "<span class='text-info'>Confirmed</span>";
            case self::SHIPPING: return "<span class='text-warning'>Shipping</span>";
            case self::SHIPPED: return "<span class='text-primary'>Shipped</span>";
            case self::COMPLETE: return "<span class='text-success'>Complete</span>";
            case self::CANCEL: return "<span class='text-danger'>Cancel</span>";
        }
    }

    public function User() {
        return $this->belongsTo(User::class);
    }
}
