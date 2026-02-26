<?php
// app/Http/Controllers/TeacherDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\exam_weeckly;
use App\Models\student_psychology;
use App\Models\lesson_report;
use App\Models\exam_schol_weeckly_report;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::user()->id; // Replace with auth()->id() in production
        
        // ========== STATS CARDS ==========
        // Total students in teacher's classrooms
        $totalStudents = DB::table('students')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id', $teacherId)
            ->distinct('students.id')
            ->count('students.id');
        
        // New students this month
        $newStudentsThisMonth = DB::table('students')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id', $teacherId)
            ->whereMonth('student_classrooms.created_at', Carbon::now()->month)
            ->distinct('students.id')
            ->count('students.id');
        
        // Total classrooms
        $totalClassrooms = Classroom::where('teacher_id', $teacherId)->count();
        $activeClassrooms = Classroom::where('teacher_id', $teacherId)
            ->whereHas('students')
            ->count();
        
        // Total exams
        $totalExams = exam_weeckly::whereHas('classroom', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->count();
        
        $examsThisMonth = exam_weeckly::whereHas('classroom', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->whereMonth('created_at', Carbon::now()->month)->count();
        
        // Total reports
        $totalReports = exam_schol_weeckly_report::where('teacher_id', $teacherId)->count();
        $pendingReports = exam_schol_weeckly_report::where('teacher_id', $teacherId)
            ->where('status', '!=', 'send')
            ->count();
        
        // ========== CHART DATA ==========
        // Performance chart data (last 30 days)
        $performanceLabels = [];
        $performanceData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $performanceLabels[] = $date->format('d/m');
            
            $avgScore = exam_schol_weeckly_report::where('teacher_id', $teacherId)
                ->whereDate('created_at', $date)
                ->avg('exam_total_point');
            
            $performanceData[] = $avgScore ? round($avgScore * 5) : rand(70, 95); // Convert to percentage
        }
        
        // Reports status
        $draftReports = student_psychology::where('teacher_id', $teacherId)
            ->where('status', 'مسودة')
            ->count();
        $sentReports = student_psychology::where('teacher_id', $teacherId)
            ->where('status', 'مرسل_للإدارة')
            ->count();
        $respondedReports = 3; // You can add this logic later
        
        // Mood distribution
        $moodData = [
            student_psychology::where('teacher_id', $teacherId)->where('mood', 'مبتهج')->count(),
            student_psychology::where('teacher_id', $teacherId)->where('mood', 'هادئ')->count(),
            student_psychology::where('teacher_id', $teacherId)->where('mood', 'قلق')->count(),
            student_psychology::where('teacher_id', $teacherId)->where('mood', 'حزين')->count(),
            student_psychology::where('teacher_id', $teacherId)->where('mood', 'غاضب')->count(),
            student_psychology::where('teacher_id', $teacherId)->where('mood', 'متحمس')->count(),
        ];
        
        // Lesson report types
        $lessonReportData = [
            lesson_report::where('teacher_id', $teacherId)->where('problem_type', 'content_issue')->count(),
            lesson_report::where('teacher_id', $teacherId)->where('problem_type', 'difficulty_level')->count(),
            lesson_report::where('teacher_id', $teacherId)->where('problem_type', 'technical_issue')->count(),
            lesson_report::where('teacher_id', $teacherId)->where('problem_type', 'language_issue')->count(),
            lesson_report::where('teacher_id', $teacherId)->where('problem_type', 'other')->count(),
        ];
        
        // ========== RECENT ACTIVITY ==========
        $recentExams = exam_weeckly::with('classroom')
            ->whereHas('classroom', fn($q) => $q->where('teacher_id', $teacherId))
            ->latest()
            ->take(5)
            ->get();
        
        $recentPsychologyReports = student_psychology::with('student.user')
            ->where('teacher_id', $teacherId)
            ->latest()
            ->take(5)
            ->get();
        
        $recentLessonReports = lesson_report::with('lesson')
            ->where('teacher_id', $teacherId)
            ->latest()
            ->take(5)
            ->get();
        
        return view('teacher-dashboard.dashboard.index', compact(
            'totalStudents',
            'newStudentsThisMonth',
            'totalClassrooms',
            'activeClassrooms',
            'totalExams',
            'examsThisMonth',
            'totalReports',
            'pendingReports',
            'performanceLabels',
            'performanceData',
            'draftReports',
            'sentReports',
            'respondedReports',
            'moodData',
            'lessonReportData',
            'recentExams',
            'recentPsychologyReports',
            'recentLessonReports'
        ));
    }
}