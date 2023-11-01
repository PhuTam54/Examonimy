<?php
// ADMIN
Route::controller(\App\Http\Controllers\Admin\AdminController::class)->group(function () {
    Route::get('/admin-dashboard', "dashboard");

    // Exams
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

    // Results
    Route::get('/admin-result', "result");

    Route::get('/result-add', "resultAdd");
    Route::post('/result-add', "resultStore");

    Route::get('/result-edit/{result}', "resultEdit");
    Route::put('/result-edit/{result}', "resultUpdate");

    Route::delete('/result-delete/{result}', "resultDelete");

    // Enrollments
    Route::get('/admin-enrollment', "enrollment");

    Route::get('/enrollment-confirm/{enrollment}', "enrollmentConfirm");

    Route::get('/enrollment-cancel/{enrollment}', "enrollmentCancel");

    Route::delete('/enrollment-delete/{enrollment}', "enrollmentDelete");

    // Users
    Route::get('/admin-user', "user");

    Route::get('/user-add', "userAdd");
    Route::post('/user-add', "userStore");

    Route::get('/user-edit/{user}', "userEdit");
    Route::put('/user-edit/{user}', "userUpdate");

    Route::delete('/user-delete/{user}', "userDelete");

    // Questions
    Route::get('/admin-question', "question");

    Route::get('/question-add', "questionAdd");
    Route::post('/question-add', "questionStore");
        // excel
    Route::post('/import-qna', "importQna")->name('importQna');

    Route::get('/question-edit/{question}', "questionEdit");
    Route::put('/question-edit/{question}', "questionUpdate");

    Route::delete('/question-delete/{question}', "questionDelete");

    // Answers
    Route::get('/admin-answer', "answer");

    Route::get('/answer-add', "answerAdd");
    Route::post('/answer-add', "answerStore");

    Route::get('/answer-edit/{answer}', "answerEdit");
    Route::put('/answer-edit/{answer}', "answerUpdate");

    Route::delete('/answer-delete/{answer}', "answerDelete");

    // Subjects
    Route::get('/admin-subject', "subject");
    Route::get('/subject-details/{subject}', "subjectDetails");

    Route::get('/subject-add', "subjectAdd");
    Route::post('/subject-add', "subjectStore");

    Route::get('/subject-edit/{subject}', "subjectEdit");
    Route::put('/subject-edit/{subject}', "subjectUpdate");

    Route::delete('/subject-delete/{subject}', "subjectDelete");

    // Attendances
    Route::get('/admin-attendance', "attendance");

    Route::get('/attendance-add', "attendanceAdd");
    Route::post('/attendance-add', "attendanceStore");

    Route::get('/attendance-edit/{attendance}', "attendanceEdit");
    Route::put('/attendance-edit/{attendance}', "attendanceUpdate");

    Route::delete('/attendance-delete/{attendance}', "attendanceDelete");

    // Courses
    Route::get('/admin-courses', "courses");

    Route::get('/course-add', "courseAdd");
    Route::post('/course-add', "courseStore");

    Route::get('/course-edit/{course}', "courseEdit");
    Route::put('/course-edit/{course}', "courseUpdate");

    Route::delete('/course-delete/{course}', "courseDelete");

    // classes
    Route::get('/admin-classroom', "classroom");

    Route::get('/classroom-add', "classroomAdd");
    Route::post('/classroom-add', "classestore");

    Route::get('/classroom-edit/{classroom}', "classroomEdit");
    Route::put('/classroom-edit/{classroom}', "classroomUpdate");

    Route::delete('/classroom-delete/{classroom}', "classroomDelete");

});
