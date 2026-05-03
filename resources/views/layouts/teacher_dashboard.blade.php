<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة تحكم المعلمين') - مدرستي نور</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-red: #dc2626;
            --dark-bg: #111827;
            --sidebar-bg: #0f172a;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #f1f5f9 100%);
            background-attachment: fixed;
        }
        
        /* Custom scrollbar */
        .sidebar-wrapper::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 10px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        
        /* Smooth transitions */
        .transition-all-custom {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Card shadows for depth */
        .card-shadow {
            box-shadow: var(--card-shadow);
        }
        
        /* Glass morphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Gradient backgrounds */
        .gradient-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #3730a3 100%);
        }
        
        .gradient-red {
            background: linear-gradient(135deg, var(--primary-red) 0%, #991b1b 100%);
        }
        
        /* Mobile sidebar positioning */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                z-index: 50;
                transition: right 0.3s ease-in-out;
            }
            #sidebar.open {
                right: 0;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
                z-index: 40;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
        
        /* Animation classes */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.3s ease-out;
        }
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        .animation-delay-2 {
            animation-delay: 2s;
        }
        
        .animation-delay-4 {
            animation-delay: 4s;
        }
        
        /* Active Menu Item */
        .nav-item.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(139, 92, 246, 0.15));
            color: #ffffff;
            border-right: 3px solid #3b82f6;
        }
        
        .nav-item.active i {
            color: #3b82f6;
        }
        
        /* Hover effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }
        
        /* Custom focus styles */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
    </style>
    
    @stack('styles')
</head>

<body x-data="{ 
    sidebarOpen: false, 
    sidebarMobileOpen: false,
    userMenuOpen: false,
    notificationsOpen: false
}" class="relative">
    
    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-20 -left-20 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 -right-20 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2"></div>
        <div class="absolute -bottom-32 left-20 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4"></div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay transition-all duration-300" :class="{ 'active': sidebarMobileOpen }" @click="sidebarMobileOpen = false"></div>
    
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-lg shadow-md sticky top-0 z-30 print:hidden border-b border-gray-100">
        <div class="px-4 sm:px-6 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="index.html" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center shadow-lg transform transition-transform group-hover:scale-105">
                        <i class="fas fa-chalkboard-user text-white text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">مدرستي نور</span>
                        <p class="text-xs text-gray-500">لوحة تحكم المعلمين</p>
                    </div>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="index.html" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        الرئيسية
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        الدروس
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        الطلاب
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>
                
                <!-- Right Section -->
                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 rounded-xl hover:bg-gray-100 transition-all duration-300 relative group">
                            <i class="fas fa-bell text-gray-600 text-lg group-hover:text-blue-600 transition-colors"></i>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 animate-slide-in-right" x-cloak>
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-bold text-gray-800">الإشعارات</h4>
                                    <span class="text-xs text-blue-600">5 جديد</span>
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <div class="p-4 hover:bg-gray-50 transition-all duration-300 cursor-pointer border-b border-gray-50">
                                    <p class="text-sm text-gray-700">تم إضافة طالب جديد إلى صفك</p>
                                    <p class="text-xs text-gray-400 mt-1">منذ ساعة</p>
                                </div>
                                <div class="p-4 hover:bg-gray-50 transition-all duration-300 cursor-pointer border-b border-gray-50">
                                    <p class="text-sm text-gray-700">طلب تصحيح امتحان في انتظار المراجعة</p>
                                    <p class="text-xs text-gray-400 mt-1">منذ 3 ساعات</p>
                                </div>
                                <div class="p-4 hover:bg-gray-50 transition-all duration-300 cursor-pointer">
                                    <p class="text-sm text-gray-700">اجتماع هيئة التدريس غداً الساعة 10 صباحاً</p>
                                    <p class="text-xs text-gray-400 mt-1">منذ يوم</p>
                                </div>
                            </div>
                            <div class="p-3 border-t border-gray-100 text-center">
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">عرض جميع الإشعارات</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 p-1 rounded-xl hover:bg-gray-100 transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-lg">م</span>
                            </div>
                            <div class="hidden lg:block text-right">
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name ?? 'محمد المعلم' }}</p>
                                <p class="text-xs text-gray-500">معلم</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 animate-slide-in-right" x-cloak>
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-xl">م</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ Auth::user()->name ?? 'محمد المعلم' }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'mohamed.teacher@example.com' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
                                    <i class="fas fa-user w-5 text-gray-400 group-hover:text-blue-600"></i>
                                    <span class="group-hover:text-blue-600">الملف الشخصي</span>
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
                                    <i class="fas fa-cog w-5 text-gray-400 group-hover:text-blue-600"></i>
                                    <span class="group-hover:text-blue-600">الإعدادات</span>
                                </a>
                            </div>
                            <div class="p-2 border-t border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 group">
                                        <i class="fas fa-sign-out-alt w-5"></i>
                                        <span>تسجيل الخروج</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarMobileOpen = true" class="md:hidden p-2 rounded-xl hover:bg-gray-100 transition-all duration-300">
                        <i class="fas fa-bars text-gray-600 text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="flex min-h-screen relative z-10">
        <!-- Sidebar -->
        <aside id="sidebar" :class="{ 'open': sidebarMobileOpen }" class="w-72 bg-gradient-to-b from-gray-900 to-gray-800 shadow-2xl overflow-y-auto sidebar-wrapper fixed lg:relative z-40" x-cloak>
            <div class="p-5">
                <!-- User Profile Section -->
                <div class="relative mb-6 pb-5 border-b border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg transform transition-transform hover:scale-105">
                                <span class="text-white font-bold text-xl">م</span>
                            </div>
                            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-gray-800 animate-pulse"></div>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-bold">{{ Auth::user()->name ?? 'محمد المعلم' }}</p>
                            <p class="text-gray-400 text-sm">معلم</p>
                        </div>
                        <button id="profile-info-button" class="p-2 rounded-xl text-gray-400 hover:text-white hover:bg-gray-700/50 transition-all duration-300">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </div>
                    
                    <!-- Teacher Info Popover -->
                    <div id="teacher-info-popover" class="absolute bg-gray-800 text-white p-4 rounded-2xl shadow-2xl z-50 w-72 top-full left-0 mt-2 hidden animate-slide-in-right border border-gray-700">
                        <h4 class="text-lg font-bold mb-3 border-b border-gray-700 pb-2 text-right">تفاصيل الحساب</h4>
                        <div class="space-y-3 text-right">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">الاسم:</span>
                                <span class="text-gray-100">{{ Auth::user()->name ?? 'محمد المعلم' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">البريد الإلكتروني:</span>
                                <span class="text-gray-300 text-xs truncate max-w-[120px]">{{ Auth::user()->email ?? 'mohamed.teacher@example.com' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">تاريخ التسجيل:</span>
                                <span class="text-gray-100">01 يناير 2023</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">الدور:</span>
                                <span class="text-blue-400 font-medium">معلم</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">المادة:</span>
                                <span class="text-yellow-400 font-medium">الرياضيات</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">الصفوف:</span>
                                <span class="text-green-400 font-medium">الرابع - السادس</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dashboard Title -->
                <h3 class="text-lg font-medium text-gray-300 mb-4 text-right px-2">لوحة تحكم المعلمين</h3>
                
                <!-- Navigation Menu -->
                <nav class="space-y-1.5">
                    <!-- Dashboard Home -->
                    <a href="{{ route('teacher.dashboard') }}" class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">الرئيسية</span>
                    </a>
                    
                    <!-- Lessons -->
                    <a href="{{ route('teacher_lesson.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-book-open w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">الدروس</span>
                    </a>
                    
                    <!-- Students Dropdown -->
                    <div x-data="{ open: {{ request()->routeIs('Interaction_Notes_student.*') || request()->routeIs('Exam_Grade.*') || request()->routeIs('teacher.exams.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-users w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">التلاميذ</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="{{ route('Interaction_Notes_student.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-sticky-note w-4"></i>
                                <span>ملاحظات التفاعل</span>
                            </a>
                            <a href="{{ route('Exam_Grade.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-check-double w-4"></i>
                                <span>تصحيح الامتحانات</span>
                            </a>
                            <a href="{{ route('teacher.exams.list') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-file-alt w-4"></i>
                                <span>الامتحانات</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Psychology Dropdown -->
                    <div x-data="{ open: {{ request()->routeIs('StudentPsychology.*') || request()->routeIs('student_psychology_response') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-brain w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">النفسية</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="{{ route('StudentPsychology.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-notes-medical w-4"></i>
                                <span>ملاحظات يومية</span>
                            </a>
                            <a href="{{ route('student_psychology_response') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-reply-all w-4"></i>
                                <span>ردود الادارة النفسية</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Communication Dropdown -->
                    <div x-data="{ open: {{ request()->routeIs('teacher_admine_reports.*') || request()->routeIs('lesson_report') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-comments w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">التواصل</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="{{ route('teacher_admine_reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-building w-4"></i>
                                <span>رسائل الإدارة</span>
                            </a>
                            <a href="{{ route('lesson_report') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-microscope w-4"></i>
                                <span>رسائل الباحث</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Settings Dropdown -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-cog w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">الإعدادات</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-user w-4"></i>
                                <span>الحساب</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-bell w-4"></i>
                                <span>التنبيهات</span>
                            </a>
                        </div>
                    </div>
                </nav>
                
                <!-- Logout Button -->
                <div class="mt-8 pt-5 border-t border-gray-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-red-400 hover:bg-red-900/20 hover:text-red-300 transition-all duration-300 group">
                            <i class="fas fa-sign-out-alt w-5 group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm font-medium">تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <div class="flex-1 w-full">
            <div class="p-4 sm:p-6 lg:p-8 animate-fade-in-up">
                @yield('content')
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-lg border-t border-gray-100 py-6 print:hidden relative z-10">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-right">
                <p class="text-gray-500 text-sm">© {{ date('Y') }} مدرستي نور. جميع الحقوق محفوظة</p>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white transition-all duration-300">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-400 hover:text-white transition-all duration-300">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-blue-700 hover:text-white transition-all duration-300">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-red-600 hover:text-white transition-all duration-300">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profileInfoButton = document.getElementById('profile-info-button');
            const teacherInfoPopover = document.getElementById('teacher-info-popover');
            
            // Toggle teacher info popover
            if (profileInfoButton && teacherInfoPopover) {
                profileInfoButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    teacherInfoPopover.classList.toggle('hidden');
                });
                
                // Close popover when clicking outside
                document.addEventListener('click', (event) => {
                    if (!teacherInfoPopover.classList.contains('hidden') && 
                        !teacherInfoPopover.contains(event.target) && 
                        !profileInfoButton.contains(event.target)) {
                        teacherInfoPopover.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>