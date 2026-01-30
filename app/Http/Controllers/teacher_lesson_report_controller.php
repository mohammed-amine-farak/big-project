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
        $teacherId = Auth::user()->teacher->id ?? 12; // Fallback for testing
        
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
    $teacherId = Auth::user()->teacher->id ?? 12;
    
    // Get lessons with their researchers
    $lessons = lessonss::with('researcher')->get();
    
    // Get classrooms
    $classrooms = classroom::all();
    
    return view('teacher-dashboard.teacher_lesson_report.create', compact(
        'lessons',
        'classrooms'
    ));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'lesson_id' => 'required|exists:lessonss,id',
        'classroom_id' => 'nullable|exists:classrooms,id',
       'problem_type' => 'required|in:content_issue,difficulty_level,technical_issue,language_issue,other',
        'priority' => 'required|in:low,medium,high,critical',
        'suggested_solution' => 'nullable|string',
    ]);

    $teacherId = Auth::user()->teacher->id ?? 12;

    // Get researcher_id from the selected lesson
    $lesson = lessonss::find($validated['lesson_id']);
    $researcherId = $lesson->researcher_id ?? null;

    lesson_report::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'lesson_id' => $validated['lesson_id'],
        'classroom_id' => $validated['classroom_id'] ?? null,
        'researcher_id' => $researcherId,
        'teacher_id' => $teacherId,
        'problem_type' => $validated['problem_type'],
        'priority' => $validated['priority'],
        'suggested_solution' => $validated['suggested_solution'] ?? null,
        'status' => 'pending',
        'reported_at' => now(),
    ]);

    return redirect()->route('lesson_report')
        ->with('success', 'تم إرسال التقرير بنجاح');
}
}