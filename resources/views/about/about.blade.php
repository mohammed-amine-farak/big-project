<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عنا - مدرستي نور</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
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

    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="index.html" class="text-2xl font-black text-blue-900">مدرستي نور</a>
                
                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="index.html" class="font-semibold text-gray-700 hover:text-red-600 transition-colors">الرئيسية</a>
                    <a href="team.html" class="font-semibold text-gray-700 hover:text-red-600 transition-colors">هيئة التدريس</a>
                    <a href="about.html" class="font-semibold text-red-600 transition-colors">عنا</a>
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
        <section class="bg-gradient-to-br from-blue-900 to-blue-700 text-white py-20 md:py-28 text-center">
            <div class="container mx-auto px-6">
                <h1 class="text-4xl md:text-6xl font-black leading-tight mb-4">
                    قصتنا: تعليم نوعي لكل طفل في المغرب
                </h1>
                <p class="text-xl md:text-2xl max-w-4xl mx-auto opacity-90">
                    نؤمن بقوة التعليم في بناء المستقبل. "مدرستي نور" هي مبادرة طموحة تهدف لتقديم تعليم ذي جودة عالمية، مجانًا، لجميع الأطفال والتلاميذ في المغرب.
                </p>
            </div>
        </section>

        <section class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2 flex justify-center">
                        <img src="https://images.unsplash.com/photo-1546410531-bb4492f99092?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="أطفال يدرسون" class="rounded-2xl shadow-xl w-full max-w-md">
                    </div>
                    <div class="lg:w-1/2 text-right">
                        <h2 class="text-3xl md:text-4xl font-black text-blue-900 mb-6">مهمتنا: جسر إلى مستقبل أفضل</h2>
                        <p class="text-lg text-gray-700 leading-relaxed mb-4">
                            تتمثل مهمة "مدرستي نور" في إحداث ثورة في جودة التعليم بالمغرب، من خلال **منصة رقمية مجانية** تجمع نخبة من الدكاترة والأساتذة لتدريس الأطفال والتلاميذ عن بُعد. نحن ملتزمون بالكامل بالمناهج الرسمية المعتمدة من وزارة التربية الوطنية.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            هدفنا هو **تحفيز الفهم الحقيقي** بدلاً من التلقين، ولهذا نقدم المفاهيم في شكل مشاكل واقعية تمنح التلميذ سببًا حقيقيًا للتعلم وتنمي لديه **التفكير النقدي**.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-blue-900">نهجنا الفريد: شراكة تربوية متكاملة</h2>
                    <p class="mt-4 text-gray-600 max-w-3xl mx-auto">نؤمن بأن التعليم الفعال يتطلب تضافر جهود الجميع.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm text-right flex flex-col items-end">
                        <div class="bg-red-100 w-14 h-14 rounded-full flex items-center justify-center mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-blue-900">الدكاترة والباحثون: صانعو المحتوى</h3>
                        <p class="text-gray-700 leading-relaxed">يتولون تصميم المحتوى العلمي التفاعلي والمبني على التفكير النقدي، مستلهمين من أبحاثهم وخبراتهم الأكاديمية العميقة.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm text-right flex flex-col items-end">
                        <div class="bg-blue-100 w-14 h-14 rounded-full flex items-center justify-center mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-2V3H7v2H5a2 2 0 00-2 2v11a2 2 0 002 2h2m4 0h6m-6-4h6m-6-8h.01M17 12h.01" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-blue-900">الأساتذة: مبسطو المعرفة</h3>
                        <p class="text-gray-700 leading-relaxed">يشرحون المفاهيم المعقدة بلغة مبسطة وسهلة الفهم، معتمدين على أساليب تدريس مبتكرة تناسب التلاميذ من مختلف الأعمار والمستويات.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm text-right flex flex-col items-end">
                        <div class="bg-green-100 w-14 h-14 rounded-full flex items-center justify-center mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-blue-900">الأخصائيات النفسيات: دعم شامل</h3>
                        <p class="text-gray-700 leading-relaxed">يُدمجن في المشروع لتقييم سلوك وتطور كل طفل ومساعدته بحسب حاجته، لضمان صحة نفسية مستقرة وبيئة تعليمية داعمة.</p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm text-right flex flex-col items-end">
                        <div class="bg-yellow-100 w-14 h-14 rounded-full flex items-center justify-center mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-2V3H7v2H5a2 2 0 00-2 2v11a2 2 0 002 2h2m4 0h6m-6-4h6m-6-8h.01M17 12h.01" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-blue-900">الآباء والأمهات: شريك النجاح</h3>
                        <p class="text-gray-700 leading-relaxed">ندعو الآباء إلى الالتزام بتحفيز أطفالهم ومتابعة حضورهم اليومي من المنزل، فدورهم حيوي في تعزيز مسيرة التعلم.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row-reverse items-center gap-12">
                    <div class="lg:w-1/2 flex justify-center">
                        <img src="https://images.unsplash.com/photo-1596700086208-d2151152a558?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="أطفال يبتسمون" class="rounded-2xl shadow-xl w-full max-w-md">
                    </div>
                    <div class="lg:w-1/2 text-right">
                        <h2 class="text-3xl md:text-4xl font-black text-blue-900 mb-6">مبادرة إنسانية: لا عائق أمام التعلم</h2>
                        <p class="text-lg text-gray-700 leading-relaxed mb-4">
                            لا نكتفي بتقديم التعليم الرقمي، بل نسعى لتحقيق **العدالة التعليمية الميدانية** أيضاً. يشمل مشروعنا مبادرة إنسانية لتوفير **الكتب المدرسية، الأدوات المكتبية، والوسائل التعليمية** للتلاميذ المنحدرين من أسر محدودة الدخل.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            نؤمن بأن الفقر يجب ألا يكون حاجزاً أمام التعلم، وهدفنا هو إزالة هذه العوائق لضمان حصول كل طفل على فرصته الكاملة في النجاح.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-red-600 text-white">
            <div class="container mx-auto px-6 py-20 text-center">
                <h2 class="text-3xl md:text-4xl font-black">كن جزءًا من هذه الثورة التعليمية!</h2>
                <p class="mt-4 text-lg text-red-100 max-w-3xl mx-auto">
                    انضم إلينا كمتطوع أو ادعم مبادرتنا لنمضي قدمًا نحو مستقبل تعليمي مشرق في المغرب.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#" class="inline-block bg-white text-red-600 text-lg font-bold px-10 py-4 rounded-xl hover:bg-red-50 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        تطوع معنا
                    </a>
                    <a href="#" class="inline-block bg-blue-900 text-white text-lg font-bold px-10 py-4 rounded-xl hover:bg-blue-800 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        ادعمنا
                    </a>
                </div>
            </div>
        </section>

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

</body>
</html>