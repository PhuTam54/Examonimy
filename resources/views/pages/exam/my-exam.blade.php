@extends("layouts.app")
@section("title", "Examonimy | My Exam")
@section("main")
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">My Exam</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Exams</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">My Exam</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- My Exam Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                <h1 class="mb-5">My Exam</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @if($enrollments->count() > 0)
                @foreach($enrollments as $enrollment)
                    @if($data_wow_delay > 0.5)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $data_wow_delay = 0.5 }}s">
                    @else
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $data_wow_delay += 0.2 }}s">
                    @endif
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ $enrollment->Exam->exam_thumbnail }}" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="exam-info/{{ $enrollment->Exam->id }}" class="flex-shrink-0 btn btn-md btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="exam-taking/{{ $enrollment->Exam->id }}" class="flex-shrink-0 btn btn-md btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-3">{{ $enrollment->Exam->exam_name ?? "Web Design & Development Course for Beginners"}}</h3>
                            <h5 class="mb-4">{{ $enrollment->Exam->Course->course_name ?? "Web Design & Development Course for Beginners"}}</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>{{ $enrollment->Exam->Instructor->name }}</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>{{ $enrollment->Exam->ExamQuestion->duration / 60 }} minutes</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-question text-primary me-2"></i>{{ $enrollment->Exam->ExamQuestion->Questions->count() }} Questions</small>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <h2 class="text-center text-primary wow fadeInUp" data-wow-delay="0.1s">There is no Exam</h2>
                @endif
            </div>
        </div>
    </div>
    <!-- My Exam End -->
@endsection
