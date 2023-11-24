@extends("layouts.admin")
@section("title", "Admin | Users Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.user.content_header")
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
                                <a class="btn btn-success btn-md" href="admin/user-add">
                                    <i class="fas fa-plus">
                                    </i>
                                    Add new User
                                </a>
                                <a class="btn btn-danger btn-md" href="admin/user-trash">
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
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Class</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="">
                                        <img src=" {{ $user->avatar }}" width="100" style="max-height: 100px; object-fit: cover" alt="img">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{!! $user->getRole() !!}</td>
                                    <td>

                                        @if($user->role == \App\Models\User::INSTRUCTOR)

                                            <!-- Trigger the modal with a button -->
                                            <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showClass{{ $user->id }}">
                                                <i class="fa fa-eye"></i>
                                                {{ $user->ClassesOfInstructor->count() }} class{{ $user->ClassesOfInstructor->count() > 1 ? 'es' : ''}}
                                            </a>

                                            <!-- Modal -->
                                            <div id="showClass{{ $user->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">

                                                    <!-- Modal content-->
                                                    <div class="modal-content" style="min-width: 700px; max-height: 600px">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Showing classes of {{ $user->name }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body overflow-auto">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Class's Name</th>
                                                                    <th>Students</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($user->ClassesOfInstructor as $class)
                                                                    <tr>
                                                                        <td>{{ $loop->index + 1 }}</td>
                                                                        <td>{{ $class->class_name }}</td>
                                                                        <td>{{ $class->Students->count() }} student{{ $class->Students->count() > 1 ? 's' : ''}}</td>
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

                                        @elseif($user->Classes != null)

                                            <!-- Trigger the modal with a button -->
                                            <a type="button" class="text text-info text-md" data-toggle="modal" data-target="#showClass{{ $user->Classes->id }}">
                                                <i class="fa fa-eye"></i>
                                                {{ $user->Classes->class_name }}
                                            </a>

                                            <!-- Modal -->
                                            <div id="showClass{{ $user->Classes->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">

                                                    <!-- Modal content-->
                                                    <div class="modal-content" style="min-width: 700px; max-height: 600px">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Showing class {{ $user->Classes->class_name }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body overflow-auto">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Class's Name</th>
                                                                    <th>Students</th>
                                                                    <th>Instructor</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>{{ $user->Classes->class_name }}</td>
                                                                    <td>{{ $user->Classes->Students->count() }} students</td>
                                                                    <td>{{ $user->Classes->Instructor->name }}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        @endif
                                    </td>
                                    <td class="project-actions text-center">
                                        @if($user->deleted_at != null)
                                            <form action="admin/user-recover/{{ $user->id }}" method="get">
                                                <button type="submit" class="btn btn-info btn-sm mb-2">
                                                    <i class="fas fa-redo-alt">
                                                    </i>
                                                    Recover
                                                </button>
                                            </form>
                                        @else
                                        <a class="btn btn-info btn-sm" href="admin/user-edit/{{ $user->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn">
                                            <form action="admin/user-delete/{{ $user->id }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                                <button onclick="return confirm('Are you sure to delete this user???')" class="btn btn-danger btn-sm" style="margin-left: -12px" type="submit">
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
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Class</th>
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
