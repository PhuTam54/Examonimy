@extends("layouts.admin")
@section("title", "Admin | Subject Add")
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.subject.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="admin/subject-add" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Add new subject</h3>
                                </div>
                                <div class="card-body d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputName">Name</label>
                                            <input
                                                name="name"
                                                value="{{ old("name") }}"
                                                type="text"
                                                class="form-control"
                                            >
                                            @error("name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="lesson">Lesson</label>
                                            <input
                                                name="lesson"
                                                value="{{ old("lesson") }}"
                                                type="number"
                                                min="0"
                                                class="form-control"
                                            >
                                            @error("lesson")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputCourse">Course</label>
                                            <select name="course" id="inputCourse" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                @foreach($courses as $course)
                                                    <option @if(old("course") == "$course->id") selected @endif value="{{ $course->id }}">{{ $course->course_name }}</option>
                                                @endforeach
                                            </select>
                                            @error("course")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputDescription">Description</label>
                                            <textarea id="inputDescription" class="form-control" name="description" rows="1">{{ old('description') }}</textarea>
                                            @error("description")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">Status</label>
                                            <select name="status" id="inputStatus" class="form-control custom-select">
                                                <option  disabled>Select one</option>
                                                <option @if(old("status") == "1") selected @endif value="1" selected>In stock</option>
                                                <option @if(old("status") == "2") selected @endif value="2">Out of stock</option>
                                            </select>
                                            @error("status")
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
                            <a href="admin/admin-subject" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Create new Subject" class="btn btn-success float-right">
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
