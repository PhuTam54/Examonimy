@extends("layouts.admin")
@section("title", "Admin | Questions Tables")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.question.content_header")
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
                                <a class="btn btn-success btn-md" href="admin/question-add">
                                    <i class="fas fa-plus">
                                    </i>
                                    Add new question
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Question_text</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
{{--                                    <th>Correct</th>--}}
                                    <th>Exam</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $question)
                                <tr>
                                    <td>#{{ $loop->index + 1 }}</td>
                                    <td>{{ $question->question_text }}</td>
                                    @foreach($question->QuestionOptions as $option)
                                        <td>{{ $option->option_text }} is_true: {{ $option->is_correct }}</td>
                                    @endforeach
                                    @if($question->QuestionOptions->count() < 4)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>{{ $question->Exam->exam_name }}</td>
                                    <td class="project-actions text-center">
{{--                                        <a class="btn btn-primary btn-sm" href="admin/question-details/{{ $question->id }}">--}}
{{--                                            <i class="fas fa-folder">--}}
{{--                                            </i>--}}
{{--                                            View--}}
{{--                                        </a>--}}
                                        <a class="btn btn-info btn-sm" href="admin/question-edit/{{ $question->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn">
                                            <form action="admin/question-delete/{{ $question->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                                <button onclick="return confirm('Are you sure to delete this question???')" class="btn btn-danger btn-sm" style="margin-left: -12px" type="submit">
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
                                    <th>Question_text</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
{{--                                    <th>Correct</th>--}}
                                    <th>Exam</th>
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
