<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckAccountStatus; // استيراد الـ Middleware
use App\Http\Middleware\UserTypeMiddleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // تسجيل Middleware كـ alias (للإستخدام في routes)
        $middleware->alias([
            'check.status' => CheckAccountStatus::class,
            'user.type' => UserTypeMiddleware::class,
        ]);
        
        // إذا أردت إضافة Middleware لجميع الطلبات
        // $middleware->append(CheckAccountStatus::class);
        
        // إذا أردت إضافة Middleware لمجموعة معينة (مثل web)
        // $middleware->appendToGroup('web', CheckAccountStatus::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();