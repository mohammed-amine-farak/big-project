<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * ✅ عرض تعليقات منشئ الفيديو (فقط على فيديوهاته)
     */
    public function videoCreatorComments(Request $request)
    {
        $videoCreator = Auth::user()->id;
        
      

        // الحصول على فيديوهات هذا المنشئ فقط
        $videoIds = Video::where('creator_id', $videoCreator)->pluck('id')->toArray();

        $query = Comment::with(['user', 'replies.user'])
            ->whereIn('commentable_id', $videoIds)
            ->where('commentable_type', 'App\\Models\\Video')
            ->whereNull('parent_id'); // التعليقات الأصلية فقط

        // فلترة حسب الحالة
        if ($request->has('status')) {
            if ($request->status == 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status == 'read') {
                $query->whereNotNull('read_at');
            }
        }

        // فلترة حسب التاريخ
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $comments = $query->latest()->paginate(15);

        // إحصائيات
        $totalComments = Comment::whereIn('commentable_id', $videoIds)
            ->where('commentable_type', 'App\\Models\\Video')
            ->count();
            
        $unreadComments = Comment::whereIn('commentable_id', $videoIds)
            ->where('commentable_type', 'App\\Models\\Video')
            ->whereNull('read_at')
            ->count();

        return view('video-dashboard.comments.index', compact('comments', 'totalComments', 'unreadComments'));
    }

    /**
     * ✅ عرض تعليقات فيديو معين
     */
    public function videoComments(Video $video)
    {
        // التحقق من أن منشئ الفيديو يمكنه رؤية هذه التعليقات
        $videoCreator = Auth::user()->id;
        
        if ($video->creator_id !== $videoCreator) {
            abort(403, 'غير مصرح لك بمشاهدة هذه التعليقات');
        }

        // جلب التعليقات مع الردود
        $comments = Comment::with(['user', 'replies.user'])
            ->where('commentable_id', $video->id)
            ->where('commentable_type', 'App\\Models\\Video')
            ->whereNull('parent_id') // التعليقات الأصلية فقط
            ->orderBy('created_at', 'desc')
            ->get();

        // تعليم التعليقات كمقروءة
        Comment::where('commentable_id', $video->id)
            ->where('commentable_type', 'App\\Models\\Video')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('video_creator.comments.show', compact('video', 'comments'));
    }

    /**
     * ✅ إضافة تعليق جديد على فيديو
     */
    public function store(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $video = Video::find($request->video_id);

        // إنشاء التعليق
        $comment = Comment::create([
            'commentable_type' => 'App\\Models\\Video',
            'commentable_id' => $video->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
            'is_approved' => true
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
                'message' => 'تم إضافة التعليق'
            ]);
        }

        return back()->with('success', 'تم إضافة التعليق بنجاح');
    }

    /**
     * ✅ الرد على تعليق
     */
    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:2000'
        ]);

        $reply = Comment::create([
            'commentable_type' => $comment->commentable_type,
            'commentable_id' => $comment->commentable_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $comment->id,
            'is_approved' => true
        ]);

        return back()->with('success', 'تم إضافة الرد بنجاح');
    }

    /**
     * ✅ تعليم التعليق كمقروء
     */
    public function markAsRead(Comment $comment)
    {
        if (!$comment->read_at) {
            $comment->update(['read_at' => now()]);
        }
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'تم تحديث الحالة');
    }

    /**
     * ✅ حذف تعليق
     */
    public function destroy(Comment $comment)
    {
        // التحقق من الصلاحية (صاحب التعليق أو منشئ الفيديو)
        $videoCreator = auth::user()->id;
        $video = Video::find($comment->commentable_id);
        
        if ($comment->user_id !== Auth::id() && 
            (!$videoCreator || $video->creator_id !== $videoCreator)) {
            abort(403, 'غير مصرح لك بحذف هذا التعليق');
        }

        $comment->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'تم حذف التعليق');
    }
}