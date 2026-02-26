{{-- resources/views/auth/waiting-approval.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>قيد المراجعة - المنصة التعليمية</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1rem;
        }
        .waiting-card {
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 max-w-md w-full waiting-card border-4 border-amber-400">
        <!-- Icon Animation -->
        <div class="text-center mb-8">
            <div class="w-28 h-28 bg-amber-100 rounded-full flex items-center justify-center mx-auto pulse shadow-lg">
                <svg class="w-16 h-16 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Welcome Message -->
        <h1 class="text-3xl font-black text-gray-900 text-center mb-4">
            مرحباً بك في المنصة! 🎉
        </h1>
        
        <p class="text-lg text-gray-700 text-center mb-6">
            شكراً لتسجيلك في المنصة التعليمية
        </p>

        <!-- Status Card -->
        <div class="bg-amber-50 rounded-2xl p-6 mb-6 border-2 border-amber-200">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 bg-amber-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-amber-800 font-bold mb-1">معلومات الحساب</p>
                    <p class="text-base text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    <p class="text-sm text-amber-700 mt-2">
                        نوع الحساب: 
                        <span class="font-bold">
                            @switch(auth()->user()->user_type)
                                @case('teacher') معلم @break
                                @case('researcher') باحث @break
                                @case('parent') ولي أمر @break
                                @case('student') طالب @break
                                @case('admin') مدير @break
                                @case('video_creator') منشئ فيديوهات @break
                                @default غير محدد
                            @endswitch
                        </span>
                    </p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-amber-200 rounded-full h-2.5 mb-4">
                <div class="bg-amber-600 h-2.5 rounded-full w-1/3"></div>
            </div>

            <!-- Status Message -->
            <div class="text-center">
                <span class="inline-block bg-amber-600 text-white px-4 py-2 rounded-full text-sm font-bold">
                    ⏳ قيد المراجعة
                </span>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 rounded-2xl p-5 mb-6 border-2 border-blue-200">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-blue-800 mb-2">ماذا يحدث الآن؟</p>
                    <ul class="text-sm text-blue-700 space-y-2 list-disc list-inside">
                        <li>سيتم مراجعة بياناتك من قبل فريق الإدارة</li>
                        <li>عملية المراجعة تستغرق عادة 24-48 ساعة</li>
                        <li>ستتصل بك الإدارة عند اكتمال المراجعة</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Important Note -->
        <div class="bg-purple-50 rounded-2xl p-5 mb-8 border-2 border-purple-200">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.333-2.694-1.333-3.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-purple-800 mb-2">ملاحظة هامة</p>
                    <p class="text-sm text-purple-700">
                        لا يمكنك الوصول إلى لوحة التحكم إلا بعد موافقة الإدارة على حسابك.
                        سيتم إشعارك عبر البريد الإلكتروني عند الموافقة.
                    </p>
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="mt-8 pt-6 border-t border-gray-700">
                <a href="{{ route('logout') }}" class="flex items-center justify-end w-full py-3 px-4 rounded-lg text-red-400 hover:bg-gray-700 hover:text-red-300 transition-all-custom focus-ring group">
                    <span class="text-base font-medium ml-3">تسجيل الخروج</span>
                    <div class="w-8 h-8 rounded-lg bg-red-900/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                </a>
            </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-gray-500 text-sm">
            © 2026 المنصة التعليمية - جميع الحقوق محفوظة
        </div>
    </div>
</body>
</html>