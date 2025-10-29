<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انضم إلينا كباحث - مدرستي نور</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts (Cairo for Arabic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc; /* A very light gray background */
            color: #1a202c; /* Default dark text color */
        }
        .font-black {
             font-weight: 900;
        }
    </style>
</head>

<body class="text-gray-900">

    <!-- ============================================ -->
    <!-- ============== HEADER & NAVBAR ============== -->
    <!-- ============================================ -->
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
                    <button class="text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- ============================================ -->
        <!-- ============== FORM HERO SECTION ============== -->
        <!-- ============================================ -->
        <section class="bg-gradient-to-br from-red-600 to-red-400 text-white py-20 md:py-28 text-center">
            <div class="container mx-auto px-6">
                <h1 class="text-4xl md:text-6xl font-black leading-tight mb-4">
                    انضم إلى فريق الخبراء لدينا
                </h1>
                <p class="text-xl md:text-2xl max-w-4xl mx-auto opacity-90">
                    ساهم بخبرتك في بناء جيل جديد من المفكرين في المغرب.
                </p>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- ============ RESEARCHER FORM SECTION ============= -->
        <!-- ============================================ -->
        <section class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-3xl mx-auto bg-gray-50 p-8 md:p-12 rounded-2xl shadow-lg border border-gray-100">
                    <h2 class="text-3xl font-black text-blue-900 text-center mb-10">نموذج الانضمام كباحث/أستاذ/أخصائي</h2>
                    
                    <form action="#" method="POST" class="space-y-6 text-right">
                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="block text-lg font-semibold text-gray-700 mb-2">الاسم الكامل</label>
                            <input type="text" id="full_name" name="full_name" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg">
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg" dir="ltr">
                        </div>

                        <!-- Phone Number (Optional) -->
                        <div>
                            <label for="phone" class="block text-lg font-semibold text-gray-700 mb-2">رقم الهاتف (اختياري)</label>
                            <input type="tel" id="phone" name="phone"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg" dir="ltr">
                        </div>

                        <!-- University/Institution -->
                        <div>
                            <label for="institution" class="block text-lg font-semibold text-gray-700 mb-2">الجامعة/المؤسسة الحالية</label>
                            <input type="text" id="institution" name="institution" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg">
                        </div>

                        <!-- Specialization -->
                        <div>
                            <label for="specialization" class="block text-lg font-semibold text-gray-700 mb-2">التخصص الدقيق</label>
                            <input type="text" id="specialization" name="specialization" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg">
                        </div>

                        <!-- Role in Project -->
                        <div>
                            <label for="role" class="block text-lg font-semibold text-gray-700 mb-2">الدور المقترح للانضمام</label>
                            <select id="role" name="role" required
                                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg">
                                <option value="">اختر دوراً...</option>
                                <option value="دكتور_مصمم_محتوى">دكتور/باحث (تصميم المحتوى)</option>
                                <option value="أستاذ_شرح">أستاذ (شرح وتبسيط الدروس)</option>
                                <option value="أخصائي_نفسي">أخصائي نفسي (تقييم ودعم)</option>
                                <option value="متطوع_عام">متطوع عام</option>
                            </select>
                        </div>

                        <!-- Why they want to join -->
                        <div>
                            <label for="motivation" class="block text-lg font-semibold text-gray-700 mb-2">لماذا ترغب في الانضمام إلى "مدرستي نور"؟</label>
                            <textarea id="motivation" name="motivation" rows="5" required
                                      class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg"></textarea>
                        </div>

                        <!-- Upload CV (Optional) -->
                        <div>
                            <label for="cv_upload" class="block text-lg font-semibold text-gray-700 mb-2">تحميل السيرة الذاتية (اختياري، بصيغة PDF)</label>
                            <input type="file" id="cv_upload" name="cv_upload" accept=".pdf"
                                   class="mt-1 block w-full text-lg text-gray-700
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="w-full bg-red-600 text-white py-4 px-6 rounded-xl font-bold text-xl
                                           hover:bg-red-700 transition duration-300 shadow-md hover:shadow-lg
                                           transform hover:-translate-y-1">
                                إرسال الطلب
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </main>

    <!-- ============================================ -->
    <!-- ================== FOOTER ================== -->
    <!-- ============================================ -->
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

</body>
</html>
