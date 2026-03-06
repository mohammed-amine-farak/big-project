<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\production_request;
use App\Models\video_creator;
use App\Models\lessonss;

use Illuminate\Support\Facades\Auth;

class ResearcherProductionRequestController extends Controller
{
        public function index(Request $request)
    {
        // الحصول على الباحث الحالي
        $researcher = Auth::user()->id;
        
        

        // بناء الاستعلام الأساسي
        $query = production_request::where('researcher_id', $researcher)
                    ->with([
                        'videoCreator', 
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
}
