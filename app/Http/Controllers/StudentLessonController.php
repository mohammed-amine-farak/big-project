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
        $student = 17;
        

        // =========================================================
        // 1. جلب جميع المواد (للقائمة المنسدلة)
        // =========================================================
        $subjects = Subject::all();

        // =========================================================
        // 2. التحقق من اختيار المادة
        // =========================================================
        $selectedSubjectId = $request->input('subject_id');
        
        if (!$selectedSubjectId) {
            return view('student-dashboard.lesson.index', [
                'subjects' => $subjects,
                'lessonsWithProgress' => [],
                'totalLessons' => 0,
                'completedLessons' => 0,
                'inProgressLessons' => 0,
                'notStartedLessons' => 0,
                'lastLessonProgress' => null,
                'selectedSubjectId' => null
            ]);
        }

        // =========================================================
        // 3. جلب الدروس الخاصة بالمادة المختارة فقط
        // =========================================================
        $allLessons = lessonss::with(['subject', 'rules.content_blocks'])
            ->where('subject_id', $selectedSubjectId)
            ->orderBy('id')
            ->get();

        // =========================================================
        // 4. جلب تقدم الطالب في كل درس
        // =========================================================
        $lessonProgress = StudentLessonProgress::where('student_id', $student)
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->get()
            ->keyBy('lesson_id');

        $contentProgress = StudentContentProgress::where('student_id', $student)
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->get()
            ->keyBy(function($item) {
                return $item->lesson_id . '_' . $item->content_block_id;
            });

        // =========================================================
        // 5. إضافة التقدم لكل درس (بدون نظام قفل/فتح)
        // =========================================================
        $lessonsWithProgress = [];

        foreach ($allLessons as $lesson) {
            $progress = $lessonProgress->get($lesson->id);
            
            if ($progress) {
                // يوجد تقدم سابق
                $progressPercentage = $progress->progress;
                $status = $progress->completed ? 'completed' : 'in_progress';
                $lastAccessed = $progress->last_accessed_at;
            } else {
                // لم يبدأ بعد
                $progressPercentage = 0;
                $status = 'not_started';
                $lastAccessed = null;
            }

            // حساب تفاصيل المحتوى (للتقدم)
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
                'created_at' => $lesson->created_at
            ];
        }

        // =========================================================
        // 6. إحصائيات
        // =========================================================
        $totalLessons = count($allLessons);
        $completedLessons = count(array_filter($lessonsWithProgress, fn($item) => $item['status'] === 'completed'));
        $inProgressLessons = count(array_filter($lessonsWithProgress, fn($item) => $item['status'] === 'in_progress'));
        $notStartedLessons = count(array_filter($lessonsWithProgress, fn($item) => $item['status'] === 'not_started'));

        // =========================================================
        // 7. آخر درس شاهده الطالب
        // =========================================================
        $lastLessonProgress = StudentLessonProgress::where('student_id', $student)
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
            'selectedSubjectId'
        ));
    }
         public function show(lessonss $lesson)
    {
        $student = 17;
        
        
        // تحميل جميع العلاقات المطلوبة
        $lesson->load([
            'subject',
            'researcher',
            'rules' => function($query) {
                $query->orderBy('id');
            },
            'rules.content_blocks' => function($query) {
                $query->orderBy('block_order', 'asc');
            },
            'rules.content_blocks.video'
        ]);

        return view('student-dashboard.lesson.show', compact('lesson'));
    }
}