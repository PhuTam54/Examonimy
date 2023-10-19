@extends("layouts.app")
@section("title", "Examonimy | My Result")
@section("main")
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">My Result</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Exams</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">My Result</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    @if($exam_results != null)
        <!-- My Result Start -->
        <div class="container-xxl py-5">
            <div class="container-fluid">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                    <h2 class="mb-1">My Result</h2>
                </div>
                <div class="row g-0 justify-content-center">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Exam</th>
                                <th>Subject</th>
{{--                                <th>Result</th>--}}
{{--                                <th>Correct</th>--}}
{{--                                <th>Incorrect</th>--}}
                                <th>Duration</th>
                                <th>Score</th>
                                <th>Rank</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <p class="mb-1">{{ $enrollment->Exam->exam_name }}</p>
                                        <img class="image mt-2" src=" {{ $enrollment->Exam->exam_thumbnail }}" width="100" alt="img">
                                    </td>
                                    <td>
                                        <p class="mb-1">{{ $enrollment->Exam->Subject->subject_name }}</p>
{{--                                        <img class="image mt-2" src=" {{ $enrollment->Exam->Subject->subject_thumbnail }}" width="100" alt="img">--}}
                                    </td>
{{--                                    <td class="text-secondary">{{ $correct_counter }} / {{ $enrollment->Enrollment->Exam->Questions->count() }}</td>--}}
{{--                                    <td class="text-success">{{ $correct_counter }}</td>--}}
{{--                                    <td class="text-danger">{{ $incorrect_counter }}</td>--}}
                                    <td>{{ $enrollment->ExamResult->time_taken }} seconds</td>
                                    <span class="d-none">
                                        @foreach ($enrollment->Exam->Questions as $question)
                                            {{ $total_score += $question->question_mark }}
                                        @endforeach
                                    </span>
                                    <td class="text-primary">{{ number_format($enrollment->ExamResult->score, 2) }} / {{  number_format($total_score, 2) }}</td>
                                    <span class="d-none">
                                        {{ $total_score = 0 }}
                                    </span>
                                    <td>
                                        {!! $enrollment->ExamResult->getStatus() !!}
                                    </td>
                                    <td>
                                        <a href="my-result-details/{{ $enrollment->ExamResult->id }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                            Details
                                        </a>
                                        <a class="btn">
                                            <form action="exam-retaken/{{ $enrollment->Exam->id }}" method="get">
{{--                                                @csrf--}}
{{--                                                @method("DELETE")--}}
                                                <button onclick="return confirm('Are you sure to retaken this exam???')" class="btn btn-danger btn-sm" type="submit">
                                                    <i class="fas fa-history"></i>
                                                    Retaken
                                                </button>
                                            </form>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center wow fadeInUp" data-wow-delay="0s">
                        <h6 class="section-title bg-white text-center text-primary px-3">
                            {!! $enrollments->links("pagination::bootstrap-4") !!}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- My Result End -->
    @else
    <!-- 404 Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                    <h1 class="display-1">404</h1>
                    <p class="mb-4">We’re sorry, the page you have looked for does not exist in our website! Maybe go to our home page or try to use a search?</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="">Go Back To Home</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 End -->
    @endif
@endsection
