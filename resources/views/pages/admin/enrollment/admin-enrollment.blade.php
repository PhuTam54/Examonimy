@extends("layouts.admin")
@section("title", "Admin | Enrollments Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.enrollment.content_header")
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
                                    <th>Exam</th>
                                    <th>Attempt</th>
                                    <th>Is_paid</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($enrollments as $enrollment)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $enrollment->User->name }}</td>
                                    @if($enrollment->Exam != null)
                                        <td>{{ $enrollment->Exam->exam_name }}</td>
                                    @else
                                        <td>...</td>
                                    @endif
                                    <td>{{ $enrollment->attempt > 1 ? $enrollment->attempt.' times' : $enrollment->attempt.' time' }}</td>
                                    <td>{{ $enrollment->is_paid ? 'Paid' : '...' }}</td>
                                    <td>{!! $enrollment->getStatus() !!}</td>
                                    <td class="project-actions text-center">
                                    @switch($enrollment->status)
                                        @case(\App\Models\Enrollment::PENDING)
                                            <a href="admin/enrollment-confirm/{{ $enrollment->id }}" class="btn btn-success btn-sm"><i
                                                    class="fa fa-check" aria-hidden="true"></i>
                                                Confirm
                                            </a>
                                            <a href="admin/enrollment-cancel/{{ $enrollment->id }}" class="btn btn-danger btn-sm"
                                                    style="margin-right: 5px;">
                                                <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                            </a>
                                            @break

                                        @case(\App\Models\Enrollment::CONFIRMED)
                                            <a href="admin/enrollment-cancel/{{ $enrollment->id }}" class="btn btn-danger btn-sm"
                                                    style="margin-right: 5px;">
                                                <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                            </a>
                                            @break
                                        @case(\App\Models\Enrollment::COMPLETED)
                                        @case(\App\Models\Enrollment::NOT_TAKEN)
                                        @case(\App\Models\Enrollment::CANCELED)
                                        @case(\App\Models\Enrollment::RETAKEN)
                                            <div class="text text-success">Done!</div>
                                            @break
                                    @endswitch
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Student</th>
                                    <th>Exam</th>
                                    <th>Attempt</th>
                                    <th>Is_paid</th>
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
