@extends("layouts.app")
@section("title", "Examonimy | Exam Taking")
@section("main")
{{--Main Section Start--}}
<section class="content">
    <div class="container-fluid">
        <form action="/exam-taking" method="post" id="exam-form">
            @csrf
            <!-- Exam Taking Start -->
            <input type="hidden" value="{{ $examination->entrance_id }}" name="entrance_id">
            <div class="container-xxl py-5">
                <h4 class="text-center text-danger">{{ session('errors') }}</h4>
                <div class="container-fluid">
                    {{-- Header start --}}
                    <a href="exam-info/{{ $examination->entrance_id }}" class="btn btn-outline-primary position-fixed"
                       style="margin-left: -100px; margin-top: -40px">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                        <h2 class="mb-1">Exam Taking</h2>
                    </div>
                    {{-- Header end --}}

                    <div class="row g-0 justify-content-center">
                        {{-- Table start--}}
                        <div class="card-body d-flex">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Duration</th>
                                    <th>Subject</th>
                                    <th>Created by</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $examination->exam_name }}</td>
                                    <td>
                                        <input id="duration" type="hidden" name="duration">
                                        <span id="countdown" class="text-primary text-center fs-5"></span>
                                    </td>
                                    <td>{{ $examination->Subject->subject_name }}</td>
                                    <td>{{ $examination->Instructor->name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{-- Table End--}}

                        {{-- Main start--}}
                        <div class="row justify-content-center">
                            {{-- Questions Start --}}
                            @php
                                $question_counter = 1;
                                $part_counter = 1;
                            @endphp
                            @foreach($questions as $index => $question)
                            <div
                                class="question {{ $index == 0 ? 'd-flex' : 'd-none'}} col-md-8 wow fadeIn" data-wow-delay="0.1s"
                                data-question="{{ $index }}"
                            >
                                <div class="card card-success">
                                    <div class="card-body">
                                        @if($question->question_paragraph != null && $question->question_paragraph !=' ')
                                            <div class="text text-secondary">Part {{ $part_counter ++ }}: {{ $question->question_paragraph }}</div><br>
                                        @endif
                                        <h6 style="min-width: 774px">
                                            Question {{ $question_counter ++ }}: {{ $question->question_text }}
{{--                                            @if(strlen($question->question_text) > 70 && strlen($question->question_text) < 120)--}}
{{--                                                <br><br><br><br><br>--}}
{{--                                            @elseif(strlen($question->question_text) > 20 && strlen($question->question_text) < 120)--}}
{{--                                                <br><br><br>--}}
{{--                                            @endif--}}
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
                                                                data-option="{{ $index }}"
                                                                name="multipleChoice-{{ $option->id }}"
                                                                value="{{ $option->id }}"
                                                                @if(old("multipleChoice-$option->id") == "$option->id") checked @endif
                                                                type="checkbox"
                                                                id="multipleChoice-{{ $option->id }}"
                                                                class="w-100 option-checkbox"
                                                            >
                                                            <label for="multipleChoice-{{ $option->id }}">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                    @elseif($question->type_of_question == 2)
                                                        <!-- radio -->
                                                        <div class="icheck-primary d-block mx-auto w-100">
                                                            <input
                                                                data-option="{{ $index }}"
                                                                type="radio"
                                                                id="oneChoice-{{ $option->id }}"
                                                                @if(old("oneChoice-$question->id") == "$option->id") checked @endif
                                                                name="oneChoice-{{ $question->id }}"
                                                                value="{{ $option->id }}"
                                                                class="option-radio"
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
                                                                data-option="{{ $index }}"
                                                                type="text"
                                                                id="fillInBlank-{{ $question->id }}"
                                                                class="form-control option-text"
                                                                name="fillInBlank-{{ $question->id }}"
                                                            >
                                                            @error("fillInBlank-$question->id")
                                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        <!-- End Options -->

                                        <!-- Buttons -->
                                        <div class="mt-4" style="margin-bottom: -10px">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination d-flex justify-content-between">
                                                    <li class="page-item"><a class="page-link prev-btn {{ $index == 0 ? 'd-none' : 'd-block'}}">Previous</a></li>
                                                    <li class="page-item next-btn"><a class="page-link next-btn">Next</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <!-- Buttons -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{-- Question End--}}

                            {{-- pagination Start--}}
                            @php
                                $question_counter = 1;
                            @endphp
                            <div class="col-md-4" style="border: 1px solid #f2f2f2">

                                <div class="row mb-3" style="margin-left: 15px">
                                    @foreach($questions as $index => $question)
                                        <div class="col-md-2">
                                            <div
                                                class="icheck-primary w-100 text-primary question-container"
                                                data-index="{{ $index }}"
                                                style="position: relative;"
                                            >
                                                <input
                                                    name="question-checkbox-{{ $index }}"
                                                    value="{{ $index }}"
                                                    @if(old("question") == "$index" || $index == 0) checked @endif
                                                    type="radio"
                                                    id="question-{{ $index }}"
                                                    class="w-100 question-checkbox"
                                                    data-question="{{ $index }}"
                                                    style="position: absolute; top: 0; left: 0;"
                                                >
                                                <label for="question-{{ $index }}"></label>
                                                <p class="number"
                                                   style="position: absolute; top: 0; left: {{ $index < 9 ? '6' : '2' }}px; pointer-events: none; user-select: none;"
                                                >
                                                    {{ $question_counter ++ }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{--  Submit Start  --}}
                                <div class="row">
                                    <div class="col-12 text-center submit-btn d-none wow fadeInUp" data-wow-delay="0.1s">
                                        <button onclick="return confirm('Are you sure that you want to submit??? You still have time.')" type="submit" class="submit btn btn-primary"><i
                                                class="fa fa-check " aria-hidden="true"></i>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                                {{--  Submit End  --}}
                            </div>
                            {{-- pagination End--}}
                        </div>
                        {{-- Main end--}}
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </div>
            <!-- Exam Taking End -->
        </form>
    </div>
    {{--  /.container-fluid  --}}
</section>
{{--Main Section End--}}
@endsection
@section("after_js")
    @include('components.embedded.exam-taking-script')
@endsection
