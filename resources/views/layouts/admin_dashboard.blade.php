{{-- resources/views/layouts/admin_dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة تحكم المسؤول') - مدرستي نور</title>

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
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #7c3aed;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #111827;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #f1f5f9 100%);
            background-attachment: fixed;
        }
        
        /* Custom Scrollbar */
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
        
        /* Smooth Transitions */
        .transition-all-custom {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Card Hover Effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }
        
        /* Mobile Sidebar */
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
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
                z-index: 40;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.3s ease-out;
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
        
        /* Gradient Backgrounds */
        .gradient-primary {
            background: linear-gradient(135deg, #1e40af, #3730a3);
        }
        
        .gradient-success {
            background: linear-gradient(135deg, #059669, #10b981);
        }
        
        .gradient-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }
        
        /* Glass Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Print Styles */
        @media print {
            #sidebar, .no-print, header, footer {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
        }
        
        /* Custom Focus */
        .focus-ring:focus {
            outline: none;
            ring: 2px solid #3b82f6;
            ring-offset: 2px;
        }
        
        /* Blob Animation */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
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
        <div class="absolute -bottom-32 left-20 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4"></div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay transition-all duration-300" :class="{ 'active': sidebarMobileOpen }" @click="sidebarMobileOpen = false"></div>
    
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-lg shadow-md sticky top-0 z-30 print:hidden border-b border-gray-100">
        <div class="px-4 sm:px-6 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center shadow-lg transform transition-transform group-hover:scale-105">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">مدرستي نور</span>
                        <p class="text-xs text-gray-500">لوحة تحكم المسؤول</p>
                    </div>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        الرئيسية
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        الدعم
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        تواصل
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
                                    <span class="text-xs text-blue-600">12 جديد</span>
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <div class="p-4 hover:bg-gray-50 transition-all duration-300 cursor-pointer border-b border-gray-50">
                                    <p class="text-sm text-gray-700">12 طلب تسجيل جديد في انتظار المراجعة</p>
                                    <p class="text-xs text-gray-400 mt-1">منذ 5 دقائق</p>
                                </div>
                                <div class="p-4 hover:bg-gray-50 transition-all duration-300 cursor-pointer border-b border-gray-50">
                                    <p class="text-sm text-gray-700">تم إضافة 5 اختبارات جديدة</p>
                                    <p class="text-xs text-gray-400 mt-1">منذ ساعة</p>
                                </div>
                                <div class="p-4 hover:bg-gray-50 transition-all duration-300 cursor-pointer">
                                    <p class="text-sm text-gray-700">تحديث جديد للنظام متاح</p>
                                    <p class="text-xs text-gray-400 mt-1">منذ 3 ساعات</p>
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
                                <span class="text-white font-bold text-lg">أ</span>
                            </div>
                            <div class="hidden lg:block text-right">
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name ?? 'أحمد المدير' }}</p>
                                <p class="text-xs text-gray-500">مسؤول النظام</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 animate-slide-in-right" x-cloak>
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-xl">أ</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ Auth::user()->name ?? 'أحمد المدير' }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@madrasati-noor.com' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <a href="" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
                                    <i class="fas fa-user w-5 text-gray-400 group-hover:text-blue-600"></i>
                                    <span class="group-hover:text-blue-600">الملف الشخصي</span>
                                </a>
                                <a href="" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
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
                                <span class="text-white font-bold text-xl">أ</span>
                            </div>
                            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-gray-800 animate-pulse"></div>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-bold">{{ Auth::user()->name ?? 'أحمد المدير' }}</p>
                            <p class="text-gray-400 text-sm">مسؤول النظام</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="space-y-1.5">
                    <!-- Dashboard Home -->
                    <a href="" class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">الرئيسية</span>
                    </a>
                    
                    <!-- User Management Dropdown -->
                    <div x-data="{ open: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-users w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">إدارة المستخدمين</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-users w-4"></i>
                                <span>جميع المستخدمين</span>
                            </a>
                            <a href="{{ route('admin.users.index', ['user_type' => 'teacher']) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-chalkboard-user w-4"></i>
                                <span>المعلمون</span>
                            </a>
                            <a href="{{ route('admin.users.index', ['user_type' => 'student']) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-user-graduate w-4"></i>
                                <span>الطلاب</span>
                            </a>
                            <a href="{{ route('admin.users.index', ['user_type' => 'researcher']) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-microscope w-4"></i>
                                <span>الباحثون</span>
                            </a>
                            <a href="{{ route('admin.users.index', ['account_status' => 'pending']) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-yellow-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-clock w-4"></i>
                                <span>طلبات التسجيل</span>
                                <span class="mr-auto text-xs bg-yellow-600 px-2 py-0.5 rounded-full">12</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Academic Management Dropdown -->
                    <div x-data="{ open: {{ request()->routeIs('admin.subjects.*') || request()->routeIs('admin.fields-of-study.*') || request()->routeIs('admin.classrooms.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-graduation-cap w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">الإدارة الأكاديمية</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="{{ route('admin.fields-of-study.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-layer-group w-4"></i>
                                <span>الشعب الدراسية</span>
                            </a>
                            <a href="{{ route('admin.subjects.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-book w-4"></i>
                                <span>المواد الدراسية</span>
                            </a>
                            <a href="{{ route('admin.classrooms.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-chalkboard w-4"></i>
                                <span>الفصول الدراسية</span>
                            </a>
                            <a href="" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-calendar-alt w-4"></i>
                                <span>السنوات الدراسية</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Content Management Dropdown -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-book-open w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">إدارة المحتوى</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-video w-4"></i>
                                <span>الدروس</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-tasks w-4"></i>
                                <span>التمارين</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-file-alt w-4"></i>
                                <span>الاختبارات</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-chart-line w-4"></i>
                                <span>المهارات</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Reports Dropdown -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-chart-bar w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">التقارير</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-chalkboard-user w-4"></i>
                                <span>تقارير المعلمين</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-user-graduate w-4"></i>
                                <span>تقارير الطلاب</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-chart-line w-4"></i>
                                <span>التقارير الأكاديمية</span>
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
                                <i class="fas fa-globe w-4"></i>
                                <span>الإعدادات العامة</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-shield-alt w-4"></i>
                                <span>الصلاحيات</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-database w-4"></i>
                                <span>النسخ الاحتياطي</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- System Monitor -->
                    <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-server w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">مراقبة النظام</span>
                    </a>
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
    
    @stack('scripts')
</body>
</html>