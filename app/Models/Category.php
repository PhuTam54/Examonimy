<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

//    protected $primaryKey = "id"; // Nếu là id thì không cần viết lại

    protected $fillable = [
        "name",
        "slug"
    ];

    public function Products() {
        return $this->hasMany(Product::class);
    }
}
