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
        "exam_id",
        "question_text",
        "question_mark",
        "type_of_question",
        "difficulty"
    ];

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

    public function checkChoiceExact()
    {
//        $optionId = $request->get("choice-$this->id");
        $optionId = request()->input("choice-$this->id");
//        $optionId = 28;
//        dd($optionId);

        if (!$optionId) {
            return false;
        }

        foreach ($this->QuestionOptions as $option) {
            if ($optionId === $option->id) {
                return $option->is_correct;
            }
        }

        return false;
    }

    public function checkFillInBlankExact()
    {
        $value = strtolower(request()->input('fillInBlank-' . $this->id));

        if ($value === strtolower($this->answers[0]['content'])) {
            return true;
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
