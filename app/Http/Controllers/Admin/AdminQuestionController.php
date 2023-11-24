<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QnaImport;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminQuestionController extends Controller
{

    // Question
    public function question() {
        $questions = Question::orderBy("id","desc")->get();
        return view("pages.admin.question.admin-question", compact("questions"));
    }
    public function questionAdd() {
        $exam_questions = ExamQuestion::where("status", "=", ExamQuestion::PENDING)->get();
        $questions = Question::all();
        return view("pages.admin.question.question-add",
            compact("exam_questions", "questions"));
    }

    public function questionStore(Request $request) {
        $request->validate([
            "question_text"=> "required",
            "question_image"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:image/*",
            'question_audio' => 'nullable|mimes:mp3,wav|mimetypes:audio/mpeg,audio/wav',
            "question_paragraph"=>"nullable",
            "type_of_question"=> "required",
            "difficulty"=> "required",
            "is_correct"=> "required | min:1 | max:9",
            "option_text"=> "required | min:1 | max:10"
        ]);
        try {
            $image = null;
            $audio = null;
            $paragraph = null;
            // Xử lí upload file
            if ($request->hasFile("question_image")) {
                $path = public_path("uploads/images");

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $path = public_path("uploads/images");
                $file = $request->file("question_image");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                if ($file->isValid()) {
                    $file->move($path, $file_name);
                    $image = "/uploads/images/".$file_name;
                }
            }

            if ($request->hasFile("question_audio")) {
                $path = public_path("uploads/audio");
                $file = $request->file("question_audio");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $audio = "/uploads/audio/".$file_name;
            }

            // get paragraph
            if ($request->get("question_paragraph") != '') {
                $paragraph = $request->get("question_paragraph");
            }

            // set point / question
            $point = 0;
            if ($request->get("difficulty") == 1) {
                $point = 1;
            } elseif ($request->get("difficulty") == 2) {
                $point = 1.5;
            } elseif ($request->get("difficulty") == 3) {
                $point = 2;
            }

            $questionId = Question::insertGetId([
                "question_no" => $request->get("question_no") || 0, // No. STT
                "question_text" => $request->get("question_text"),
                "exam_question_id" => $request->get("exam_question_id"),
                "question_mark" => $point,
                "difficulty" => $request->get("difficulty"),
                "type_of_question" => $request->get("type_of_question"),
                "question_image" => $image,
                "question_audio" => $audio,
                "question_paragraph" => $paragraph,
            ]);

            if ($request->get("type_of_question") == Question::MULTIPLE_CHOICE || $request->get("type_of_question") == Question::CHOICE) {
                $answers = $request->get("is_correct");
                $options = $request->get("option_text");
                foreach ($options as $index => $option) {
                    if ($option != null && $option != '') {
                        $is_correct = in_array($option, $answers); // Kiểm tra xem đáp án có nằm trong mảng $answers không
                        QuestionOption::insert([
                            "question_id" => $questionId,
                            "option_text" => chr($index + ord('A')).'. '.$option,
                            "is_correct" => $is_correct,
                        ]);
                    }
                }
            } else {
                if ($request->get("option_text") != null && $request->get("option_text") != []) {
                    $answer = implode(",", $request->get("option_text"));

                    QuestionOption::insert([
                        "question_id" => $questionId,
                        "option_text" => $answer,
                        "is_correct" => true,
                    ]);
                }
            }

            return response()->json(['success'=>true, 'msg'=>"Add new question successfully!!!"]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function questionEdit(Question $question) {
        $exam_questions = ExamQuestion::all();

        return view("pages.admin.question.question-edit",
            compact("question", "exam_questions"));
    }

    public function questionUpdate(Request $request, Question $question) {
        $request->validate([
            "question_text"=> "required",
            "question_image"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:image/*",
            "question_audio"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:audio/*",
            "question_paragraph"=>"nullable",
            "type_of_question"=> "required",
            "difficulty"=> "required",
            "is_correct"=> "required | min:1 | max:9",
            "option_text"=> "required | min:1 | max:10"
        ]);
        try {
            $image = null;
            $audio = null;
            $paragraph = null;
            // Xử lí upload file
            if ($request->hasFile("question_image")) {
                $path = public_path("uploads/images");
                $file = $request->file("question_image");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $image = "/uploads/".$file_name;

                $question->question_image = $image;
            }

            if ($request->hasFile("question_audio")) {
                $path = public_path("uploads/audio");
                $file = $request->file("question_audio");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $audio = "/uploads/audio/".$file_name;

                $question->question_audio = $audio;
            }

            // get paragraph
            if ($request->get("question_paragraph") != '') {
                $paragraph = $request->get("question_paragraph");
            }

            // set point / question
            $point = 0;
            if ($request->get("difficulty") == 1) {
                $point = 1;
            } elseif ($request->get("difficulty") == 2) {
                $point = 1.5;
            } elseif ($request->get("difficulty") == 3) {
                $point = 2;
            }

            // edit question
            $question->update([
                "question_no" => $request->get("question_no") || 0, // No. STT
                "question_text" => $request->get("question_text"),
                "exam_question_id" => $request->get("exam_question_id"),
                "question_mark" => $point,
                "difficulty" => $request->get("difficulty"),
                "type_of_question" => $request->get("type_of_question"),
                "question_paragraph" => $paragraph,
            ]);

            $old_options = $question->QuestionOptions;
            $new_options = $request->get("option_text");
            $new_answers = $request->get("is_correct");

            foreach ($old_options as $index => $old_option) {
                if ($old_option != null && $old_option != '') {
                    // Kiểm tra xem $index có tồn tại trong mảng $new_options không
                    if (array_key_exists($index, $new_options)) {
                        $new_option = $new_options[$index];
                        $is_correct = in_array($new_option, $new_answers);

                        // Cập nhật thông tin cho sự lựa chọn cũ
                        if ($request->get("type_of_question") == Question::FILL_IN_BLANK) {
                            $old_option->update([
                                "option_text" => $new_option,
                            ]);
                        } else {
                            $old_option->update([
                                "option_text" => chr($index + ord('A')).'. '.$new_option,
                                "is_correct" => $is_correct,
                            ]);
                        }
                    } else {
                        // Nếu admin xóa bớt câu trả lời
                        $old_option->delete();
                    }
                }
            }

            // Thêm mới sự lựa chọn nếu $new_options có nhiều phần tử hơn và chưa được sử dụng để update $old_options
            for ($index = count($old_options); $index < count($new_options) && $index < count($old_options) + count($new_options); $index++) {
                $new_option = $new_options[$index];
                $is_correct = in_array($new_option, $new_answers);

                // Thêm mới sự lựa chọn
                QuestionOption::create([
                    "question_id" => $question->id,
                    "option_text" => chr($index + ord('A')).'. '.$new_option,
                    "is_correct" => $is_correct,
                ]);
            }
            return response()->json(['success'=>true, 'msg'=>"Edit question successfully!!!"]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function questionDelete(Question $question) {
        try {
            // delete question
            $to_delete_question = Question::find($question->id);
            $to_delete_question->delete();
            return redirect()->to("admin/admin-question")->with("delete-success", "Delete question successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function questionTrash() {
        $questions = Question::onlyTrashed()->orderBy("id","desc")->get();
        return view("pages.admin.question.admin-question", compact("questions"))->with("questionTrash");
    }

    public function questionRecover(Question $question) {
        try {
            // recover question
            $question->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-question")->with("recover-success", "Recover question $question->question_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    // excel
    public function importQna(Request $request) {
        try {
            Excel::import(new QnaImport, $request->file('file'));

            return response()->json(['success'=>true, 'msg'=>'Import Q&A successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

}
