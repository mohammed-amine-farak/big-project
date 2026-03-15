<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\production_request;
use App\Models\video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoCreatorDashboardControlle extends Controller
{
   public function index()
    {
        $videoCreator = Auth::user()->id;
        
        if (!$videoCreator) {
            return redirect()->route('login')
                ->with('error', 'لم يتم العثور على بيانات منشئ الفيديو');
        }

        // =========================================================
        // إحصائيات طلبات الإنتاج
        // =========================================================
        $totalRequests = production_request::where('video_creator_id', $videoCreator)->count();
        
        $pendingRequests = production_request::where('video_creator_id', $videoCreator)
            ->where('status', 'pending')
            ->count();
            
        $acceptedRequests = production_request::where('video_creator_id', $videoCreator)
            ->where('status', 'accepted')
            ->count();
            
        $submittedRequests = production_request::where('video_creator_id', $videoCreator)
            ->where('status', 'submitted')
            ->count();
            
        $revisionRequests = production_request::where('video_creator_id', $videoCreator)
            ->where('status', 'revision_required')
            ->count();
            
        $approvedRequests = production_request::where('video_creator_id', $videoCreator)
            ->where('status', 'approved')
            ->count();
            
        $rejectedRequests = production_request::where('video_creator_id', $videoCreator)
            ->where('status', 'rejected')
            ->count();

        // =========================================================
        // إحصائيات الفيديوهات
        // =========================================================
        $totalVideos = video::where('creator_id', $videoCreator)->count();
        $totalViews = Video::where('creator_id', $videoCreator)->sum('views');
        $totalLikes = Video::where('creator_id', $videoCreator)->sum('likes');
        
        // أحدث الفيديوهات
        $recentVideos = Video::where('creator_id', $videoCreator)
            ->with('productionRequests')
            ->latest()
            ->limit(5)
            ->get();

        // =========================================================
        // إحصائيات التعليقات
        // =========================================================
        $videoIds = Video::where('creator_id', $videoCreator)->pluck('id')->toArray();
        
        $totalComments = Comment::whereIn('commentable_id', $videoIds)
            ->where('commentable_type', 'App\\Models\\Video')
            ->count();
            
        $unreadComments = Comment::whereIn('commentable_id', $videoIds)
            ->where('commentable_type', 'App\\Models\\Video')
            ->whereNull('read_at')
            ->count();

        // أحدث التعليقات
        $recentComments = Comment::with(['user', 'commentable'])
            ->whereIn('commentable_id', $videoIds)
            ->where('commentable_type', 'App\\Models\\Video')
            ->whereNull('parent_id') // التعليقات الأصلية فقط
            ->latest()
            ->limit(5)
            ->get();

        // =========================================================
        // طلبات الإنتاج النشطة (قيد التنفيذ)
        // =========================================================
        $activeRequests = production_request::where('video_creator_id', $videoCreator)
            ->whereIn('status', ['accepted', 'submitted', 'revision_required'])
            ->with(['researcher', 'lesson'])
            ->latest()
            ->limit(5)
            ->get();

        // =========================================================
        // إحصائيات الأداء الشهرية
        // =========================================================
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $monthlyVideos = Video::where('creator_id', $videoCreator)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
            
        $monthlyViews = Video::where('creator_id', $videoCreator)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('views');

        return view('video-dashboard.dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'acceptedRequests',
            'submittedRequests',
            'revisionRequests',
            'approvedRequests',
            'rejectedRequests',
            'totalVideos',
            'totalViews',
            'totalLikes',
            'recentVideos',
            'totalComments',
            'unreadComments',
            'recentComments',
            'activeRequests',
            'monthlyVideos',
            'monthlyViews'
        ));
    }
}
