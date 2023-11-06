<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentAnswer extends Model
{
    use HasFactory;
    protected $table = "enrollment_answers";
    protected $fillable = [
        "enrollment_id",
        "question_id",
        "answers",
        "status",
    ];

    const UNANSWERED = 0;
    const CORRECT = 1;
    const INCORRECT = 2;

    public function Enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }

    public function Question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function Options() // not uses
    {
        return $this->belongsToMany(QuestionOption::class, 'answer_options', 'answer_id', 'option_id');
    }
}
