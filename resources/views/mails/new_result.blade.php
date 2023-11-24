<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div>{{ $result->note }}</div>
                        <br>
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Student</th>
                                <th>Exam</th>
                                <th>Score</th>
                                <th>Time_taken</th>
                                <th>Grade</th>
                                <th>Date_Submit</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $result->Enrollment->User->name }} -- </td>
                                    <td>{{ $result->Enrollment->Exam->exam_name }} -- </td>
                                    <td>
                                        {{ number_format($result->score, 2) }} / {{  number_format($result->Enrollment->Exam->ExamQuestion->total_marks, 2) }} --</td>
                                    @if($result->time_taken / 3600 > 1)
                                        <td>
                                            {{ floor($result->time_taken / 3600) }} hours
                                            {{ floor($result->time_taken % 3600 / 60) }} minutes
                                            {{ $result->time_taken % 60 }} seconds --
                                        </td>
                                    @elseif(($result->time_taken % 3600) / 60 > 1)
                                        <td>
                                            {{ floor($result->time_taken % 3600 / 60) }} minutes
                                            {{ $result->time_taken % 60 }} seconds --
                                        </td>
                                    @elseif($result->time_taken % 60 > 1)
                                        <td>
                                            {{ $result->time_taken % 60 }} seconds --
                                        </td>
                                    @endif
                                    <td>{!! $result->getGrade() !!} -- </td>
                                    <td>{{ $result->created_at }} -- </td>
                                    <td>{!! $result->getStatus() !!}</td>
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
