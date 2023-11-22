<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;// trait

    protected $table = "subjects";
    protected $fillable = [
        "subject_name",
        "subject_description",
        "lesson",
        "subject_thumbnail",
        "course_id",
    ];

    public function Course() {  // Model relationship
        return $this->belongsTo(Course::class, "course_id");
    }
}
