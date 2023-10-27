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

                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#importQnaModal">
                                    <i class="fas fa-file-import">
                                    </i>
                                    Import Questions
                                </button>

                                <!-- Modal -->
                                <div id="importQnaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Import Q&A</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form id="importQna">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="file" name="file" id="file_upload" required accept=".csv, application/vnd.openxmlformarts-officedocument.spreadsheetml.sheet ,application/vnd.ms.excel">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-info">Import</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Question_text</th>
                                    <th>Option_A</th>
                                    <th>Option_B</th>
                                    <th>Option_C</th>
                                    <th>Option_D</th>
                                    <th>ExamQuestion</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $question)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $question->question_text }}</td>
                                    @foreach($question->QuestionOptions as $option)
                                        @if($option->is_correct)
                                        <td class="text-success text-bold">
                                            {{ $option->option_text }}
                                            <span class="text-success">
                                                <i class="fa fa-check"></i>
                                            </span>
                                        </td>
                                        @else
                                        <td>{{ $option->option_text }}</td>
                                        @endif
                                    @endforeach
                                    @if($question->QuestionOptions->count() < 2)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @elseif($question->QuestionOptions->count() < 3)
                                        <td></td>
                                        <td></td>
                                    @elseif($question->QuestionOptions->count() < 4)
                                        <td></td>
                                    @elseif($question->QuestionOptions->count() < 1)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>{{ $question->ExamQuestion->exam_question_name }}</td>
                                    <td class="project-actions text-center">
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
                                    <th>Option_A</th>
                                    <th>Option_B</th>
                                    <th>Option_C</th>
                                    <th>Option_D</th>
                                    <th>ExamQuestion</th>
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

    <script>
        // Import Q&A
        $('#importQna').submit(function (e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('file', file_upload.files[0]);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN":"{{ csrf_token() }}"
                }
            });

            $.ajax({
                url:"{{ route('importQna') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function (data) {
                    // console.log(data)
                    if(data.success === true) {
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                }
            })

        })
    </script>
@endsection
