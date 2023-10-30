<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class QnaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info($row);
        if ($row[0] != 'no.') {
            $image = $row[11] ?? null;
            $audio = $row[12] ?? null;
            $paragraph = $row[13] ?? null;

            $questionId = Question::insertGetId([
                "question_no" => $row[0], // No. STT
                "question_text" => $row[1],
                "exam_question_id" => $row[7],
                "question_mark" => $row[8],
                "difficulty" => $row[9],
                "type_of_question" => $row[10],
                "question_image" => $image,
                "question_audio" => $audio,
                "question_paragraph" => $paragraph,
            ]);

            $question = Question::find($questionId);

            if ($question->type_of_question == Question::MULTIPLE_CHOICE || $question->type_of_question == Question::CHOICE) {
                $answers = explode(',', $row[6]);
                $options = array_slice($row, 2, 4); // Lấy mảng các đáp án sai từ $row[2] đến $row[5]
                foreach ($options as $index => $option) {
                    if ($option != null && $option != ' ') {
                        $is_correct = in_array(chr($index + ord('A')), $answers); // Kiểm tra xem đáp án có nằm trong mảng $answers không
                        QuestionOption::insert([
                            "question_id" => $questionId,
                            "option_text" => chr($index + ord('A')).'. '.$option,
                            "is_correct" => $is_correct,
                        ]);
                    }
                }
            } else {
                if ($row[2] != null) {
                    $answer = trim($row[2]);

                    QuestionOption::insert([
                        "question_id" => $questionId,
                        "option_text" => $answer,
                        "is_correct" => true,
                    ]);
                }
            }
        }
    }
}
