<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء درس جديد - مدرستي نور</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc; /* A very light gray background */
            color: #1a202c; /* Default dark text color */
        }
        .font-black {
            font-weight: 900;
        }
        /* Custom scrollbar for sidebar (optional, for better aesthetics) */
        .sidebar-wrapper::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: #4a5568; /* gray-700 */
            border-radius: 10px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #6b7280; /* gray-500 */
            border-radius: 10px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: #9ca3af; /* gray-400 */
        }
    </style>
</head>

<body class="text-gray-900">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="index.html" class="text-2xl font-black text-blue-900">مدرستي نور</a>

                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="index.html" class="font-semibold text-gray-700 hover:text-red-600 transition-colors">الرئيسية</a>
                    <a href="team.html" class="font-semibold text-gray-700 hover:text-red-600 transition-colors">هيئة التدريس</a>
                    <a href="about.html" class="font-semibold text-gray-700 hover:text-red-600 transition-colors">عنا</a>
                </div>

                <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                    <a href="#" class="font-semibold text-gray-700">تسجيل الدخول</a>
                    <a href="#" class="bg-red-600 text-white px-5 py-2 rounded-lg font-bold hover:bg-red-700 transition duration-300">
                        إنشاء حساب مجاني
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-sidebar-toggle" class="text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    
    <main class="flex flex-col lg:flex-row-reverse bg-gray-100 min-h-screen">

        <div id="sidebar" class="w-full lg:w-72 bg-gray-800 p-6 shadow-xl m-6 lg:m-0 sidebar-wrapper top-[60px]">

            <div class="relative flex flex-row-reverse justify-between items-center px-4 py-3 mb-8 pb-4 border-b border-gray-700">
                <button id="profile-info-button" class="  p-1 text-gray-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                <div class="flex items-center">
                    <div class="ml-3">
                        <img src="https://placehold.co/80x80/64748b/ffffff?text=أحمد" alt="صورة ملف أحمد الشخصي"
                            class="rounded-full w-10 h-10 border-2 border-blue-500 object-cover shadow-md flex-shrink-0">
                    </div>
                    
                </div>

                <div id="student-info-popover" class="absolute bg-gray-700 text-white p-4 rounded-lg shadow-lg z-50 w-64
                            top-full right-0 mt-4 hidden transform transition-all duration-300 ease-out opacity-0 translate-y-2 origin-top-right">
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
            </div>

            <h3 class="text-xl font-extralight text-white mb-6 text-right">researchers dashboard</h3>
            <ul class=" space-y-3.5">
                <li>
                    <a href="" class="sidebar-toggle-btn flex flex-row-reverse items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                            </svg>
                              <span class="text-lg font-medium">الرئيسية</span>
                        </div>
                    </a>
                    
                </li>
                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>

                        <div class="flex items-center space-x-2 space-x-reverse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.523 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253" /></svg>
                            <span class="text-lg font-medium">التلاميذ</span>
                        </div>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                        <li><a href="{{route('student_progress.index')}}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">نسبة إنجاز الدروس</a></li>
                        <li><a href="{{route('Interaction_Notes_student.index')}}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">ملاحظات التفاعل</a></li>
            
                    </ul>
                </li>

                <li>
                    <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300 transform -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        <div class="flex items-center space-x-2 space-x-reverse group">
                            <i class="fas fa-chart-line h-6 w-6 text-gray-400"></i>
                            <span class="text-xl font-medium truncate max-w-[15ch] group-hover:hidden">الأكاديمية</span>
                            <span class="text-xl font-medium hidden group-hover:block">التقارير الأكاديمية</span>
                        </div>
                    </button>
                    <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                        <li><a href="{{route('Exam_Grade.index')}}" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">تصحيح الامتحانات</a></li>
                        <li><a href="" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">سجل الدرجات</a></li>
                    </ul>
                </li>

                <li>


                    <li>
                        <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300 transform -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                            <div class="flex items-center space-x-2 space-x-reverse group">
                                <i class="fas fa-brain h-6 w-6 text-gray-400"></i>
                                <span class="text-xl font-medium truncate max-w-[15ch] group-hover:hidden">النفسية</span>
                                <span class="text-xl font-medium hidden group-hover:block">التقارير النفسية</span>
                            </div>
                        </button>
                        <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                            <li><a href="" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">توصيات الأخصائي</a></li>
                            <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">ملاحظات يومية</a></li>
                        </ul>
                    </li>
    
                    <li>
    
                        <li>
                            <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300 transform -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                <div class="flex items-center space-x-2 space-x-reverse group">
                                    <i class="fas fa-comments h-6 w-6 text-gray-400"></i>
                                    <span class="text-xl font-medium truncate max-w-[15ch] group-hover:hidden">التواصل</span>
                                    <span class="text-xl font-medium hidden group-hover:block">تواصل الإدارة/الأخصائي</span>
                                </div>
                            </button>
                            <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                                <li><a href="" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">رسائل الإدارة</a></li>
                                <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">رسائل الأخصائي</a></li>
                            </ul>
                        </li>
                        
                        <li>
        
                            <li>
                                <button class="sidebar-toggle-btn flex items-center justify-between w-full py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="arrow-icon h-5 w-5 text-gray-400 transition-transform duration-300 transform -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                    <div class="flex items-center space-x-2 space-x-reverse group">
                                        <i class="fas fa-cog h-6 w-6 text-gray-400"></i>
                                        <span class="text-xl font-medium truncate max-w-[15ch] group-hover:hidden">الإعدادات</span>
                                        <span class="text-xl font-medium hidden group-hover:block">إعدادات الحساب</span>
                                    </div>
                                </button>
                                <ul class="sidebar-submenu hidden space-y-1 pt-1 pl-8 border-l-2 border-blue-500 ml-4">
                                    <li><a href="" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">الحساب</a></li>
                                    <li><a href="#" class="block py-2 px-4 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition-colors text-right text-base font-normal">التنبيهات</a></li>
                                </ul>
                            </li>
            
                
                

                
            </ul>

            <div class="mt-8 pt-8 border-t border-gray-700">
                <a href="#" class="flex items-center justify-end w-full py-2 px-4 rounded-lg text-red-400 hover:bg-gray-700 hover:text-red-300 transition duration-300 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <span class="text-lg font-medium ml-3">تسجيل الخروج</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                </a>
            </div>
        </div>
        <div class="w-full"> 
            
            @yield('content')</div>
   
        </main>

    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right">
                <div>
                    <h3 class="text-2xl font-black text-white">مدرستي نور</h3>
                    <p class="mt-2 text-gray-400">التميز الأكاديمي. متاح للجميع.</p>
                </div>
                <div>
                    <h4 class="font-bold tracking-wider uppercase">روابط</h4>
                    <ul class="mt-4 space-y-2">
                        <li><a href="index.html" class="text-gray-400 hover:text-white">الرئيسية</a></li>
                        <li><a href="team.html" class="text-gray-400 hover:text-white">هيئة التدريس</a></li>
                        <li><a href="about.html" class="text-gray-400 hover:text-white">عنا</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">سياسة الخصوصية</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold tracking-wider uppercase">تابعنا</h4>
                    <div class="mt-4 flex space-x-4 space-x-reverse justify-end">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-500 text-sm">
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
            const profileInfoButton = document.getElementById('profile-info-button'); // Get the kebab menu button
            const studentInfoPopover = document.getElementById('student-info-popover'); // Get the popover

            // Toggle submenus
            sidebarToggleBtns.forEach(button => {
                button.addEventListener('click', () => {
                    const submenu = button.nextElementSibling;
                    const arrowIcon = button.querySelector('.arrow-icon');

                    if (submenu && submenu.classList.contains('sidebar-submenu')) {
                        submenu.classList.toggle('hidden');
                        // Rotate arrow for visual feedback (for RTL)
                        arrowIcon.classList.toggle('-rotate-90'); 
                    }
                });
            });

            // Mobile sidebar toggle functionality
            mobileSidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('translate-x-full');
            });

            // Toggle student info popover
            profileInfoButton.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevent click from bubbling up and immediately closing
                studentInfoPopover.classList.toggle('hidden');
                // Apply/remove transition classes for smooth effect
                if (!studentInfoPopover.classList.contains('hidden')) {
                    studentInfoPopover.classList.remove('opacity-0', 'translate-y-2');
                    studentInfoPopover.classList.add('opacity-100', 'translate-y-0');
                } else {
                    studentInfoPopover.classList.remove('opacity-100', 'translate-y-0');
                    studentInfoPopover.classList.add('opacity-0', 'translate-y-2');
                }
            });

            // Close sidebar and popover when clicking outside
            document.addEventListener('click', (event) => {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnMobileToggle = mobileSidebarToggle.contains(event.target);
                const isClickInsidePopover = studentInfoPopover.contains(event.target);
                const isLargeScreen = window.innerWidth >= 1024; // Tailwind's 'lg' breakpoint

                // Close sidebar if open on mobile and clicked outside sidebar and toggle button
                if (!isClickInsideSidebar && !isClickOnMobileToggle && !sidebar.classList.contains('translate-x-full') && !isLargeScreen) {
                    sidebar.classList.add('translate-x-full');
                }

                // Close popover if open and clicked outside itself or its trigger button
                if (!studentInfoPopover.classList.contains('hidden') && !isClickInsidePopover && !profileInfoButton.contains(event.target)) {
                    studentInfoPopover.classList.add('hidden');
                    studentInfoPopover.classList.remove('opacity-100', 'translate-y-0');
                    studentInfoPopover.classList.add('opacity-0', 'translate-y-2');
                }
            });

            // Ensure sidebar is visible on large screens if hidden by mobile toggle
            // And hide popover on resize to prevent awkward positioning
            window.addEventListener('resize', () => {
                const isLargeScreen = window.innerWidth >= 1024;
                if (isLargeScreen && sidebar.classList.contains('translate-x-full')) {
                    sidebar.classList.remove('translate-x-full');
                }
                // Hide popover on resize
                if (!studentInfoPopover.classList.contains('hidden')) {
                    studentInfoPopover.classList.add('hidden');
                    studentInfoPopover.classList.remove('opacity-100', 'translate-y-0');
                    studentInfoPopover.classList.add('opacity-0', 'translate-y-2');
                }
            });
        });
    </script>
     @yield('script')
</body>
</html>