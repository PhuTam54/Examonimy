@extends("layouts.admin")
@section("title", "Admin | Classes Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.classroom.content_header")
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
        @elseif(session()->has("addStudent-success"))
            <div class="alert alert-success" role="alert">
                {{ session("addStudent-success") }}
            </div>
        @elseif(session()->has("deleteStudent-success"))
            <div class="alert alert-success" role="alert">
                {{ session("deleteStudent-success") }}
            </div>
        @elseif(session()->has("recover-success-success"))
            <div class="alert alert-success" role="alert">
                {{ session("recover-success-success") }}
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
                                <a class="btn btn-success btn-md" href="admin/classroom-add">
                                    <i class="fas fa-plus">
                                    </i>
                                    Add new classroom
                                </a>
                                <a class="btn btn-danger btn-md" href="admin/classroom-trash">
                                    <i class="fas fa-trash-alt">
                                    </i>
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Students</th>
                                    <th>Instructor</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $classroom)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $classroom->class_name }}</td>
                                    <td class="project-actions text-center">
                                        <!-- Trigger the modal with a button -->
                                        <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showStudentModal{{ $classroom->id }}">
                                            <i class="fa fa-eye"></i>
                                            {{ $classroom->Students->count() }} to show
                                        </a>

                                        <!-- Modal -->
                                        <div id="showStudentModal{{ $classroom->id }}" class="modal fade text-left" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">

                                                <!-- Modal content-->
                                                <div class="modal-content" style="min-width: 700px">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Showing Students</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="text fs-6">Class {{ $classroom->class_name }}</h5>
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Student's Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($classroom->Students as $index => $student)
                                                                <tr>
                                                                    <td>{{ $loop->index + 1 }}</td>
                                                                    <td>{{ $student->name }}</td>
                                                                    <td class="project-actions text-center">
                                                                        <a class="btn">
                                                                            <form action="admin/classroom-delete-student/{{ $student->id }}" method="post">
                                                                                @csrf
                                                                                <button onclick="return confirm('Are you sure to delete this student???')" class="btn btn-danger btn-sm" style="min-width: 80px" type="submit">
                                                                                    <i class="fas fa-trash">
                                                                                    </i>
                                                                                    Remove
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
                                                                <th>Student's Name</th>
                                                                <th>Action</th>
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

                                        <!-- 2222222222222222222 Trigger the modal with a button -->
                                        <a type="button" class="btn btn-info btn-sm ml-3" data-toggle="modal" data-target="#showAddStudentModal{{ $classroom->id }}">
                                            <i class="fa fa-plus"></i>
                                            Add students
                                        </a>

                                        <!--2222222222222 Modal -->
                                        <div id="showAddStudentModal{{ $classroom->id }}" class="modal fade text-left" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">

                                                <!-- Modal content-->
                                                <div class="modal-content" style="min-width: 700px">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Add Students for {{ $classroom->class_name }}</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form action="admin/classroom-add-student" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="hidden" name="class_id" value="{{ $classroom->id }}">
                                                            <label for="inputAddStudent{{ $classroom->id }}">Students list</label>
                                                            <select name="students[]" class="select2" id="inputAddStudent{{ $classroom->id }}" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                                                @foreach($students as $index => $student)
                                                                    <option @if(old("students") == "$student->id") selected @endif value="{{ $student->id }}">Student {{ $index + 1 }}: {{ $student->name }}</option>
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

                                    </td>
                                    <td>{{ $classroom->Instructor->name }}</td>
                                    <td>{{ $classroom->created_at }}</td>
                                    <td class="project-actions text-center">
                                        @if($classroom->deleted_at != null)
                                            <form action="admin/classroom-recover/{{ $classroom->id }}" method="post">
                                                @csrf
                                                @method("PUT")
                                                <button type="submit" class="btn btn-info btn-sm mb-2">
                                                    <i class="fas fa-redo-alt">
                                                    </i>
                                                    Recover
                                                </button>
                                            </form>
                                        @else
                                        <a class="btn btn-info btn-sm" href="admin/classroom-edit/{{ $classroom->id }}" style="min-width: 80px">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn">
                                            <form action="admin/classroom-delete/{{ $classroom->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                                <button onclick="return confirm('Are you sure to delete this classroom???')" class="btn btn-danger btn-sm" style="min-width: 80px" type="submit">
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
                                    <th>Name</th>
                                    <th>Students</th>
                                    <th>Instructor</th>
                                    <th>Created at</th>
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
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endsection
