@extends("layouts.admin")
@section("title", "Admin | Courses Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.course.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="d-flex justify-content-between" style="margin-bottom: -2px">
                                    <a class="btn btn-success btn-md" href="admin/course-add">
                                        <i class="fas fa-plus">
                                        </i>
                                        Add new Course
                                    </a>
                                    <a class="btn btn-danger btn-md" href="admin/course-trash">
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Subjects</th>
                                        <th>Year</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="">
                                                <img src=" {{ $course->course_thumbnail }}" width="100" alt="img">
                                            </td>
                                            <td>{{ $course->course_name }}</td>
                                            <td>{{ $course->course_description }}</td>
                                            <td>
                                                <!-- Trigger the modal with a button -->
                                                <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showSubjectModal{{ $course->id }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ $course->Subjects->count() }} to show
                                                </a>

                                                <!-- Modal -->
                                                <div id="showSubjectModal{{ $course->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">

                                                        <!-- Modal content-->
                                                        <div class="modal-content" style="min-width: 700px">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Showing Subject</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text fs-6">Course {{ $course->course_name }}</p>
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Image</th>
                                                                        <th>Subject</th>
                                                                        <th>Lesson</th>
                                                                        <th>Description</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($course->Subjects as $subject)
                                                                        <tr>
                                                                            <td>{{ $loop->index +1 }}</td>
                                                                            <td>
                                                                                <img src="{{ $subject->subject_thumbnail }}" width="50" alt="">
                                                                            </td>
                                                                            <td>{{ $subject->subject_name }}</td>
                                                                            <td>{{ $subject->lesson }}</td>
                                                                            <td>
                                                                                @if(strlen($subject->subject_description) > 50)
                                                                                    {{ substr($subject->subject_description, 0, 50) }}...
                                                                                @endif
                                                                            </td> <br>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $course->course_year }} years</td>
                                            <td class="project-actions text-center">
                                                @if($course->deleted_at != null)
                                                    <form action="admin/course-recover/{{ $course->id }}" method="post">
                                                        @csrf
                                                        @method("PUT")
                                                        <button type="submit" class="btn btn-info btn-sm mb-2">
                                                            <i class="fas fa-redo-alt">
                                                            </i>
                                                            Recover
                                                        </button>
                                                    </form>
                                                @else
                                                <a class="btn btn-info btn-sm" href="admin/course-edit/{{ $course->id }}" style="min-width: 80px">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Edit
                                                </a>
                                                <a class="btn">
                                                    <form action="admin/course-delete/{{ $course->id }}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button onclick="return confirm('Are you sure to delete this course???')" class="btn btn-danger btn-sm" style="min-width: 80px" type="submit">
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Subjects</th>
                                        <th>Year</th>
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
@endsection
