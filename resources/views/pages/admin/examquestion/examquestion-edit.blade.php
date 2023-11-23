@extends("layouts.admin")
@section("title", "Admin | Exam Question Edit")
@section("before_css")
    {{--    @include("components.admin.embedded.table_head")--}}
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.examquestion.content_header")
        <!-- /.content-header -->
        @if($errors->any())
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
            <form action="admin/examquestion-edit/{{ $examquestion->id }}" method="post">
                @csrf
                @method("PUT")
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit examquestion</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputName">Name</label>
                                            <input
                                                required
                                                name="examquestion_name"
                                                value="{{ $examquestion->exam_question_name }}"
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter examquestion name"
                                            >
                                            @error("examquestion_name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Duration</label>

                                            <div class="input-group row">
                                                <div class="col-3">
                                                    <div>Hour</div>
                                                    <input name="durationHour" type="number" id="durationHour" class="form-control float-right" min="0" value="{{ $hour }}">
                                                    @error("durationHour")
                                                    <p class="text-danger"><i>{{ $message }}</i></p>
                                                    @enderror
                                                </div>
                                                <div class="col-6">
                                                    <div>Minute</div>
                                                    <input name="durationMinute" type="number" id="durationMinute" class="form-control float-right" min="0" required value="{{ $minute }}">
                                                    @error("durationMinute")
                                                    <p class="text-danger"><i>{{ $message }}</i></p>
                                                    @enderror
                                                </div>
                                                <div class="col-3">
                                                    <div>Second</div>
                                                    <input name="durationSecond" type="number" id="durationSecond" class="form-control float-right" min="0" value="{{ $second }}">
                                                    @error("durationSecond")
                                                    <p class="text-danger"><i>{{ $message }}</i></p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label for="inputName">Number of questions</label>
                                            <input
                                                required
                                                name="number_of_question"
                                                value="{{ $examquestion->number_of_questions }}"
                                                type="number"
                                                min="1"
                                                class="form-control"
                                                placeholder="Enter the number of questions"
                                            >
                                            @error("number_of_question")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputDescription">Description</label>
                                            <textarea id="inputDescription" class="form-control" name="description" rows="2" required>{{ $examquestion->exam_question_description }}</textarea>
                                            @error("description")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Total mark</label>
                                            <input
                                                required
                                                name="total_mark"
                                                id="totalMarkInput"
                                                value="{{ $examquestion->total_marks }}"
                                                type="number"
                                                min="1"
                                                class="form-control"
                                                placeholder="100 point"
                                                onchange="updatePassingMark()"
                                            >
                                            @error("total_mark")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Passing mark</label>
                                            <input
                                                required
                                                name="passing_mark"
                                                id="passingMarkInput"
                                                value="{{ $examquestion->passing_marks }}"
                                                type="text"
                                                min="1"
                                                class="form-control"
                                                placeholder="100/3 point"
                                            >
                                            @error("passing_mark")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
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
                            <input type="submit" value="Save change" class="btn btn-info float-right">
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
        function updatePassingMark() {
            const totalMarkInput = document.getElementById('totalMarkInput');
            const passingMarkInput = document.getElementById('passingMarkInput');

            // Lấy giá trị từ ô input "total_mark"
            const totalMarkValue = parseFloat(totalMarkInput.value);

            // Kiểm tra nếu giá trị hợp lệ
            if (!isNaN(totalMarkValue)) {
                // Cập nhật giá trị của ô input "passing_mark"
                passingMarkInput.value = (totalMarkValue / 3).toFixed(2);
            }
        }
    </script>
@endsection
