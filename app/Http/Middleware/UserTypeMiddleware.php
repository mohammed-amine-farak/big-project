<?php
// app/Http/Middleware/UserTypeMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$types  // أنواع المستخدمين المسموح بها
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        // التحقق من وجود مستخدم مسجل دخول
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // التحقق من حالة الحساب أولاً (يجب أن يكون approved)
        if ($user->account_status !== 'approved' && $user->user_type !== 'admin') {
            if ($user->account_status === 'pending') {
                return redirect()->route('waiting.approval');
            }
            if ($user->account_status === 'rejected') {
                return redirect()->route('rejected.notice');
            }
        }

        // التحقق من نوع المستخدم
        if (!in_array($user->user_type, $types)) {
            // إذا كان المستخدم admin، اسمح له بالدخول (صلاحيات كاملة)
            if ($user->user_type === 'admin') {
                return $next($request);
            }
            
            // إذا لم يكن مسموحاً له، ارجع صفحة خطأ
            abort(403, 'ليس لديك صلاحية الوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}