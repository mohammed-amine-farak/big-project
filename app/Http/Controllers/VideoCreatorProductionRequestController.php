<?php

namespace App\Http\Controllers;

use App\Models\lessonss;
use Illuminate\Http\Request;
use App\Models\production_request;
use App\Models\Researchers;
use App\Models\video;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Support\Str; 
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


          public function uploadChunk(Request $request, production_request $production_request)
    {
        // التحقق من الصلاحية
        if ($production_request->video_creator_id !== 63) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        try {
            $chunk = $request->file('video_file');
            $chunkIndex = $request->input('chunk_index');
            $totalChunks = $request->input('total_chunks');
            $fileName = $request->input('file_name');
            $fileSize = $request->input('file_size');

            // مجلد مؤقت للقطع
            $tempDir = 'temp/' . uniqid() . '_' . $production_request->id;
            
            // حفظ القطعة
            $chunk->storeAs($tempDir, 'chunk_' . $chunkIndex . '.part', 'public');

            // إذا كانت آخر قطعة، نقوم بدمج جميع القطع
            if ($chunkIndex == $totalChunks - 1) {
                return $this->assembleChunks($tempDir, $totalChunks, $fileName, $fileSize, $production_request, $request);
            }

            return response()->json(['success' => true, 'chunk' => $chunkIndex]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * دمج القطع وحفظ الفيديو النهائي
     */
    protected function assembleChunks($tempDir, $totalChunks, $fileName, $fileSize, $production_request, $request)
    {
        // المسار النهائي للفيديو
        $finalPath = 'videos/' . date('Y/m');
        $finalFileName = time() . '_' . $fileName;
        
        // إنشاء المجلد النهائي إذا لم يكن موجوداً
        if (!Storage::disk('public')->exists($finalPath)) {
            Storage::disk('public')->makeDirectory($finalPath);
        }

        // دمج القطع
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = storage_path('app/public/' . $tempDir . '/chunk_' . $i . '.part');
            $finalFilePath = storage_path('app/public/' . $finalPath . '/' . $finalFileName);
            
            if (file_exists($chunkPath)) {
                file_put_contents($finalFilePath, file_get_contents($chunkPath), FILE_APPEND);
                unlink($chunkPath); // حذف القطعة بعد الدمج
            }
        }

        // حذف المجلد المؤقت
        rmdir(storage_path('app/public/' . $tempDir));

        // حفظ معلومات الفيديو في قاعدة البيانات
        $video = Video::create([
            'creator_id' =>63,
            'production_request_id' => $production_request->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'file_path' => $finalPath . '/' . $finalFileName,
            'video_format' => pathinfo($fileName, PATHINFO_EXTENSION),
            'file_size' => round($fileSize / 1048576, 2),
            'views' => 0,
            'likes' => 0,
            'completion_rate' => 0
        ]);

        // تحديث حالة طلب الإنتاج
        $production_request->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'video_id' => $video->id
        ]);
    }
      }
