<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدرستي نور - جودة التعليم الخاص، الآن مجاناً</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="text-gray-900">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="#" class="text-2xl font-black text-gradient">مدرستي نور</a>

                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="#" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors">الرئيسية</a>
                    <a href="#" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors">هيئة التدريس</a>
                    <a href="#" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors">الدروس</a>
                    <a href="#" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors">عنا</a>
                </div>

                <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                    <a href="#" class="font-semibold text-gray-700 hover:text-blue-600 transition-colors">تسجيل الدخول</a>
                    <a href="#" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-xl font-bold hover:from-blue-700 hover:to-purple-700 transition duration-300 shadow-lg hover:shadow-xl">
                        إنشاء حساب مجاني
                    </a>
                </div>

                <div class="md:hidden">
                    <button class="text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main>

        <!-- Hero Section -->
        <section class="hero-bg text-white relative">
            <div class="container mx-auto px-6 py-24 md:py-32 text-center relative z-10">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black leading-tight">
                        جودة التعليم الخاص،
                        <span class="block text-yellow-300 mt-2">مجاناً لكل طفل</span>
                    </h1>
                    <p class="mt-6 text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                        نظام تعليمي متكامل بمعايير عالمية، مصمم خصيصاً للمنهج المغربي
                    </p>
                    <p class="mt-4 text-lg text-blue-200 max-w-2xl mx-auto">
                        نخبة من الخبراء العالميين يقدمون تجربة تعليمية استثنائية تحفز التفكير النقدي والإبداعي
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="#" class="bg-white text-blue-600 text-lg font-bold px-8 py-4 rounded-xl hover:bg-blue-50 transition duration-300 shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 inline-flex items-center justify-center gap-3">
                            <i class="fas fa-rocket"></i>
                            ابدأ رحلة التعلم الآن
                        </a>
                        <a href="#" class="border-2 border-white text-white text-lg font-bold px-8 py-4 rounded-xl hover:bg-white/10 transition duration-300 inline-flex items-center justify-center gap-3">
                            <i class="fas fa-play-circle"></i>
                            شاهد الفيديو التعريفي
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Floating Elements -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full floating"></div>
            <div class="absolute bottom-20 right-10 w-16 h-16 bg-yellow-300/20 rounded-full floating" style="animation-delay: 1.5s;"></div>
            <div class="absolute top-1/2 left-1/4 w-12 h-12 bg-white/5 rounded-full floating" style="animation-delay: 2s;"></div>
        </section>

        <!-- Features Section -->
        <section class="py-20 md:py-28 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                        ركائز <span class="text-gradient">التميز</span> التعليمي
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        أربعة أعمدة أساسية تضمن تجربة تعليمية استثنائية لطفلك
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl border border-gray-200 shadow-lg card-hover text-right">
                        <div class="bg-gradient-to-r from-red-500 to-pink-500 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-brain text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900">منهجية التفكير النقدي</h3>
                        <p class="text-gray-600 leading-relaxed">
                            منهج تفاعلي يعتمد على حل المشكلات، مصمم من قبل دكاترة وباحثين لتعزيز التفكير النقدي والإبداعي
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl border border-gray-200 shadow-lg card-hover text-right">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900">خطة دراسية فردية</h3>
                        <p class="text-gray-600 leading-relaxed">
                            تتبع تحليلي شامل بالتعاون مع أخصائيين نفسيين لبناء خطة دراسية تراعي التطور الفردي للطالب
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl border border-gray-200 shadow-lg card-hover text-right">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-laptop-code text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900">بيئة رقمية متكاملة</h3>
                        <p class="text-gray-600 leading-relaxed">
                            منصة تعليمية شاملة تضم وحدات دراسية، فيديوهات تفاعلية، واختبارات ذكية لتعزيز التحصيل العلمي
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl border border-gray-200 shadow-lg card-hover text-right">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-500 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-globe-americas text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900">خبرة عالمية مجانية</h3>
                        <p class="text-gray-600 leading-relaxed">
                            فريق أكاديمي تطوعي من نخبة الدكاترة والأساتذة من حول العالم يضمنون تجربة تعليمية استثنائية
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lessons Section -->
        <section class="py-20 md:py-28 bg-gradient-to-br from-blue-50 to-indigo-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                        اكتشف <span class="text-gradient">الدروس</span> المتكاملة
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        مكتبة شاملة من المحتوى التعليمي المنظم حسب المستويات والمواد
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Math Card -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-xl card-hover text-right flex flex-col">
                        <div class="bg-gradient-to-r from-red-500 to-pink-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg self-end">
                            <i class="fas fa-calculator text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">الرياضيات</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed flex-grow">
                            تعلم الأعداد، الهندسة، الجبر، والإحصاء بطرق تفاعلية تناسب جميع المستويات الدراسية
                        </p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-sm text-gray-500">24 درساً متاحاً</span>
                            <a href="#" class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-3 rounded-xl hover:shadow-lg transition duration-300 font-bold">
                                ابدأ التعلم
                            </a>
                        </div>
                    </div>

                    <!-- Arabic Card -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-xl card-hover text-right flex flex-col">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg self-end">
                            <i class="fas fa-book-open text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">اللغة العربية</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed flex-grow">
                            أتقن قواعد اللغة، النحو، الصرف، والإملاء مع تعزيز مهارات القراءة والكتابة والإبداع
                        </p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-sm text-gray-500">18 درساً متاحاً</span>
                            <a href="#" class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-3 rounded-xl hover:shadow-lg transition duration-300 font-bold">
                                ابدأ التعلم
                            </a>
                        </div>
                    </div>

                    <!-- Science Card -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-xl card-hover text-right flex flex-col">
                        <div class="bg-gradient-to-r from-yellow-500 to-amber-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg self-end">
                            <i class="fas fa-flask text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">العلوم</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed flex-grow">
                            استكشف عالم الأحياء، الفيزياء، والكيمياء من خلال تجارب عملية وشروحات مبسطة
                        </p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-sm text-gray-500">15 درساً متاحاً</span>
                            <a href="#" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-6 py-3 rounded-xl hover:shadow-lg transition duration-300 font-bold">
                                ابدأ التعلم
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Assessment Section -->
        <section class="py-20 md:py-28 bg-gradient-to-r from-purple-600 to-indigo-700 text-white">
            <div class="container mx-auto px-6 text-center">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6">
                        حدد مستواك الدراسي!
                    </h2>
                    <p class="text-xl md:text-2xl text-purple-100 mb-8 leading-relaxed">
                        اختبار بسيط وسريع لضمان حصولك على المحتوى التعليمي الأنسب لمستواك
                    </p>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 md:p-12 border border-white/20">
                        <p class="text-lg md:text-xl text-purple-100 mb-6">
                            اختبار تحديد المستوى يساعدنا في توجيهك نحو المسار التعليمي الأمثل لتحقيق أفضل النتائج
                        </p>
                        <a href="#" class="bg-white text-purple-600 text-lg font-bold px-10 py-4 rounded-xl hover:bg-purple-50 transition duration-300 shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 inline-flex items-center gap-3">
                            <i class="fas fa-play"></i>
                            ابدأ اختبار تحديد المستوى
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="py-20 md:py-28 bg-white">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2">
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl p-1 shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1618090584222-22a10c71a396?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                                 alt="العلم المغربي يمثل الطموح الوطني" 
                                 class="rounded-2xl w-full h-auto">
                        </div>
                    </div>
                    <div class="lg:w-1/2 text-right">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 mb-6">
                            الريادة العالمية 
                            <span class="text-gradient">للتعليم المغربي</span>
                        </h2>
                        <p class="text-lg text-gray-700 leading-relaxed mb-6">
                            مهمتنا تتجاوز دعم الطلاب. هدفنا الأسمى هو المساهمة في جعل التعليم المغربي في مصاف أفضل النظم التعليمية في العالم.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            من خلال توفير تعليم عالي الجودة ومتاح للجميع، نحن نستثمر في العقول التي ستبني مستقبل المغرب. كل طفل يتفوق هو خطوة نحو تحقيق هذه الريادة الوطنية.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Teachers Section -->
        <section class="py-20 md:py-28 bg-gradient-to-br from-gray-50 to-blue-50">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row-reverse items-center gap-12">
                    <div class="lg:w-1/2">
                        <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl p-1 shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1573496799652-408c2ac9fe98?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                                 alt="هيئة تدريس عالمية" 
                                 class="rounded-2xl w-full h-auto">
                        </div>
                    </div>
                    <div class="lg:w-1/2 text-right">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 mb-6">
                            هيئة تدريس 
                            <span class="text-gradient">عالمية المستوى</span>
                        </h2>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            مدرستي نور مدعومة بهيئة تدريس عالمية تضم دكاترة وأساتذة متخصصين من جامعات مرموقة حول العالم. هذه الكفاءات، التي تعمل بشكل تطوعي، هي الضمانة لجودة وقوة نظامنا التعليمي.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Humanitarian Section -->
        <section class="py-20 md:py-28 bg-gradient-to-r from-orange-400 to-red-500 text-white">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-1 border border-white/20">
                            <img src="https://images.unsplash.com/photo-1587825310065-ce18d6e99496?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                                 alt="أطفال يدرسون" 
                                 class="rounded-2xl w-full h-auto">
                        </div>
                    </div>
                    <div class="lg:w-1/2 text-right">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6">
                            مبادرة 
                            <span class="text-yellow-300">جسر الأمل</span>
                        </h2>
                        <p class="text-xl text-orange-100 leading-relaxed mb-6">
                            إدراكاً منا بأن الفقر قد يكون حاجزاً أمام التعلم، تلتزم "مدرستي نور" بمبادرة إنسانية لتوفير الكتب المدرسية والأدوات التعليمية للتلاميذ المحتاجين.
                        </p>
                        <p class="text-xl text-orange-100 leading-relaxed">
                            نؤمن بأن التعليم حق للجميع، ونسعى جاهدين لضمان ألا يحرم أي طفل من فرصة التعلم والتفوق بسبب الظروف المادية.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 md:py-28 gradient-bg text-white">
            <div class="container mx-auto px-6 text-center">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6">
                        مستقبل باهر يبدأ 
                        <span class="text-yellow-300">من هنا</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-blue-100 mb-8 leading-relaxed">
                        التميز الأكاديمي الذي توفره المدارس الخاصة، أصبح الآن بين يديك. وبالمجان.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="#" class="bg-white text-blue-600 text-lg font-bold px-10 py-4 rounded-xl hover:bg-blue-50 transition duration-300 shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 inline-flex items-center gap-3">
                            <i class="fas fa-user-plus"></i>
                            سجل حساب مجاني
                        </a>
                        <a href="#" class="border-2 border-white text-white text-lg font-bold px-10 py-4 rounded-xl hover:bg-white/10 transition duration-300 inline-flex items-center gap-3">
                            <i class="fas fa-comments"></i>
                            تواصل معنا
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-right">
                <div class="md:col-span-2">
                    <h3 class="text-3xl font-black text-white mb-4">مدرستي نور</h3>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        التميز الأكاديمي. متاح للجميع. مبادرة علمية عالمية تطوعية من أجل المغرب.
                    </p>
                    <div class="flex space-x-4 space-x-reverse mt-6">
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-400 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-red-600 transition duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">روابط سريعة</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">الرئيسية</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">هيئة التدريس</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">الدروس</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">عنا</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">الدعم</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">الأسئلة الشائعة</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">اتصل بنا</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">سياسة الخصوصية</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-lg">شروط الاستخدام</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-500">
                <p class="text-lg">© 2024 مدرستي نور. كل الحقوق محفوظة.</p>
                <p class="mt-2 text-gray-400">مبادرة علمية عالمية تطوعية من أجل المغرب</p>
            </div>
        </div>
    </footer>

</body>
</html>