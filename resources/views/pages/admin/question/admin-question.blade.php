@extends("layouts.admin")
@section("title", "Admin | Questions Table")
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
        @elseif(session()->has("success"))
            <div class="alert alert-danger" role="alert">
                {{ session("success") }}
            </div>
        @endif
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header d-flex">
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
                                                    <button type="submit" class="btn btn-info import-btn">Import</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </h3>
                            <a class="btn btn-danger btn-md" href="admin/question-trash" style="margin-left: auto">
                                <i class="fas fa-trash-alt">
                                </i>
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>QuestionText</th>
                                    <th>QuestionMark</th>
                                    <th>Difficulty</th>
                                    <th>TypeOfQuestion</th>
                                    <th>QuestionOptions</th>
                                    <th>ExamQuestion</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $question_counter = 1;
                                @endphp
                                @foreach($questions as $question)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $question->question_text }}</td>
                                    <td>{{ $question->question_mark }}</td>
                                    <td>{!! $question->getDifficulty() !!}</td>
                                    <td>{{ $question->type_of_question }}</td>
                                    <td>
                                        <!-- Trigger the modal with a button -->
                                        <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showAnswerModal{{ $question->id }}">
                                            <i class="fa fa-eye"></i>
                                            {{ $question->QuestionOptions->count() }} to show
                                        </a>

                                        <!-- Modal -->
                                        <div id="showAnswerModal{{ $question->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Showing Answer</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text fs-6">Question {{ $question_counter ++ }}: {{ $question->question_text }}</p>
                                                        <ul>
                                                            @foreach($question->QuestionOptions as $option)
                                                                @if($option->is_correct)
                                                                    <li class="text-success text-bold">
                                                                        {{ $option->option_text }}
                                                                        <span class="text-success">
                                                                            <i class="fa fa-check"></i>
                                                                        </span>
                                                                    </li>
                                                                @else
                                                                    <li>{{ $option->option_text }}</li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Trigger the modal with a button -->
                                        <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showExamQuestionModal{{ $question->ExamQuestion->id }}">
                                            <i class="fa fa-eye"></i>
                                            {{ $question->ExamQuestion->exam_question_name }}
                                        </a>

                                        <!-- Modal -->
                                        <div id="showExamQuestionModal{{ $question->ExamQuestion->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Showing ExamQuestion</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="text fs-6">Exam {{ $question->exam_name }}</h5>
                                                        <ul>
                                                            <li>ExamQuestion: {{ $question->ExamQuestion->exam_question_name }}</li>
                                                            <li>Duration: {{ $question->ExamQuestion->duration }} seconds</li>
                                                            <li>Questions: {{ $question->ExamQuestion->number_of_questions }}</li>
                                                            <li>Total: {{ $question->ExamQuestion->total_marks }} points</li>
                                                            <li>Passing: {{ $question->ExamQuestion->passing_marks }} points</li>
                                                            <li>
                                                                Description: {{ $question->ExamQuestion->exam_question_description }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <a class="btn btn-info" href="admin/exam-question-details/{{ $question->ExamQuestion->id }}">Details</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="project-actions text-center">
                                        @if($question->deleted_at != null)
                                            <a class="btn btn-info btn-sm mb-2" href="admin/question-recover/{{ $question->id }}">
                                                <i class="fas fa-redo-alt">
                                                </i>
                                                Recover
                                            </a>
                                        @else
                                        <a class="btn btn-info btn-sm" href="admin/question-edit/{{ $question->id }}" style="min-width: 80px">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn">
                                            <form action="admin/question-delete/{{ $question->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                                <button onclick="return confirm('Are you sure to delete this question???')" class="btn btn-danger btn-sm" style="min-width: 80px" type="submit">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    Delete
                                                </button>
                                            </form>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>QuestionText</th>
                                    <th>QuestionMark</th>
                                    <th>Difficulty</th>
                                    <th>TypeOfQuestion</th>
                                    <th>QuestionOptions</th>
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

            $(`.import-btn`).html("Please wait <i class='fa fa-spinner fa-spin'></i>")

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
