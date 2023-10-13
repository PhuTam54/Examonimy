@extends("layouts.admin")
@section("title", "Admin | Results Table")
@section("before_css")
    @include("components.admin.embedded.table_head")
@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.result.content_header")
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
                                <h3 class="card-title">Results</h3>
                            </div>
                            <!-- ./card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Student</th>
                                        <th>Exam</th>
                                        <th>Score</th>
                                        <th>Date_Submit</th>
                                        <th>Time_taken</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($results as $result)
{{--                                        <tr data-widget="expandable-table" aria-expanded="false">--}}
                                        <tr>
                                            <td>#{{ $loop->index + 1 }}</td>
                                            <td>{{ $result->Enrollment->User->name }}</td>
                                            <td>{{ $result->Enrollment->Exam->exam_name }}</td>
                                            <td>{{ $result->score }}</td>
                                            <td>{{ $result->created_at }}</td>
                                            <td>{{ $result->time_taken }}</td>
                                            <td>{!! $result->getStatus() !!}</td>
                                            <td>
                                                <a href="admin/result-details/{{ $result->id }}" class="btn btn-outline-info">Details</a>
                                            </td>
                                        </tr>
{{--                                        <tr class="expandable-body">--}}
{{--                                            <td colspan="10">--}}
{{--                                                <p>--}}
{{--                                                    Exam is purchase at: {{ $result->updated_at }}--}}
{{--                                                </p>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Student</th>
                                        <th>Exam</th>
                                        <th>Score</th>
                                        <th>Date_Submit</th>
                                        <th>Time_taken</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Striped Full Width Table</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Task</th>
                                        <th>Progress</th>
                                        <th style="width: 40px">Label</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Sold 100 orders</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-danger">{{ $results->count()*100/100 }}%</span></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Clean database</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-warning" style="width: 70%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-warning">70%</span></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Cron job running</td>
                                        <td>
                                            <div class="progress progress-xs progress-striped active">
                                                <div class="progress-bar bg-primary" style="width: 30%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">30%</span></td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Fix and squish bugs</td>
                                        <td>
                                            <div class="progress progress-xs progress-striped active">
                                                <div class="progress-bar bg-success" style="width: 90%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">90%</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Expandable Table Tree</h3>
                            </div>
                            <!-- ./card-header -->
                            <div class="card-body p-0">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <td class="border-0">183</td>
                                    </tr>
                                    <tr data-widget="expandable-table" aria-expanded="true">
                                        <td>
                                            <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                            219
                                        </td>
                                    </tr>
                                    <tr class="expandable-body">
                                        <td>
                                            <div class="p-0">
                                                <table class="table table-hover">
                                                    <tbody>
                                                    <tr data-widget="expandable-table" aria-expanded="false">
                                                        <td>
                                                            <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                            219-1
                                                        </td>
                                                    </tr>
                                                    <tr class="expandable-body">
                                                        <td>
                                                            <div class="p-0">
                                                                <table class="table table-hover">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>219-1-1</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>219-1-2</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>219-1-3</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr data-widget="expandable-table" aria-expanded="false">
                                                        <td>
                                                            <button type="button" class="btn btn-primary p-0">
                                                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                            </button>
                                                            219-2
                                                        </td>
                                                    </tr>
                                                    <tr class="expandable-body">
                                                        <td>
                                                            <div class="p-0">
                                                                <table class="table table-hover">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>219-2-1</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>219-2-2</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>219-2-3</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>219-3</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>657</td>
                                    </tr>
                                    <tr>
                                        <td>175</td>
                                    </tr>
                                    <tr>
                                        <td>134</td>
                                    </tr>
                                    <tr>
                                        <td>494</td>
                                    </tr>
                                    <tr>
                                        <td>832</td>
                                    </tr>
                                    <tr>
                                        <td>982</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")
    @include("components.admin.embedded.table_script")
@endsection
