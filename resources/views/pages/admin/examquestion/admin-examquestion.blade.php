@extends("layouts.admin")
@section("title", "Admin | ExamQuestions Tables")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.examquestion.content_header")
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
        @elseif(session()->has("recover-success"))
            <div class="alert alert-success" role="alert">
                {{ session("recover-success") }}
            </div>
        @elseif($errors->any())
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
                            <div class="card-header">
                                <h3 class="d-flex justify-content-between" style="margin-bottom: -2px">
                                    <a class="btn btn-success btn-md" href="admin/examquestion-add">
                                        <i class="fas fa-plus">
                                        </i>
                                        Add new exam question
                                    </a>
                                    <a class="btn btn-danger btn-md" href="admin/examquestion-trash">
                                        <i class="fas fa-trash-alt">
                                        </i>
                                    </a>
                                </h3>
                            </div>
                            <!-- ./card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>ExamQuestionName</th>
                                        <th>Duration</th>
                                        <th>TotalMark</th>
                                        <th>PassingMark</th>
                                        <th>Questions</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($examquestions as $examquestion)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
{{--                                            <td class="">--}}
{{--                                                <img src=" {{ $examquestion->exam_question_thumbnail ?? asset("storage/img/main-img/course-1.jpg") }}" width="80" alt="img">--}}
{{--                                            </td>--}}
                                            <td>{{ $examquestion->exam_question_name }}</td>
                                            <td>{{ $examquestion->duration }}</td>
                                            <td>{{ $examquestion->total_marks }}</td>
                                            <td>{{ $examquestion->passing_marks }}</td>
                                            <td>
                                                <!-- Trigger the modal with a button -->
                                                <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showQuestionModal{{ $examquestion->id }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ $examquestion->number_of_questions }} to show
                                                </a>

                                                <!-- Modal -->
                                                <div id="showQuestionModal{{ $examquestion->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered min-vw-100" role="document">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Showing Q&A for {{ $examquestion->exam_question_name }}</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <form id="importQna">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <ul>
                                                                    @foreach($examquestion->Questions as $question)
                                                                        <li>Question {{ $question->question_no.': '.$question->question_text }}</li>
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
                                                                                        <p class="text fs-6">Question {{ $question->question_no }}: {{ $question->question_text }}</p>
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
                                                                    @endforeach
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-info">Import</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{!! $examquestion->getStatus() !!}</td>
                                            <td class="project-actions text-center">
                                                @if($examquestion->deleted_at != null)
                                                    <a class="btn btn-info btn-sm mb-2" href="admin/examquestion-recover/{{ $examquestion->id }}">
                                                        <i class="fas fa-redo-alt">
                                                        </i>
                                                        Recover
                                                    </a>
                                                @else
                                                @switch($examquestion->status)
                                                    @case(\App\Models\ExamQuestion::PENDING)
                                                        <a href="admin/examquestion-confirm/{{ $examquestion->id }}" class="btn btn-success btn-sm mb-2">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                            Confirm
                                                        </a>
                                                        <a href="admin/examquestion-cancel/{{ $examquestion->id }}" class="btn btn-danger btn-sm"
                                                           style="margin-right: 5px;">
                                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                        </a>
                                                        @break

                                                    @case(\App\Models\ExamQuestion::CONFIRMED)
                                                        <a href="admin/examquestion-cancel/{{ $examquestion->id }}" class="btn btn-danger btn-sm"
                                                           style="margin-right: 5px;">
                                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                        </a>
                                                        @break
                                                    @case(\App\Models\ExamQuestion::CANCELED)
                                                        <div class="text text-success">Done!</div>
                                                        @break
                                                @endswitch
                                                @endif
                                            </td>
                                            <td class="project-actions text-center">
                                                @unless($examquestion->deleted_at != null)
                                                <a class="btn btn-info btn-sm mb-2" href="admin/examquestion-edit/{{ $examquestion->id }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Edit
                                                </a>
                                                <form action="admin/examquestion-delete/{{ $examquestion->id }}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete {{ $examquestion->exam_question_name }}???')" style="min-width: 80px;" type="submit">
                                                        <i class="fas fa-trash-alt">
                                                        </i>
                                                        Delete
                                                    </button>
                                                </form>
                                                @endunless
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>ExamQuestionName</th>
                                        <th>Duration</th>
                                        <th>TotalMark</th>
                                        <th>PassingMark</th>
                                        <th>Questions</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>#</th>
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
