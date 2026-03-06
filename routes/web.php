<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\rule_controller;
use App\Http\Controllers\ruleExampleController;
use App\Http\Controllers\exam_Controller;
use App\Http\Controllers\Progress_Controller;
use App\Http\Controllers\Interaction_Notes_student;
use App\Http\Controllers\Exam_grade_Controller;
use App\Http\Controllers\skille_level_Controller;
use App\Http\Controllers\exam_skills_level_Controller;
use App\Http\Controllers\exam_weeckly_Controller;
use App\Http\Controllers\teacher_report;
use App\Http\Controllers\admine_report_controller;
use App\Http\Controllers\ReseacherDashboardController;
use App\Http\Controllers\ResearcherProductionRequestController;
use App\Http\Controllers\StudentPsychologyController;
use App\Http\Controllers\teacher_admine_reports_view_Controller;
use App\Http\Controllers\teacher_lesson_controller;
use App\Http\Controllers\teacher_lesson_report_controller;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\VideoCreatorProductionRequestController;
use App\Models\content_blocks;
use App\Models\rules;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;




Route::middleware(['auth'])->group(function () {
    
    Route::get('/waiting-approval', function () {
        $user = auth::user();
        if ($user->account_status === 'approved') {
            return redirect()->route('dashboard');
        }
        return view('auth.waiting-approval');
    })->name('waiting.approval');
    
    Route::get('/rejected', function () {
        $user = auth::user();
        if ($user->account_status === 'approved') {
            return redirect()->route('dashboard');
        }
        return view('auth.rejected', [
            'reason' => $user->rejection_reason ?? 'لم يتم تحديد سبب'
        ]);
    })->name('rejected.notice');
});

// ===== الصفحات المحمية (تتطلب موافقة) =====
Route::middleware(['auth', 'check.status'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth::user();
        return redirect()->route($user->user_type . '.dashboard');
    })->name('dashboard');
    
    // Routes المعلم
     Route::prefix('teacher')->name('teacher.')->group(function () {
        // ✅ هذا هو المسار الصحيح: teacher.dashboard
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])
             ->name('dashboard');
        
        // يمكنك إضافة المزيد من Routes المعلم هنا
        // Route::get('/students', [TeacherController::class, 'students'])->name('students');
        // Route::get('/classes', [TeacherController::class, 'classes'])->name('classes');
    });
    
    // Routes الباحث
    Route::prefix('researcher')->name('researcher.')->group(function () {
       Route::get('/dashboard', [ReseacherDashboardController::class, 'index'])
             ->name('dashboard');
    });
    
    // Routes أخرى...
    
   
});
 Route::get('/logout', function (Request $request) {
        auth::logout();
        request()->session()->invalidate();
request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
// routes/web.php
Route::get('/', function () {
    return view('welcome');
})->name('index');
 // هذا يستدعي routes Fortify






   Route::middleware(['user.type:researcher'])->group(function () {
       



Route::get('/exam/create', [exam_Controller::class, 'create'])->name('exam.create');
Route::post('/exam/store', [exam_Controller::class, 'store'])->name('exam.store');
Route::get('/exam/index', [exam_Controller::class, 'index'])->name('exam.index');

Route::get('/exam/show/{exam}', [exam_Controller::class, 'show'])->name('exam.show');
Route::delete('/exam/destroy/{exam}', [exam_Controller::class, 'destroy'])->name('exam.destroy');
Route::get('/exam/edit/{exam}', [exam_Controller::class, 'edit'])->name('exam.edit');


Route::put('/exam/update/{exam}', [exam_Controller::class, 'update'])->name('exam.update');



Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
Route::post('/lessons/store',[LessonController::class, 'store'])->name('lessons.store');
Route::get('/lessons/index',[LessonController::class, 'index'])->name('lessons.index');
Route::get('/lessons/update/{lessonID}',[LessonController::class, 'update'])->name('lessons.update');
Route::put('/lessons/edit/{lessonID}',[LessonController::class, 'edit'])->name('lessons.edit');
Route::delete('/lessons/delete/{lessonID}',[LessonController::class, 'destroy'])->name('lessons.delete');
Route::get('/lessons/show/{lesson}',[LessonController::class, 'show'])->name('lessons.show');
Route::get('/ProgressTracker',[LessonController::class, 'ProgressTracker'])->name('lessons.ProgressTracker');
Route::put('/ProgressTracker/update/{lesson}',[LessonController::class, 'updateStatus'])->name('lessons.updateStatus');
Route::get('/teacher_reports',[LessonController::class, 'teacher_reports'])->name('lessons.teacher_reports');
Route::get('/student_reports',[LessonController::class, 'student_reports'])->name('lessons.student_reports');
Route::get('/rules/create',[rule_controller::class, 'create'])->name('rules.create');
Route::post('/rules/store',[rule_controller::class, 'store'])->name('rules.store');
Route::get('/rules/index',[rule_controller::class, 'index'])->name('rules.index');
Route::delete('/rules/destroy/{rule}',[rule_controller::class, 'destroy'])->name('rules.destroy');
Route::get('/rules/update/{rule}',[rule_controller::class, 'update'])->name('rules.rule_update');
Route::put('/rules/edit/{rule}',[rule_controller::class, 'edit'])->name('rules.rule_edit');
Route::get('/rules/content/blocks/{rule}',[rule_controller::class, 'content_block_show'])->name('content_block.show');
 Route::get('/rules/content/create/{rule}', [rule_controller::class, 'create_rule_content'])->name('rules.content.create');
    Route::post('/rules/content/store/{rule}', [rule_controller::class, 'store_rule_content'])->name('rules.content.store');
Route::get('/{rule}/content/{contentBlock}/edit', [rule_controller::class, 'content_blocks_edit'])->name('rules.content.edit');
    Route::put('/{rule}/content/{contentBlock}/update', [rule_controller::class, 'content_blocks_update'])->name('rules.content.update');
Route::delete('/rules/{rule}/content/{contentBlock}', [rule_controller::class, 'content_blocks_destroy'])
     ->name('rules.content.destroy');



Route::get('/lesson-reports', [teacher_report::class, 'index'])->name('lesson-reports.index');
Route::get('/lesson-reports/{lesson_report}', [teacher_report::class, 'show'])->name('lesson-reports.show');
Route::put('/lesson-reports/{lesson_report}', [teacher_report::class, 'update'])->name('lesson-reports.update');

Route::get('/admine-reports', [admine_report_controller::class, 'index'])->name('admine_report.index');
Route::get('/admine-reports/{id}', [admine_report_controller::class, 'show'])->name('admine_report.show');
Route::put('/admin-reports/{id}/response', [admine_report_controller::class, 'updateResponse'])
->name('admin-reports.update-response');



Route::get('Exam_skill/create',[exam_skills_level_Controller::class, 'create'])->name('Exam_skill.create');
Route::get('Exam_skill/index',[exam_skills_level_Controller::class, 'index'])->name('Exam_skill.index');
Route::get('/exam-skills/{id}', [exam_skills_level_Controller::class, 'show'])->name('exam-skills.show');
Route::post('/get-skill-levels-by-exam', [exam_skills_level_Controller::class, 'getSkillLevelsByExam'])->name('get.skill.levels.by.exam');
Route::post('/exam-skills', [exam_skills_level_Controller::class, 'store'])->name('exam-skills.store');
Route::post('/exam-skills/delete/level/{exam_id}', [exam_skills_level_Controller::class, 'delete_level'])->name('exam-skills.delete_level');
Route::post('/exam-skills/delete/{exam_id}', [exam_skills_level_Controller::class, 'delete'])->name('exam-skills.delete');
Route::post('/exam-skills/add_to_exam_skills/{exam_id}', [exam_skills_level_Controller::class, 'add_to_exam_skills'])->name('exam-skills.add_to_exam_skills');




Route::get('/exam_weeckly',[exam_weeckly_Controller::class,'index'])->name('exam_weeckly.index');
Route::get('exam_weeklies/create', [exam_weeckly_Controller::class, 'create'])->name('exam_weeklies.create');
Route::post('exam_weeklies', [exam_weeckly_Controller::class, 'store'])->name('exam_weeklies.store');
Route::post('/get-classrooms-by-subject', [exam_weeckly_Controller::class, 'getClassroomsBySubject'])->name('get.classrooms.by.subject');
Route::get('/exam_weeklies/{id}/edit', [exam_weeckly_Controller::class, 'edit'])->name('exam_weeklies.edit');
Route::put('/exam_weeklies/{id}', [exam_weeckly_Controller::class, 'update'])->name('exam_weeklies.update');
Route::delete('/exam_weeklies/{id}', [exam_weeckly_Controller::class, 'destroy'])->name('exam_weeklies.destroy');




Route::get('skills/index',[skille_level_Controller::class,'index'])->name('skills.index');
Route::post('skills/store',[skille_level_Controller::class,'store'])->name('skills.store');

Route::get('skills/create',[skille_level_Controller::class,'create'])->name('skills.create');

Route::get('show_more_skills/{skills}',[skille_level_Controller::class,'show'])->name('show_more_skills.show');
Route::get('level/create/{id}',[skille_level_Controller::class,'create_level'])->name('create_level.create');
Route::post('level/store',[skille_level_Controller::class,'store_level'])->name('store_level');

Route::get('level/{id}/edit', [skille_level_Controller::class, 'edit_level'])->name('level.edit');
Route::put('level/{id}', [skille_level_Controller::class, 'update_level'])->name('level.update');
Route::delete('level/{id}', [skille_level_Controller::class, 'destroy_level'])->name('level.destroy');

// في routes/web.php
Route::get('skills/{id}/edit', [skille_level_Controller::class, 'edit'])->name('skills.edit');
Route::put('skills/{id}', [skille_level_Controller::class, 'update'])->name('skills.update');
Route::delete('skills/{id}', [skille_level_Controller::class, 'destroy'])->name('skills.destroy');


 Route::get('researcher/production-requests', 
        [ResearcherProductionRequestController::class, 'index'])
        ->name('researcher.production_requests.index');

 Route::get('researcher/production-requests/create', 
        [ResearcherProductionRequestController::class, 'create'])
        ->name('researcher.production_requests.create');

Route::post('researcher/production-requests/store', 
        [ResearcherProductionRequestController::class, 'store'])
        ->name('researcher.production_requests.store');

Route::get('/ajax/get-lesson-rules/{lessonId}', function($lessonId) {
    $rules = rules::where('lessons_id', $lessonId)
                 ->select('id', 'title')
                 ->orderBy('title')
                 ->get();
    
    return response()->json([
        'success' => true,
        'rules' => $rules
    ]);
});

Route::get('/ajax/get-rule-content-blocks/{ruleId}', function($ruleId) {
    $contentBlocks = content_blocks::where('rule_id', $ruleId)
                                 ->select('id', 'type', 'content')
                                 ->orderBy('block_order')
                                 ->get();
    
    return response()->json([
        'success' => true,
        'contentBlocks' => $contentBlocks
    ]);
});
    });





Route::middleware(['user.type:teacher'])->group(function () {


Route::get('/Interaction_Notes_student',[Interaction_Notes_student::class,'index'])->name('Interaction_Notes_student.index');
Route::get('/Interaction_Notes_student/create',[Interaction_Notes_student::class,'create'])->name('Interaction_Notes_student.create');
Route::post('/Interaction_Notes_student/store',[Interaction_Notes_student::class,'store'])->name('Interaction_Notes_student.store');
Route::put('/Interaction_Notes_student/{send}',[Interaction_Notes_student::class,'send'])->name('Interaction_Notes_student.send');
Route::delete('/Interaction_Notes_student/{delete}',[Interaction_Notes_student::class,'delete'])->name('Interaction_Notes_student.delete');
Route::get('/Interaction_Notes_student/{Interaction_Notes_students}',[Interaction_Notes_student::class,'update'])->name('Interaction_Notes_student.update');
Route::put('/Interaction_Notes_student/edit/{edit}',[Interaction_Notes_student::class,'edit'])->name('Interaction_Notes_student.edit');
// Interaction Notes AJAX Routes
Route::get('/ajax/get-classroom-students/{classroomId}', [Interaction_Notes_student::class, 'getClassroomStudentsAjax'])->name('ajax.get-classroom-students');

Route::get('/Exam_Grade/index',[Exam_grade_Controller::class,'index'])->name('Exam_Grade.index');
Route::get('/Exam_Grade/create',[Exam_grade_Controller::class,'create'])->name('Exam_Grade.create');
Route::post('/Exam_Grade/store',[Exam_grade_Controller::class,'store'])->name('Exam_Grade.store');
Route::get('/Exam_Grade/edit/{Exam_Grade}',[Exam_grade_Controller::class,'edit'])->name('Exam_Grade.edit');
Route::put('/Exam_Grade/update/{Exam_Grade}',[Exam_grade_Controller::class,'update'])->name('Exam_Grade.update');
Route::put('/Exam_Grade/update_status/{Exam_Grade}',[Exam_grade_Controller::class,'update_status'])->name('Exam_Grade.update_status');
Route::delete('/Exam_Grade/destroy/{Exam_Grade}',[Exam_grade_Controller::class,'destroy'])->name('Exam_Grade.destroy');
// Make sure these are ABOVE any catch-all routes
Route::prefix('ajax')->group(function () {
    Route::get('/get-classroom-data/{classroomId}', [Exam_grade_Controller::class, 'getClassroomDataAjax']);
    Route::get('/get-student-exams/{classroomId}/{studentId}', [Exam_grade_Controller::class, 'getStudentExamsAjax']);
    Route::get('/get-exam-skills/{examId}/{studentId}', [Exam_grade_Controller::class, 'getExamSkillsAjax']);
});
Route::get('/Exam_Grade/show/{Exam_Grade}',[Exam_grade_Controller::class,'show'])->name('Exam_Grade.show');
Route::get('/teacher/exams', [Exam_grade_Controller::class, 'examsList'])->name('teacher.exams.list');
 Route::get('/exams/{id}/view', [Exam_grade_Controller::class, 'viewExam'])->name('teacher.exams.view');




Route::get('/StudentPsychology',[StudentPsychologyController::class,'index'])->name('StudentPsychology.index');
Route::get('/StudentPsychology/{student_psychology}', [StudentPsychologyController::class, 'show'])
     ->name('StudentPsychology.show');
Route::put('/StudentPsychology/{student_psychology}/status', [StudentPsychologyController::class, 'updateStatus'])
     ->name('StudentPsychology.update-status');

Route::get('/StudentPsychology/{student_psychology}/edit', [StudentPsychologyController::class, 'edit'])
     ->name('StudentPsychology.edit');
Route::put('/StudentPsychology/{student_psychology}', [StudentPsychologyController::class, 'update'])
     ->name('StudentPsychology.update');
Route::get('/create', [StudentPsychologyController::class, 'create'])
     ->name('StudentPsychology.create');    
Route::post('/StudentPsychology', [StudentPsychologyController::class, 'store'])
     ->name('StudentPsychology.store');
Route::delete('/StudentPsychology/{student_psychology}', [StudentPsychologyController::class, 'destroy'])
     ->name('StudentPsychology.destroy');   

Route::get('/psychology-responses', [StudentPsychologyController::class, 'student_psychology_response'])->name('student_psychology_response');
Route::get('/psychology-responses/show/{response_admine}', [StudentPsychologyController::class, 'student_psychology_response_show'])->name('student_psychology_response_show');




Route::get('/teacher/lesson/report/index',[teacher_lesson_report_controller::class,'index'])->name('lesson_report');
Route::get('/teacher/lesson/report/create',[teacher_lesson_report_controller::class,'create'])->name('lesson_report.create');
Route::get('/ajax/get-researcher-by-lesson/{lessonId}', [teacher_lesson_report_controller::class, 'getResearcherByLesson'])
    ->name('ajax.researcher.by.lesson');
 Route::post('/lesson-reports', [teacher_lesson_report_controller::class, 'store'])
        ->name('lesson_reports.store');
Route::get('/teacher/lesson/report/{id}', [teacher_lesson_report_controller::class, 'show'])
        ->name('teacher_lesson_reports.show');
Route::delete('/teacher/lesson-reports/delete/{id}', 
    [teacher_lesson_report_controller::class, 'destroy'])
    ->name('lesson_reports.destroy');
// Edit and Update routes
Route::get('/teacher/lesson-reports/{id}/edit', 
    [teacher_lesson_report_controller::class, 'edit'])
    ->name('teacher.lesson_reports.edit');

Route::put('/teacher/lesson-reports/{id}', 
    [teacher_lesson_report_controller::class, 'update'])
    ->name('teacher.lesson_reports.update');




   Route::get('/teacher/admine/report/index',[teacher_admine_reports_view_Controller::class,'index'])->name('teacher_admine_reports.index');

   Route::get('/teacher/admine/report/show/{id}',[teacher_admine_reports_view_Controller::class,'show'])->name('teacher_admin_reports.show');


   Route::get('/teacher/lesson/index',[teacher_lesson_controller::class,'index'])->name('teacher_lesson.index');
Route::get('/teacher/lessons/show/{lesson}',[teacher_lesson_controller::class, 'show'])->name('teacher_lesson.show');

// routes/web.php

Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');



});


//video_creator




Route::get('/video_creator/production_request', [VideoCreatorProductionRequestController::class, 'index'])->name('video_creator.production_request');
Route::get('/video_creator/production_request/show/{productionRequest}', [VideoCreatorProductionRequestController::class,'show'])->name('video_creator.production_request.show');
 Route::get('/production-requests/{production_request}/accept', [VideoCreatorProductionRequestController::class, 'accept'])
        ->name('video_creator.production_requests.accept');
Route::get('/production-requests/{production_request}/upload', [VideoCreatorProductionRequestController::class, 'uploadForm'])
        ->name('video_creator.production_requests.upload');
    Route::post('/production-requests/{production_request}/upload-chunk', 
        [VideoCreatorProductionRequestController::class, 'uploadChunk'])
        ->name('production_requests.upload.chunk');

         Route::get('/production-requests/{production_request}/revise', 
        [VideoCreatorProductionRequestController::class, 'reviseForm'])
        ->name('video_creator.production_requests.revise');
 Route::post('/production-requests/{production_request}/revise-chunk', 
        [VideoCreatorProductionRequestController::class, 'reviseChunk'])
        ->name('video_creator.production_requests.revise.chunk');


   







/*
Route::get('about_us', function () {
    return view('about.about');
})->name('about');

//team
Route::get('team', function () {
    return view('team.index');
})->name('team');


Route::get('team.create', function () {
    return view('team.create');
})->name('team.create');
//

Route::get('student_dashboard', function () {
    return view('student_dashboard.index');
})->name('student_dashboard.index');

Route::get('login', function () {
    return view('auth.login');
})->name('login');


Route::get('our_project', function () {
    return view('our_project.index');
})->name('project.index');


**/
