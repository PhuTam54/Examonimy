<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;
    protected $table = "classrooms";
    protected $fillable = [
        "class_name",
        "number_of_students",
        "instructor_id",
    ];
}
