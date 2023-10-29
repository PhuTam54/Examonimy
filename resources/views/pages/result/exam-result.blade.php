@extends("layouts.app")
@section("title", "Examonimy | Exam Result")
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
            <h2 class="mb-1">{{ session('exam-submit-success') ?? "Exam Result" }} </h2>
        </div>
        <div class="row g-0 justify-content-center">
            <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Result</th>
                        <th>Correct</th>
                        <th>Incorrect</th>
                        <th>Duration</th>
                        <th>Score</th>
                        <th>Rank</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <p class="text-center mb-1">{{ $examination->exam_name }}</p>
                            <img class="image mt-2" src=" {{ $examination->exam_thumbnail }}" width="200" alt="img">
                        </td>
                        <td class="text-secondary">{{ $enrollment_result->correct }} / {{ $examination->ExamQuestion->Questions->count() }}</td>
                        <td class="text-success">{{ $enrollment_result->correct }}</td>
                        <td class="text-danger">{{ $enrollment_result->incorrect }}</td>
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
                            {!! $enrollment_result->getStatus() !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Questions--}}
            <div class="col-md-12 g-0">
                <div class="card card-success">
                    <div class="card-header">
                        <h4 class="card-title">{{ $examination->exam_name }} - {{ $examination->Subject->subject_name }}</h4>
                    </div>
                    @foreach($questions as $question)
                        <div class="card-body">
                            <h6>Question {{ $question->question_no }}: {{ $question->question_text }}</h6>
                            <div class="d-flex">
                                <p>Mark: {{ $question->question_mark }} -</p>
                                <span>- Difficulty: {!! $question->getDifficulty() !!}</span>
                            </div>
                            <!-- Options -->
                            <div class="form-group clearfix">
                                @foreach($question->QuestionOptions as $option)
                                    @if($question->type_of_question == 1)
                                        @php
                                            $isValid = false;
                                            foreach ($enrollment->EnrollmentAnswers as $enrollment_answer) {
                                                if (str_contains($enrollment_answer->answers, $option->id) !== false) {
                                                    $isValid = true;
                                                }
                                            }
                                        @endphp
                                        <!-- checkbox -->
                                        <div class="icheck-primary d-block mx-auto w-100 {{ $isValid ? 'text-success' : '' }}">
                                            <input
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
                                                {{ $option->option_text }} - {!! $option->getIsCorrect() !!}
                                            </label>
                                        </div>
                                    @elseif($question->type_of_question == 2)
                                        @php
                                            $isValid = false;
                                            foreach ($enrollment->EnrollmentAnswers as $enrollment_answer) {
                                                if ($enrollment_answer->answers == $option->id) {
                                                    $isValid = true;
                                                }
                                            }
                                        @endphp
                                        <!-- radio -->
                                        <div class="icheck-primary d-block mx-auto w-100 {{ $isValid ? 'text-success' : '' }}">
                                            <input
                                                type="radio"
                                                id="oneChoice-{{ $option->id }}"
                                                name="oneChoice-{{ $question->id }}"
                                                value="{{ $option->id }}"
                                                @foreach($enrollment->EnrollmentAnswers as $enrollment_answer)
                                                    @if($enrollment_answer->answers == $option->id) checked @endif
                                                @endforeach
                                            >
                                            <label for="oneChoice-{{ $option->id }}">
                                                {{ $option->option_text }} - {!! $option->getIsCorrect() !!}
                                            </label>
                                        </div>
                                    @else
                                        @php
                                            $isValid = false;
                                            $answer = '';
                                            foreach ($enrollment->EnrollmentAnswers as $enrollment_answer) {
                                                if ($enrollment_answer->answers == $option->option_text) {
                                                    $isValid = true;
                                                    $answer = $enrollment_answer->answers;
                                                }
                                            }
                                        @endphp
                                        <!-- textarea -->
                                        <div class="icheck-primary d-block mx-auto {{ $isValid ? 'text-success' : 'text-danger' }}">
                                            <label for="fillInBlank-{{ $question->id }}">Fill in the blank</label>
                                            <input
                                                type="text"
                                                id="fillInBlank-{{ $question->id }}"
                                                name="fillInBlank-{{ $question->id }}"
                                                class="form-control text-white {{ $isValid ? 'is-valid bg-success' : 'is-invalid bg-danger fst-italic' }}"
                                                value="{{ $answer }} {{ $isValid ? '' : '==> '.$option->option_text }}"
                                            >
                                            @error("fillInBlank-$question->id")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    @endif
                                @endforeach
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
