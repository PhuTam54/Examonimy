<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;// trait

    protected $table = "exam_questions";
    protected $fillable = [
        "exam_question_name",
        "exam_question_description",
        "status",
        "duration",
        "number_of_questions",
        "total_marks",
        "passing_marks",
        "status"
    ];

    const PENDING = 0;
    const CONFIRMED = 1;
    const CANCELED = 2;

    public function Questions() {
        return $this->hasMany(Question::class, "exam_question_id");
    }

    public function Exams() {
        return $this->hasMany(Exam::class, "exam_id");
    }

    public function getStatus() {
        switch($this->status) {
            case self::PENDING: return "<span class='text-secondary'>Pending</span>";
            case self::CONFIRMED: return "<span class='text-info'>Confirmed</span>";
            case self::CANCELED: return "<span class='text-danger'>Canceled</span>";
            default: return "<span class='text-warning'>Not found 404</span>";
        }
    }
}
