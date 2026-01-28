<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lesson_report;
use App\Models\lessonss;
use App\Models\Researchers;
use App\Models\teacher;
use App\Models\teacher_reports;

class teacher_lesson_report_controller extends Controller
{
    public function index(Request $request)
    {
        $teacherId = 12;

        $reports = lesson_report::with([
                'lesson.subject',
                'teacher.user',
                'classroom',
                'researcher.user'
            ])

            ->where('teacher_id', $teacherId)
            ->when($request->title, fn ($q) =>
                $q->where('title', 'like', '%' . $request->title . '%')
            )
            ->when($request->lesson_id, fn ($q) =>
                $q->where('lesson_id', $request->lesson_id)
            )
            ->when($request->classroom_id, fn ($q) =>
                $q->where('classroom_id', $request->classroom_id)
            )
            ->when($request->status, fn ($q) =>
                $q->where('status', $request->status)
            )
            ->when($request->priority, fn ($q) =>
                $q->where('priority', $request->priority)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();
         
        $lessons = \App\Models\lessonss::whereHas('lessonReports', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->get();

        $classrooms = \App\Models\classroom::whereHas('lessonReports', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->get();

        return view('teacher-dashboard.teacher_lesson_report.index', compact(
            'reports',
            'lessons',
            'classrooms'
        ));
    }
}
