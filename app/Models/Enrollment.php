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

    const PENDING = 0;
    const CONFIRMED = 1;
    const COMPLETED = 2;
    const NOT_TAKEN = 3;
    const CANCELED = 4;
    const RETAKEN = 5;

    public function User()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function getStatus() {
        switch($this->status) {
            case self::PENDING: return "<span class='text-secondary'>Pending</span>";
            case self::CONFIRMED: return "<span class='text-info'>Confirmed</span>";
            case self::COMPLETED: return "<span class='text-success'>Completed</span>";
            case self::NOT_TAKEN: return "<span class='text-warning'>Not_Taken</span>";
            case self::CANCELED: return "<span class='text-danger'>Canceled</span>";
            case self::RETAKEN: return "<span class='text-primary'>Retaken</span>";
            default: return "<span class='text-warning'>Not found 404</span>";
        }
    }
}
