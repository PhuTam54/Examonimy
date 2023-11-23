@extends("layouts.admin")
@section("title", "Admin | Question Edit")
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.question.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form method="post" enctype="multipart/form-data" id="editQnAForm">
                @csrf
                @method("PUT")
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Q&A</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="col-md-6 left-col">
                                        <input type="hidden" id="inputQuestionId" value="{{ $question->id }}">
                                        <div class="form-group">
                                            <label for="inputName">Question text</label>
                                            <input
                                                required
                                                id="inputName"
                                                name="question_text"
                                                value="{{ $question->question_text }}"
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter question text"
                                            >
                                            @error("question_text")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTypeOfQuestion">Type Of Question</label>
                                            <select name="type_of_question" id="inputTypeOfQuestion" class="form-control custom-select" required>
                                                <option disabled>Select a type</option>
                                                <option @if( $question->type_of_question == "1") selected @endif value="1">Multiple Choice</option>
                                                <option @if( $question->type_of_question == "2") selected @endif value="2">One Choice</option>
                                                <option @if( $question->type_of_question == "3") selected @endif value="3">Fill in blank</option>
                                            </select>
                                        @error("type_of_question")
                                            <p class="text-danger"><i></i></p>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDifficulty">Difficulty</label>
                                            <select name="difficulty" id="inputDifficulty" class="form-control custom-select" required>
                                                <option disabled selected>Select a difficulty</option>
                                                <option @if( $question->difficulty == "1") selected @endif value="1">Easy</option>
                                                <option @if( $question->difficulty == "2") selected @endif value="2">Medium</option>
                                                <option @if( $question->difficulty == "3") selected @endif value="3">Difficult</option>
                                            </select>
                                            @error("difficulty")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputCourse">ExamQuestion (not required)</label>
                                            <select name="exam_question_id" id="inputCourse" class="form-control custom-select">
                                                <option selected disabled>Select an exam question</option>
                                                @foreach($exam_questions as $exam_question)
                                                    <option
                                                        @if( $question->exam_question_id == "$exam_question->id") selected @endif
                                                        value="{{ $exam_question->id }}">{{ $exam_question->exam_question_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("exam_question_id")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputParagraph">Paragraph (not required)</label>
                                            <textarea
                                                id="inputParagraph" class="form-control" name="question_paragraph" rows="1"
                                                placeholder="Enter question paragraph"
                                            >{{ $question->question_paragraph }}</textarea>
                                            @error("question_paragraph")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Image (not required)</label>
                                            <input
                                                name="question_image"
                                                type="file"
                                                class="form-control"
                                                accept="image/*,.pdf"
                                            >
                                            @if ($question->question_image)
                                                <p class="text-info">Old thumb nail: {{ $question->question_image }}</p>
                                            @endif
                                            @error("question_image")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Audio (not required)</label>
                                            <input
                                                name="question_audio"
                                                type="file"
                                                class="form-control"
                                                accept="audio/*"
                                            >
                                            @if ($question->question_audio)
                                                <p class="text-info">Old audio: {{ $question->question_audio }}</p>
                                            @endif
                                            @error("question_audio")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputOption" class="mb-3 mr-2">Options</label>
                                        <button id="addOption-btn" class="btn btn-secondary">Add an option</button>
                                        <br><span class="option-error text text-danger"></span>

                                        <ul class="todo-list right-col" data-widget="todo-list">
                                            @php
                                                $counter = 100;
                                            @endphp
                                            @foreach($question->QuestionOptions as $option)
                                                @php
                                                    $counter ++;
                                                    $isChecked = $option->is_correct; // Kiểm tra đáp án có được chọn không
                                                @endphp
                                                <li class="d-inline-flex options" >
                                                <span class="handle d-inline-flex mt-2">
                                                  <i class="fas fa-ellipsis-v"></i>
                                                  <i class="fas fa-ellipsis-v"></i>
                                                </span>
                                                    <div class="icheck-primary ml-2">
                                                        <input
                                                            id="is_correct{{ $counter }}"
                                                            type="checkbox"
                                                            name="is_correct[]"
                                                            class="is_correct"
                                                            value=""
                                                            {{ $isChecked ? 'checked' : '' }} {{-- Thêm checked nếu đáp án đã được chọn--}}
                                                        >
                                                        <label for="is_correct{{ $counter }}"></label>
                                                    </div>
                                                    <input
                                                        required
                                                        name="option_text[]"
                                                        value="{{ $question->type_of_question != "3" ? explode(". ", $option->option_text)[1] : $option->option_text }}"
                                                        type="text"
                                                        class="form-control"
                                                        id="inputOption"
                                                        style="min-width: 475px"
                                                        placeholder="Enter option text"
                                                    >
                                                    <label for=""></label>
                                                    <div class="tools removeOption-btn mt-1 ml-1">
                                                        <i class="fas fa-trash"></i>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
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
                        <div class="col-12 mb-3">
                            <a href="admin/admin-question" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-info float-right">Save the change</button>
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
    {{-- get the drag item --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="js/admin-js/dist/js/pages/dashboard.js"></script>

    @include("components.admin.embedded.question-script")
@endsection
