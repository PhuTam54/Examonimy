<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ExamQuestion extends Model
{
    use HasFactory;
    protected $table = "exam_questions";
    protected $fillable = [
        "question_no", // No. STT
        "question_text",
        "exam_id",
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
//    public function __construct($id, $content, $answers)
//    {
//        parent::__construct('multiple_choice', $id, $content, $answers);
//    }

//    public function render($index)
//    {
//        $answersHTML = '';
//        foreach ($this->answers as $item) {
//            $answersHTML .= '<div>
//                <input value="' . $item['id'] . '" class="answer-' . $this->id . '" type="radio" name="answer-' . $this->id . '"/>
//                <label class="lead">' . $item['content'] . '</label>
//            </div>';
//        }
//
//        return '
//            <div>
//                <p class="lead font-italic" style="font-size: 30px;">
//                    Câu ' . $index . ': ' . $this->content . '
//                </p>
//                ' . $answersHTML . '
//            </div>
//        ';
//    }

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

    public function checkMultipleChoiceExact($answer_array)
    {
        if (!$answer_array) {
            return false;
        }

        $isCorrect = true;

        foreach ($answer_array as $answer) {
            $result = $this->checkChoiceExact($answer);
            if (!$result) {
                $isCorrect = false;
                break;
            }
        }

        return $isCorrect;
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

    public function ExamAnswers() {
        return $this->hasMany(ExamAnswer::class, "question_id");
    }

    public function Exam() {
        return $this->belongsTo(Exam::class, "exam_id");
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
