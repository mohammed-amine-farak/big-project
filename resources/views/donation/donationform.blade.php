<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة التبرع - نبني المغرب</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .form-input {
            background-color: #f8fafc; /* slate-50 */
            border: 2px solid #e2e8f0; /* slate-200 */
            transition: all 0.3s;
        }
        .dark .form-input {
            background-color: #1e293b; /* slate-800 */
            border-color: #334155; /* slate-700 */
        }
        .form-input:focus {
            background-color: white;
            border-color: #10b981; /* emerald-500 */
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
            outline: none;
        }
        .peer:checked ~ .peer-checked\:ring-green-500 {
            --tw-ring-color: #22c55e;
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-900">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl mx-auto lg:grid lg:grid-cols-5 gap-10">
            <!-- قسم المعلومات -->
            <div class="lg:col-span-3 bg-white dark:bg-slate-800/50 rounded-2xl p-8 shadow-2xl">
                <a href="index.html" class="text-2xl font-extrabold gradient-text mb-6 inline-block">العودة إلى الرئيسية</a>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white">أكمل تبرعك</h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400">اختر المبلغ ووجه دعمك لقطاعك المفضل.</p>

                <form action="#" method="POST" class="mt-8 space-y-8">
                    <!-- اختيار المبلغ -->
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">1. اختر مبلغ التبرع (بالدرهم)</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="relative">
                                <input class="sr-only peer" type="radio" value="250" name="amount" id="amount-250" checked>
                                <label for="amount-250" class="flex flex-col text-center p-4 rounded-xl cursor-pointer bg-slate-100 dark:bg-slate-700 peer-checked:ring-green-500 peer-checked:text-green-600 dark:peer-checked:text-green-400 transition-all">
                                    <span class="text-2xl font-bold">250</span>
                                </label>
                            </div>
                            <div class="relative">
                                <input class="sr-only peer" type="radio" value="500" name="amount" id="amount-500">
                                <label for="amount-500" class="flex flex-col text-center p-4 rounded-xl cursor-pointer bg-slate-100 dark:bg-slate-700 peer-checked:ring-green-500 peer-checked:text-green-600 dark:peer-checked:text-green-400 transition-all">
                                    <span class="text-2xl font-bold">500</span>
                                </label>
                            </div>
                            <div class="relative">
                                <input class="sr-only peer" type="radio" value="1000" name="amount" id="amount-1000">
                                <label for="amount-1000" class="flex flex-col text-center p-4 rounded-xl cursor-pointer bg-slate-100 dark:bg-slate-700 peer-checked:ring-green-500 peer-checked:text-green-600 dark:peer-checked:text-green-400 transition-all">
                                    <span class="text-2xl font-bold">1000</span>
                                </label>
                            </div>
                            <div class="relative">
                                <input class="sr-only peer" type="radio" value="custom" name="amount" id="amount-custom">
                                <label for="amount-custom" class="flex flex-col text-center p-4 rounded-xl cursor-pointer bg-slate-100 dark:bg-slate-700 peer-checked:ring-green-500 peer-checked:text-green-600 dark:peer-checked:text-green-400 transition-all">
                                    <span class="text-xl font-bold">مبلغ آخر</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات المتبرع -->
                    <div>
                         <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">2. معلوماتك الشخصية</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                             <input type="text" placeholder="الاسم الأول" class="form-input w-full p-4 rounded-xl" required>
                             <input type="text" placeholder="الاسم الأخير" class="form-input w-full p-4 rounded-xl" required>
                        </div>
                        <input type="email" placeholder="البريد الإلكتروني" class="form-input w-full p-4 rounded-xl mt-4" required>
                    </div>

                    <!-- توجيه التبرع -->
                    <div>
                         <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">3. وجّه تبرعك (اختياري)</h2>
                         <select class="form-input w-full p-4 rounded-xl">
                            <option>الصندوق العام (للأولويات القصوى)</option>
                            <option>قطاع الهندسة والطاقة</option>
                            <option>قطاع البيولوجيا والصحة</option>
                            <option>قطاع الزراعة الذكية</option>
                         </select>
                    </div>

                    <!-- زر التبرع -->
                    <button type="submit" class="w-full text-white font-bold py-4 px-4 rounded-xl text-lg transition-all duration-300 transform hover:scale-105 shadow-xl bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700">
                        الانتقال للدفع الآمن
                    </button>
                </form>
            </div>
            
            <!-- قسم الملخص -->
            <div class="hidden lg:block lg:col-span-2 bg-slate-800 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-16 w-48 h-48 bg-green-500/20 rounded-full"></div>
                <div class="absolute -bottom-24 -left-16 w-64 h-64 bg-red-500/10 rounded-full"></div>
                <h2 class="text-3xl font-extrabold relative z-10">تبرعك يصنع الفرق.</h2>
                <p class="mt-4 text-slate-300 relative z-10">بدعمكم الكريم، تتحول الأفكار إلى مشاريع، والأحلام إلى واقع ملموس يخدم أجيال المستقبل في المغرب.</p>
                <div class="mt-10 pt-10 border-t border-slate-700 relative z-10">
                    <!-- تم تحديث الصورة هنا -->
                    <img src="images/donate-summary.jpg" alt="Abstract technology" class="rounded-lg aspect-video object-cover">
                    <div class="mt-6 flex items-center text-sm text-slate-400">
                         <svg class="w-5 h-5 ml-2 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5.023L2.096 5.068A11.954 11.954 0 0110 18.056a11.954 11.954 0 017.904-12.988L17.834 5.023A11.954 11.954 0 0110 1.944zM8.5 6.5a.5.5 0 00-1 0v3.793l-1.146-1.147a.5.5 0 00-.708.708l2 2a.5.5 0 00.708 0l2-2a.5.5 0 00-.708-.708L8.5 10.293V6.5z" clip-rule="evenodd"></path></svg>
                        <span>تبرعات آمنة ومشفّرة بالكامل.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>