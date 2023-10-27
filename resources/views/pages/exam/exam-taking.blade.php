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
                    </div> <br><br>
                    <div class="row justify-content-center">
                        {{-- Questions--}}
                        <div class="col-md-8 g-0">
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
                                                <!-- checkbox -->
                                                <div class="icheck-primary d-block mx-auto w-100">
                                                    <input
                                                        name="multipleChoice-{{ $option->id }}"
                                                        value="{{ $option->id }}"
                                                        @if(old("multipleChoice-$option->id") == "$option->id") checked @endif
                                                        type="checkbox"
                                                        id="multipleChoice-{{ $option->id }}"
                                                        class="w-100"
                                                    >
                                                    <label for="multipleChoice-{{ $option->id }}">
                                                        {{ $option->option_text }} - {!! $option->getIsCorrect() !!}
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
                                                    >
                                                    <label for="oneChoice-{{ $option->id }}">
                                                        {{ $option->option_text }} - {!! $option->getIsCorrect() !!}
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
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-success position-fixed w-auto">
                                <div class="card-header">
                                    <h4 class="card-title text-center">
                                        <label for="duration">Duration</label>
                                        <input id="duration" type="hidden" name="duration">
                                        <span id="countdown" class="text-primary text-center fs-5"></span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body row g-2">
                                    @foreach($questions as $question)
                                        <div class="col-md-3">
                                            <h6>{{ $question->question_no }}</h6>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                                <div class="card-header">
                                    <h4 class="card-title text-center">
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
                                                <a onclick="return confirm('Are you sure to cancel {{ $examination->exam_name }}???')" href="exam-info/{{ $examination->id }}" class="btn btn-danger float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                </a>
                                            </div>
                                        </div>
                                        {{--  Submit End  --}}
                                    </h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Exam Taking End -->
        </form>
    </div>
</section>
{{--Main Section End--}}

@endsection
@section("after_js")
    <script>
        let time = {{ $examination->ExamQuestion->duration }};
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
