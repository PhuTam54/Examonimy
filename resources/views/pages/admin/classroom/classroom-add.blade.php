@extends("layouts.admin")
@section("title", "Admin | Class Add")
@section("before_css")
{{--    @include("components.admin.embedded.table_head")--}}
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.classroom.content_header")
        <!-- /.content-header -->
        @if ($errors->any())
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
            <form action="admin/classroom-add" method="post">
                @csrf
                @method('POST')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Add new classroom</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputName">Name</label>
                                            <input
                                                required
                                                name="name"
                                                value="{{ old("name") }}"
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter the name for class"
                                            >
                                            @error("name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputInstructor">Instructor</label>
                                            <select name="instructor" id="inputInstructor" class="form-control custom-select" required>
                                                <option selected disabled>Select one</option>
                                                @foreach($instructors as $instructor)
                                                    <option @if(old("instructor") == "$instructor->id") selected @endif value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("instructor")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputStudents">Students ( not required )</label>
                                            <select name="students[]" class="select2" id="inputStudents" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                                {{--                                                @php $array = old("students") ?? [] @endphp--}}
                                                @foreach($students as $student)
                                                    {{--                                                    <option @if(in_array("$student->id", $array)) selected @endif value="{{ $student->id }}">{{ $student->student_name }}</option>--}}
                                                    <option @if(old("students") == "$student->id") selected @endif value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("students")
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
                            <a href="admin/admin-classroom" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Create new Product" class="btn btn-success float-right">
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
        })
    </script>
@endsection
