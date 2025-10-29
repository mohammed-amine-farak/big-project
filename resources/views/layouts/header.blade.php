<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تواصل معنا - مبادرة نبني المغرب</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .gradient-text {
            background-image: linear-gradient(to left, #d9272d, #16a34a);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .form-input-modern {
            background-color: rgba(241, 245, 249, 0.5); /* slate-100 with opacity */
            border: 1px solid rgba(203, 213, 225, 0.3); /* slate-300 with opacity */
            transition: all 0.3s ease;
        }
        .dark .form-input-modern {
            background-color: rgba(30, 41, 59, 0.5); /* slate-800 with opacity */
            border-color: rgba(71, 85, 105, 0.3); /* slate-600 with opacity */
        }
        .form-input-modern:focus {
            background-color: rgba(255, 255, 255, 0.8);
            border-color: #16a34a; /* green-500 */
            box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2);
            outline: none;
        }
        .dark .form-input-modern:focus {
            background-color: rgba(15, 23, 42, 0.8); /* slate-900 with opacity */
        }
    </style>
    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenuButton.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); });
        });
    </script>
</head>
<body class="bg-slate-100 dark:bg-slate-900">

    <!-- خلفية الخريطة التفاعلية -->
   
    <!-- الشريط العلوي (Header) -->
    <header class="bg-transparent sticky top-0 z-50">
         <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="index.html" class="text-3xl font-extrabold gradient-text">نبني المغرب</a>
                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="{{route('index')}}" class="font-medium text-slate-700 dark:text-slate-300 hover:text-green-600 transition-colors">الرئيسية</a>
                    <a href="{{route('project.index')}}" class="font-medium text-slate-700 dark:text-slate-300 hover:text-green-600 transition-colors">مشاريعنا</a>
                    <a href="{{route('about')}}" class="font-medium text-slate-700 dark:text-slate-300 hover:text-green-600 transition-colors">من نحن</a>
                    <a href="{{route('contact')}}" class="font-bold text-green-600 dark:text-green-400">تواصل معنا</a>
                </div>
                <div class="hidden md:block">
                     <a href="donate.html" class="inline-flex items-center px-6 py-2.5 border border-transparent text-base font-bold rounded-full shadow-sm text-white bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 transition-all">تبرع الآن</a>
                </div>
                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-button" type="button" class="p-2 rounded-md text-slate-400"><span class="sr-only">افتح القائمة</span><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg></button>
                </div>
            </div>
        </nav>
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white/95 dark:bg-slate-800/95 backdrop-blur-sm rounded-b-lg shadow-lg">
                <a href="index.html" class="block px-3 py-2 rounded-md text-base font-medium text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700">الرئيسية</a>
                <a href="index.html#projects" class="block px-3 py-2 rounded-md text-base font-medium text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700">مشاريعنا</a>
                <a href="about.html" class="block px-3 py-2 rounded-md text-base font-medium text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700">من نحن</a>
                <a href="contact.html" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 bg-slate-100 dark:bg-slate-900">تواصل معنا</a>
                <a href="donate.html" class="block text-center mt-4 w-full text-white font-bold py-3 px-4 rounded-xl bg-gradient-to-r from-green-500 to-teal-600">تبرع الآن</a>
            </div>
        </div>
    </header>
   
    @yield('content')


    <footer class="bg-slate-800 dark:bg-black text-center py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white">هل أنت مستعد لتكون جزءاً من التغيير؟</h2>
            <p class="mt-4 text-lg text-slate-400">مستقبل المغرب مشرق، وبدعمكم سيصبح أكثر إشراقاً.</p>
            <a href="donate.html" class="mt-8 inline-block bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-bold py-4 px-12 rounded-full text-lg transition-all duration-300 transform hover:scale-105 shadow-2xl">
                ادعم المبادرة الآن
            </a>
            <p class="mt-12 text-sm text-slate-500">© 2023 مبادرة "نبني المغرب" | جميع الحقوق محفوظة.</p>
        </div>
    </footer>
</body>
</html>