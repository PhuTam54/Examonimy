@extends("layouts.app")
@section("title", "Examonimy | Exam Taking")
@section("main")
{{--Main Section Start--}}
<section class="content">
    <div class="container-fluid">
        <form action="/exam-taking" method="post" id="exam-form">
            @csrf
            <!-- Exam Taking Start -->
            <input type="hidden" value="{{ $examination->id }}" name="examId">
            <div class="container-xxl py-5">
                <h4 class="text-center text-danger">{{ session('errors') }}</h4>
                <div class="container-fluid">
                    {{-- Header start --}}
                    <a href="exam-info/{{ $examination->id }}" class="btn btn-outline-primary position-fixed"
                       style="margin-left: -100px;">
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
                                    <th>Created_by</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $examination->exam_name }}</td>
                                    <td>
                                        <label for="duration" class="d-none">Duration</label>
                                        <input id="duration" class="d-none" name="duration">
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

                        {{-- pagination Start--}}
                        <div class="row mb-3">
                            <div class="col-md-8 mx-auto">
                                <div class="text-center">
                                     <h6 class="section-title bg-white text-center text-primary px-3 d-flex justify-content-center">
{{--                                         {!! $questions->links("pagination::bootstrap-4") !!}--}}
                                         @foreach($questions as $index => $question)
                                             @if($questions->count() < 20)
                                                 <div class="icheck-primary w-100 question-container" data-index="{{ $index }}" style="position: relative;">
                                                     <input
                                                         name="question-checkbox-{{ $question->id }}"
                                                         value="{{ $question->id }}"
                                                         @if(old("question") == "$question->id" || $index == 0) checked @endif
                                                         type="checkbox"
                                                         id="question-{{ $question->id }}"
                                                         class="w-100 question-checkbox"
                                                         style="position: absolute; top: 0; left: 0;"
                                                     >
                                                     <label for="question-{{ $question->id }}"></label>
                                                     <p class="number"
                                                        style="position: absolute; top: 1px; left: 11px; pointer-events: none; user-select: none;"
                                                     >
                                                         {{ $question->question_no }}
                                                     </p>
                                                 </div>
                                             @elseif($index < 20)
                                                 <div class="icheck-primary w-100 question-container" data-index="{{ $index }}" style="position: relative;">
                                                     <input
                                                         name="question-checkbox-{{ $question->id }}"
                                                         value="{{ $question->id }}"
                                                         @if(old("question") == "$question->id" || $index == 0) checked @endif
                                                         type="checkbox"
                                                         id="question-{{ $question->id }}"
                                                         class="w-100 question-checkbox"
                                                         style="position: absolute; top: 0; left: 0;"
                                                     >
                                                     <label for="question-{{ $question->id }}"></label>
                                                     <p class="number"
                                                        style="position: absolute; top: 1px; left: 6px; pointer-events: none; user-select: none;"
                                                     >
                                                         {{ $question->question_no }}
                                                     </p>
                                                 </div>
                                             @elseif($index === 20)
                                                 <div class="icheck-primary w-100 question-container show-more-container" data-index="{{ $index }}" style="position: relative;">
                                                     <input
                                                         type="checkbox"
                                                         id="show-more-checkbox"
                                                         class="w-100 question-checkbox"
                                                         style="position: absolute; top: 0; left: 0;"
                                                     >
                                                     <label for="show-more-checkbox"></label>
                                                     <p class="show-more"
                                                        style="position: absolute; top: 1px; left: 8px;cursor: pointer;"
                                                        onclick="showMoreQuestions()"
                                                     >
                                                         ...
                                                     </p>
                                                 </div>
                                             @endif
                                         @endforeach
                                     </h6>
                                    @if($questions->count() > 20)
                                        <h6 class="section-title bg-white text-center text-primary px-3 d-flex justify-content-center">
                                            {{--                                         {!! $questions->links("pagination::bootstrap-4") !!}--}}
                                            @foreach($questions as $index => $question)
                                                @if($index >= 20 && $index < 40)
                                                    <div class="icheck-primary w-100 question-container" data-index="{{ $index }}" style="position: relative;">
                                                        <input
                                                            name="question-checkbox-{{ $question->id }}"
                                                            value="{{ $question->id }}"
                                                            @if(old("question") == "$question->id" || $index == 0) checked @endif
                                                            type="checkbox"
                                                            id="question-{{ $question->id }}"
                                                            class="w-100 question-checkbox"
                                                            style="position: absolute; top: 0; left: 0;"
                                                        >
                                                        <label for="question-{{ $question->id }}"></label>
                                                        <p class="number"
                                                           style="position: absolute; top: 1px; left: 6px; pointer-events: none; user-select: none;"
                                                        >
                                                            {{ $question->question_no }}
                                                        </p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </h6>
                                    @endif
                                    @if($questions->count() > 40)
                                        <h6 class="section-title bg-white text-center text-primary px-3 d-flex justify-content-center">
                                            {{--                                         {!! $questions->links("pagination::bootstrap-4") !!}--}}
                                            @foreach($questions as $index => $question)
                                                @if($index >= 40 && $index < 60)
                                                    <div class="icheck-primary w-100 question-container" data-index="{{ $index }}" style="position: relative;">
                                                        <input
                                                            name="question-checkbox-{{ $question->id }}"
                                                            value="{{ $question->id }}"
                                                            @if(old("question") == "$question->id" || $index == 0) checked @endif
                                                            type="checkbox"
                                                            id="question-{{ $question->id }}"
                                                            class="w-100 question-checkbox"
                                                            style="position: absolute; top: 0; left: 0;"
                                                        >
                                                        <label for="question-{{ $question->id }}"></label>
                                                        <p class="number"
                                                           style="position: absolute; top: 1px; left: 6px; pointer-events: none; user-select: none;"
                                                        >
                                                            {{ $question->question_no }}
                                                        </p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </h6>
                                    @endif
                                    @if($questions->count() > 60)
                                        <h6 class="section-title bg-white text-center text-primary px-3 d-flex justify-content-center">
                                            {{--                                         {!! $questions->links("pagination::bootstrap-4") !!}--}}
                                            @foreach($questions as $index => $question)
                                                @if($index >= 60 && $index < 80)
                                                    <div class="icheck-primary w-100 question-container" data-index="{{ $index }}" style="position: relative;">
                                                        <input
                                                            name="question-checkbox-{{ $question->id }}"
                                                            value="{{ $question->id }}"
                                                            @if(old("question") == "$question->id" || $index == 0) checked @endif
                                                            type="checkbox"
                                                            id="question-{{ $question->id }}"
                                                            class="w-100 question-checkbox"
                                                            style="position: absolute; top: 0; left: 0;"
                                                        >
                                                        <label for="question-{{ $question->id }}"></label>
                                                        <p class="number"
                                                           style="position: absolute; top: 1px; left: 6px; pointer-events: none; user-select: none;"
                                                        >
                                                            {{ $question->question_no }}
                                                        </p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </h6>
                                    @endif
                                    @if($questions->count() > 80)
                                        <h6 class="section-title bg-white text-center text-primary px-3 d-flex justify-content-center">
                                            {{--                                         {!! $questions->links("pagination::bootstrap-4") !!}--}}
                                            @foreach($questions as $index => $question)
                                                @if($index >= 80)
                                                    <div class="icheck-primary w-100 question-container" data-index="{{ $index }}" style="position: relative;">
                                                        <input
                                                            name="question-checkbox-{{ $question->id }}"
                                                            value="{{ $question->id }}"
                                                            @if(old("question") == "$question->id" || $index == 0) checked @endif
                                                            type="checkbox"
                                                            id="question-{{ $question->id }}"
                                                            class="w-100 question-checkbox"
                                                            style="position: absolute; top: 0; left: 0;"
                                                        >
                                                        <label for="question-{{ $question->id }}"></label>
                                                        <p class="number"
                                                           style="position: absolute; top: 1px; left: 6px; pointer-events: none; user-select: none;"
                                                        >
                                                            {{ $question->question_no }}
                                                        </p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- pagination End--}}

                        {{-- Questions Start --}}
                        @foreach($questions as $index=> $question)
                        <div class="question {{ $index == 0 ? 'd-flex' : 'd-none'}}" data-question="{{ $question->id }}">
                            <div class="col-md-6">
                                <div class="card card-success">
    {{--                                        <div class="card-header">--}}
    {{--                                            <h4 class="card-title">Question</h4>--}}
    {{--                                        </div>--}}
                                    <div class="card-body">
                                        @if($question->question_paragraph != null && $question->question_paragraph !=' ')
                                            <div class="text text-secondary">Part {{ $question->id }}: {{ $question->question_paragraph }}</div><br>
                                        @endif
                                        <h6>
                                            Question {{ $question->question_no }}: {{ $question->question_text }}
                                            @if(strlen($question->question_text) > 70 && strlen($question->question_text) < 120)
                                                <br><br><br><br><br>
                                            @elseif(strlen($question->question_text) > 20 && strlen($question->question_text) < 120)
                                                <br><br><br>
                                            @endif
                                        </h6>
                                        @if($question->question_image != null)
                                            <img src="{{ asset("storage/file/images/exam/1.".$question->question_image.".jpg") }}" width="250" alt="img">
                                        @endif
                                        @if($question->question_audio != null)
                                            <audio controls>
                                                <source src="{{ asset('storage/file/audio/exam/1.'.$question->question_audio.'.mp3') }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                        <!-- Options -->
                            <div class="card card-success">
                                <div class="card-body">
                                    <div class="form-group clearfix">
                                    @foreach($question->QuestionOptions as $option)
                                        @if($question->type_of_question == 1)
                                            <!-- checkbox -->
                                            <div class="icheck-primary d-block mx-auto w-100">
                                                <input
                                                    name="multipleChoice-{{ $option->id }}"
                                                    value="{{ $option->id }}"
                                                    @if(old("multipleChoice-$option->id") == "$option->id") checked @endif
                                                    type="checkbox"
                                                    id="multipleChoice-{{ $option->id }}"
                                                    class="w-100 option-checkbox"
                                                >
                                                <label for="multipleChoice-{{ $option->id }}">
                                                    {{ $option->option_text }}
                                                    - {!! $option->getIsCorrect() !!}
                                                </label>
                                            </div>
                                        @elseif($question->type_of_question == 2)
                                            <!-- radio -->
                                            <div class="icheck-primary d-block mx-auto w-100">
                                                <input
                                                    type="radio"
                                                    id="oneChoice-{{ $option->id }}"
                                                    @if(old("oneChoice-$question->id") == "$option->id") checked @endif
                                                    name="oneChoice-{{ $question->id }}"
                                                    value="{{ $option->id }}"
                                                    class="option-radio"
                                                >
                                                <label for="oneChoice-{{ $option->id }}">
                                                    {{ $option->option_text }}
                                                    - {!! $option->getIsCorrect() !!}
                                                </label>
                                            </div>
                                        @else
                                            <!-- textarea -->
                                            <div class="icheck-primary d-block mx-auto">
                                                <label for="fillInBlank-{{ $question->id }}">Fill in the blank</label>
                                                <input
                                                    type="text"
                                                    id="fillInBlank-{{ $question->id }}"
                                                    class="form-control option-text"
                                                    name="fillInBlank-{{ $question->id }}"
{{--                                                    value="{{ $option->option_text }}"--}}
                                                >
                                                @error("fillInBlank-$question->id")
                                                <p class="text-danger"><i>{{ $message }}</i></p>
                                                @enderror
                                            </div>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        @endforeach
                        {{-- Question End--}}

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </div>
            <!-- Exam Taking End -->

            {{--  Submit Start  --}}
            <div class="row">
                <div class="col-12 text-center">
                    <button onclick="return confirm('Are you sure that you want to submit??? You still have time.')" type="submit" class="submit btn btn-primary"><i
                            class="fa fa-check " aria-hidden="true"></i>
                        Submit
                    </button>
                </div>
            </div>
            {{--  Submit End  --}}
        </form>
    </div>
    {{--  /.container-fluid  --}}
</section>
{{--Main Section End--}}
@endsection
@section("after_js")
    @include('components.embedded.exam-taking-script')
@endsection
