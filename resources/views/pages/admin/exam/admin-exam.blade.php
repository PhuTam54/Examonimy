@extends("layouts.admin")
@section("title", "Admin | Exams Tables")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.exam.content_header")
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
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a class="btn btn-success btn-md" href="admin/exam-add">
                                        <i class="fas fa-plus">
                                        </i>
                                        Add new exam
                                    </a>
                                </h3>
                            </div>
                            <!-- ./card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Image</th>
                                        <th>Exam_Name</th>
{{--                                        <th>Start_date</th>--}}
{{--                                        <th>End_date</th>--}}
                                        <th>Duration(min)</th>
                                        <th>Questions</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th>Created_by</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($exams as $exam)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="">
                                                <img src=" {{ $exam->exam_thumbnail }}" width="100" alt="img">
                                            </td>
                                            <td>{{ $exam->exam_name }}</td>
{{--                                            <td>{{ $exam->start_date ?? "Never start" }}</td>--}}
{{--                                            <td>{{ $exam->end_date ?? "Never end" }}</td>--}}
                                            <td>{{ $exam->duration }}</td>
                                            <td>{{ $exam->number_of_questions }}</td>
                                            <td>{{ $exam->subject->Course->course_name }}</td>
                                            <td>{!! $exam->getStatus() !!}</td>
                                            <td>{{ $exam->Instructor->name }}</td>
                                            <td class="project-actions text-center">
{{--                                                <a class="btn btn-primary btn-sm" href="admin/exam-details/{{ $exam->id }}">--}}
{{--                                                    <i class="fas fa-folder">--}}
{{--                                                    </i>--}}
{{--                                                    View--}}
{{--                                                </a>--}}
                                                <a class="btn btn-info btn-sm" href="admin/exam-edit/{{ $exam->id }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Edit
                                                </a>
                                                <a class="btn">
                                                    <form action="admin/exam-delete/{{ $exam->id }}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button onclick="return confirm('Are you sure to delete this exam???')" class="btn btn-danger btn-sm" style="margin-left: -12px" type="submit">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Image</th>
                                        <th>Exam_Name</th>
{{--                                        <th>Start_date</th>--}}
{{--                                        <th>End_date</th>--}}
                                        <th>Duration(min)</th>
                                        <th>Questions</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th>Created_by</th>
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
