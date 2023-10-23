<?php

namespace App\Imports;

use App\Models\ExamQuestion;
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

            $questionId = ExamQuestion::insertGetId([
                "question_no" => $row[0], // No. STT
                "question_text" => $row[1],
                "exam_id" => $row[7],
                "question_mark" => $row[8],
                "difficulty" => $row[9],
                "type_of_question" => $row[10]
            ]);

            $question = ExamQuestion::find($questionId);

            if ($question->type_of_question == ExamQuestion::MULTIPLE_CHOICE) {
                $answers = explode(',', $row[6]);
                $options = array_slice($row, 2, 4); // Lấy mảng các đáp án sai từ $row[2] đến $row[5]
                foreach ($options as $index => $option) {
                    $is_correct = in_array(chr($index + ord('A')), $answers); // Kiểm tra xem đáp án có nằm trong mảng $answers không
                    QuestionOption::insert([
                        "question_id" => $questionId,
                        "option_text" => $option,
                        "is_correct" => $is_correct,
                    ]);
                }
            } elseif ($question->type_of_question == ExamQuestion::CHOICE) {
                for ($i = 2; $i <= 5; $i ++) {
                    if ($row[$i] != null) {
                        $is_correct = false;
                        $answer = null;

                        if ($row[6] == 'A') {
                            $answer = $row[2];
                        } elseif ($row[6] == 'B') {
                            $answer = $row[3];
                        } elseif ($row[6] == 'C') {
                            $answer = $row[4];
                        } elseif ($row[6] == 'D') {
                            $answer = $row[5];
                        }

                        if ($row[$i] == $answer) {
                            $is_correct = true;
                        }

                        QuestionOption::insert([
                            "question_id" => $questionId,
                            "option_text" => $row[$i],
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
//        return new ExamQuestion([
//            //
//        ]);
    }
}
