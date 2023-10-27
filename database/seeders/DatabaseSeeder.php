<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\EnrollmentAnswer;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Webmozart\Assert\Tests\StaticAnalysis\integer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'name' => 'Phu Tam',
             'email' => 'phutamytb@gmail.com',
             'password' => bcrypt('123456'),
             'role' => 3,
             "full_name"=> "Nguyen Phu Tam",
             "phone_number"=> "0987654321",
             "address"=> "TS - BN",
         ]);

        \App\Models\User::factory(19)->create();
        \App\Models\Course::factory(4)->create();
//        DB::table("courses")
//            ->insert([
//            "course_name"=> "ADSE",
////            "slug"=> Str::slug($name),
//            "course_description"=> $this->faker->unique()->city,
//            "course_thumbnail"=>"storage/img/main-img/cat-1.jpg",
//            "course_year"=> 2,
//            ]);

        \App\Models\Subject::factory(20)->create();
        $subjects = Subject::all();
        foreach ($subjects as $subject) {
            DB::table("exam_questions")
                ->insert([
                    "exam_question_name"=>$subject->subject_name.' ExamQuestion',
                    "exam_question_description"=>$subject->subject_description.' ExamQuestion',
                    "duration"=> 40 * 60, // seconds
                    "number_of_questions"=> 16,
                    "total_marks"=> 20,
                    "passing_marks"=> 6.7,
                    "status"=>1
                ]);
        }

        \App\Models\Exam::factory(5)->create();

        $exams = Exam::all();
        foreach ($exams as $exam) {
            DB::table("enrollments")
                ->insert([
                    "student_id"=> random_int(1, 1),
                    "exam_id"=>$exam->id,
                    "status"=>random_int(1, 1)
                ]);
        }

        \App\Models\Classes::factory(10)->create();

        $classes = Classes::all();
        foreach ($classes as $class) {
            DB::table("attendances")
                ->insert([
                    "student_id"=> random_int(1, 20),
                    "subject_id"=> random_int(1, 20),
                    "class_id"=> $class->id,
                    "lesson_attendance"=> random_int(1, 20),
                ]);
        }

//        \App\Models\Question::factory(200)->create();
//        $questions = Question::all();
//        $option_text = "A. Answer";
//        $string_text = "This is Answer";
//        foreach ($questions as $question) {
//            if ($question->type_of_question == 1) {
//                for ($i = 0; $i < 3; $i++) {
//                    DB::table("question_options")
//                        ->insert([
//                            "question_id" => $question->id,
//                            "option_text" => $question->id . " " . $option_text . " " . $i,
//                            "is_correct" => random_int(0, 1)
//                        ]);
//                }
//                DB::table("question_options") // Make sure at least 1 option is correct
//                ->insert([
//                    "question_id" => $question->id,
//                    "option_text" => $question->id . " " . $option_text . " " . $i,
//                    "is_correct" => 1
//                ]);
//
//            } elseif ($question->type_of_question == 2) {
//                for ($i = 0; $i < 3; $i++) {
//                    DB::table("question_options")
//                        ->insert([
//                            "question_id" => $question->id,
//                            "option_text" => $question->id . " " . $option_text . " " . $i,
//                            "is_correct" => 0
//                        ]);
//                }
//                DB::table("question_options") // Make sure at least 1 option is correct
//                ->insert([
//                    "question_id" => $question->id,
//                    "option_text" => $question->id . " " . $option_text . " " . $i,
//                    "is_correct" => 1
//                ]);
//
//            } else {
//                DB::table("question_options")
//                    ->insert([
//                        "question_id" => $question->id,
//                        "option_text" => $question->id . " " . $string_text,
//                        "is_correct" => 1
//                    ]);
//            }
//        }

//        \App\Models\QuestionOption::factory(200)->create();

//        $exams = Exam::all();
//        foreach ($exams as $exam) {
////            DB::table("enrollment_answers")
//                $answer = new EnrollmentAnswer;
//                $answer->enrollment_id = random_int(1, 30);
//                $answer->question_id = random_int(1, 50);
//                $answer->answers = str(random_int(1, 200) .','. random_int(1, 200));
//                $answer->status = random_int(0, 2);
//                $answer->save();
//                $answer->Options()->attach($options);

//                ->insert([
//                    "enrollment_id"=> random_int(1, 30),
//                    "option_id"=>random_int(1, 200),
//                    "status"=>random_int(0, 2)
//                ]);
//        }

//        \App\Models\EnrollmentResult::factory(50)->create();
    }
}
