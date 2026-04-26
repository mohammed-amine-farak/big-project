<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
        public function index(Request $request)
    {
        $query = User::with(['studentProfile', 'researcherProfile', 'teacherProfile', 'videoCreatorProfile']);
       
        // Filter by user type
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        // Filter by account status
        if ($request->filled('account_status')) {
            $query->where('account_status', $request->account_status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'pending' => User::where('account_status', 'pending')->count(),
            'approved' => User::where('account_status', 'approved')->count(),
            'rejected' => User::where('account_status', 'rejected')->count(),
            'teachers' => User::where('user_type', 'teacher')->count(),
            'students' => User::where('user_type', 'student')->count(),
            'researchers' => User::where('user_type', 'researcher')->count(),
            'video_creators' => User::where('user_type', 'video_creator')->count(),
        ];

        return view('admine-dashboard.users.index', compact('users', 'stats'));
    }
    public function show($id)
    {
        $user = User::with(['studentProfile.fieldStudy', 'researcherProfile', 'teacherProfile', 'videoCreatorProfile'])->findOrFail($id);
        
        // Get additional data based on user type
        $additionalData = null;
        
        switch ($user->user_type) {
            case 'student':
                $additionalData = $user->studentProfile;
              
                break;
            case 'teacher':
                $additionalData = $user->teacherProfile;
                break;
            case 'researcher':
                $additionalData = $user->researcherProfile;
                break;
            case 'video_creator':
                $additionalData = $user->videoCreatorProfile;
                break;
        }
        
        return view('admine-dashboard.users.show', compact('user', 'additionalData'));
    }

    /**
     * Approve a user account.
     */
    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->account_status = 'approved';
        $user->approved_at = now();
        $user->approved_by =17;
        $user->rejection_reason = null;
        $user->save();

        // You can add notification here
        // Notification::send($user, new AccountApprovedNotification());

        return redirect()->back()->with('success', 'تم قبول حساب المستخدم بنجاح');
    }

    /**
     * Reject a user account with reason.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500'
        ]);

        $user = User::findOrFail($id);
        
        $user->account_status = 'rejected';
        $user->approved_at = now();
        $user->approved_by = 17;
        $user->rejection_reason = $request->rejection_reason;
        $user->save();

        // You can add notification here
        // Notification::send($user, new AccountRejectedNotification($request->rejection_reason));

        return redirect()->back()->with('warning', 'تم رفض حساب المستخدم');
    }

    /**
     * Delete a user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Delete related records based on user type
        switch ($user->user_type) {
            case 'student':
                $user->studentProfile()->delete();
                break;
            case 'teacher':
                $user->teacherProfile()->delete();
                break;
            case 'researcher':
                $user->researcherProfile()->delete();
                break;
            case 'video_creator':
                $user->videoCreatorProfile()->delete();
                break;
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }

    /**
     * Bulk approve selected users.
     */
    public function bulkApprove(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id', $ids)->update([
            'account_status' => 'approved',
            'approved_at' => now(),
            'approved_by' =>17,
            'rejection_reason' => null
        ]);

        return response()->json(['success' => true, 'message' => 'تم قبول المستخدمين المحددين']);
    }

}
