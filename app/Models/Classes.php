<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory;
    use SoftDeletes;// trait

    protected $table = "classes";
    protected $fillable = [
        "class_name",
        "number_of_students",
        "instructor_id",
    ];

    public function Instructor() {
        return $this->belongsTo(User::class, "instructor_id");
    }

    public function Students() {
        return $this->hasMany(User::class, "class_id");
    }

    public function Attendances() {
        return $this->hasMany(User::class, "class_id");
    }
}
