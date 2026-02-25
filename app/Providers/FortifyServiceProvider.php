<?php
// app/Providers/FortifyServiceProvider.php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register actions
        Fortify::createUsersUsing(CreateNewUser::class);
        
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // ===== إضافة الـ Views =====
        
        // صفحة تسجيل الدخول
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // صفحة التسجيل
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // صفحة نسيت كلمة المرور
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        // صفحة إعادة تعيين كلمة المرور
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        // صفحة تأكيد البريد الإلكتروني
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        // صفحة تأكيد كلمة المرور (للإجراءات الحساسة)
        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });

        // صفحة المصادقة الثنائية
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        // ===== Rate Limiting =====
        
        // تحديد معدل محاولات تسجيل الدخول
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        // تحديد معدل محاولات المصادقة الثنائية
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}