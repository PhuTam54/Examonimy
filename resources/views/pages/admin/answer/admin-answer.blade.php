@extends("layouts.admin")
@section("title", "Admin | Answers Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.answer.content_header")
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
                                    <th>Question</th>
                                    <th>Answers</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($answers as $answer)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $answer->Enrollment->User->name }}</td>
                                    <td>{{ $answer->Enrollment->Exam->exam_name }}</td>
                                    <td>{{ $answer->Question->question_text }}</td>
                                    <td>{{ $answer->answers }}</td>
                                    <td>{{ $answer->status }}</td>
                                    <td class="project-actions text-center">
                                    @switch($answer->status)
                                        @case(0)
                                            <a href="admin/answer-confirm/{{ $answer->id }}" class="btn btn-sm btn-primary" style="margin-bottom: 5px">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                Confirm
                                            </a>
                                            <a href="admin/answer-cancel/{{ $answer->id }}" class="btn btn-sm btn-danger"
                                                    style="margin-right: 5px;">
                                                <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                            </a>
                                            @break

                                        @case(1)
                                            <a href="admin/answer-cancel/{{ $answer->id }}" class="btn btn-sm btn-danger"
                                                    style="margin-right: 5px;">
                                                <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                            </a>
                                            @break
                                        @case(2)
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
                                    <th>Question</th>
                                    <th>Answers</th>
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
