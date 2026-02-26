<?php
// app/Http/Middleware/CheckAccountStatus.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق من وجود مستخدم مسجل دخول
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // إذا كان admin، اسمح له بالدخول دائماً (قارن مع القيمة مباشرة)
        if ($user->user_type === 'admin') {
            return $next($request);
        }

        // التحقق من حالة الحساب (قارن مع القيمة مباشرة)
        if ($user->account_status === 'pending') {
            return redirect()->route('waiting.approval');
        }

        if ($user->account_status === 'rejected') {
            return redirect()->route('rejected.notice');
        }

        // إذا كان approved، اسمح بالدخول
        return $next($request);
    }
}