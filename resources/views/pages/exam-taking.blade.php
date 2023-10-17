@extends("layouts.app")
@section("title", "Examonimy | Exam Taking")
@section("main")

@if(session()->has('exam-submit-success'))

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Exam {{ $examination->exam_name }} Result</h1>
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
            <h2 class="mb-1">Exam Result</h2>
        </div>
        <div class="row g-0 justify-content-center">
            <div class="card-body">
                <div class="text-center">
                    <p class="text-secondary text-center" style="font-size: larger">
                        Correct:
                        @foreach($questions as $item)
                            <span class="d-none">
                                @if($item->checkChoiceExact())
                                {{ $correct_counter += 1 }}
                                {{ $score_counter += $item->question_mark }}
                                @endif
                            </span>
                        @endforeach
                        <span class="text-center text-success">
                            {{ $correct_counter }}
                        </span>
                        - Incorrect:
                        <span class="text-center text-danger">
                            {{ $incorrect_counter = $questions->count() - $correct_counter }}
                        </span>
                        - Score:
                        <span class="text-center text-primary">
                            {{ number_format($score_counter, 2) }} / {{  number_format($total_score, 2) }}
                        </span> <br>
                        @if($score_counter >= ($total_score / 2))
                            <span class="text-center text-success">
                                Excellent
                            </span>
                        @elseif($score_counter > ($total_score / 3)) {
                            <span class="text-center text-info">
                                Good
                            </span>
                        @else
                            <span class="text-center text-danger">
                                Failed
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Exam Result End -->

@else

    {{--Main Section Start--}}
    <section class="content">
        <div class="container-fluid">
            <form action="exam-submit/{{ $examination->id }}" method="get">
{{--                @csrf--}}
{{--                @method('POST')--}}

                <!-- Exam Taking Start -->
                <div class="container-xxl py-5">
                    <div class="container-fluid">
                        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                            <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                            <h2 class="mb-1">Exam Taking</h2>
                        </div>
                        <div class="row g-0 justify-content-center">
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
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
                                        <td>
                                        {{ $examination->exam_name }}
                                        <td>{{ $examination->duration }} minutes</td>
                                        <td>{{ $examination->Subject->subject_name }}</td>
    {{--                                    @foreach($questions as $question)--}}
    {{--                                        @foreach($question->QuestionOptions as $option) @endforeach--}}
    {{--                                        <td>{{ $option->id }}</td>--}}
    {{--                                        <td>{!! $option->getIsCorrect() !!}</td>--}}
    {{--                                    @endforeach--}}
                                        <td>{{ $examination->Instructor->name }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
{{--                                         <h6 --}}
{{--                                             class="section-title bg-white text-center text-primary px-3"--}}
{{--                                         >{!! $questions->links("pagination::bootstrap-4") !!}</h6>--}}
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->

                            {{-- Easy Questions--}}
                            @foreach($questions as $question)
                                <div class="col-md-6">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title">Question {{ $question_counter += 1 }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <h6>{{ $question->question_text }}
                                                @if(strlen($question->question_text) < 170) <br><br>@endif
                                            </h6>
                                            <p>Mark: {{ $question->question_mark }}</p>
                                            <span>Difficulty: {!! $question->getDifficulty() !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title">Answers
{{--                                            @if($question->checkRadioExact(109))--}}
{{--                                                <span class="text-center text-success">True</span>--}}
{{--                                            @else--}}
{{--                                                    <span class="text-center text-danger">False</span>--}}
{{--                                            @endif--}}
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- Minimal style -->
                                            <div class="form-group clearfix">
                                            @foreach($question->QuestionOptions as $option)
                                                @if($question->type_of_question == 1)
                                                <!-- checkbox -->
                                                <div class="icheck-primary d-block mx-auto">
                                                    <input
                                                        name="multipleChoice-{{ $option->id }}"
                                                        value="{{ $option->id }}"
                                                        @if(old("multipleChoice-$option->id") == "$option->id") checked @endif
                                                        type="checkbox"
                                                        id="multipleChoice-{{ $option->id }}"
                                                    >
                                                    <label for="multipleChoice-{{ $option->id }}">
                                                        Option {{ $option->id }}: {{ $option->option_text }} - {!! $option->getIsCorrect() !!}
                                                    </label>
                                                </div>
                                                @elseif($question->type_of_question == 2)
                                                <!-- radio -->
                                                <div class="icheck-primary d-block">
                                                    <input
                                                        type="radio"
                                                        id="oneChoice-{{ $option->id }}"
                                                        @if(old("oneChoice-$question->id") == "$option->id") checked @endif
                                                        name="oneChoice-{{ $question->id }}"
                                                        value="{{ $option->id }}"
                                                    >
                                                    <label for="oneChoice-{{ $option->id }}">
                                                        Option {{ $option->id }}: {{ $option->option_text }} - {!! $option->getIsCorrect() !!}
                                                    </label>
                                                </div>
                                                @else
                                                <!-- textarea -->
                                                <div class="icheck-primary d-block mx-auto">
                                                    <label for="fillInBlank">Fill in the blank</label>
                                                    <textarea id="fillInBlank" class="form-control" name="fillInBlank" rows="1">Option {{ $option->id }}: {{ $option->option_text }}</textarea>
                                                    @error("fillInBlank")
                                                    <p class="text-danger"><i>{{ $message }}</i></p>
                                                    @enderror
                                                </div>
                                                @endif
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Exam Taking End -->

                {{--  Submit Start  --}}
                <div class="row">
                <div class="col-12 text-center">
                    <a href="#" rel="noopener" target="_blank" class="btn btn-outline-secondary">
                        <i class="fas fa-stop"></i> Pause
                    </a>
                    <button type="submit" class="btn btn-primary float-right"><i
                            class="fa fa-check" aria-hidden="true"></i>
                        Submit
                    </button>
                    <a href="exam-info/{{ $examination->id }}" class="btn btn-danger float-right"
                            style="margin-right: 5px;">
                        <i class="fa fa-times" aria-hidden="true"></i> Cancel
                    </a>
                </div>
                </div>
                {{--  Submit End  --}}

            </form>
        </div>
    </section>
    {{--Main Section End--}}

@endif
@endsection
