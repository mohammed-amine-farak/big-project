<?php

namespace App\Http\Controllers;

use App\Models\lessonss;
use Illuminate\Http\Request;
use App\Models\production_request;
use App\Models\Researchers;
use App\Models\video;

class VideoCreatorProductionRequestController extends Controller
{
         public function index(Request $request)
    {
        $videoCreator = 63;
        
        // استعلام واحد لكل الطلبات
        $query = production_request::where('video_creator_id', $videoCreator)
                    ->with(['researcher', 'lesson']);
        
        // تطبيق فلتر الحالة (إذا كان موجوداً)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // فلاتر إضافية
        if ($request->filled('researcher_id')) {
            $query->where('researcher_id', $request->researcher_id);
        }
        
        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        // إحصائيات سريعة (بنفس الاستعلام)
        $totalRequests = $query->count();
        $pendingCount = production_request::where('video_creator_id', $videoCreator)->where('status', 'pending')->count();
        $acceptedCount = production_request::where('video_creator_id', $videoCreator)->where('status', 'accepted')->count();
        $revisionCount = production_request::where('video_creator_id', $videoCreator)->where('status', 'revision_required')->count();
        $approvedCount = production_request::where('video_creator_id', $videoCreator)->where('status', 'approved')->count();
        $rejectedCount = production_request::where('video_creator_id', $videoCreator)->where('status', 'rejected')->count();
        
        // بيانات الفلاتر
        $researchers = Researchers::whereHas('productionRequests', function($q) use ($videoCreator) {
            $q->where('video_creator_id', $videoCreator);
        })->get();
        
        $lessons = lessonss::whereHas('productionRequests', function($q) use ($videoCreator) {
            $q->where('video_creator_id', $videoCreator);
        })->get();
        
        $production_requests = $query->paginate(15);
        
        return view('video-dashboard.production_requests.index', compact(
            'production_requests', 'researchers', 'lessons',
            'totalRequests', 'pendingCount', 'acceptedCount', 
            'revisionCount', 'approvedCount', 'rejectedCount'
        ));
    } 
    
 public function show(production_request $productionRequest){
    if ($productionRequest->video_creator_id !== 63) {
        abort(403, 'غير مصرح لك بعرض هذا الطلب');
    }
          $productionRequest::with(['researcher','researcher.user','videoCreator','videoCreator.user','lesson','rule','contentBlock','videos'])->get();
      return view('video-dashboard.production_requests.show', compact(
           'productionRequest'
        ));


        
 }
     public function accept(production_request $production_request)
    {
        // التحقق من أن الطلب يخص منشئ الفيديو الحالي
        if ($production_request->video_creator_id !== 63) {
            abort(403, 'غير مصرح لك بقبول هذا الطلب');
        }

        // التحقق من أن الطلب في حالة "pending" فقط
        if ($production_request->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'لا يمكن قبول هذا الطلب في حالته الحالية');
        }

        // تحديث حالة الطلب
        $production_request->status = 'accepted';
        $production_request->accepted_at = now();
        $production_request->save();

        // رسالة نجاح
        return redirect()->route('video_creator.production_request.show', $production_request->id)
            ->with('success', '✅ تم قبول الطلب بنجاح. يمكنك الآن البدء في العمل عليه.');
    }











     public function uploadForm(production_request $production_request)
    {
        // التحقق من الصلاحية
        if ($production_request->video_creator_id !== 63) {
            abort(403, 'غير مصرح لك برفع فيديو لهذا الطلب');
        }

        // التحقق من أن الطلب في حالة "accepted" فقط
        if ($production_request->status !== 'accepted') {
            return redirect()->route('video_creator.production_requests.show', $production_request->id)
                ->with('error', 'لا يمكن رفع فيديو لهذا الطلب في حالته الحالية');
        }
         $production_request::with(['researcher','researcher.user','videoCreator','videoCreator.user','lesson','rule','contentBlock','videos'])->get();

        return view('video-dashboard.production_requests.Upload_Video', compact('production_request'));
    }
        public function upload(Request $request, production_request $production_request)
    {
        // التحقق من الصلاحية - استخدام Auth::id() بدلاً من الرقم الثابت
        if ($production_request->video_creator_id !== 63) {
            abort(403, 'غير مصرح لك برفع فيديو لهذا الطلب');
        }

        // التحقق من أن الطلب في حالة "accepted" فقط
        if ($production_request->status !== 'accepted') {
            return redirect()->route('video_creator.production_requests.show', $production_request->id)
                ->with('error', 'لا يمكن رفع فيديو لهذا الطلب في حالته الحالية');
        }

        // التحقق من صحة البيانات
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'video_file' => 'required|file|mimes:mp4,mov,avi|max:512000', // 500MB max
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // صورة مصغرة (اختياري)
        ], [
            'title.required' => 'عنوان الفيديو مطلوب',
            'title.max' => 'عنوان الفيديو يجب أن لا يتجاوز 255 حرف',
            'description.max' => 'وصف الفيديو يجب أن لا يتجاوز 500 حرف',
            'video_file.required' => 'ملف الفيديو مطلوب',
            'video_file.mimes' => 'صيغة الملف غير مدعومة. الصيغ المدعومة: mp4, mov, avi',
            'video_file.max' => 'حجم الملف كبير جداً. الحد الأقصى هو 500 ميجابايت',
            'thumbnail.image' => 'الملف يجب أن يكون صورة',
            'thumbnail.mimes' => 'صيغ الصور المدعومة: jpeg, png, jpg',
            'thumbnail.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت'
        ]);

        try {
            // رفع ملف الفيديو إلى السيرفر
            $videoPath = $request->file('video_file')->store('videos/' . date('Y/m'), 'public');

            // رفع الصورة المصغرة إن وجدت
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails/' . date('Y/m'), 'public');
            }

            // حساب حجم الملف بالميجابايت
            $fileSize = round($request->file('video_file')->getSize() / 1048576, 2);

            // حساب مدة الفيديو (اختياري - يمكنك استخدام مكتبة getID3)
            $duration = null;
            // يمكنك إضافة كود لحساب المدة إذا أردت
            // مثال: $duration = $this->getVideoDuration($request->file('video_file'));

            // إنشاء سجل الفيديو في قاعدة البيانات (ملاحظة: تم حذف حقل status)
            $video = video::create([
                'creator_id' => 63, // استخدام Auth بدلاً من الرقم الثابت
                'production_request_id' => $production_request->id,
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $videoPath,
                'thumbnail' => $thumbnailPath,
                'duration' => $duration,
                'video_format' => $request->file('video_file')->getClientOriginalExtension(),
                'file_size' => $fileSize,
                'views' => 0,
                'likes' => 0,
                'completion_rate' => 0
            ]);

            // ✅ تحديث حالة طلب الإنتاج تلقائياً
            $production_request->status = 'submitted';
            $production_request->submitted_at = now();
            $production_request->save();

            // رسالة نجاح
            return redirect()->route('video_creator.production_request.show', $production_request->id)
                ->with('success', '✅ تم رفع الفيديو بنجاح. بانتظار مراجعة الباحث.');

        } catch (\Exception $e) {
            // رسالة خطأ في حالة فشل الرفع
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء رفع الفيديو: ' . $e->getMessage());
        }
    }

}
