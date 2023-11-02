<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances';

    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'lesson_attendance',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function Subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function Class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
