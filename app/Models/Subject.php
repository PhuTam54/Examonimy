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
        "subject_thumbnail",
        "course_id",
    ];

    public function Course() {  // Model relationship
        return $this->belongsTo(Course::class ); //"category_id"
    }

    public function Exams() {
        return $this->belongsToMany(Exam::class, "order_details")->withPivot(["price", "qty"]);
    }
}
