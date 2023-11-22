<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;// trait

    protected $table = "courses";

//    protected $primaryKey = "id"; // Nếu là id thì không cần viết lại

    protected $fillable = [
        "course_name",
        "course_description",
        "course_thumbnail",
        "course_year",
    ];

    public function Subjects() {
        return $this->hasMany(Subject::class, "course_id");
    }
}
