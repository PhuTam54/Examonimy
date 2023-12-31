<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;// trait

    protected $table = "questions";
    protected $fillable = [
        "question_no", // No. STT
        "question_text",
        "exam_question_id",
        "question_image",
        "question_audio",
        "question_paragraph",
        "question_mark",
        "type_of_question",
        "difficulty"
    ];

    // 1. Multiple Choice 2. Choice 3. Fill in the blank
    const MULTIPLE_CHOICE = 1;
    const CHOICE = 2;
    const FILL_IN_BLANK = 3;

    // 1. Easy 2. Medium 3. Difficult
    const EASY = 1;
    const MEDIUM = 2;
    const DIFFICULT = 3;

    public function checkChoiceExact($answer)
    {
        if (!$answer) {
            return false;
        }

        foreach ($this->QuestionOptions as $option) {
            if ($answer == $option->id) {
                return $option->is_correct;
            }
        }

        return false;
    }

    public function checkFillInBlankExact($answer_text)
    {
        $value = strtolower($answer_text);

        foreach ($this->QuestionOptions as $option) {
            if ($value === strtolower($option->option_text)) {
                return true;
            }
        }

        return false;
    }

    public function QuestionOptions() {
        return $this->hasMany(QuestionOption::class, "question_id");
    }

    public function EnrollmentAnswers() {
        return $this->hasMany(EnrollmentAnswer::class, "question_id");
    }

    public function ExamQuestion() {
        return $this->belongsTo(ExamQuestion::class, "exam_question_id");
    }

    public function getDifficulty() {
        switch($this->difficulty) {
            case self::EASY: return "<span class='text-success'>Easy</span>";
            case self::MEDIUM: return "<span class='text-info'>Medium</span>";
            case self::DIFFICULT: return "<span class='text-danger'>Difficult</span>";
            default: return "<span class='text-warning'>404 Not found</span>";
        }
    }
}
