@extends("layouts.admin")
@section("title", "Admin | User Add")
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.user.content_header")
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
            <form action="admin/user-add" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Add new user</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputName">User Name</label>
                                            <input
                                                required
                                                name="name"
                                                value="{{ old("name") }}"
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter user name"
                                            >
                                            @error("name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Email</label>
                                            <input
                                                required
                                                name="email"
                                                value="{{ old("email") }}"
                                                type="email"
                                                class="form-control"
                                                placeholder="Enter user email"
                                            >
                                            @error("email")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Password</label>
                                            <input
                                                required
                                                name="password"
                                                value="{{ old("password") }}"
                                                type="password"
                                                class="form-control"
                                                placeholder="Enter user password"
                                            >
                                            @error("password")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">Role</label>
                                            <select name="role" id="inputStatus" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                <option @if(old("role") == "1") selected @endif value="1">Student</option>
                                                <option @if(old("role") == "2") selected @endif value="2">Instructor</option>
                                                <option @if(old("role") == "3") selected @endif value="3">Admin</option>
                                            </select>
                                            @error("role")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputClass">Class ( not required )</label>
                                            <select name="class_id" id="inputClass" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                @foreach($classes as $class)
                                                    <option @if(old("class_id") == "$class->id") selected @endif value="{{ $class->id }}">{{ $class->class_name }}</option>
                                                @endforeach
                                            </select>
                                            @error("class_id")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputName">Full Name ( not required )</label>
                                            <input
                                                name="full_name"
                                                value="{{ old("full_name") }}"
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter user full_name"
                                            >
                                            @error("full_name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label for="inputName">Date of birth ( not required )</label>
                                            <input
                                                name="date_of_birth"
                                                value="{{ old("date_of_birth") }}"
                                                type="date"
                                                class="form-control"
                                                placeholder="Enter user date_of_birth"
                                            >
                                            @error("date_of_birth")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label for="inputName">Address ( not required )</label>
                                            <input
                                                name="address"
                                                value="{{ old("address") }}"
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter user address"
                                            >
                                            @error("address")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label for="inputName">Phone number ( not required )</label>
                                            <input
                                                name="phone_number"
                                                value="{{ old("phone_number") }}"
                                                type="number"
                                                class="form-control"
                                                placeholder="Enter user phone_number"
                                            >
                                            @error("phone_number")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label for="inputName">Avatar ( not required )</label>
                                            <input
                                                name="avatar"
                                                type="file"
                                                class="form-control"
                                                accept="image/*,.jpg"
                                            >
                                            @if (old('avatar'))
                                                <p class="text-info">Old avatar: {{ old("avatar") }}</p>
                                            @endif
                                            @error("avatar")
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
                            <a href="admin/admin-user" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Create new User" class="btn btn-success float-right">
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
