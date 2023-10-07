<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = "subjects";
    protected $fillable = [
        "subject_name",
        "subject_description",
        "lesson",
        "thumbnail",
        "course_id",
    ];

    public function Category() {  // Model relationship
        return $this->belongsTo(Course::class ); //"category_id"
    }

    public function Orders() {
        return $this->belongsToMany(Exam::class, "order_details")->withPivot(["price", "qty"]);
    }
}
