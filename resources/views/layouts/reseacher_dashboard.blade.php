<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة تحكم الباحثين') - مدرستي نور</title>

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
    
    <!-- MathJax for mathematical equations -->
    <script>
        MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']],
                processEscapes: true,
                processEnvironments: true
            },
            options: {
                skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre']
            },
            svg: {
                fontCache: 'global'
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>

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
                <a href="index.html" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center shadow-lg transform transition-transform group-hover:scale-105">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">مدرستي نور</span>
                        <p class="text-xs text-gray-500">لوحة تحكم الباحثين</p>
                    </div>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="index.html" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        الرئيسية
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="team.html" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        هيئة التدريس
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="about.html" class="text-gray-600 hover:text-blue-600 transition-all duration-300 font-medium relative group">
                        عنا
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>
                
                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="" class="font-semibold text-gray-600 hover:text-blue-600 transition-colors">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="gradient-danger text-white px-5 py-2 rounded-xl font-bold hover:shadow-lg transition-all duration-300 hover-lift">
                        إنشاء حساب مجاني
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="sidebarMobileOpen = true" class="text-gray-600 p-2 rounded-xl hover:bg-gray-100 transition-all duration-300">
                        <i class="fas fa-bars text-xl"></i>
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
                            <p class="text-white font-bold">أحمد</p>
                            <p class="text-gray-400 text-sm">باحث</p>
                        </div>
                        <button id="profile-info-button" class="p-2 rounded-xl text-gray-400 hover:text-white hover:bg-gray-700/50 transition-all duration-300">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </div>
                    
                    <!-- Researcher Info Popover -->
                    <div id="researcher-info-popover" class="absolute bg-gray-800 text-white p-4 rounded-2xl shadow-2xl z-50 w-72 top-full left-0 mt-2 hidden animate-slide-in-right border border-gray-700">
                        <h4 class="text-lg font-bold mb-3 border-b border-gray-700 pb-2 text-right">تفاصيل الحساب</h4>
                        <div class="space-y-3 text-right">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">الاسم:</span>
                                <span class="text-gray-100">أحمد</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">البريد الإلكتروني:</span>
                                <span class="text-gray-300 text-xs truncate max-w-[120px]">ahmed.researcher@example.com</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">تاريخ التسجيل:</span>
                                <span class="text-gray-100">01 يناير 2023</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">الدور:</span>
                                <span class="text-blue-400 font-medium">باحث</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">نقاط الخبرة:</span>
                                <span class="text-yellow-400 font-medium">4250 XP</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-400">المشاريع المكتملة:</span>
                                <span class="text-green-400 font-medium">15 مشروع</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dashboard Title -->
                <h3 class="text-lg font-medium text-gray-300 mb-4 text-right px-2">لوحة تحكم الباحثين</h3>
                
                <!-- Navigation Menu -->
                <nav class="space-y-1.5">
                    <!-- Dashboard Home -->
                    <a href="" class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-chart-pie w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">الرئيسية</span>
                    </a>
                    
                    <!-- Articles Dropdown -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-book w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">المقالات</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="{{ route('lessons.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-video w-4"></i>
                                <span>الدروس</span>
                            </a>
                            <a href="{{ route('rules.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-tasks w-4"></i>
                                <span>القواعد</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Exams Dropdown -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-file-alt w-5 group-hover:scale-110 transition-transform"></i>
                                <span class="text-sm font-medium">الاختبارات</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-all duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pr-8 mt-1 space-y-1">
                            <a href="{{ route('exam.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-file-alt w-4"></i>
                                <span>الاختبارات</span>
                            </a>
                            <a href="{{ route('exam_weeckly.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-calendar-week w-4"></i>
                                <span>الاختبار الاسبوعي</span>
                            </a>
                            <a href="{{ route('Exam_skill.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-400 hover:bg-gray-700/50 hover:text-white text-sm transition-all duration-300">
                                <i class="fas fa-chart-line w-4"></i>
                                <span>مهارات الاختبار</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Progress Tracker -->
                    <a href="{{ route('lessons.ProgressTracker') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-chart-simple w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">تتبع التقدم</span>
                    </a>
                    
                    <!-- Production Requests -->
                    <a href="{{ route('researcher.production_requests.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-clipboard-list w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">طلبات الانتاج</span>
                    </a>
                    
                    <!-- Skills -->
                    <a href="{{ route('skills.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-brain w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">المهارات</span>
                    </a>
                    
                    <!-- Teacher Reports -->
                    <a href="{{ route('lesson-reports.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-chalkboard-user w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">تقارير المعلمين</span>
                    </a>
                    
                    <!-- Administration -->
                    <a href="{{ route('admine_report.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-building w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">الادارة</span>
                    </a>
                    
                    <!-- Student Reports -->
                    <a href="{{ route('lessons.student_reports') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all duration-300 group">
                        <i class="fas fa-users w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">تقارير الطلاب</span>
                    </a>
                </nav>
                
                <!-- Logout Button -->
                <div class="mt-8 pt-5 border-t border-gray-700">
                    <a href="{{ route('logout') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-red-400 hover:bg-red-900/20 hover:text-red-300 transition-all duration-300 group">
                        <i class="fas fa-sign-out-alt w-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">تسجيل الخروج</span>
                    </a>
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
                <p class="text-gray-500 text-sm">© 2024 مدرستي نور. جميع الحقوق محفوظة</p>
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
            const researcherInfoPopover = document.getElementById('researcher-info-popover');
            
            // Toggle researcher info popover
            if (profileInfoButton && researcherInfoPopover) {
                profileInfoButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    researcherInfoPopover.classList.toggle('hidden');
                });
                
                // Close popover when clicking outside
                document.addEventListener('click', (event) => {
                    if (!researcherInfoPopover.classList.contains('hidden') && 
                        !researcherInfoPopover.contains(event.target) && 
                        !profileInfoButton.contains(event.target)) {
                        researcherInfoPopover.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>