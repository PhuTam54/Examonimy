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
                            @foreach($exam_results as $exam_result)
                                <tr>
                                    <td>
                                        <p class="mb-1">{{ $exam_result->Enrollment->Exam->exam_name }}</p>
                                        <img class="image mt-2" src=" {{ $exam_result->Enrollment->Exam->exam_thumbnail }}" width="100" alt="img">
                                    </td>
{{--                                    <td class="text-secondary">{{ $correct_counter }} / {{ $exam_result->Enrollment->Exam->Questions->count() }}</td>--}}
{{--                                    <td class="text-success">{{ $correct_counter }}</td>--}}
{{--                                    <td class="text-danger">{{ $incorrect_counter }}</td>--}}
                                    <td>{{ $exam_result->time_taken }} seconds</td>
                                    <td class="text-primary">{{ number_format($exam_result->score, 2) }} / {{  number_format($exam_result->score, 2) }}</td>
                                    <td>
                                        {!! $exam_result->getStatus() !!}
                                    </td>
                                    <td>
                                        <a href="my-result-details/{{ $exam_result->id }}" class="btn btn-info">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center wow fadeInUp" data-wow-delay="0s">
                        <h6 class="section-title bg-white text-center text-primary px-3">
                            {!! $exam_results->links("pagination::bootstrap-4") !!}
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
