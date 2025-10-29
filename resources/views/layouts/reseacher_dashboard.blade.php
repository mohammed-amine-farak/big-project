<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الباحثين - مدرستي نور</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-red: #dc2626;
            --dark-bg: #111827;
            --sidebar-bg: #1f2937;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
            color: #1a202c;
        }
        
        /* Custom scrollbar */
        .sidebar-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: #2d3748;
            border-radius: 10px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 10px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }
        
        /* Smooth transitions */
        .transition-all-custom {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
                height: calc(100vh - 60px);
                z-index: 40;
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
            }
            #sidebar.open {
                transform: translateX(0);
            }
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 30;
            }
            .overlay.active {
                display: block;
            }
        }
        
        /* Animation classes */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Hover effects */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Custom focus styles */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
    </style>
</head>

<body class="text-gray-900 bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="index.html" class="flex items-center space-x-2 space-x-reverse">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-purple-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <span class="text-xl font-black text-blue-900">مدرستي نور</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="index.html" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors relative group">
                        الرئيسية
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="team.html" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors relative group">
                        هيئة التدريس
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="about.html" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors relative group">
                        عنا
                        <span class="absolute bottom-0 right-0 w-0 h-0.5 bg-blue-600 transition-all group-hover:w-full"></span>
                    </a>
                </div>

                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                    <a href="#" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors">تسجيل الدخول</a>
                    <a href="#" class="gradient-red text-white px-5 py-2 rounded-lg font-bold hover:shadow-lg transition-all duration-300 hover-lift">
                        إنشاء حساب مجاني
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-sidebar-toggle" class="text-gray-700 p-2 rounded-md hover:bg-gray-100 transition-colors focus-ring">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="overlay"></div>
    
    <!-- Main Content -->
    <main class="flex flex-col lg:flex-row-reverse min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="w-full lg:w-72 bg-gray-800 p-4 lg:p-6 shadow-xl sidebar-wrapper overflow-y-auto">
            <!-- User Profile Section -->
            <div class="relative flex flex-row-reverse justify-between items-center px-3 py-4 mb-6 pb-4 border-b border-gray-700">
                <button id="profile-info-button" class="p-2 rounded-full text-gray-300 hover:text-white hover:bg-gray-700 transition-colors focus-ring">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <div class="flex items-center">
                    <div class="ml-3 relative">
                        <div class="rounded-full w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-md">
                            <span class="text-white font-bold text-lg">أ</span>
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-gray-800"></span>
                    </div>
                    <div class="text-right">
                        <p class="text-white font-medium">أحمد</p>
                        <p class="text-gray-400 text-sm">باحث</p>
                    </div>
                </div>

                <!-- Student Info Popover -->
                <div id="student-info-popover" class="absolute bg-gray-700 text-white p-4 rounded-xl shadow-lg z-50 w-72
                            top-full right-0 mt-2 hidden card-shadow animate-fade-in">
                    <h4 class="text-lg font-bold mb-3 border-b border-gray-600 pb-2 text-right">تفاصيل الحساب</h4>
                    <div class="space-y-3 text-right">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-300">الاسم:</span>
                            <span class="text-gray-100">أحمد</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-300">البريد الإلكتروني:</span>
                            <span class="text-gray-400 text-xs truncate max-w-[120px]">ahmed.researcher@example.com</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-300">تاريخ التسجيل:</span>
                            <span class="text-gray-100">01 يناير 2023</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-300">الدور:</span>
                            <span class="text-blue-400 font-medium">باحث</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-300">نقاط الخبرة:</span>
                            <span class="text-yellow-400 font-medium">4250 XP</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-300">المشاريع المكتملة:</span>
                            <span class="text-green-400 font-medium">15 مشروع</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Title -->
            <h3 class="text-lg font-medium text-gray-300 mb-6 text-right px-3">لوحة تحكم الباحثين</h3>
            
            <!-- Navigation Menu -->
            <ul class="space-y-2">
                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-3 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all-custom focus-ring group">
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-8 h-8 rounded-lg bg-blue-900/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.523 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-base font-medium">المقالات</span>
                        </div>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-2 pl-8 border-r-2 border-blue-500 mr-4">
                        <li>
                            <a href="{{ route('lessons.index') }}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-sm font-normal group">
                                <span class="relative">
                                    الدروس
                                    <span class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1 h-1 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rules.index') }}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-sm font-normal group">
                                <span class="relative">
                                    القواعد
                                    <span class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1 h-1 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-3 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all-custom focus-ring group">
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-8 h-8 rounded-lg bg-green-900/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <span class="text-base font-medium">الاختبارات</span>
                        </div>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-2 pl-8 border-r-2 border-green-500 mr-4">
                        <li>
                            <a href="{{ route('exam.index') }}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-sm font-normal group">
                                <span class="relative">
                                    الاختبارات
                                    <span class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('exam_weeckly.index')}}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-sm font-normal group">
                                <span class="relative">
                                   الاختبار الاسبوعي
                                    <span class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('Exam_skill.index')}}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-sm font-normal group">
                                <span class="relative">
                                    مهارات الاختبار
                                    <span class="absolute right-0 top-1/2 transform -translate-y-1/2 w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Other menu items with improved styling -->
                <li>
                    <a href="{{ route('lessons.ProgressTracker') }}" class="sidebar-toggle-btn flex flex-row-reverse items-center justify-between w-full py-3 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all-custom focus-ring group">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-8 h-8 rounded-lg bg-purple-900/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8" />
                                </svg>
                            </div>
                            <span class="text-base font-medium">تتبع التقدم</span>
                        </div>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('skills.index')}}" class="sidebar-toggle-btn flex flex-row-reverse items-center justify-between w-full py-3 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all-custom focus-ring group">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-8 h-8 rounded-lg bg-yellow-900/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.942 3.313.842 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.942 1.543-.842 3.313-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.942-3.313-.842-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.942-1.543.842-3.313 2.37-2.37.527.288 1.137.432 1.724.432s1.197-.144 1.724-.432z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-base font-medium">المهارات</span>
                        </div>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('lesson-reports.index') }}" class="sidebar-toggle-btn flex flex-row-reverse items-center justify-between w-full py-3 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all-custom focus-ring group">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-8 h-8 rounded-lg bg-indigo-900/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 00-4-4H5a2 2 0 00-2 2v4h6zM16 17v-2a4 4 0 00-4-4h-1a2 2 0 00-2 2v4h7zM18 7h-1.586a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 011.414-1.414l2.414 2.414A1 1 0 0118 5.414V7z" />
                                </svg>
                            </div>
                            <span class="text-base font-medium">تقارير المعلمين</span>
                        </div>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admine_report.index') }}"  class="sidebar-toggle-btn flex flex-row-reverse items-center justify-between w-full py-3 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all-custom focus-ring group">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-8 h-8 rounded-lg bg-pink-900/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h8M8 15h5m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-base font-medium">الادارة</span>
                        </div>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('lessons.student_reports') }}" class="sidebar-toggle-btn flex flex-row-reverse items-center justify-between w-full py-3 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all-custom focus-ring group">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-8 h-8 rounded-lg bg-teal-900/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                                </svg>
                            </div>
                            <span class="text-base font-medium">تقارير الطلاب</span>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- Logout Button -->
            <div class="mt-8 pt-6 border-t border-gray-700">
                <a href="#" class="flex items-center justify-end w-full py-3 px-4 rounded-lg text-red-400 hover:bg-gray-700 hover:text-red-300 transition-all-custom focus-ring group">
                    <span class="text-base font-medium ml-3">تسجيل الخروج</span>
                    <div class="w-8 h-8 rounded-lg bg-red-900/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 w-full p-4 sm:p-6 lg:p-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 sm:px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right">
                <div>
                    <h3 class="text-xl font-black text-white flex items-center justify-end">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-purple-700 flex items-center justify-center ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                        </div>
                        مدرستي نور
                    </h3>
                    <p class="mt-2 text-gray-400 text-sm">التميز الأكاديمي. متاح للجميع.</p>
                </div>
                <div>
                    <h4 class="font-bold tracking-wider uppercase text-sm">روابط</h4>
                    <ul class="mt-4 space-y-2">
                        <li><a href="index.html" class="text-gray-400 hover:text-white text-sm transition-colors">الرئيسية</a></li>
                        <li><a href="team.html" class="text-gray-400 hover:text-white text-sm transition-colors">هيئة التدريس</a></li>
                        <li><a href="about.html" class="text-gray-400 hover:text-white text-sm transition-colors">عنا</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">سياسة الخصوصية</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold tracking-wider uppercase text-sm">تابعنا</h4>
                    <div class="mt-4 flex space-x-4 space-x-reverse justify-end">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors p-2 rounded-full hover:bg-gray-800">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors p-2 rounded-full hover:bg-gray-800">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-6 text-center text-gray-500 text-xs">
                <p>© 2024 مدرستي نور. كل الحقوق محفوظة.</p>
                <p class="mt-1">مبادرة علمية عالمية تطوعية من أجل المغرب.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggleBtns = document.querySelectorAll('.sidebar-toggle-btn');
            const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const profileInfoButton = document.getElementById('profile-info-button');
            const studentInfoPopover = document.getElementById('student-info-popover');

            // Toggle submenus
            sidebarToggleBtns.forEach(button => {
                button.addEventListener('click', () => {
                    const submenu = button.nextElementSibling;
                    const arrowIcon = button.querySelector('.arrow-icon');

                    if (submenu && submenu.classList.contains('sidebar-submenu')) {
                        submenu.classList.toggle('hidden');
                        arrowIcon.classList.toggle('-rotate-90');
                    }
                });
            });

            // Mobile sidebar toggle functionality
            mobileSidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
            });

            // Close sidebar when clicking on overlay
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            });

            // Toggle student info popover
            profileInfoButton.addEventListener('click', (event) => {
                event.stopPropagation();
                studentInfoPopover.classList.toggle('hidden');
            });

            // Close sidebar and popover when clicking outside
            document.addEventListener('click', (event) => {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnMobileToggle = mobileSidebarToggle.contains(event.target);
                const isClickInsidePopover = studentInfoPopover.contains(event.target);
                const isLargeScreen = window.innerWidth >= 1024;

                // Close sidebar if open on mobile and clicked outside sidebar and toggle button
                if (!isClickInsideSidebar && !isClickOnMobileToggle && sidebar.classList.contains('open') && !isLargeScreen) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }

                // Close popover if open and clicked outside itself or its trigger button
                if (!studentInfoPopover.classList.contains('hidden') && !isClickInsidePopover && !profileInfoButton.contains(event.target)) {
                    studentInfoPopover.classList.add('hidden');
                }
            });

            // Ensure sidebar is visible on large screens if hidden by mobile toggle
            // And hide popover on resize to prevent awkward positioning
            window.addEventListener('resize', () => {
                const isLargeScreen = window.innerWidth >= 1024;
                if (isLargeScreen && sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
                // Hide popover on resize
                if (!studentInfoPopover.classList.contains('hidden')) {
                    studentInfoPopover.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>