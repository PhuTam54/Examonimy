@extends("layouts.app")
@section("title", "Examonimy | Courses")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
                <h1 class="mb-5">Courses and Subjects</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
{{--                    Courses--}}
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Subjects</th>
                                    <th>Year</th>
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
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Subjects</th>
                                    <th>Year</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

{{--                    Subjects--}}
                    <div class="card">
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped" style="border: 1px solid rgba(0,0,0,0.05)">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Lesson</th>
                                    <th>Course</th>
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
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    <!-- Courses End -->
@endsection
@section("after_js")
    @include("components.admin.embedded.table_script")
@endsection
