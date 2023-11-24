<?php
// ADMIN
Route::controller(\App\Http\Controllers\Admin\AdminController::class)->group(function () {
    Route::get('/admin-dashboard', "dashboard");
});

// Exams
Route::controller(\App\Http\Controllers\Admin\AdminExamController::class)->group(function () {
    Route::get('/admin-exam', "exam");
    Route::get('/exam-details/{exam}', "examDetails");

    Route::get('/exam-add', "examAdd");
    Route::post('/exam-add', "examStore");

    Route::get('/exam-edit/{exam}', "examEdit");
    Route::put('/exam-edit/{exam}', "examUpdate");

    Route::delete('/exam-delete/{exam}', "examDelete");

    Route::get('/exam-confirm/{exam}', "examConfirm");
    Route::get('/exam-cancel/{exam}', "examCancel");

    Route::get('/exam-trash', "examTrash");
    Route::get('/exam-recover/{exam}', "examRecover");
});

// ExamQuestions
Route::controller(\App\Http\Controllers\Admin\AdminExamQuestionController::class)->group(function () {
    Route::get('/admin-examquestion', "examquestion");
    Route::get('/examquestion-details/{examquestion}', "examquestionDetails");

    Route::get('/examquestion-add', "examquestionAdd");
    Route::post('/examquestion-add', "examquestionStore");

    Route::get('/examquestion-edit/{examquestion}', "examquestionEdit");
    Route::put('/examquestion-edit/{examquestion}', "examquestionUpdate");

    Route::delete('/examquestion-delete/{examquestion}', "examquestionDelete");

    Route::get('/examquestion-confirm/{examquestion}', "examquestionConfirm");
    Route::get('/examquestion-cancel/{examquestion}', "examquestionCancel");

    Route::get('/examquestion-trash', "examquestionTrash");
    Route::get('/examquestion-recover/{examquestion}', "examquestionRecover");

    Route::post('/examquestion-add-question', "examQuestionAddQuestion");
    Route::post('/examquestion-delete-question/{question}', "examQuestionDeleteQuestion");
});

// Results
Route::controller(\App\Http\Controllers\Admin\AdminResultController::class)->group(function () {
    Route::get('/admin-result', "result");

    Route::get('/result-add', "resultAdd");
    Route::post('/result-add', "resultStore");

    Route::get('/result-edit/{result}', "resultEdit");
    Route::put('/result-edit/{result}', "resultUpdate");

    Route::delete('/result-delete/{result}', "resultDelete");

    Route::get('/result-trash', "resultTrash");
    Route::get('/result-recover/{result}', "resultRecover");

    Route::get('/result-approve/{result}', "resultApprove");
    Route::get('/result-decline/{result}', "resultDecline");
});

// Enrollments
Route::controller(\App\Http\Controllers\Admin\AdminEnrollmentController::class)->group(function () {
    Route::get('/admin-enrollment', "enrollment");

    Route::get('/enrollment-confirm/{enrollment}', "enrollmentConfirm");

    Route::get('/enrollment-cancel/{enrollment}', "enrollmentCancel");

    Route::delete('/enrollment-delete/{enrollment}', "enrollmentDelete");

    Route::get('/enrollment-trash', "enrollmentTrash");
    Route::get('/enrollment-recover/{enrollment}', "enrollmentRecover");
});

// Users
Route::controller(\App\Http\Controllers\Admin\AdminUserController::class)->group(function () {
    Route::get('/admin-user', "user");

    Route::get('/user-add', "userAdd");
    Route::post('/user-add', "userStore");

    Route::get('/user-edit/{user}', "userEdit");
    Route::put('/user-edit/{user}', "userUpdate");

    Route::delete('/user-delete/{user}', "userDelete");

    Route::get('/user-trash', "userTrash");
    Route::get('/user-recover/{user}', "userRecover");
});

// Questions
Route::controller(\App\Http\Controllers\Admin\AdminQuestionController::class)->group(function () {
    Route::get('/admin-question', "question");

    Route::get('/question-add', "questionAdd");
    Route::post('/question-add', "questionStore");

    // EXCEL
    Route::post('/import-qna', "importQna")->name('importQna');

    Route::get('/question-edit/{question}', "questionEdit");
    Route::put('/question-edit/{question}', "questionUpdate");

    Route::delete('/question-delete/{question}', "questionDelete");

    Route::get('/question-trash', "questionTrash");
    Route::get('/question-recover/{question}', "questionRecover");
});

// Answers
Route::controller(\App\Http\Controllers\Admin\AdminController::class)->group(function () {
    Route::get('/admin-answer', "answer");

    Route::get('/answer-add', "answerAdd");
    Route::post('/answer-add', "answerStore");

    Route::get('/answer-edit/{answer}', "answerEdit");
    Route::put('/answer-edit/{answer}', "answerUpdate");

    Route::delete('/answer-delete/{answer}', "answerDelete");

    Route::get('/answer-trash', "answerTrash");
    Route::get('/answer-recover/{answer}', "answerRecover");
});

// Subjects
Route::controller(\App\Http\Controllers\Admin\AdminSubjectController::class)->group(function () {
    Route::get('/admin-subject', "subject");
    Route::get('/subject-details/{subject}', "subjectDetails");

    Route::get('/subject-add', "subjectAdd");
    Route::post('/subject-add', "subjectStore");

    Route::get('/subject-edit/{subject}', "subjectEdit");
    Route::put('/subject-edit/{subject}', "subjectUpdate");

    Route::delete('/subject-delete/{subject}', "subjectDelete");

    Route::get('/subject-trash', "subjectTrash");
    Route::get('/subject-recover/{subject}', "subjectRecover");
});

// Attendances
Route::controller(\App\Http\Controllers\Admin\AdminAttendanceController::class)->group(function () {
    Route::get('/admin-attendance', "attendance");

    Route::get('/attendance-add', "attendanceAdd");
    Route::post('/attendance-add', "attendanceStore");

    Route::get('/attendance-edit/{attendance}', "attendanceEdit");
    Route::put('/attendance-edit/{attendance}', "attendanceUpdate");

    Route::delete('/attendance-delete/{attendance}', "attendanceDelete");

    Route::get('/attendance-trash', "attendanceTrash");
    Route::get('/attendance-recover/{attendance}', "attendanceRecover");
});

// Courses
Route::controller(\App\Http\Controllers\Admin\AdminCourseController::class)->group(function () {
    Route::get('/admin-courses', "courses");

    Route::get('/course-add', "courseAdd");
    Route::post('/course-add', "courseStore");

    Route::get('/course-edit/{course}', "courseEdit");
    Route::put('/course-edit/{course}', "courseUpdate");

    Route::delete('/course-delete/{course}', "courseDelete");

    Route::get('/course-trash', "courseTrash");
    Route::put('/course-recover/{course}', "courseRecover");
});

// Classes
Route::controller(\App\Http\Controllers\Admin\AdminClassController::class)->group(function () {
    Route::get('/admin-classroom', "classroom");

    Route::get('/classroom-add', "classroomAdd");
    Route::post('/classroom-add', "classroomStore");

    Route::get('/classroom-edit/{classroom}', "classroomEdit");
    Route::put('/classroom-edit/{classroom}', "classroomUpdate");

    Route::delete('/classroom-delete/{classroom}', "classroomDelete");

    Route::get('/classroom-trash', "classroomTrash");
    Route::put('/classroom-recover/{classroom}', "classroomRecover");

    Route::post('/classroom-add-student', "classAddStudent");
    Route::post('/classroom-delete-student/{student}', "classDeleteStudent");
});
