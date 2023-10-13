<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $table = 'enrollments';

    protected $fillable = [
        'student_id',
        'exam_id',
        'status'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
