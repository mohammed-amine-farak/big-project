<?php

namespace App\Http\Controllers;

use App\Models\lessonss;
use Illuminate\Http\Request;
use App\Models\production_request;
use App\Models\Researchers;

class VideoCreatorProductionRequestController extends Controller
{
        public function index(Request $request)
    {
        // 1. التحقق من هوية منشئ الفيديو
        $videoCreator = 63;
        
        if (!$videoCreator) {
            return redirect()->route('video_creator.dashboard')
                ->with('error', 'لم يتم العثور على بيانات منشئ الفيديو');
        }

        // 2. بناء الاستعلام الأساسي
        $query = production_request::where('video_creator_id', $videoCreator)
                    ->with([
                        'researcher' ,    // معلومات الباحث
                       'lesson',         // معلومات الدرس
                        'rule',           // معلومات القاعدة
                     'contentBlock',   // معلومات كتلة المحتوى
                              // الفيديوهات المرتبطة
                    ]);
      
        // 3. تطبيق الفلاتر (إذا تم تحديدها)
        
        // فلتر حسب الباحث
        if ($request->filled('researcher_id')) {
            $query->where('researcher_id', $request->researcher_id);
        }

        // فلتر حسب الدرس
        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }

        // فلتر حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلتر حسب تاريخ التسليم
        if ($request->filled('deadline')) {
            $query->whereDate('deadline', $request->deadline);
        }

        // 4. ترتيب النتائج: حسب الأولوية (الحالة) ثم حسب تاريخ التسليم
        $query->orderByRaw("CASE status 
            WHEN 'pending' THEN 1           
            WHEN 'accepted' THEN 2        
            WHEN 'submitted' THEN 3        
            WHEN 'revision_required' THEN 4
            WHEN 'approved' THEN 5          
            WHEN 'rejected' THEN 6          
            ELSE 7 END")
            ->orderBy('deadline', 'asc');   // المواعيد الأقرب أولاً

        // 5. تقسيم النتائج إلى صفحات (15 طلب في كل صفحة)
        $production_requests = $query->paginate(15)->withQueryString();

        // 6. جلب بيانات الفلاتر (للقوائم المنسدلة)
        
        // قائمة الباحثين الذين لديهم طلبات لهذا المنشئ
        $researchers = Researchers::whereHas('productionRequests', function($q) use ($videoCreator) {
            $q->where('video_creator_id', $videoCreator);
        })->get();

        // قائمة الدروس التي لها طلبات لهذا المنشئ
        $lessons = lessonss::whereHas('productionRequests', function($q) use ($videoCreator) {
            $q->where('video_creator_id', $videoCreator);
        })->get();

        // 7. عرض الصفحة مع البيانات
        return view('video-dashboard.production_requests.index', compact(
            'production_requests', 
            'researchers', 
            'lessons'
        ));
    }
}
