@extends("layouts.admin")
@section("title", "Admin | Attendances Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.attendance.content_header")
        <!-- /.content-header -->
        @if(session()->has("confirm-success"))
            <div class="alert alert-success" role="alert">
                {{ session("confirm-success") }}
            </div>
        @elseif(session()->has("edit-success"))
            <div class="alert alert-info" role="alert">
                {{ session("edit-success") }}
            </div>
        @elseif(session()->has("cancel-success"))
            <div class="alert alert-danger" role="alert">
                {{ session("cancel-success") }}
            </div>
        @elseif ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Lesson_Attendance</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $attendance->User->name }}</td>
                                    <td>{{ $attendance->Subject->subject_name }}</td>
                                    <td>{{ $attendance->Class->class_name }}</td>
                                    <td>{{ $attendance->lesson_attendance }}</td>
                                    <td class="project-actions text-center">
                                    @if($attendance->lesson_attendance == 0)
                                        <a href="admin/attendance-confirm/{{ $attendance->id }}" class="btn btn-primary"><i
                                                class="fa fa-check" aria-hidden="true"></i>
                                            Confirm
                                        </a>
                                        <a href="admin/attendance-cancel/{{ $attendance->id }}" class="btn btn-danger"
                                                style="margin-right: 5px;">
                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                        </a>
                                        @break
                                    @elseif($attendance->lesson_attendance < 10)
                                        <a href="admin/attendance-cancel/{{ $attendance->id }}" class="btn btn-danger"
                                                style="margin-right: 5px;">
                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                        </a>
                                        @break
                                    @else
                                        <div class="text text-success">Done!</div>
                                        @break
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Lesson_Attendance</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
    @include("components.admin.embedded.table_script")
@endsection
