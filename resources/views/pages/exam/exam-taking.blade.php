@extends("layouts.app")
@section("title", "Examonimy | Exam Taking")
@section("main")

{{--Main Section Start--}}
<section class="content">
    <div class="container-fluid">
        <form action="exam-taking/{{ $examination->id }}" method="post" id="exam-form">
            @csrf

            <!-- Exam Taking Start -->
            <div class="container-xxl py-5">
                <h4 class="text-center text-danger">{{ session('errors') }}</h4>
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
{{--                                    <td>{{ $examination->duration }} seconds</td>--}}
                                    <td>
                                        <label for="duration" class="d-none">Duration</label>
                                        <input id="duration" class="d-none" name="duration">
                                        <span id="countdown" class="text-primary text-center fs-5"></span>
                                    </td>
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
                                            @if(strlen($question->question_text) < 155) <br><br>@endif
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
                                                <label for="fillInBlank-{{ $question->id }}">Fill in the blank</label>
                                                <input
                                                    type="text"
                                                    id="fillInBlank-{{ $question->id }}"
                                                    class="form-control"
                                                    name="fillInBlank-{{ $question->id }}"
                                                    value="{{ $option->option_text }}"
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

@endsection
@section("after_js")
    <script>
        // const startingMinutes = 40;
        let time = {{ $examination->duration }};
        // let time = 10;

        const countdownEl = document.getElementById('countdown');
        const durationEl = document.getElementById('duration');
        const examForm = document.getElementById('exam-form');

        const intervalId = setInterval(updateCountdown, 1000);

        function updateCountdown() {
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor((time % 3600) / 60);
            let seconds = time % 60;

            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            countdownEl.innerHTML = hours < 1 ? `${minutes}:${seconds} time left` : `${hours}:${minutes}:${seconds} time left`;
            time--;
            durationEl.value = time;

            if (time === 300) {
                alert("You only have 5 minutes left.")
            }
            if (time === 0) {
                alert("Your exam has been auto submitted.")
                clearInterval(intervalId);
                examForm.submit();
            }
        }
    </script>
@endsection
