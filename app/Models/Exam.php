<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory;
    use SoftDeletes;// trait
    protected $table = "exams";
    protected $fillable = [
        "exam_name",
        "exam_description",
        "start_date",
        "end_date",
        "exam_thumbnail",
        "retaken_fee",
        "status",
        "type_of_exam",
        "created_by",
        "subject_id",
        "exam_question_id",
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

    public function ExamQuestion() {
        return $this->belongsTo(ExamQuestion::class, "exam_question_id");
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
}
