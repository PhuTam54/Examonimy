<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;
    protected $table = "exam_questions";
    protected $fillable = [
        "exam_id",
        "question_text",
        "question_mark",
        "difficulty"
    ];

    public function QuestionOptions() {
        return $this->hasMany(QuestionOption::class, "question_id");
    }

    public function Exams() {
        return $this->belongsTo(Exam::class, "exam_id");
    }
}
