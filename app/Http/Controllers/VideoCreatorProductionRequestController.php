<?php

namespace App\Http\Controllers;

use App\Models\lessonss;
use Illuminate\Http\Request;
use App\Models\production_request;
use App\Models\Researchers;
use App\Models\video;

use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Support\Str; 
class VideoCreatorProductionRequestController extends Controller
{
         public function index(Request $request)
    {
        $videoCreator = Auth::user()->id;
        
        // استعلام واحد لكل الطلبات
        $query = production_request::where('video_creator_id', $videoCreator)
                    ->with(['researcher.user', 'lesson']);
        
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
    if ($productionRequest->video_creator_id !== Auth::user()->id) {
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
        if ($production_request->video_creator_id !== Auth::user()->id) {
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
        if ($production_request->video_creator_id !== 1) {
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
    try {

        // التحقق من الصلاحية
        if ($production_request->video_creator_id !== 1) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        // التحقق من حالة الطلب
        if ($production_request->status !== 'accepted') {
            return response()->json(['error' => 'حالة الطلب غير مناسبة'], 400);
        }

        // استلام chunk
        $chunk = $request->file('video_file');

        if (!$chunk) {
            return response()->json(['error' => 'لم يتم استلام الملف'], 400);
        }

        if (!$chunk->isValid()) {
            return response()->json([
                'error' => 'الملف غير صالح: ' . $chunk->getErrorMessage()
            ], 400);
        }

        // بيانات الرفع
        $chunkIndex = (int)$request->input('chunk_index');
        $totalChunks = (int)$request->input('total_chunks');
        $fileName = $request->input('file_name');
        $fileSize = $request->input('file_size');

        // مجلد مؤقت ثابت لكل فيديو
        $tempDir = 'temp/' . md5($fileName . $production_request->id);

        if (!Storage::disk('public')->exists($tempDir)) {
            Storage::disk('public')->makeDirectory($tempDir);
        }

        // حفظ chunk
        $chunk->storeAs($tempDir, 'chunk_' . $chunkIndex . '.part', 'public');

        // إذا كانت آخر قطعة
        if ($chunkIndex == $totalChunks - 1) {

            return $this->assembleChunks(
                $tempDir,
                $totalChunks,
                $fileName,
                $fileSize,
                $production_request,
                $request
            );
        }

        return response()->json([
            'success' => true,
            'chunk_received' => $chunkIndex,
            'message' => 'تم استلام القطعة ' . ($chunkIndex + 1) . ' من ' . $totalChunks
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ], 500);
    }
}


protected function assembleChunks($tempDir, $totalChunks, $fileName, $fileSize, $production_request, $request)
{

    // المسار النهائي
    $finalPath = 'videos/' . date('Y/m');
    $finalFileName = time() . '_' . $fileName;

    if (!Storage::disk('public')->exists($finalPath)) {
        Storage::disk('public')->makeDirectory($finalPath);
    }

    $finalFilePath = storage_path('app/public/' . $finalPath . '/' . $finalFileName);

    // إنشاء الملف
    if (!file_exists($finalFilePath)) {
        touch($finalFilePath);
    }

    // دمج القطع
    for ($i = 0; $i < $totalChunks; $i++) {

        $chunkPath = storage_path('app/public/' . $tempDir . '/chunk_' . $i . '.part');

        if (!file_exists($chunkPath)) {
            throw new \Exception("Chunk {$i} missing");
        }

        file_put_contents(
            $finalFilePath,
            file_get_contents($chunkPath),
            FILE_APPEND
        );

        unlink($chunkPath);
    }

    // حذف المجلد المؤقت
    rmdir(storage_path('app/public/' . $tempDir));

    // حفظ الفيديو في قاعدة البيانات
    $video = Video::create([
        'creator_id' => 1,
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

    // تحديث حالة الطلب
    $production_request->update([
        'status' => 'submitted',
        'submitted_at' => now()
    ]);

    return response()->json([
        'success' => true,
        'video_id' => $video->id
    ]);
}
        public function reviseForm(production_request $production_request)
    {
        // التحقق من الصلاحية
        if ($production_request->video_creator_id !== 1) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب');
        }

        // التحقق من أن الطلب في حالة revision_required
        if ($production_request->status !== 'revision_required') {
            return redirect()->route('video_creator.production_request.show', $production_request->id)
                ->with('error', 'لا يمكن تعديل هذا الطلب في حالته الحالية');
        }

        // تحميل الفيديوهات المرتبطة (آخر فيديو)
        $production_request->load('videos');

        return view('video-dashboard.production_requests.edit_video', compact('production_request'));
    }

    /**
     * رفع النسخة المعدلة باستخدام Chunking
     * POST /video-creator/production-requests/{id}/revise-chunk
     */
    public function reviseChunk(Request $request, production_request $production_request)
{
    if ($production_request->video_creator_id !== 1) {
        return response()->json(['error' => 'غير مصرح لك برفع فيديو لهذا الطلب'], 403);
    }

    if ($production_request->status !== 'revision_required') {
        return response()->json(['error' => 'لا يمكن رفع فيديو لهذا الطلب في حالته الحالية'], 400);
    }

    try {

        $chunk = $request->file('video_file');
        $chunkIndex = (int)$request->input('chunk_index');
        $totalChunks = (int)$request->input('total_chunks');
        $fileName = $request->input('file_name');
        $fileSize = $request->input('file_size');
        $revisionNotes = $request->input('revision_notes');

        if (!$chunk) {
            return response()->json(['error' => 'لم يتم استلام ملف الفيديو'], 400);
        }

        // مجلد ثابت لكل الفيديو
        $tempDir = 'temp/revise_' . md5($fileName . $production_request->id);

        if (!Storage::disk('public')->exists($tempDir)) {
            Storage::disk('public')->makeDirectory($tempDir);
        }

        // حفظ chunk
        $chunk->storeAs($tempDir, 'chunk_' . $chunkIndex . '.part', 'public');

        // إذا كانت آخر قطعة
        if ($chunkIndex == $totalChunks - 1) {

            return $this->assembleRevisedChunks(
                $tempDir,
                $totalChunks,
                $fileName,
                $fileSize,
                $production_request,
                $revisionNotes
            );
        }

        return response()->json([
            'success' => true,
            'chunk' => $chunkIndex,
            'message' => 'تم استلام القطعة ' . ($chunkIndex + 1) . ' من ' . $totalChunks
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}

    /**
     * دمج القطع وحفظ النسخة المعدلة
     */
   protected function assembleRevisedChunks($tempDir, $totalChunks, $fileName, $fileSize, $production_request, $revisionNotes)
{
    try {

        $finalPath = 'videos/' . date('Y/m');
        $finalFileName = time() . '_revised_' . $fileName;

        if (!Storage::disk('public')->exists($finalPath)) {
            Storage::disk('public')->makeDirectory($finalPath);
        }

        $finalFilePath = storage_path('app/public/' . $finalPath . '/' . $finalFileName);

        // إنشاء الملف النهائي
        if (!file_exists($finalFilePath)) {
            touch($finalFilePath);
        }

        // دمج chunks
        for ($i = 0; $i < $totalChunks; $i++) {

            $chunkPath = storage_path('app/public/' . $tempDir . '/chunk_' . $i . '.part');

            if (!file_exists($chunkPath)) {
                throw new \Exception("Chunk {$i} missing");
            }

            file_put_contents(
                $finalFilePath,
                file_get_contents($chunkPath),
                FILE_APPEND
            );

            unlink($chunkPath);
        }

        // حذف المجلد المؤقت
        rmdir(storage_path('app/public/' . $tempDir));

        $video = Video::create([
            'creator_id' => 1,
            'production_request_id' => $production_request->id,
            'title' => $production_request->title . ' (نسخة معدلة)',
            'description' => $revisionNotes,
            'file_path' => $finalPath . '/' . $finalFileName,
            'video_format' => pathinfo($fileName, PATHINFO_EXTENSION),
            'file_size' => round($fileSize / 1048576, 2),
            'views' => 0,
            'likes' => 0,
            'completion_rate' => 0
        ]);

        $production_request->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'video_id' => $video->id,
            'message' => 'تم رفع النسخة المعدلة بنجاح'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => 'فشل دمج القطع: ' . $e->getMessage()
        ], 500);
    }
}      }
