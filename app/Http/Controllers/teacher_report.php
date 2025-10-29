<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lesson_report;
class teacher_report extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Get all lessons and classrooms for filters
    $lessons = \App\Models\Lessonss::with('subject')
        ->where('researcher_id', 1) // Adjust based on your auth
        ->get();
    
    $classrooms = \App\Models\Classroom::all();

    $query = lesson_report::with(['lesson', 'teacher.user', 'classroom','researcher.user'])
        ->where('researcher_id', 1);

    // Apply filters
    if (request('title')) {
        $query->where('title', 'like', '%' . request('title') . '%');
    }

    if (request('lesson_id')) {
        $query->where('lesson_id', request('lesson_id'));
    }

    if (request('classroom_id')) {
        $query->where('classroom_id', request('classroom_id'));
    }

    if (request('status')) {
        $query->where('status', request('status'));
    }

    if (request('priority')) {
        $query->where('priority', request('priority'));
    }

    $reports = $query->latest()->paginate(10);  
    
    return view('researchers-dashboard\teacher_report\index', compact('reports', 'lessons', 'classrooms'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(lesson_report $lessonReport)
    {
        // تحميل العلاقات
        $lessonReport->load([
            'lesson.subject',
            'teacher.user',
            'researcher.user',
            'classroom'
        ]);

        return view('researchers-dashboard\teacher_report\show', compact('lessonReport'));
    }
    public function update(Request $request, lesson_report $lessonReport)
    {
        $validated = $request->validate([
            'researcher_response' => 'required|string',
            'status' => 'required|in:pending,under_review,resolved,closed',
            
        ]);

        // إذا تم تغيير الحالة إلى "تم الحل"، قم بتسجيل وقت الحل
        if ($validated['status'] === 'resolved' && $lessonReport->status !== 'resolved') {
            $validated['resolved_at'] = now();
        }

        $lessonReport->update($validated);

        return redirect()->route('lesson-reports.index')
            ->with('success', 'تم تحديث التقرير بنجاح');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
