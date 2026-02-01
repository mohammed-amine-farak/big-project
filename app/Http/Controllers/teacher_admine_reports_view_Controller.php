<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacher_admin_reports;
use App\Models\teacher;
use App\Models\admin;
use Illuminate\Support\Facades\Redirect;

class teacher_admine_reports_view_Controller extends Controller
{
   public function index(Request $request)
    {
        // التحقق من أن المستخدم معلم
       
        // الحصول على المعلم الحالي
        $teacher = 12;
        
        // بناء الاستعلام مع العلاقات
        $query = teacher_admin_reports::with(['teacher.user', 'admin.user'])
            ->where('teacher_id', $teacher);

        // تطبيق الفلاتر
        if ($request->filled('report_type')) {
            $query->where('report_type', $request->report_type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('is_read')) {
            $isRead = $request->is_read === 'read' ? true : false;
            $query->where('is_read', $isRead);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // الترتيب
        $query->orderBy('created_at', 'desc');

        // الحصول على البيانات مع التقسيم
        $reports = $query->paginate(10);

        // إحصائيات
        $stats = [
            'total' => teacher_admin_reports::where('teacher_id', $teacher)->count(),
            'read' => teacher_admin_reports::where('teacher_id', $teacher)->where('is_read', true)->count(),
            'unread' => teacher_admin_reports::where('teacher_id', $teacher)->where('is_read', false)->count(),
            'high_priority' => teacher_admin_reports::where('teacher_id', $teacher)->where('priority', 'high')->count(),
        ];

        // أنواع التقارير
        $reportTypes = [
            'administrative' => 'إداري',
            'academic' => 'أكاديمي',
            'technical' => 'تقني',
            'other' => 'أخرى'
        ];

        // الأولويات
        $priorities = [
            'low' => 'منخفضة',
            'medium' => 'متوسطة', 
            'high' => 'عالية',
            'urgent' => 'عاجلة'
        ];

        return view('teacher-dashboard.admine_reports.index', compact(
            'reports', 
            'stats', 
            'reportTypes', 
            'priorities',
            'teacher'
        ));
    }
    public function show($id)
{
    $report = teacher_admin_reports::with(['teacher.user', 'admin.user'])
        ->where('id', $id)
        ->where('teacher_id', 12)
        ->firstOrFail();

    // تحديث حالة القراءة
    if (!$report->is_read) {
        $report->update(['is_read' => true]);
    }

    // الحصول على التقرير السابق
    $previousReport = teacher_admin_reports::where('teacher_id', 12)
        ->where('id', '<', $id)
        ->orderBy('id', 'desc')
        ->first();

    // الحصول على التقرير التالي
    $nextReport = teacher_admin_reports::where('teacher_id', 12)
        ->where('id', '>', $id)
        ->orderBy('id', 'asc')
        ->first();

    return view('teacher-dashboard.admine_reports.show', compact('report', 'previousReport', 'nextReport'));
}
}
