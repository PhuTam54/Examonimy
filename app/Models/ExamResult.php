<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;
    protected $table = "exam_results";
    protected $fillable = [
        "enrollment_id",
        "score",
        "time_taken",
        "status",
        "note"
    ];

    public function Enrollment()
    {
        return $this->belongsTo(Enrollment::class, "enrollment_id");
    }

    const FAIL = 1;
    const ACCEPTABLE = 2;
    const GOOD = 3;
    const VERYGOOD = 4;
    const EXCELLENT = 5;

    public function getStatus() {
        switch($this->status) {
            case self::EXCELLENT: return "<span class='text-primary'>Excellent</span>";
            case self::VERYGOOD: return "<span class='text-success'>Very good</span>";
            case self::GOOD: return "<span class='text-info'>Good</span>";
            case self::ACCEPTABLE: return "<span class='text-warning'>Acceptable</span>";
            case self::FAIL: return "<span class='text-danger'>Fail</span>";
            default: return "<span class='text-warning'>Not found 404</span>";
        }
    }

//    public function getEnrollmentKeyAttribute()
//    {
//        return $this->user_id . '-' . $this->exam_id;
//    }
//
//    public function Enrollment()
//    {
//        return $this->belongsTo(Enrollment::class, 'enrollment_key', ['user_id', 'exam_id']);
//    }


//    public function Enrollment()
//    {
//        return $this->belongsTo(Enrollment::class, ['user_id', 'exam_id']);
//    }
}
