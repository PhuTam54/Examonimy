@extends("layouts.admin")
@section("title", "Admin | Exam Question Add")
@section("before_css")
{{--    @include("components.admin.embedded.table_head")--}}
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.examquestion.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="admin/examquestion-add" method="post">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Add new examquestion</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputName">Name</label>
                                            <input
                                                name="examquestion_name"
                                                value="{{ old("examquestion_name") }}"
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter examquestion name"
                                            >
                                            @error("examquestion_name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">Type of examquestion</label>
                                            <select name="type_of_examquestion" id="inputStatus" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                <option @if(old("type_of_examquestion") == "1") selected @endif value="1">MultipleChoice</option>
                                                <option @if(old("type_of_examquestion") == "2") selected @endif value="2">Essay</option>
                                                <option @if(old("type_of_examquestion") == "3") selected @endif value="3">Listening</option>
                                            </select>
                                            @error("type_of_examquestion")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSubject">Subject</label>
                                            <select name="subject" id="inputSubject" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                @foreach($subjects as $subject)
                                                    <option @if(old("subject") == "$subject->id") selected @endif value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                                @endforeach
                                            </select>
                                            @error("subject")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputClassEnrollment">Class enrollment</label>
                                            <select name="classes" class="select2" id="inputClassEnrollment" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                                @php $array = old("classes") ?? [] @endphp
                                                @foreach($classes as $class)
{{--                                                    <option @if(in_array("$class->id", $array)) selected @endif value="{{ $class->id }}">{{ $class->class_name }}</option>--}}
                                                    <option @if(old("classes") == "$class->id") selected @endif value="{{ $class->id }}">{{ $class->class_name }}</option>
                                                @endforeach
                                            </select>
                                            @error("classes")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label for="inputExamQuestion">Exam question</label>
                                            <select name="exam_question" id="inputExamQuestion" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                @foreach($exam_questions as $exam_question)
                                                    <option @if(old("exam_question") == "$exam_question->id") selected @endif value="{{ $exam_question->id }}">{{ $exam_question->exam_question_name }}</option>
                                                @endforeach
                                            </select>
                                            @error("exam_question")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <!-- Date and time range -->
                                        <div class="form-group">
                                            <label>Date and time range:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <input name="datetime" type="text" class="form-control float-right" id="reservationtime">
                                                @error("datetime")
                                                <p class="text-danger"><i>{{ $message }}</i></p>
                                                @enderror
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label for="inputDescription">Description</label>
                                            <textarea id="inputDescription" class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                                            @error("description")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Retaken fee</label>
                                            <input
                                                name="retaken_fee"
                                                value="{{ old("retaken_fee") }}"
                                                type="number"
                                                class="form-control"
                                                placeholder="$0.0"
                                            >
                                            @error("retaken_fee")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Image</label>
                                            <input
                                                name="thumbnail"
                                                type="file"
                                                class="form-control"
                                                accept="image/*,.pdf"
                                            >
                                            @if (old('thumbnail'))
                                                <p class="text-info">Old thumb nail: {{ old("thumbnail") }}</p>
                                                <p class="text-danger">Please choose again.</p>
                                            @endif
                                            @error("thumbnail")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- /.card-body -->
                                </div>
                            <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <a href="admin/admin-examquestion" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Create new Exam Question" class="btn btn-success float-right">
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
    })
</script>
@endsection
