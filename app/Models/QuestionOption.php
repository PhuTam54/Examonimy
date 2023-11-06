<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;
    protected $table = "question_options";
    protected $fillable = [
        "question_id",
        "option_text",
        "is_correct",
    ];

    public function Question() {
        return $this->belongsTo(Question::class, "question_id");
    }

    const CORRECT = true;
    const INCORRECT = false;

    public function getIsCorrect() {
        switch($this->is_correct) {
            case self::CORRECT: return "<span class='text-success'>Correct</span>";
            case self::INCORRECT: return "<span class='text-danger'>Incorrect</span>";
            default: return "<span class='text-warning'>404 Not found</span>";
        }
    }
}
