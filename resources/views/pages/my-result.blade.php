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
    @if(session()->has('exam-submit-success'))
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
                        <p class="text-info text-center">
                            Correct:
                            @foreach($questions as $question)
                                <span class="d-none">
                                @if($question->checkRadioExact())
                                        {{ $correct_counter += 1 }}
                                    @endif
                            </span>
                            @endforeach
                            <span class="text-center text-success">
                            {{ $correct_counter }}
                        </span>
                            Incorrect:
                            @foreach($questions as $question)
                                <span class="d-none">
                                @unless($question->checkRadioExact())
                                        {{ $incorrect_counter += 1 }}
                                    @endunless
                            </span>
                            @endforeach
                            <span class="text-center text-danger">
                            {{ $incorrect_counter }}
                        </span>
                            Score: {{ number_format($correct_counter / $questions->count(), 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Exam Result End -->

    @else
    <!-- My Result Start -->
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
    <!-- My Result End -->
    @endif
@endsection
