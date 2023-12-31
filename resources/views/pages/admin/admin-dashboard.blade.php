@extends("layouts.admin")
@section("title", "Admin | Dashboard")
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.dashboard.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $exams->count() }}</h3>

                                <p>Exams</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="admin/admin-exam" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $results->count() }}<sup style="font-size: 20px"></sup></h3>

                                <p>Results</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="admin/admin-result" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $users->count() }}</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $classroom->count() }}</h3>

                                <p>Classroom</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable">

                        <!-- New exams -->
                        <div class="card direct-chat direct-chat-primary">
                            <div class="card-header">
                                <a href="admin/admin-exam"><h3 class="card-title">New Exams</h3></a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="card">
                                    <!-- ./card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ExamName</th>
                                                <th>StartEnd_date</th>
                                                <th>Participants</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($newExams as $exam)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        <p>{{ $exam->exam_name }}</p>
                                                        <img src=" {{ $exam->exam_thumbnail ?? asset("storage/img/main-img/course-1.jpg") }}" width="80" alt="img">
                                                    </td>
                                                    <td>{{ $exam->start_date ?? "Never start" }} <br> => <br> {{ $exam->end_date ?? "Never end" }}</td>
                                                    <td>
                                                        <!-- Trigger the modal with a button -->
                                                        <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showPaticipantModal{{ $exam->id }}">
                                                            <i class="fa fa-eye"></i>
                                                            {{ $exam->Enrollments->count() }} to show
                                                        </a>

                                                        <!-- Modal -->
                                                        <div id="showPaticipantModal{{ $exam->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">

                                                                <!-- Modal content-->
                                                                <div class="modal-content" style="min-width: 700px; max-height: 600px">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Showing Participants</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body overflow-auto">
                                                                        <h5 class="text fs-6">Exam: {{ $exam->exam_name }}</h5>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Student's Name</th>
                                                                                <th>Class</th>
                                                                                <th>Attempt</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach($exam->Enrollments as $index => $enrollment)
                                                                                <tr>
                                                                                    <td>{{ $loop->index + 1 }}</td>
                                                                                    <td>{{ $enrollment->User->name }}</td>
                                                                                    @if($enrollment->User->Classes != null)
                                                                                        <td>{{ $enrollment->User->Classes->class_name }}</td>
                                                                                    @else
                                                                                        <td></td>
                                                                                    @endif
                                                                                    <td>{{ $enrollment->attempt > 1 ? $enrollment->attempt . " times" : $enrollment->attempt . " time"}}</td>
                                                                                    <td>{!! $enrollment->getStatus() !!}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                            <tfoot>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Student's Name</th>
                                                                                <th>Class</th>
                                                                                <th>Attempt</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{!! $exam->getStatus() !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>ExamName</th>
                                                <th>StartEnd_date</th>
                                                <th>Participants</th>
                                                <th>Status</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!--/.New exams -->

                    </section>
                    <!-- /.Left col -->
                    <!-- Right col -->
                    <section class="col-lg-6 connectedSortable">

                        <!-- New results -->
                        <div class="card direct-chat direct-chat-primary">
                            <div class="card-header">
                                <a href="admin/admin-result"><h3 class="card-title">New Results</h3></a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="card">
                                    <!-- ./card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Student</th>
                                                <th>Exam</th>
                                                <th>Score</th>
                                                <th>Time_taken</th>
                                                <th>Grade</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($newResults as $result)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $result->Enrollment->User->name }}</td>
                                                    <td>{{ $result->Enrollment->Exam->exam_name }}</td>
                                                    <td>
                                                        <div class="text-primary d-inline">
                                                            {{ number_format($result->score, 2) }}
                                                        </div> / {{  number_format($result->Enrollment->Exam->ExamQuestion->total_marks, 2) }}</td>
                                                    @if($result->time_taken / 3600 > 1)
                                                        <td>
                                                            {{ floor($result->time_taken / 3600) }} hours
                                                            {{ floor($result->time_taken % 3600 / 60) }} minutes
                                                            {{ $result->time_taken % 60 }} seconds
                                                        </td>
                                                    @elseif(($result->time_taken % 3600) / 60 > 1)
                                                        <td>
                                                            {{ floor($result->time_taken % 3600 / 60) }} minutes
                                                            {{ $result->time_taken % 60 }} seconds
                                                        </td>
                                                    @elseif($result->time_taken % 60 > 1)
                                                        <td>
                                                            {{ $result->time_taken % 60 }} seconds
                                                        </td>
                                                    @endif
                                                    <td>{!! $result->getGrade() !!}</td>
                                                    <td>{!! $result->getStatus() !!}</td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Student</th>
                                                <th>Exam</th>
                                                <th>Score</th>
                                                <th>Time_taken</th>
                                                <th>Grade</th>
                                                <th>Status</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                        <!--/.New exams -->

                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="js/admin-js/dist/js/pages/dashboard.js"></script>
@endsection
