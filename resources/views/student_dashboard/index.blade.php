<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم التلميذ - مدرستي نور</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Cairo', 'Inter', ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            background-color: #f1f5f9; /* slate-100 - A slightly darker light gray */
            color: #1e293b; /* slate-800 - Default dark text color */
            line-height: 1.6;
            -webkit-text-size-adjust: 100%;
            tab-size: 4;
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent;
            box-sizing: border-box; /* Ensure padding and border are included in the element's total width and height */
        }
        .font-black {
            font-weight: 900;
        }
        .font-extrabold {
            font-weight: 800;
        }
        .font-bold {
            font-weight: 700;
        }
        .font-semibold {
            font-weight: 600;
        }
        .font-medium {
            font-weight: 500;
        }

        /* Custom styles for progress bar */
        .progress-bar-container {
            width: 100%;
            background-color: #bfdbfe; /* blue-200 */
            border-radius: 9999px; /* full rounded */
            height: 10px; /* Slightly smaller progress bar */
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            background-color: #f43f5e; /* rose-500 */
            border-radius: 9999px; /* full rounded */
            transition: width 0.5s ease-in-out;
        }

        /* Style for the arrow icon rotation */
        .arrow-icon {
            transition: transform 0.3s ease-in-out;
        }
        /* Rotated state for the arrow icon */
        .arrow-icon.rotated {
            transform: rotate(-90deg); /* For RTL, 0deg is right, -90deg (or 270deg) is down */
        }

        /* Active link styling for sidebar */
        .sidebar-link.active {
            background-color: #2563eb; /* blue-600 */
            color: #ffffff; /* white */
            font-weight: 700; /* Cairo bold weight */
        }
        .sidebar-link.active svg {
            color: #ffffff; /* white */
        }

        /* --- Custom CSS for Fixed Sidebar and Main Content --- */
        @media (min-width: 1024px) { /* Apply fixed positioning on large screens (lg) and up */
            .sidebar-wrapper {
                position: fixed;
                top: 0; /* Align to the top of the viewport */
                right: 0; /* Align to the right for RTL layout */
                height: 100vh; /* Make it take full viewport height */
                overflow-y: auto; /* Enable scrolling for sidebar content if it overflows */
                z-index: 40; /* Higher z-index to ensure it's above other content like header shadow */
                padding-top: 6rem; /* Space for the fixed header height */
                box-sizing: border-box; /* Include padding in height calculation */
            }

            /* Adjust main content margin to prevent overlap with the fixed sidebar */
            .main-content-area {
                margin-right: 18rem; /* Width of lg:w-72 sidebar (72 * 0.25rem = 18rem) */
                margin-left: 0; /* Ensure no left margin from previous attempts */
            }
        }

        /* Ensure main content starts below the fixed header */
        .main-content-container {
            padding-top: 2rem; /* Add padding at the top of the main content to clear the sticky header */
            padding-bottom: 2rem; /* Add some padding at the bottom as well */
            min-height: calc(100vh - 4rem); /* Ensure main content pushes footer down if content is short, adjust 4rem for header/footer height */
            box-sizing: border-box;
        }

        /* Specific fix for header shadow in context of fixed sidebar */
        .header {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Tailwind's shadow-md */
        }
    </style>
</head>

<body class="text-gray-900">

    <header class="bg-white shadow-lg sticky top-0 z-50 header">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="index.html" class="text-2xl font-black text-blue-800">مدرستي نور</a>

                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="index.html" class="font-medium text-gray-700 hover:text-rose-600 transition-colors">الرئيسية</a>
                    <a href="team.html" class="font-medium text-gray-700 hover:text-rose-600 transition-colors">هيئة التدريس</a>
                    <a href="about.html" class="font-medium text-gray-700 hover:text-rose-600 transition-colors">عنا</a>
                    <a href="child_dashboard.html" class="font-semibold text-rose-600 transition-colors">لوحة التحكم</a>
                </div>

                <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                    <a href="#" class="font-semibold text-gray-700 hover:text-rose-700">تسجيل الدخول</a>
                    <a href="#" class="bg-rose-600 text-white px-5 py-2 rounded-lg font-bold hover:bg-rose-700 transition duration-300 shadow-md">
                        إنشاء حساب مجاني
                    </a>
                </div>

                <div class="md:hidden">
                    <button class="text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex flex-col lg:flex-row-reverse bg-gray-100 min-h-screen">
        <div class="w-full lg:w-72 bg-gray-800 p-6 rounded-2xl shadow-xl m-6 lg:m-0 sidebar-wrapper top-[60px]">
            <div class="flex flex-row justify-between p-4 mb-8 pb-4 border-b border-gray-700 ">
                <button id="profile-info-button" class="  p-1 rounded-full text-gray-300 hover:text-white transition-colors ">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                <div >
                    <img src="https://placehold.co/80x80/64748b/ffffff?text=أحمد" alt="صورة ملف أحمد الشخصي"
                        class="rounded-full w-10 h-10 border-2 border-blue-500 object-cover shadow-md flex-shrink-0">
                   
                </div>
            </div>

            <div id="student-info-popover" class="absolute bg-gray-700 text-white p-4 rounded-lg shadow-lg z-50 w-64 right-6 top-[calc(6rem + 2rem)] hidden transform transition-all duration-300 ease-out opacity-0 translate-y-2">
                <h4 class="text-lg font-bold mb-3 border-b border-gray-600 pb-2 text-right">تفاصيل حساب أحمد</h4>
                <div class="space-y-2 text-right">
                    <p class="text-sm">
                        <span class="font-semibold text-gray-300 block mb-1">الاسم:</span>
                        <span class="text-gray-400">أحمد</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-semibold text-gray-300 block mb-1">البريد الإلكتروني:</span>
                        <span class="text-gray-400">ahmed.student@example.com</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-semibold text-gray-300 block mb-1">تاريخ التسجيل:</span>
                        <span class="text-gray-400">01 يناير 2023</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-semibold text-gray-300 block mb-1">المستوى الدراسي:</span>
                        <span class="text-gray-400">الرابع ابتدائي</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-semibold text-gray-300 block mb-1">نقاط الخبرة الكلية:</span>
                        <span class="text-gray-400">4250 XP</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-semibold text-gray-300 block mb-1">الدروس المكتملة:</span>
                        <span class="text-gray-400">15 درسًا</span>
                    </p>
                </div>
            </div>

            <h3 class="text-2xl font-extrabold text-white mb-6 text-right">قائمة التعلم</h3>
            <ul class="space-y-2">
                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                            <span class="text-lg font-medium">الفيديوهات</span>
                        </div>
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">فيديو 1: مقدمة في الرياضيات</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">فيديو 2: أساسيات العلوم</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">فيديو 3: تاريخ المغرب القديم</a></li>
                    </ul>
                </li>
            
                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.523 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253" /></svg>
                            <span class="text-lg font-medium">الدروس</span>
                        </div>
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">الدرس 1: الأعداد الكسرية</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">الدرس 2: الجهاز الهضمي</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">الدرس 3: الفاعل والمفعول به</a></li>
                    </ul>
                </li>
            
                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            <span class="text-lg font-medium">التمارين</span>
                        </div>
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">تمرين 1: عمليات حسابية</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">تمرين 2: أكمل الفراغ</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">تمرين 3: خيارات متعددة</a></li>
                    </ul>
                </li>
            
                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v10m-4 2l2 2m-2-2l-2-2m2 2V6m0 0H9m5 0v6" /></svg>
                            <span class="text-lg font-medium">المقالات</span>
                        </div>
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">مقالة 1: أهمية القراءة</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">مقالة 2: علماء غيروا التاريخ</a></li>
                    </ul>
                </li>
            
                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            <span class="text-lg font-medium">المراجعات</span>
                        </div>
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">مراجعة الوحدة الأولى</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">مراجعة الاختبار الفصلي</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="flex-1 p-6 lg:p-10 main-content-area">
            <div class="main-content-container">
                <section class="py-8 md:py-12">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl md:text-4xl font-extrabold text-blue-900">إنجازاتك في لمحة</h2>
                        <p class="mt-4 text-gray-600 max-w-3xl mx-auto text-lg">هنا يمكنك رؤية مدى تقدمك وشغفك بالتعلم.</p>
                    </div>
        
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 shadow-md text-right flex flex-col items-end transform transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                            <div class="bg-rose-50 w-16 h-16 rounded-full flex items-center justify-center mb-6 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.329 1.176l1.519 4.674c.3.921-.755 1.688-1.539 1.175l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.784.513-1.838-.254-1.539-1.175l1.519-4.674a1 1 0 00-.329-1.176l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z" /></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-blue-900">نقاط الخبرة والتقدم</h3>
                            <p class="text-5xl font-extrabold text-rose-600 mb-4">4250 <span class="text-xl text-gray-500">XP</span></p>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: 70%;"></div>
                            </div>
                            <p class="text-gray-600 mt-2 text-sm">70% إلى المستوى التالي</p>
                        </div>
        
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 shadow-md text-right flex flex-col items-end transform transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                            <div class="bg-sky-50 w-16 h-16 rounded-full flex items-center justify-center mb-6 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-blue-900">ساعات مشاهدة الفيديوهات</h3>
                            <p class="text-5xl font-extrabold text-sky-600 mb-4">120 <span class="text-xl text-gray-500">ساعة</span></p>
                            <p class="text-gray-600 mt-2 text-sm">شاهدت 80% من الفيديوهات المخصصة لك</p>
                        </div>
        
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 shadow-md text-right flex flex-col items-end transform transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                            <div class="bg-emerald-50 w-16 h-16 rounded-full flex items-center justify-center mb-6 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.523 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-blue-900">المقالات المقروءة</h3>
                            <p class="text-5xl font-extrabold text-emerald-600 mb-4">35 <span class="text-xl text-gray-500">مقالة</span></p>
                            <p class="text-gray-600 mt-2 text-sm">اكتشفت مواضيع جديدة! استمر في القراءة.</p>
                        </div>
        
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 shadow-md text-right flex flex-col items-end transform transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                            <div class="bg-amber-50 w-16 h-16 rounded-full flex items-center justify-center mb-6 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-blue-900">التمارين المحلولة</h3>
                            <p class="text-5xl font-extrabold text-amber-600 mb-4">78 <span class="text-xl text-gray-500">تمرين</span></p>
                            <p class="text-gray-600 mt-2 text-sm">عمل ممتاز! أنت تتحسن يوماً بعد يوم.</p>
                        </div>
                    </div>
                </section>
        
                <section class="bg-gradient-to-br from-sky-600 to-blue-500 text-white rounded-2xl shadow-xl mt-12 py-16 md:py-20">
                    <div class="container mx-auto px-6 text-center">
                        <h2 class="text-3xl md:text-4xl font-black">ماذا بعد؟</h2>
                        <p class="mt-4 text-lg text-blue-100 max-w-3xl mx-auto">
                            استمر في رحلتك التعليمية الممتعة! اختر درسك التالي وواصل تحقيق الإنجازات.
                        </p>
                        <a href="#" class="mt-8 inline-block bg-white text-blue-700 text-lg font-bold px-10 py-4 rounded-xl hover:bg-blue-50 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            ابـدأ درسك التالي
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </main>

    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButtons = document.querySelectorAll('.sidebar-toggle-btn');
            const profileInfoButton = document.getElementById('profile-info-button');
            const studentInfoPopover = document.getElementById('student-info-popover');

            toggleButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    // Stop propagation to prevent document click from closing popover immediately
                    event.stopPropagation();
                    const parentLi = button.closest('li');
                    const submenu = parentLi.querySelector('.sidebar-submenu');
                    const arrowIcon = button.querySelector('.arrow-icon');

                    if (submenu) {
                        submenu.classList.toggle('hidden'); // Toggle visibility
                        arrowIcon.classList.toggle('rotated'); // Rotate arrow
                    }
                });
            });

            // Toggle student info popover
            profileInfoButton.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevent document click from closing it immediately
                studentInfoPopover.classList.toggle('hidden');
                // Optional: Add/remove classes for transition effects
                if (!studentInfoPopover.classList.contains('hidden')) {
                    studentInfoPopover.classList.remove('opacity-0', 'translate-y-2');
                    studentInfoPopover.classList.add('opacity-100', 'translate-y-0');
                } else {
                    studentInfoPopover.classList.remove('opacity-100', 'translate-y-0');
                    studentInfoPopover.classList.add('opacity-0', 'translate-y-2');
                }
            });

            // Close popover when clicking outside
            document.addEventListener('click', (event) => {
                if (!studentInfoPopover.classList.contains('hidden') && !profileInfoButton.contains(event.target) && !studentInfoPopover.contains(event.target)) {
                    studentInfoPopover.classList.add('hidden');
                    studentInfoPopover.classList.remove('opacity-100', 'translate-y-0');
                    studentInfoPopover.classList.add('opacity-0', 'translate-y-2');
                }
            });
        });
    </script>
</body>
</html>