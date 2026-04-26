<?php

namespace App\Http\Controllers;
use App\Models\lessonss;
use App\Models\StudentLessonProgress;
use App\Models\StudentContentProgress;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentLessonController extends Controller
{
    

    public function index(Request $request)
{
    $studentId = Auth::user()->id; // In production, use: auth()->id()
    
    // =========================================================
    // 1. Get student's enrolled classrooms with their subjects
    // =========================================================
    $studentClassrooms = DB::table('classrooms')
        ->join('teachers', 'classrooms.teacher_id', '=', 'teachers.id')
        ->join('users', 'users.id', '=', 'teachers.id')
        ->join('subjects', 'subjects.id', '=', 'classrooms.subject_id')
        ->join('fields_of_studies', 'subjects.fields_id', '=', 'fields_of_studies.id')
        ->join('student_classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
        ->join('students', 'students.id', '=', 'student_classrooms.student_id')
        ->where('students.id', $studentId)
       
         
        ->select(
            'classrooms.id as classroom_id',
            'classrooms.class_name',
            'subjects.id as subject_id',
            'subjects.name as subject_name',
            'fields_of_studies.name as field_name',
            'fields_of_studies.study_level',
            'users.name as teacher_name'
        )
        ->get();

    // Get unique subjects from student's classrooms
    $availableSubjectIds = $studentClassrooms->pluck('subject_id')->unique();
    
    // Get subjects for dropdown (only subjects the student is enrolled in)
    $subjects = Subject::whereIn('id', $availableSubjectIds)->get();

    // =========================================================
    // 2. Check if subject is selected
    // =========================================================
    $selectedSubjectId = $request->input('subject_id');
    
    if (!$selectedSubjectId || !$availableSubjectIds->contains($selectedSubjectId)) {
        return view('student-dashboard.lesson.index', [
            'subjects' => $subjects,
            'lessonsWithProgress' => [],
            'totalLessons' => 0,
            'completedLessons' => 0,
            'inProgressLessons' => 0,
            'notStartedLessons' => 0,
            'lastLessonProgress' => null,
            'selectedSubjectId' => null,
            'studentClassrooms' => $studentClassrooms
        ]);
    }

    // =========================================================
    // 3. Get lessons for the selected subject only
    // =========================================================
    $allLessons = lessonss::with(['subject', 'rules.content_blocks'])
        ->where('subject_id', $selectedSubjectId)
        ->orderBy('id')
        ->get();

    // If no lessons exist for this subject
    if ($allLessons->isEmpty()) {
        return view('student-dashboard.lesson.index', [
            'subjects' => $subjects,
            'lessonsWithProgress' => [],
            'totalLessons' => 0,
            'completedLessons' => 0,
            'inProgressLessons' => 0,
            'notStartedLessons' => 0,
            'lastLessonProgress' => null,
            'selectedSubjectId' => $selectedSubjectId,
            'studentClassrooms' => $studentClassrooms
        ])->with('warning', 'No lessons available for this subject yet.');
    }

    // =========================================================
    // 4. Get student progress for these lessons
    // =========================================================
    $lessonProgress = StudentLessonProgress::where('student_id', $studentId)
        ->whereIn('lesson_id', $allLessons->pluck('id'))
        ->get()
        ->keyBy('lesson_id');

    $contentProgress = StudentContentProgress::where('student_id', $studentId)
        ->whereIn('lesson_id', $allLessons->pluck('id'))
        ->get()
        ->keyBy(function($item) {
            return $item->lesson_id . '_' . $item->content_block_id;
        });

    // =========================================================
    // 5. Add progress data to each lesson
    // =========================================================
    $lessonsWithProgress = [];

    foreach ($allLessons as $lesson) {
        $progress = $lessonProgress->get($lesson->id);
        
        if ($progress) {
            $progressPercentage = $progress->progress;
            $status = $progress->completed ? 'completed' : 'in_progress';
            $lastAccessed = $progress->last_accessed_at;
        } else {
            $progressPercentage = 0;
            $status = 'not_started';
            $lastAccessed = null;
        }

        // Calculate content progress
        $totalContent = 0;
        $completedContent = 0;

        foreach ($lesson->rules as $rule) {
            foreach ($rule->content_blocks as $block) {
                $totalContent++;
                $contentKey = $lesson->id . '_' . $block->id;
                if (isset($contentProgress[$contentKey]) && $contentProgress[$contentKey]->completed) {
                    $completedContent++;
                }
            }
        }
        
        // Get classroom info for this subject (which classroom the student is in)
        $classroomInfo = $studentClassrooms->firstWhere('subject_id', $lesson->subject_id);

        $lessonsWithProgress[] = [
            'id' => $lesson->id,
            'title' => $lesson->title,
            'subject' => $lesson->subject,
            'description' => $lesson->content,
            'status' => $status,
            'progress' => $progressPercentage,
            'total_content' => $totalContent,
            'completed_content' => $completedContent,
            'last_accessed' => $lastAccessed,
            'created_at' => $lesson->created_at,
            'classroom_name' => $classroomInfo ? $classroomInfo->class_name : null,
            'teacher_name' => $classroomInfo ? $classroomInfo->teacher_name : null
        ];
    }

    // =========================================================
    // 6. Statistics
    // =========================================================
    $totalLessons = count($allLessons);
    $completedLessons = count(array_filter($lessonsWithProgress, fn($item) => $item['status'] === 'completed'));
    $inProgressLessons = count(array_filter($lessonsWithProgress, fn($item) => $item['status'] === 'in_progress'));
    $notStartedLessons = count(array_filter($lessonsWithProgress, fn($item) => $item['status'] === 'not_started'));

    // =========================================================
    // 7. Last lesson viewed by student
    // =========================================================
    $lastLessonProgress = StudentLessonProgress::where('student_id', $studentId)
        ->whereIn('lesson_id', $allLessons->pluck('id'))
        ->with('lesson')
        ->orderBy('updated_at', 'desc')
        ->first();

    return view('student-dashboard.lesson.index', compact(
        'subjects',
        'lessonsWithProgress',
        'totalLessons',
        'completedLessons',
        'inProgressLessons',
        'notStartedLessons',
        'lastLessonProgress',
        'selectedSubjectId',
        'studentClassrooms'
    ));
}
     public function show(lessonss $lesson)
{
    $student =  Auth::user()->id;
    
    // تحميل جميع العلاقات المطلوبة
    $lesson->load([
        'subject',
        'researcher',
        'exams', // ✅ Add this to load the exam relationship
        'rules' => function($query) {
            $query->orderBy('id');
        },
        'rules.content_blocks' => function($query) {
            $query->orderBy('block_order', 'asc');
        },
        'rules.content_blocks.video',
        'rules.content_blocks.exerciseSolution',
        'exams.questions', // ✅ Optional: load questions with the exam
        'exams.questions.choices' // ✅ Optional: load choices for each question
    ]);
   
    
    return view('student-dashboard.lesson.show', compact('lesson'));
}
}