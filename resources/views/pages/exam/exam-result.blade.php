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
                <table id="example1" class="table table-bordered table-striped">
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
                        <td class="text-secondary">{{ $correct_counter }} / {{ $examination->Questions->count() }}</td>
                        <td class="text-success">{{ $correct_counter }}</td>
                        <td class="text-danger">{{ $incorrect_counter }}</td>
                        <td>{{ $exam_result->time_taken }} seconds</td>
                        <td class="text-primary">{{ number_format($exam_result->score, 2) }} / {{  number_format($total_score, 2) }}</td>
                        <td>
                            {!! $exam_result->getStatus() !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 text-center">
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
