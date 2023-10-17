<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = "exams";
    protected $fillable = [
        "exam_name",
        "exam_description",
        "status",
        "start_date",
        "end_date",
        "duration",
        "number_of_questions",
        "exam_thumbnail",
        "total_marks",
        "passing_marks",
        "status",
        "type_of_exam",
        "created_by",
        "subject_id",
    ];

    const PENDING = 0;
    const CONFIRMED = 1;
    const PROCESSING = 2;
    const COMPLETE = 3;
    const CANCEL = 4;

    public function Subject() {
        return $this->belongsTo(Subject::class);
    }

    public function Instructor() {
        return $this->belongsTo(User::class, "created_by");
    }

    public function Questions() {
        return $this->hasMany(ExamQuestion::class, "exam_id");
    }

    public function getStatus() {
        switch($this->status) {
            case self::PENDING: return "<span class='text-secondary'>Pending</span>";
            case self::CONFIRMED: return "<span class='text-info'>Confirmed</span>";
            case self::PROCESSING: return "<span class='text-warning'>Processing</span>";
            case self::COMPLETE: return "<span class='text-success'>Completed</span>";
            case self::CANCEL: return "<span class='text-danger'>Canceled</span>";
            default: return "<span class='text-warning'>Not found 404</span>";
        }
    }

//    public function getGrandTotal() {
//        return "$".number_format($this->grand_total, 2);
//    }
//
//    public function getIsPaid() {
//        return $this->is_paid?
//            "<span class='bg-success p-2 small'>Has paid</span>":
//            "<span class='bg-secondary p-2 small'>Not pay</span>";
//    }
//
}
