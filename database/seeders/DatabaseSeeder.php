<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
             'role' => "ADMIN",
             "full_name"=> "Nguyen Phu Tam",
             "phone_number"=> "0987654321",
             "address"=> "TS - BN",
         ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Course::factory(10)->create();
        \App\Models\Subject::factory(10)->create();
        \App\Models\Exam::factory(30)->create();

        $exams = Exam::all();
        foreach ($exams as $exam) {
            DB::table("enrollments")
                ->insert([
                    "user_id"=> random_int(2, 11),
                    "exam_id"=>$exam->id,
                    "status"=>random_int(0, 3)
                ]);
        }

        \App\Models\ClassRoom::factory(10)->create();

        $classes = ClassRoom::all();
        foreach ($classes as $class) {
            DB::table("attendances")
                ->insert([
                    "user_id"=> random_int(2, 11),
                    "subject_id"=> random_int(1, 10),
                    "class_id"=> $class->id,
                    "lesson_attendance"=> random_int(0, 50),
                ]);
        }



    }
}
