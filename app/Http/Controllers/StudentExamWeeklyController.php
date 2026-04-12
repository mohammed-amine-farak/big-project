<?php

namespace App\Http\Controllers;

use App\Models\exam_schol_weeckly_report;
use Illuminate\Http\Request;
use App\Models\ExamScholWeeklyReport;
use Illuminate\Support\Facades\Auth;

class StudentExamWeeklyController extends Controller
{
    /**
     * Display exam reports for the authenticated student
     */
   public function index(Request $request)
    {
        $studentId = 17;
        
        $query = exam_schol_weeckly_report::where('student_id', $studentId)
            ->with(['examWeeckly', 'teacher.user']);
        
        // Filter by exam
        if ($request->filled('exam_weecklies_id')) {
            $query->where('exam_weeklies_id', $request->exam_weeklies_id);
        }
        
        $reports = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get statistics (based on 20/20 system)
        $totalReports = $reports->total();
        $averagePoints = $reports->avg('exam_total_point') ?? 0;
        $bestScore = $reports->max('exam_total_point') ?? 0;
        $totalPoints = $reports->sum('exam_total_point');
        
        // Get exams list for filter
        $exams = exam_schol_weeckly_report::where('student_id', $studentId)
            ->with('examWeeckly')
            ->get()
            ->pluck('examWeeckly')
            ->unique();
        
        return view('student-dashboard.exam_weekly_reports.index', compact(
            'reports', 'totalReports', 'averagePoints', 
            'bestScore', 'totalPoints', 'exams'
        ));
    }
    
    /**
     * Show a single exam report
     */
    public function show(exam_schol_weeckly_report $exam_weekly_report)
    {
        // Ensure student can only see their own reports
        if ($exam_weekly_report->student_id != 17) {
            abort(403, 'غير مصرح لك بمشاهدة هذا التقرير');
        }
        
        $report = $exam_weekly_report->load(['examWeeckly', 'teacher.user']);
        
        return view('student-dashboard.exam_weekly_reports.show', compact('report'));
 
        }

        
}