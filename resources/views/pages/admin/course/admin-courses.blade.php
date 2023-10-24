@extends("layouts.admin")
@section("title", "Admin | Courses Tables")
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
                                <h3 class="card-title">
                                    <a class="btn btn-success btn-md" href="admin/subject-add">
                                        <i class="fas fa-plus">
                                        </i>
                                        Add new course
                                    </a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Subjects</th>
                                        <th>Created at</th>
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
                                            <td>{{ $course->Subjects->count() }}</td>
                                            <td>{{ $course->created_at }}</td>
                                            <td class="project-actions text-center">
{{--                                                <a class="btn btn-primary btn-sm" href="admin/course-details/{{ $course->id }}">--}}
{{--                                                    <i class="fas fa-folder">--}}
{{--                                                    </i>--}}
{{--                                                    View--}}
{{--                                                </a>--}}
                                                <a class="btn btn-info btn-sm" href="admin/course-edit/{{ $course->id }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Edit
                                                </a>
                                                <a class="btn">
                                                    <form action="admin/course-delete/{{ $course->id }}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button onclick="return confirm('Are you sure to delete this course???')" class="btn btn-danger btn-sm" style="margin-left: -12px" type="submit">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            Delete
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Subjects</th>
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
@endsection
