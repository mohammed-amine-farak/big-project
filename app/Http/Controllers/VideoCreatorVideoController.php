<?php


namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VideoCreatorVideoController extends Controller
{
    /**
     * عرض جميع فيديوهات منشئ الفيديو
     */
  

    /**
     * عرض تفاصيل فيديو معين مع التعليقات
     */
    public function show(Video $video)
    {
        $videoCreator = Auth::user()->id;
        
        // التحقق من أن الفيديو يخص هذا المنشئ
        if ($video->creator_id !== $videoCreator) {
            abort(403, 'غير مصرح لك بمشاهدة هذا الفيديو');
        }

        // تحميل العلاقات
        $video->load([
            'productionRequests',
            'productionRequests.researcher',
            'productionRequests.lesson'
        ]);

        // جلب التعليقات مع الردود
        $comments = \App\Models\Comment::with(['user', 'replies.user'])
            ->where('commentable_id', $video->id)
            ->where('commentable_type', 'App\\Models\\Video')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('video-dashboard.videos.show', compact('video', 'comments'));
    }
    public function index(Request $request)
    {
        $videoCreator = Auth::user()->id;
        
        if (!$videoCreator) {
            return redirect()->route('video_creator.dashboard')
                ->with('error', 'لم يتم العثور على بيانات منشئ الفيديو');
        }

        // استعلام الفيديوهات
        $query = Video::where('creator_id', $videoCreator)
            ->with(['productionRequests', 'productionRequests.researcher']);

        // بحث حسب العنوان
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // فلترة حسب الحالة (من خلال production request)
        if ($request->filled('status')) {
            $query->whereHas('productionRequests', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // ترتيب
        $query->latest();

        // تقسيم النتائج
        $videos = $query->paginate(12)->withQueryString();

        // إحصائيات
        $totalVideos = Video::where('creator_id', $videoCreator)->count();
        $totalViews = Video::where('creator_id', $videoCreator)->sum('views');
        $totalComments = Comment::whereIn('commentable_id', Video::where('creator_id', $videoCreator)->pluck('id'))
            ->where('commentable_type', 'App\\Models\\Video')
            ->count();

        return view('video-dashboard.videos.index', compact('videos', 'totalVideos', 'totalViews', 'totalComments'));
    }
}