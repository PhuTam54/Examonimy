@extends("layouts.app")
@section("title", "Examonimy | My Result")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
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

    @if($enrollment_results != null)
        <!-- My Result Start -->
        <div class="container-xxl py-5">
            <div class="container-fluid">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                    <h2 class="mb-1">My Result</h2>
                    @if(session()->has('retaken'))
                        <h3 class="bg-white text-center text-primary px-3">
                            {{ session('retaken') }}
                        </h3>
                    @endif
                </div>
                <div class="row g-0 justify-content-center">
                    <div class="card-body">
                        <table id="example2" class="table table-bordered border table-striped">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Time_taken</th>
                                <th>Score</th>
                                <th>Rank</th>
                                <th>Attempt</th>
                                <th>Submitted</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($enrollments as $enrollment)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <p class="mb-1">{{ $enrollment->Exam->exam_name }}</p>
                                        <img class="image mt-2" src=" {{ $enrollment->Exam->exam_thumbnail }}" width="100" alt="img">
                                    </td>
                                    <td>
                                        <p class="mb-1">{{ $enrollment->Exam->Subject->subject_name }}</p>
                                        <img class="image mt-2" src=" {{ $enrollment->Exam->Subject->subject_thumbnail }}" width="100" alt="img">
                                    </td>
                                    @if($enrollment->EnrollmentResult->time_taken / 3600 > 1)
                                        <td>
                                            {{ floor($enrollment->EnrollmentResult->time_taken / 3600) }} hours
                                            {{ floor($enrollment->EnrollmentResult->time_taken % 3600 / 60) }} minutes
                                            {{ $enrollment->EnrollmentResult->time_taken % 60 }} seconds
                                        </td>
                                    @elseif(($enrollment->EnrollmentResult->time_taken % 3600) / 60 > 1)
                                        <td>
                                            {{ floor($enrollment->EnrollmentResult->time_taken % 3600 / 60) }} minutes
                                            {{ $enrollment->EnrollmentResult->time_taken % 60 }} seconds
                                        </td>
                                    @else
                                        <td>
                                            {{ $enrollment->EnrollmentResult->time_taken % 60 }} seconds
                                        </td>
                                    @endif
                                    <span class="d-none">
                                        @foreach ($enrollment->Exam->ExamQuestion->Questions as $question)
                                            {{ $total_score += $question->question_mark }}
                                        @endforeach
                                    </span>
                                    <td class="text-primary">{{ number_format($enrollment->EnrollmentResult->score, 2) }} / {{  number_format($total_score, 2) }}</td>
                                    <span class="d-none">
                                        {{ $total_score = 0 }}
                                    </span>
                                    <td>
                                        {!! $enrollment->EnrollmentResult->getStatus() !!}
                                    </td>
                                    <td>{{ $enrollment->attempt }} {{ $enrollment->attempt > 1 ? 'times' : 'time' }}</td>
                                    <td>{{ $enrollment->updated_at }}</td>
                                    <td>
                                        <a class="btn" href="exam-retaken/{{ $enrollment->Exam->id }}">
                                            <form action="exam-retaken/{{ $enrollment->Exam->id }}" method="get">
                                                <button onclick="return confirm('Are you sure to retaken {{ $enrollment->Exam->exam_name }}???')" class="btn btn-danger btn-sm" type="submit">
                                                    <i class="fas fa-history"></i>
                                                    Retaken
                                                </button>
                                            </form>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <th>No.</th>
                                <th>Exam</th>
                                <th>Subject</th><th>Duration</th>
                                <th>Score</th>
                                <th>Rank</th>
                                <th>Attempt</th>
                                <th>Submitted</th>
                                <th>Action</th>
                            </tfoot>
                        </table>
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
@section("after_js")
    @include("components.admin.embedded.table_script")
@endsection
