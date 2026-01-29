<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use Illuminate\Http\Request;
use App\Models\lesson_report;
use App\Models\lessonss;
use App\Models\Researchers;
use App\Models\teacher;
use App\Models\teacher_reports;
use Illuminate\Support\Facades\Auth;

class teacher_lesson_report_controller extends Controller
{
    public function index(Request $request)
    {
        // Get teacher ID from authenticated user
        $teacherId = Auth::user()->teacher->id ?? 2; // Fallback for testing
        
        // Start query - get reports for this teacher
        $query = lesson_report::with(['lesson', 'teacher.user', 'classroom', 'researcher.user'])
            ->where('teacher_id', $teacherId);
        
        // Apply ONLY the specified filters
        if ($request->filled('researcher_id')) {
            $query->where('researcher_id', $request->researcher_id);
        }

        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('problem_type')) {
            $query->where('problem_type', $request->problem_type);
        }

        $reports = $query->latest()->paginate(10);

        // Get researchers for filter dropdown (researchers related to this teacher's reports)
        $researcherIds = lesson_report::where('teacher_id', $teacherId)
            ->pluck('researcher_id')
            ->unique()
            ->filter()
            ->values();
        
        $researchers = Researchers::whereIn('id', $researcherIds)->get();

        // Get lessons for filter dropdown (lessons related to this teacher's reports)
        $lessonIds = lesson_report::where('teacher_id', $teacherId)
            ->pluck('lesson_id')
            ->unique()
            ->filter()
            ->values();
        
        $lessons = lessonss::whereIn('id', $lessonIds)->get();

        // Get unique problem types from this teacher's reports
        $problemTypes = lesson_report::where('teacher_id', $teacherId)
            ->distinct('problem_type')
            ->pluck('problem_type')
            ->filter()
            ->values();

        return view('teacher-dashboard.teacher_lesson_report.index', compact(
            'reports',
            'researchers',
            'lessons',
            'problemTypes'
        ));
        
    }
    public function create()
{
    // Get teacher ID
    $teacherId = Auth::user()->teacher->id ?? 2;
    
    // Get lessons taught by this teacher
    $lessons = lessonss::all(); // Or filter by teacher if you have that relationship
    
    // Get classrooms taught by this teacher
    $classrooms = classroom::all(); // Or filter by teacher if you have that relationship
    
    // Get all researchers for dropdown (will be filtered by JavaScript based on lesson selection)
    $researchers = Researchers::with('user')->get();
    
    return view('teacher-dashboard.teacher_lesson_report.create', compact(
        'lessons',
        'classrooms',
        'researchers'
    ));
}

// Add this method to get researcher by lesson (for AJAX)
public function getResearcherByLesson($lessonId)
{
    $lesson = lessonss::with('researcher.user')->find($lessonId);
    
    if ($lesson && $lesson->researcher) {
        return response()->json([
            'success' => true,
            'researcher' => [
                'id' => $lesson->researcher->id,
                'name' => $lesson->researcher->user->name ?? 'باحث',
                'email' => $lesson->researcher->user->email ?? ''
            ]
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'لا يوجد باحث مسؤول عن هذا الدرس'
    ]);
}
}