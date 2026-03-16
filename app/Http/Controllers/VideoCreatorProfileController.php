<?php



namespace App\Http\Controllers;

use App\Models\production_request;
use App\Models\VideoCreator;
use App\Models\Video;
use App\Models\ProductionRequest;
use App\Models\video_creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VideoCreatorProfileController extends Controller
{
    /**
     * إنشاء middleware للتحقق من المستخدم
     */
   

    /**
     * الحصول على منشئ الفيديو الحالي
     */
    private function getVideoCreator()
    {
        $user = Auth::user();
        
        // محاولة الحصول على منشئ الفيديو من العلاقة
        $videoCreator = $user->videoCreator;
        
        // إذا لم يكن موجوداً، حاول البحث في جدول video_creators مباشرة
        if (!$videoCreator) {
            $videoCreator = video_creator::find($user->id);
        }
        
        return $videoCreator;
    }

    /**
     * عرض الملف الشخصي
     */
    public function index()
    {
        $videoCreator = $this->getVideoCreator();
        
        if (!$videoCreator) {
            return redirect()->route('video_creator.dashboard')
                ->with('error', 'لم يتم العثور على بيانات منشئ الفيديو');
        }

        // تحميل المستخدم المرتبط
        $user = Auth::user();

        // إحصائيات إضافية
        $totalVideos = Video::where('creator_id', $videoCreator->id)->count();
        $totalViews = Video::where('creator_id', $videoCreator->id)->sum('views');
        $completedRequests = production_request::where('video_creator_id', $videoCreator->id)
            ->where('status', 'approved')
            ->count();
        $pendingRequests = production_request::where('video_creator_id', $videoCreator->id)
            ->where('status', 'accepted')
            ->count();

        // آخر 5 فيديوهات
        $recentVideos = Video::where('creator_id', $videoCreator->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('video-dashboard.profile.index', compact(
            'videoCreator',
            'user',
            'totalVideos',
            'totalViews',
            'completedRequests',
            'pendingRequests',
            'recentVideos'
        ));
    }

    /**
     * عرض صفحة تعديل الملف الشخصي
     */
    public function edit()
    {
        $videoCreator = $this->getVideoCreator();
        
        if (!$videoCreator) {
            return redirect()->route('video_creator.dashboard')
                ->with('error', 'لم يتم العثور على بيانات منشئ الفيديو');
        }

        $user = Auth::user();

        // تحويل المهارات من JSON إلى مصفوفة
        $skills = is_string($videoCreator->skills) 
            ? json_decode($videoCreator->skills, true) 
            : ($videoCreator->skills ?? []);

        return view('video-dashboard.profile.edit', compact('videoCreator', 'user', 'skills'));
    }

    /**
     * تحديث الملف الشخصي
     */
    public function update(Request $request)
{
    $user = Auth::user();
    $videoCreator = $this->getVideoCreator();
    
    if (!$videoCreator) {
        return redirect()->route('video_creator.dashboard')
            ->with('error', 'لم يتم العثور على بيانات منشئ الفيديو');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'specialization' => 'required|string|max:255',
        'skills' => 'required|array|min:1',
        'skills.*' => 'string',
        'preferred_software' => 'nullable|string|max:255',
        'portfolio_url' => 'nullable|url|max:255',
        'bio' => 'nullable|string|max:1000',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // الصورة الآن في video_creators
    ]);

    DB::beginTransaction();

    try {
        // تحديث معلومات المستخدم الأساسية فقط
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save(); // لا يوجد profile_image هنا

        // تحديث معلومات منشئ الفيديو (بما في ذلك الصورة)
        $videoCreator->specialization = $request->specialization;
        $videoCreator->skills = json_encode($request->skills, JSON_UNESCAPED_UNICODE);
        $videoCreator->preferred_software = $request->preferred_software;
        $videoCreator->portfolio_url = $request->portfolio_url;
        $videoCreator->bio = $request->bio;
        
        // ✅ رفع الصورة الشخصية إلى جدول video_creators
        if ($request->hasFile('profile_image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($videoCreator->profile_image) {
                Storage::disk('public')->delete($videoCreator->profile_image);
            }
            
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $videoCreator->profile_image = $path;
        }
        
        $videoCreator->save();

        DB::commit();

        return redirect()->route('video_creator.profile.index')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
}
    /**
     * تحديث حالة التوفر
     */
    public function updateStatus(Request $request)
    {
        $videoCreator = $this->getVideoCreator();
        
        $request->validate([
            'status' => 'required|in:active,busy,inactive'
        ]);

        $videoCreator->status = $request->status;
        $videoCreator->save();

        return response()->json(['success' => true]);
    }
}