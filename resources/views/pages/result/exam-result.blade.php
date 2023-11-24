@extends("layouts.app")
@section("title", "Examonimy | Exam Result")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Exam Result</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Exams</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Exam Result</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
        <!-- Header End -->

        <!-- Exam Result Start -->
    <div class="container-xxl py-5">
        <div class="container-fluid">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                <h2 class="mb-1">{{ session('exam-submit-success') ?? "$enrollment_result->note" }} </h2>
            </div>
            <div class="row g-0 justify-content-center">
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped" style="border: 1px solid rgba(0,0,0,0.125)">
                        <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Result</th>
                            <th>Correct</th>
                            <th>Incorrect</th>
                            <th>Unanswered</th>
                            <th>Duration</th>
                            <th>Score</th>
                            <th>Grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <p class="text-center mb-1">{{ $examination->exam_name }}</p>
                                <img class="image mt-2" src="{{ $examination->exam_thumbnail }}" width="100" alt="img">
                            </td>
                            <td class="text-secondary">{{ $enrollment_result->correct }} / {{ $examination->ExamQuestion->Questions->count() }}</td>
                            <td class="text-success">{{ $enrollment_result->correct }}</td>
                            <td class="text-danger">{{ $enrollment_result->incorrect }}</td>
                            <td class="text-warning">{{ $enrollment_result->unanswered }}</td>
                            @if($enrollment_result->time_taken / 3600 > 1)
                                <td>
                                    {{ floor($enrollment_result->time_taken / 3600) }} hours
                                    {{ floor($enrollment_result->time_taken % 3600 / 60) }} minutes
                                    {{ $enrollment_result->time_taken % 60 }} seconds
                                </td>
                            @elseif(($enrollment_result->time_taken % 3600) / 60 > 1)
                                <td>
                                    {{ floor($enrollment_result->time_taken % 3600 / 60) }} minutes
                                    {{ $enrollment_result->time_taken % 60 }} seconds
                                </td>
                            @elseif($enrollment_result->time_taken % 60 > 1)
                                <td>
                                    {{ $enrollment_result->time_taken % 60 }} seconds
                                </td>
                            @endif
                            <td class="text-primary">{{ number_format($enrollment_result->score, 2) }} / {{  number_format($total_score, 2) }}</td>
                            <td>
                                {!! $enrollment_result->getGrade() !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    @php
                        $resultPercent = round(($enrollment_result->correct / $examination->ExamQuestion->Questions->count()) * 100, 2);
                        $resultBg = '';
                        if ($resultPercent <= 33.33) {
                            $resultBg = 'danger';
                        } elseif ($resultPercent <= 66.66) {
                            $resultBg = 'warning';
                        } else {
                            $resultBg = 'success';
                        }
                    @endphp

                    <div class="progress" style="height: 40px;">
                        <div
                            class="fs-6 progress-bar progress-bar-striped progress-bar-animated bg-{{ $resultBg }}" role="progressbar" style="width: {{ $resultPercent }}%"
                            aria-valuenow="{{ $resultPercent }}" aria-valuemin="0" aria-valuemax="100"
                        >{{ $resultPercent }}%</div>
                    </div>
                </div>
                {{-- Questions--}}
                <div class="col-md-12 g-0">
                    <div class="card card-success">
                        <div class="card-header">
                            <h4 class="card-title">{{ $examination->exam_name }} - {{ $examination->Subject->subject_name }}</h4>
                        </div>
                        @php
                            $part_counter = 1;
                            $question_counter = 1;
                        @endphp
                        @foreach($questions as $question)
                            @php
                                $isCorrect = false;
                                $isUnanswered = false;
                                $answers = '';
                                foreach ($enrollment->EnrollmentAnswers as $enrollment_answer) {
                                    if ($enrollment_answer->question_id == $question->id) {
                                        $isCorrect = ($enrollment_answer->status == \App\Models\EnrollmentAnswer::CORRECT);
                                        $isUnanswered = ($enrollment_answer->status == \App\Models\EnrollmentAnswer::UNANSWERED);
                                        $answers = $enrollment_answer->answers;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="card-body">
                                @if($question->question_paragraph != null && $question->question_paragraph !=' ')
                                    <div class="text text-secondary">Part {{ $part_counter ++ }}: {{ $question->question_paragraph }}</div><br>
                                @endif
                                <h6>Question {{ $question_counter ++ }}: {{ $question->question_text }} <br>
                                    <span class="text-info">Point: {{ $question->question_mark }}</span>
                                </h6>
                                @if($question->question_image != null)
                                    <img src="{{ Illuminate\Support\Str::contains($question->question_image, '/uploads/') ? $question->question_image : asset("storage/file/images/exam/1.".$question->question_image.".jpg") }}" width="250" alt="img">
                                @endif
                                @if($question->question_audio != null)
                                    <audio controls>
                                        <source src="{{ Illuminate\Support\Str::contains($question->question_audio, '/uploads/') ? $question->question_audio : asset('storage/file/audio/exam/1.'.$question->question_audio.'.mp3') }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                                <!-- Options -->
                                <div class="form-group clearfix">
                                    @foreach($question->QuestionOptions as $option)
                                        @if($question->type_of_question == 1)
                                            <!-- checkbox -->
                                            <div class="icheck-primary d-block mx-auto w-100">
                                                <input
                                                    disabled
                                                    name="multipleChoice-{{ $option->id }}"
                                                    value="{{ $option->id }}"
                                                    type="checkbox"
                                                    id="multipleChoice-{{ $option->id }}"
                                                    class="w-100"
                                                    @foreach($enrollment->EnrollmentAnswers as $enrollment_answer)
                                                        @if(str_contains($enrollment_answer->answers, $option->id) !== false) checked @endif
                                                    @endforeach
                                                >
                                                <label for="multipleChoice-{{ $option->id }}">
                                                    {{ $option->option_text }}
                                                </label>
                                            </div>
                                        @elseif($question->type_of_question == 2)
                                            <!-- radio -->
                                            <div class="icheck-primary d-block mx-auto w-100">
                                                <input
                                                    disabled
                                                    type="radio"
                                                    id="oneChoice-{{ $option->id }}"
                                                    name="oneChoice-{{ $question->id }}"
                                                    value="{{ $option->id }}"
                                                    @foreach($enrollment->EnrollmentAnswers as $enrollment_answer)
                                                        @if($enrollment_answer->answers == $option->id) checked @endif
                                                    @endforeach
                                                >
                                                <label for="oneChoice-{{ $option->id }}">
                                                    {{ $option->option_text }}
                                                </label>
                                            </div>
                                        @else
                                            <!-- textarea -->
                                            <div class="icheck-primary d-block mx-auto">
                                                <label for="fillInBlank-{{ $question->id }}">Fill in the blank</label>
                                                <input
                                                    disabled
                                                    type="text"
                                                    id="fillInBlank-{{ $question->id }}"
                                                    name="fillInBlank-{{ $question->id }}"
                                                    class="form-control {{ $isCorrect ? 'is-valid ' : 'is-invalid fst-italic' }}"
                                                    value="{{ $answers }}"
                                                >
                                                @error("fillInBlank-$question->id")
                                                <p class="text-danger"><i>{{ $message }}</i></p>
                                                @enderror
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($isUnanswered)
                                        <div class="d-block text text-warning">
                                            <i class="fa fa-question"></i>
                                            Unanswered
                                        </div>
                                    @else
                                        <div class="d-block text {{ $isCorrect ? 'text-success' : 'text-danger' }}"">
                                            @if($isCorrect)
                                                <i class="fa fa-check"></i>
                                                Correct
                                            @else
                                                <i class="fa fa-times"></i>
                                                Incorrect
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 text-center mt-5">
                    <a href="/my-result" class="btn btn-primary float-right"><i
                            class="fa fa-history" aria-hidden="true"></i>
                        See my history result
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Exam Result End -->

@endsection
@section("after_js")
    <!-- DataTables  & Plugins -->
    <script src="js/admin-js/plugins/jquery.dataTables.min.js"></script>
    <script src="js/admin-js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(function () {
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
