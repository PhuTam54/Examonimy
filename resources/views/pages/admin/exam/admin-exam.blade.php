@extends("layouts.admin")
@section("title", "Admin | Exams Table")
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
                                    <a class="btn btn-success btn-md" href="admin/exam-add">
                                        <i class="fas fa-plus">
                                        </i>
                                        Add new exam
                                    </a>
                                    <a class="btn btn-danger btn-md" href="admin/exam-trash">
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
                                        <th>ExamName</th>
                                        <th>StartEnd_date</th>
                                        <th>ExamQuestion</th>
                                        <th>Subject</th>
                                        <th>Participants</th>
                                        <th>Status</th>
                                        <th>CreatedBy</th>
                                        <th>Action</th>
                                        <th>#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($exams as $exam)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <p>{{ $exam->exam_name }}</p>
                                                <img src=" {{ $exam->exam_thumbnail ?? asset("storage/img/main-img/course-1.jpg") }}" width="80" alt="img">
                                            </td>
                                            <td>{{ $exam->start_date ?? "Never start" }} <br> => <br> {{ $exam->end_date ?? "Never end" }}</td>
                                            <td>
                                                <!-- Trigger the modal with a button -->
                                                <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showExamQuestionModal{{ $exam->ExamQuestion->id }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ $exam->ExamQuestion->exam_question_name }}
                                                </a>

                                                <!-- Modal -->
                                                <div id="showExamQuestionModal{{ $exam->ExamQuestion->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">

                                                        <!-- Modal content-->
                                                        <div class="modal-content" style="min-width: 700px">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Showing ExamQuestion</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5 class="text fs-6">Exam {{ $exam->exam_name }}</h5>
                                                                <ul>
                                                                    <li>ExamQuestion: {{ $exam->ExamQuestion->exam_question_name }}</li>
                                                                    @if($exam->ExamQuestion->duration / 3600 > 1)
                                                                        <li>Duration:
                                                                            {{ floor($exam->ExamQuestion->duration / 3600) }} hours
                                                                            {{ floor($exam->ExamQuestion->duration % 3600 / 60) }} minutes
                                                                        </li>
                                                                    @elseif(($exam->ExamQuestion->duration % 3600) / 60 > 1)
                                                                        <li>Duration:
                                                                            {{ floor($exam->ExamQuestion->duration % 3600 / 60) }} minutes
                                                                        </li>
                                                                    @elseif($exam->ExamQuestion->duration % 60 > 1)
                                                                        <li>Duration:
                                                                            {{ $exam->ExamQuestion->duration % 60 }} seconds
                                                                        </li>
                                                                    @endif
                                                                    <li>Questions: {{ $exam->ExamQuestion->number_of_questions }}</li>
                                                                    <li>Total: {{ $exam->ExamQuestion->total_marks }} points</li>
                                                                    <li>Passing: {{ $exam->ExamQuestion->passing_marks }} points</li>
                                                                    <li>
                                                                        Description: {{ $exam->ExamQuestion->exam_question_description }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $exam->subject->subject_name }}</td>
                                            <td>
                                                <!-- Trigger the modal with a button -->
                                                <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showPaticipantModal{{ $exam->id }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ $exam->Enrollments->count() }} to show
                                                </a>

                                                <!-- Modal -->
                                                <div id="showPaticipantModal{{ $exam->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">

                                                        <!-- Modal content-->
                                                        <div class="modal-content" style="min-width: 700px; max-height: 600px">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Showing Participants</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body overflow-auto">
                                                                <h5 class="text fs-6">Exam: {{ $exam->exam_name }}</h5>
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Student's Name</th>
                                                                        <th>Class</th>
                                                                        <th>Attempt</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($exam->Enrollments as $index => $enrollment)
                                                                        <tr>
                                                                            <td>{{ $loop->index + 1 }}</td>
                                                                            <td>{{ $enrollment->User->name }}</td>
                                                                            @if($enrollment->User->Classes != null)
                                                                                <td>{{ $enrollment->User->Classes->class_name }}</td>
                                                                            @else
                                                                                <td></td>
                                                                            @endif
                                                                            <td>{{ $enrollment->attempt > 1 ? $enrollment->attempt . " times" : $enrollment->attempt . " time"}}</td>
                                                                            <td>{!! $enrollment->getStatus() !!}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                    <tfoot>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Student's Name</th>
                                                                        <th>Class</th>
                                                                        <th>Attempt</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{!! $exam->getStatus() !!}</td>
                                            <td>{{ $exam->Instructor->name }}</td>
                                            <td class="project-actions text-center">
                                                @if($exam->deleted_at != null)
                                                    <a class="btn btn-info btn-sm mb-2" href="admin/exam-recover/{{ $exam->id }}">
                                                        <i class="fas fa-redo-alt">
                                                        </i>
                                                        Recover
                                                    </a>
                                                @else
                                                @switch($exam->status)
                                                    @case(\App\Models\Exam::PENDING)
                                                        <a href="admin/exam-confirm/{{ $exam->id }}" class="btn btn-success btn-sm mb-2" style="min-width: 80px;" >
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                            Confirm
                                                        </a>
                                                        <a href="admin/exam-cancel/{{ $exam->id }}" class="btn btn-danger btn-sm"
                                                           style="min-width: 80px;">
                                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                        </a>
                                                        @break

                                                    @case(\App\Models\Exam::CONFIRMED)
                                                        <a href="admin/exam-cancel/{{ $exam->id }}" class="btn btn-danger btn-sm"
                                                           style="min-width: 80px;">
                                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                        </a>
                                                        @break
                                                    @case(\App\Models\Exam::PROCESSING)
                                                        <a href="admin/exam-cancel/{{ $exam->id }}" class="btn btn-danger btn-sm"
                                                           style="min-width: 80px;">
                                                            <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                        </a>
                                                        @break
                                                    @case(\App\Models\Exam::COMPLETE)
                                                    @case(\App\Models\Exam::CANCEL)
                                                        <div class="text text-success">Done!</div>
                                                        @break
                                                @endswitch
                                                @endif
                                            </td>
                                            <td class="project-actions text-center">
                                                @unless($exam->deleted_at != null)
                                                <a class="btn btn-info btn-sm mb-2" href="admin/exam-edit/{{ $exam->id }}" style="min-width: 80px;">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Edit
                                                </a>
                                                <form action="admin/exam-delete/{{ $exam->id }}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete {{ $exam->exam_name }}???')" style="min-width: 80px;" type="submit">
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
                                        <th>ExamName</th>
                                        <th>StartEnd_date</th>
                                        <th>ExamQuestion</th>
                                        <th>Subject</th>
                                        <th>Participants</th>
                                        <th>Status</th>
                                        <th>CreatedBy</th>
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
