@extends("layouts.admin")
@section("title", "Admin | Subjects Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.subject.content_header")
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
        @endif
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="d-flex justify-content-between" style="margin-bottom: -2px">
                                <a class="btn btn-success btn-md" href="admin/subject-add">
                                    <i class="fas fa-plus">
                                    </i>
                                    Add new Subject
                                </a>
                                <a class="btn btn-danger btn-md" href="admin/subject-trash">
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
                                    <th>Lesson</th>
                                    <th>Course</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="">
                                        <img src=" {{ $subject->subject_thumbnail }}" width="100" alt="img">
                                    </td>
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>{{ $subject->lesson }}</td>
                                    <td>

                                        <!-- Trigger the modal with a button -->
                                        <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showCourseModal{{ $subject->id }}">
                                            <i class="fa fa-eye"></i>
                                            {{ $subject->Course->course_name }}
                                        </a>

                                        <!-- Modal -->
                                        <div id="showCourseModal{{ $subject->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">

                                                <!-- Modal content-->
                                                <div class="modal-content" style="min-width: 700px">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Showing Subject</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text fs-6">Subject {{ $subject->subject_name }}</p>
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th>Image</th>
                                                                <th>Course</th>
                                                                <th>Year</th>
                                                                <th>Description</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <img src="{{ $subject->Course->course_thumbnail }}" width="50" alt="">
                                                                    </td>
                                                                    <td>{{ $subject->Course->course_name }}</td>
                                                                    <td>{{ $subject->Course->course_year }}</td>
                                                                    <td>
                                                                        @if(strlen($subject->Course->course_description) > 50)
                                                                            {{ substr($subject->Course->course_description, 0, 50) }}...
                                                                        @else
                                                                            {{ $subject->Course->course_description }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="project-actions text-center">
                                        @if($subject->deleted_at != null)
                                            <a class="btn btn-info btn-sm mb-2" href="admin/subject-recover/{{ $subject->id }}">
                                                <i class="fas fa-redo-alt">
                                                </i>
                                                Recover
                                            </a>
                                        @else
                                        <a class="btn btn-info btn-sm" href="admin/subject-edit/{{ $subject->id }}" style="min-width: 80px">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn">
                                            <form action="admin/subject-delete/{{ $subject->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                                <button onclick="return confirm('Are you sure to delete this subject???')" class="btn btn-danger btn-sm" style="min-width: 80px" type="submit">
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
                                    <th>Lesson</th>
                                    <th>Course</th>
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
