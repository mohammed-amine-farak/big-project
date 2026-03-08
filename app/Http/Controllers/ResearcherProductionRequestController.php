<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\content_block_video;
use App\Models\content_blocks;
use App\Models\production_request;
use App\Models\video_creator;
use App\Models\lessonss;
use App\Models\rules;
use App\Models\video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ResearcherProductionRequestController extends Controller
{
        public function index(Request $request)
    {
        // الحصول على الباحث الحالي
        $researcher = Auth::user()->id;
        
        

        // بناء الاستعلام الأساسي
        $query = production_request::where('researcher_id', $researcher)
                    ->with([
                        'videoCreator.user', 
                        'lesson', 
                        'rule', 
                        'contentBlock', 
                        'videos'
                    ]);

        // تطبيق الفلاتر
        if ($request->filled('video_creator_id')) {
            $query->where('video_creator_id', $request->video_creator_id);
        }

        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('created_date')) {
            $query->whereDate('created_at', $request->created_date);
        }

        // ترتيب النتائج
        $query->orderByRaw("CASE status 
            WHEN 'pending' THEN 1 
            WHEN 'accepted' THEN 2 
            WHEN 'submitted' THEN 3 
            WHEN 'revision_required' THEN 4 
            WHEN 'approved' THEN 5 
            WHEN 'rejected' THEN 6 
            ELSE 7 END")
            ->orderBy('created_at', 'desc');

        // تقسيم النتائج إلى صفحات
        $production_requests = $query->paginate(15)->withQueryString();

        // حساب الإحصائيات
        $totalRequests = production_request::where('researcher_id', $researcher)->count();
        $pendingCount = production_request::where('researcher_id', $researcher)
                        ->where('status', 'pending')->count();
        $acceptedCount = production_request::where('researcher_id', $researcher)
                        ->where('status', 'accepted')->count();
        $submittedCount = production_request::where('researcher_id', $researcher)
                        ->where('status', 'submitted')->count();
        $revisionCount = production_request::where('researcher_id', $researcher)
                        ->where('status', 'revision_required')->count();
        $approvedCount = production_request::where('researcher_id', $researcher)
                        ->where('status', 'approved')->count();
        $rejectedCount = production_request::where('researcher_id', $researcher)
                        ->where('status', 'rejected')->count();

        // بيانات الفلاتر
        $videoCreators = video_creator::whereHas('productionRequests', function($q) use ($researcher) {
            $q->where('researcher_id', $researcher);
        })->get();

        $lessons = lessonss::whereHas('productionRequests', function($q) use ($researcher) {
            $q->where('researcher_id', $researcher);
        })->get();

        return view('researchers-dashboard.production_request.index', compact(
            'production_requests',
            'videoCreators',
            'lessons',
            'totalRequests',
            'pendingCount',
            'acceptedCount',
            'submittedCount',
            'revisionCount',
            'approvedCount',
            'rejectedCount'
        ));
    }
        public function create()
    {
        $researcher = Auth::user()->id;
        
       

        // جلب الدروس التي أنشأها هذا الباحث
        $lessons = lessonss::all();

        // جلب جميع منشئي الفيديو النشطين
      $videoCreators = video_creator::with('user')
    ->join('users', 'video_creators.id', '=', 'users.id')
    ->where('video_creators.status', 'active')
    ->orderBy('users.name')
    ->select('video_creators.*')
    ->get();

        return view('researchers-dashboard.production_request.create', compact('lessons', 'videoCreators'));
    }
    public function store(Request $request)
    {
        $researcher = Auth::user()->id;
        
        

        // التحقق من صحة البيانات
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'lesson_id' => 'required|exists:lessonss,id',
            'rule_id' => 'nullable|exists:rules,id',
            'content_block_id' => 'nullable|exists:content_blocks,id',
            'video_creator_id' => 'required|exists:video_creators,id',
            'reference_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'deadline' => 'nullable|date|after_or_equal:today',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            // رفع الملف المرجعي إذا وجد
            $referenceFilePath = null;
            if ($request->hasFile('reference_file')) {
                $file = $request->file('reference_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $referenceFilePath = $file->storeAs('references/' . date('Y/m'), $fileName, 'public');
            }

            // إنشاء طلب الإنتاج
            $productionRequest = production_request::create([
                'researcher_id' => $researcher,
                'video_creator_id' => $request->video_creator_id,
                'lesson_id' => $request->lesson_id,
                'rule_id' => $request->rule_id,
                'content_block_id' => $request->content_block_id,
                'title' => $request->title,
                'description' => $request->description,
                'reference_file_path' => $referenceFilePath,
                'deadline' => $request->deadline,
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            return redirect()->route('researcher.production_requests.index')
                ->with('success', '✅ تم إنشاء طلب الإنتاج بنجاح');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إنشاء الطلب: ' . $e->getMessage());
        }
    }
        public function show(production_request $production_request)
    {
        // الحصول على الباحث الحالي
        $researcher = Auth::user()->id;
        
        // التحقق من وجود الباحث
       
        // التحقق من أن الطلب يخص هذا الباحث فقط
        if ($production_request->researcher_id !== $researcher) {
            abort(403, 'غير مصرح لك بعرض هذا الطلب');
        }

        // تحميل جميع العلاقات المطلوبة
        $production_request->load([
            'videoCreator',           // معلومات منشئ الفيديو
            'lesson',                 // معلومات الدرس
            'rule',                   // معلومات القاعدة (إذا وجدت)
            'contentBlock',           // معلومات كتلة المحتوى (إذا وجدت)
            'videos' => function($q) { // الفيديوهات المرفوعة (مرتبة تنازلياً)
                $q->latest();
            }
        ]);

        // تمرير البيانات إلى صفحة العرض
        return view('researchers-dashboard.production_request.show', [
            'production_request' => $production_request
        ]);
    }

    /**
     * الموافقة على الفيديو (تستخدم في صفحة show)
     */
 public function approve(Request $request, production_request $production_request)
{
    // التحقق من الصلاحية
    if ($production_request->researcher_id !== Auth::user()->id) {
        abort(403);
    }

    // التحقق من حالة الطلب
    if ($production_request->status !== 'submitted') {
        return redirect()->back()->with('error', 'لا يمكن الموافقة على هذا الطلب في حالته الحالية');
    }

    // التحقق من وجود فيديو
    $video = $production_request->videos()->latest()->first();
    if (!$video) {
        return redirect()->back()->with('error', 'لا يوجد فيديو للموافقة عليه');
    }

    try {
        // 1. تحديث حالة طلب الإنتاج (الفيديو يرث هذه الحالة)
        $production_request->status = 'approved';
        $production_request->approved_at = now();
        $production_request->save();

        // ✅ 2. ربط الفيديو بكتلة المحتوى (إذا وجدت)
        if ($production_request->content_block_id) {
            // فصل أي فيديو قديم مرتبط بنفس الكتلة
            DB::table('videos')
                ->where('content_block_id', $production_request->content_block_id)
                ->where('id', '!=', $video->id)
                ->update(['content_block_id' => null]);
            
            // ربط الفيديو الحالي
            $video->content_block_id = $production_request->content_block_id;
            $video->save(); // ✅ الفيديو لا يحتوي على status، فقط content_block_id
        }
              
        return redirect()->route('researcher.production_requests.show', $production_request->id)
            ->with('success', '✅ تمت الموافقة على الفيديو وربطه بالدرس بنجاح');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
}
    /**
     * طلب تعديلات على الفيديو (revision)
     */
    public function requestRevision(Request $request, production_request $production_request)
    {
        $researcher = Auth::user()->id;
        
        // التحقق من الصلاحية
        if ($production_request->researcher_id !== $researcher) {
            abort(403);
        }

        // التحقق من أن الطلب في حالة submitted
        if ($production_request->status !== 'submitted') {
            return redirect()->back()
                ->with('error', 'لا يمكن طلب تعديلات على هذا الطلب في حالته الحالية');
        }

        // التحقق من وجود تفاصيل التعديل
        $request->validate([
            'revision_details' => 'required|string|max:2000'
        ], [
            'revision_details.required' => 'يجب إدخال تفاصيل التعديلات المطلوبة'
        ]);

        // تحديث حالة الطلب
        $production_request->status = 'revision_required';
        $production_request->revision_details = $request->revision_details;
        $production_request->save();

        return redirect()->route('researcher.production_requests.show', $production_request->id)
            ->with('success', '✏️ تم إرسال طلب التعديلات إلى منشئ الفيديو');
    }

    /**
     * رفض الفيديو
     */
    public function reject(Request $request, production_request $production_request)
    {
        $researcher = Auth::user()->id;
        
        // التحقق من الصلاحية
        if ($production_request->researcher_id !== $researcher) {
            abort(403);
        }

        // التحقق من أن الطلب في حالة submitted
        if ($production_request->status !== 'submitted') {
            return redirect()->back()
                ->with('error', 'لا يمكن رفض هذا الطلب في حالته الحالية');
        }

        // تحديث حالة الطلب
        $production_request->status = 'rejected';
        $production_request->notes = $request->rejection_reason ?? 'رفض من قبل الباحث';
        $production_request->save();

        return redirect()->route('researcher.production_requests.show', $production_request->id)
            ->with('success', '❌ تم رفض الفيديو');
    }



        public function edit(production_request $production_request)
    {
        $researcher = Auth::user()->id;
        
        // التحقق من الصلاحية
        if ($production_request->researcher_id !== $researcher) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب');
        }

        // التحقق من أن الطلب في حالة pending فقط
        if ($production_request->status !== 'pending') {
            return redirect()->route('researcher.production_requests.show', $production_request->id)
                ->with('error', 'لا يمكن تعديل هذا الطلب بعد بدء العمل عليه');
        }

        // جلب الدروس التي أنشأها هذا الباحث
        $lessons = lessonss::all();
   
        // جلب جميع منشئي الفيديو النشطين
     $videoCreators = video_creator::with('user')
    ->join('users', 'video_creators.id', '=', 'users.id')
    ->where('video_creators.status', 'active')
    ->orderBy('users.name')
    ->select('video_creators.*')
    ->get();

        // جلب القواعد المرتبطة بالدرس الحالي (إذا وجد)
        $rules = [];
        if ($production_request->lesson_id) {
            $rules = rules::where('lessons_id', $production_request->lesson_id)
                        ->orderBy('title')
                        ->get();
        }

        // جلب كتل المحتوى المرتبطة بالقاعدة الحالية (إذا وجدت)
        $contentBlocks = [];
        if ($production_request->rule_id) {
            $contentBlocks = content_blocks::where('rule_id', $production_request->rule_id)
                                        ->orderBy('block_order')
                                        ->get();
        }

        return view('researchers-dashboard.production_request.edit', compact(
            'production_request', 
            'lessons', 
            'videoCreators',
            'rules',
            'contentBlocks'
        ));
    }

    /**
     * تحديث طلب إنتاج
     */
    public function update(Request $request, production_request $production_request)
    {
        $researcher = Auth::user()->id;
        
        // التحقق من الصلاحية
        if ($production_request->researcher_id !== $researcher) {
            abort(403, 'غير مصرح لك بتحديث هذا الطلب');
        }

        // التحقق من أن الطلب في حالة pending فقط
        if ($production_request->status !== 'pending') {
            return redirect()->route('researcher.production_requests.show', $production_request->id)
                ->with('error', 'لا يمكن تحديث هذا الطلب بعد بدء العمل عليه');
        }

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'lesson_id' => 'required|exists:lessonss,id',
            'rule_id' => 'nullable|exists:rules,id',
            'content_block_id' => 'nullable|exists:content_blocks,id',
            'video_creator_id' => 'required|exists:video_creators,id',
            'reference_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'deadline' => 'nullable|date|after_or_equal:today',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'notes' => 'nullable|string|max:1000',
            'delete_reference_file' => 'nullable|boolean'
        ]);

        try {
            // معالجة حذف الملف المرجعي القديم
            if ($request->has('delete_reference_file') && $request->delete_reference_file && $production_request->reference_file_path) {
                Storage::disk('public')->delete($production_request->reference_file_path);
                $production_request->reference_file_path = null;
            }

            // معالجة رفع ملف مرجعي جديد
            if ($request->hasFile('reference_file') && $request->file('reference_file')->isValid()) {
                // حذف الملف القديم إذا وجد
                if ($production_request->reference_file_path) {
                    Storage::disk('public')->delete($production_request->reference_file_path);
                }
                
                $file = $request->file('reference_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $referenceFilePath = $file->storeAs('references/' . date('Y/m'), $fileName, 'public');
                $production_request->reference_file_path = $referenceFilePath;
            }

            // تحديث البيانات
            $production_request->update([
                'title' => $request->title,
                'description' => $request->description,
                'lesson_id' => $request->lesson_id,
                'rule_id' => $request->rule_id,
                'content_block_id' => $request->content_block_id,
                'video_creator_id' => $request->video_creator_id,
                'deadline' => $request->deadline,
                'priority' => $request->priority,
                'notes' => $request->notes
            ]);

            return redirect()->route('researcher.production_requests.show', $production_request->id)
                ->with('success', '✅ تم تحديث طلب الإنتاج بنجاح');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث الطلب: ' . $e->getMessage());
        }
    }
        public function destroy(production_request $production_request)
    {
        // الحصول على الباحث الحالي
        $researcher = Auth::user()->id;
        
        // التحقق من وجود الباحث
        if (!$researcher) {
            return redirect()->route('researcher.dashboard')
                ->with('error', 'لم يتم العثور على بيانات الباحث');
        }

        // التحقق من أن الطلب يخص هذا الباحث فقط
        if ($production_request->researcher_id !== $researcher) {
            abort(403, 'غير مصرح لك بحذف هذا الطلب');
        }

        // التحقق من أن الطلب في حالة pending فقط (يمكن حذفه فقط إذا لم يبدأ العمل عليه)
        if ($production_request->status !== 'pending') {
            return redirect()->route('researcher.production_requests.show', $production_request->id)
                ->with('error', 'لا يمكن حذف هذا الطلب بعد بدء العمل عليه');
        }

        try {
            // 1. حذف الملف المرجعي إذا وجد
            if ($production_request->reference_file_path) {
                Storage::disk('public')->delete($production_request->reference_file_path);
            }

            // 2. حذف الفيديوهات المرتبطة (إذا وجدت)
            if ($production_request->videos && $production_request->videos->count() > 0) {
                foreach ($production_request->videos as $video) {
                    // حذف ملف الفيديو من السيرفر
                    if ($video->file_path) {
                        Storage::disk('public')->delete($video->file_path);
                    }
                    // حذف الصورة المصغرة إذا وجدت
                    if ($video->thumbnail) {
                        Storage::disk('public')->delete($video->thumbnail);
                    }
                    // حذف سجل الفيديو من قاعدة البيانات
                    $video->delete();
                }
            }

            // 3. حذف طلب الإنتاج نفسه
            $production_request->delete();

            // رسالة نجاح
            return redirect()->route('researcher.production_requests.index')
                ->with('success', '✅ تم حذف طلب الإنتاج بنجاح');

        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف الطلب: ' . $e->getMessage());
        }
    }

    /**
     * حذف ملف مرجعي فقط (بدون حذف الطلب)
     * (وظيفة إضافية اختيارية)
     */
    public function deleteReferenceFile(production_request $production_request)
    {
        $researcher = Auth::user()->id;
        
        if ($production_request->researcher_id !== $researcher) {
            abort(403);
        }

        if ($production_request->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'لا يمكن حذف الملف المرجعي بعد بدء العمل على الطلب');
        }

        if ($production_request->reference_file_path) {
            Storage::disk('public')->delete($production_request->reference_file_path);
            $production_request->reference_file_path = null;
            $production_request->save();

            return redirect()->back()
                ->with('success', '✅ تم حذف الملف المرجعي بنجاح');
        }

        return redirect()->back()
            ->with('error', 'لا يوجد ملف مرجعي للحذف');
    }

}
