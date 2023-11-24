<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentResult extends Model
{
    use HasFactory;

    protected $table = "enrollment_results";
    protected $fillable = [
        "enrollment_id",
        "score",
        "correct",
        "incorrect",
        "unanswered",
        "time_taken",
        "grade",
        "status",
        "note"
    ];

    public function Enrollment()
    {
        return $this->belongsTo(Enrollment::class, "enrollment_id");
    }

    const PENDING = 0;
    const APPROVED = 1;
    const DECLINED = 2;

    const FAIL = 1;
    const ACCEPTABLE = 2;
    const GOOD = 3;
    const VERYGOOD = 4;
    const EXCELLENT = 5;

    public function getGrade() {
        switch($this->grade) {
            case self::EXCELLENT: return "<span class='text-primary'>Excellent</span>";
            case self::VERYGOOD: return "<span class='text-success'>Very good</span>";
            case self::GOOD: return "<span class='text-info'>Good</span>";
            case self::ACCEPTABLE: return "<span class='text-warning'>Acceptable</span>";
            case self::FAIL: return "<span class='text-danger'>Fail</span>";
            default: return "<span class='text-warning'>Not found 404</span>";
        }
    }

    public function getStatus() {
        switch($this->status) {
            case self::PENDING: return "<span class='text-secondary'>PENDING</span>";
            case self::APPROVED: return "<span class='text-success'>APPROVED</span>";
            case self::DECLINED: return "<span class='text-danger'>DECLINED</span>";
            default: return "<span class='text-warning'>Not found 404</span>";
        }
    }
}
