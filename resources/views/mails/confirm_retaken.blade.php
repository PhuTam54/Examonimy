<h1>Your request to retaken {{ $retakenEnrollment->Exam->exam_name }} has been confirmed. <br>
    Now you can take this exam again. Thank you! </h1>
<p>ID: {{ $retakenEnrollment->id }}</p>
<p>Student: {{ $retakenEnrollment->User->name }}</p>
<p>Exam: {{ $retakenEnrollment->Exam->exam_name }}</p>
<p>Status: {{ $retakenEnrollment->status }}</p>
<p>Attempt: {{ $retakenEnrollment->attempt }}</p>
