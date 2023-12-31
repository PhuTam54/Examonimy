@extends("layouts.app")
@section("title", "Examonimy | Exam Information")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Exam Information</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Exams</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Exam Information</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    @if(session()->has("canceled"))
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                    <h1 class="mb-5">{{ session("canceled") }}</h1>
                    <div class="col-12 text-center">
                        <a href="/my-exam" class="btn btn-primary float-right"><i
                                class="fa fa-history" aria-hidden="true"></i>
                            See my another exam
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
    <!-- Exam Information Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Exams</h6>
                <h1 class="mb-5">Exam Information</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped" style="border: 1px solid rgba(0,0,0,0.125)">
                    <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Description</th>
                            <th>Start_date</th>
                            <th>End_date</th>
                            <th>Duration</th>
                            <th>Questions</th>
                            <th>Subject</th>
                            <th>Created_by</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p class="text-center mb-1">{{ $examination->exam_name }}</p>
                                    <img class="image mt-2" src=" {{ $examination->exam_thumbnail }}" width="100" alt="img"></td>
                                @if(strlen($examination->exam_description) > 180)
                                    <td>{{ substr($examination->exam_description, 0, 180) }}...</td>
                                @else
                                    <td>{{ $examination->exam_description }}</td>
                                @endif
                                <td>{{ $examination->start_date ?? "Never start" }}</td>
                                <td>{{ $examination->end_date ?? "Never end" }}</td>
                                @if($examination->ExamQuestion->duration / 3600 > 1)
                                    <td>
                                        {{ floor($examination->ExamQuestion->duration / 3600) }} hours
                                        {{ floor($examination->ExamQuestion->duration % 3600 / 60) }} minutes
                                    </td>
                                @elseif(($examination->ExamQuestion->duration % 3600) / 60 > 1)
                                    <td>
                                        {{ floor($examination->ExamQuestion->duration % 3600 / 60) }} minutes
                                    </td>
                                @elseif($examination->ExamQuestion->duration % 60 > 1)
                                    <td>
                                        {{ $examination->ExamQuestion->duration % 60 }} seconds
                                    </td>
                                @endif
                                <td>{{ $examination->ExamQuestion->Questions->count() }}</td>
                                <td>{{ $examination->Subject->subject_name }}</td>
                                <td>{{ $examination->Instructor->name }}</td>
                                <td class="project-actions text-center">
                                    <a class="btn {{ $examination->status == \App\Models\Exam::PROCESSING ? '' : 'disabled' }}" href="exam-taking/{{ $examination->entrance_id }}">
                                        <button class="btn btn-success btn-sm" style="margin-left: -12px" type="submit">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Taking
                                        </button>
                                    </a>
                                    <a class="btn">
                                        <form action="exam-info/{{ $examination->entrance_id }}" method="post">
                                            @csrf
                                            @method("PUT")
                                            <button onclick="return confirm('Are you sure to cancel {{$examination->exam_name}}???')" class="btn btn-danger btn-sm" style="margin-left: -12px" type="submit">
                                                <i class="fas fa-trash">
                                                </i>
                                                Cancel
                                            </button>
                                        </form>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="">
                    <h4>INSTRUCTIONS</h4>
                    <p class="text-secondary" style="margin-left: 20px">
                        1. This is an online Theory/ Programming Exam. <br>
                        2. Please make sure that you are using the latest version of the browser. We recommend using Google Chrome.<br>
                        3. It's mandatory to disable all the browser extensions and enabled Add-ons and open the test in incognito mode.<br>
                        4. For Practical Exam, you are free to choose your preferred programming language from the options that have been listed for you.<br>
                        5. Note that - All inputs are from STDIN and output to STDOUT.<br>
                        6. To understand our test environment better, or know more about other parameters like the time limits, etc, you can read our FAQs <a class="text-info">here</a>.<br>
                        7. To know the test results or figure out the next course of action, please contact your test administrator and they will guide you.<br>
                    </p>
                    <span>Best wishes from Aptech !</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Exam Information End -->
    @endif
@endsection
@section("after_js")
    <!-- DataTables  & Plugins -->
    <script src="js/admin-js/plugins/jquery.dataTables.min.js"></script>
    <script src="js/admin-js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
