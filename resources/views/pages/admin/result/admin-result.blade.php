@extends("layouts.admin")
@section("title", "Admin | Results Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.result.content_header")
        <!-- /.content-header -->
        @if(session()->has("add-success"))
            <div class="alert alert-success" role="alert">
                {{ session("add-success") }}
            </div>
        @elseif(session()->has("edit-success"))
            <div class="alert alert-info" role="alert">
                {{ session("edit-success") }}
            </div>
        @elseif(session()->has("delete-success"))
            <div class="alert alert-danger" role="alert">
                {{ session("delete-success") }}
            </div>
        @endif
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
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
                                        <th>Date_Submit</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($results as $result)
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
                                            <td>{{ $result->created_at }}</td>
                                            <td>{!! $result->getStatus() !!}</td>
                                            <td>
                                                @if($result->status == \App\Models\EnrollmentResult::PENDING)
                                                    <a href="admin/result-approve/{{ $result->id }}" class="btn btn-success btn-sm">
                                                        <i class="fa fa-check"></i>
                                                        Approve
                                                    </a>
                                                    <a href="admin/result-decline/{{ $result->id }}" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-times"></i>
                                                        Decline
                                                    </a>
                                                @else
                                                    <div class="text text-success text-center">Done!</div>
                                                @endif
                                            </td>
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
                                        <th>Date_Submit</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
    @include("components.admin.embedded.table_script")
@endsection
