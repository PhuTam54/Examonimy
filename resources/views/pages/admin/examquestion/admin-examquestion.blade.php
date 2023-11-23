@extends("layouts.admin")
@section("title", "Admin | ExamQuestions Table")
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
        @elseif(session()->has("addQuestion-success"))
            <div class="alert alert-success" role="alert">
                {{ session("addQuestion-success") }}
            </div>
        @elseif(session()->has("deleteQuestion-success"))
            <div class="alert alert-success" role="alert">
                {{ session("deleteQuestion-success") }}
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
                                            <td>{{ $examquestion->exam_question_name }}</td>
                                            @if($examquestion->duration / 3600 > 1)
                                                <td>
                                                    {{ floor($examquestion->duration / 3600) }} hours
                                                    {{ floor($examquestion->duration % 3600 / 60) }} minutes
                                                </td>
                                            @elseif(($examquestion->duration % 3600) / 60 > 1)
                                                <td>
                                                    {{ floor($examquestion->duration % 3600 / 60) }} minutes
                                                </td>
                                            @elseif($examquestion->duration % 60 > 1)
                                                <td>
                                                    {{ $examquestion->duration % 60 }} seconds
                                                </td>
                                            @endif
                                            <td>{{ $examquestion->total_marks }}</td>
                                            <td>{{ $examquestion->passing_marks }}</td>
                                            <td class="project-actions text-center">
                                                <!-- 111111111111111 Trigger the modal with a button -->
                                                <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showQuestionModal{{ $examquestion->id }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ $examquestion->Questions->count() }}/{{ $examquestion->number_of_questions }}
                                                </a>

                                                <!--1111111111111111  Modal -->
                                                <div id="showQuestionModal{{ $examquestion->id }}" class="modal fade text-left" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">

                                                        <!-- Modal content-->
                                                        <div class="modal-content" style="min-width: 700px; max-height: 600px">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Showing Q&A for {{ $examquestion->exam_question_name }}</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body overflow-auto">
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Question</th>
                                                                        <th>Options</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($examquestion->Questions as $question)
                                                                        <tr>
                                                                            <td>{{ $loop->index + 1 }}</td>
                                                                            <td>{{ $question->question_text }}</td>
                                                                            <td>
                                                                                <!-- Trigger the modal with a button -->
                                                                                <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showAnswerModal{{ $question->id }}">
                                                                                    <i class="fa fa-eye"></i>
                                                                                    {{ $question->QuestionOptions->count() }}
                                                                                </a>

                                                                                <!-- Modal -->
                                                                                <div id="showAnswerModal{{ $question->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered" role="document">

                                                                                        <!-- Modal content-->
                                                                                        <div class="modal-content" style="min-width: 700px">
                                                                                            <div class="modal-header">
                                                                                                <h4 class="modal-title">Showing Answer</h4>
                                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p class="text fs-6">Question {{ $loop->index + 1 }}: {{ $question->question_text }}</p>
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
                                                                            <td class="project-actions text-center">
                                                                                @if($examquestion->status == \App\Models\ExamQuestion::PENDING)
                                                                                    <form action="admin/examquestion-delete-question/{{ $question->id }}" method="post">
                                                                                        @csrf
                                                                                        <input type="hidden" name="examquestion_id" value="{{ $examquestion->id }}">
                                                                                        <button onclick="return confirm('Are you sure to delete this question???')" class="btn btn-danger btn-sm" style="min-width: 80px" type="submit">
                                                                                            <i class="fas fa-trash">
                                                                                            </i>
                                                                                            Remove
                                                                                        </button>
                                                                                    </form>
                                                                                @else
                                                                                    #
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($examquestion->status == \App\Models\ExamQuestion::PENDING)

                                                    <!-- 2222222222222222222 Trigger the modal with a button -->
                                                    <a type="button" class="btn btn-info btn-sm mt-3" data-toggle="modal" data-target="#showAddQuestionModal{{ $examquestion->id }}">
                                                        <i class="fa fa-plus"></i>
                                                        Add questions
                                                    </a>

                                                    <!--2222222222222 Modal -->
                                                    <div id="showAddQuestionModal{{ $examquestion->id }}" class="modal fade text-left" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">

                                                            <!-- Modal content-->
                                                            <div class="modal-content" style="min-width: 700px">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Add Q&A for {{ $examquestion->exam_question_name }}</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <form action="admin/examquestion-add-question" method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="examquestion_id" value="{{ $examquestion->id }}">
                                                                        <label for="inputAddQuestion{{ $examquestion->id }}">Questions list</label>
                                                                        <select name="questions[]" class="select2" id="inputAddQuestion{{ $examquestion->id }}" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                                                            @foreach($questions as $index => $question)
                                                                                <option @if(old("questions") == "$question->id") selected @endif value="{{ $question->id }}">Question {{ $index + 1 }}: {{ $question->question_text }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error("classes")
                                                                        <p class="text-danger"><i>{{ $message }}</i></p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-info">Add</button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>

                                                @endif
                                            </td>
                                            <td>{!! $examquestion->getStatus() !!}</td>
                                            <td class="project-actions text-center">
                                                @if($examquestion->deleted_at != null)
                                                    <a class="btn btn-info btn-sm" href="admin/examquestion-recover/{{ $examquestion->id }}" style="min-width: 80px;">
                                                        <i class="fas fa-redo-alt">
                                                        </i>
                                                        Recover
                                                    </a>
                                                @else
                                                @switch($examquestion->status)
                                                    @case(\App\Models\ExamQuestion::PENDING)
                                                        <a href="admin/examquestion-confirm/{{ $examquestion->id }}" class="btn btn-success btn-sm mb-2 {{ $examquestion->number_of_questions == $examquestion->Questions->count() ? '' : 'disabled' }}" style="min-width: 80px;">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                            Confirm
                                                        </a>
                                                        <a href="admin/examquestion-cancel/{{ $examquestion->id }}" class="btn btn-danger btn-sm"
                                                           style="min-width: 80px;">
                                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                        </a>
                                                        @break

                                                    @case(\App\Models\ExamQuestion::CONFIRMED)
                                                        <a href="admin/examquestion-cancel/{{ $examquestion->id }}" class="btn btn-danger btn-sm"
                                                           style="margin-right: 5px;min-width: 80px;">
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
                                                <a class="btn btn-info btn-sm mb-2" href="admin/examquestion-edit/{{ $examquestion->id }}" style="min-width: 80px;">
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
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endsection
