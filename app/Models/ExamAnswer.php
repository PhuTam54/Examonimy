<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;
    protected $table = "exam_answers";
    protected $fillable = [
        "enrollment_id",
        "question_id",
        "answers",
        "status",
    ];

    public function Enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }

    public function Question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id');
    }

    public function Options()
    {
        return $this->belongsToMany(QuestionOption::class, 'answer_options', 'answer_id', 'option_id');
    }
}
