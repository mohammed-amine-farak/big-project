@extends('layouts.teacher_dashboard')

@section('content')
<div class="min-h-screen bg-white p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-12 text-center pt-4">
            لوحة الفصل <span class="text-pink-500">الترحيبية</span>
        </h1>

        <!-- قسم المعلم (تم تحويله إلى HTML ثابت) -->
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-3xl 
                        shadow-2xl shadow-purple-300/50 
                        p-8 md:p-12 mb-16 transition duration-700 ease-in-out 
                        hover:scale-[1.005] relative overflow-hidden">
            <!-- زخرفة دائرية خفيفة في الخلفية -->
            <div class="absolute top-0 right-0 w-40 h-40 rounded-full bg-white opacity-10 transform translate-x-1/4 -translate-y-1/4"></div>

            <div class="flex flex-col md:flex-row items-center md:space-x-8 md:space-x-reverse relative z-10">
                <div class="mb-6 md:mb-0 flex-shrink-0">
                    <img 
                        src="https://placehold.co/128x128/9D174D/ffffff?text=T_K" 
                        alt="صورة المعلم" 
                        class="w-32 h-32 rounded-full border-4 border-white object-cover 
                                    shadow-xl ring-8 ring-pink-300/50"
                    />
                </div>
                
                <div class="text-center md:text-right text-white">
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-1 tracking-wider">الأستاذ خالد أحمد</h2>
                    <p class="text-xl font-light opacity-90 border-b border-white/50 inline-block pb-1">
                        معلم الفصل والمشرف الأكاديمي
                    </p>
                    <p class="mt-4 text-base opacity-85 max-w-lg md:max-w-none font-medium">
                        مرحباً، يسعدني الإشراف على تقدم طلابك. هذه اللوحة هي مساحتك لإدارة وتقييم مهارات الفصل.
                    </p>
                </div>
            </div>
        </div>

        <!-- قسم الطلاب -->
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b-4 border-pink-100 pb-3">
            <span class="text-pink-600">فريق</span> الفصل (8)
        </h2>

        <!-- بطاقات الطلاب (تم تحويلها إلى HTML ثابت) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
            
            <!-- بطاقة الطالب 1 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/FACC15/65a30d?text=A.M" 
                        alt="صورة علياء محمد" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="علياء محمد">علياء محمد</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>

            <!-- بطاقة الطالب 2 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/F97316/7c2d12?text=F.N" 
                        alt="صورة فهد ناصر" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="فهد ناصر">فهد ناصر</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>

            <!-- بطاقة الطالب 3 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/38BDF8/075985?text=S.Y" 
                        alt="صورة سارة يوسف" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="سارة يوسف">سارة يوسف</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>

            <!-- بطاقة الطالب 4 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/10B981/064e3b?text=M.B" 
                        alt="صورة ماجد بدر" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="ماجد بدر">ماجد بدر</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>

            <!-- بطاقة الطالب 5 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/C084FC/4c1d95?text=N.K" 
                        alt="صورة نور خالد" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="نور خالد">نور خالد</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>

            <!-- بطاقة الطالب 6 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/FB7185/881337?text=Y.A" 
                        alt="صورة ياسين علي" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="ياسين علي">ياسين علي</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>

            <!-- بطاقة الطالب 7 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/F472B6/831843?text=L.H" 
                        alt="صورة ليلى حسن" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="ليلى حسن">ليلى حسن</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>

            <!-- بطاقة الطالب 8 -->
            <div class="bg-white rounded-3xl border border-gray-100 p-5 text-center group 
                        transition-all duration-300 ease-in-out 
                        shadow-lg shadow-gray-100/50 
                        hover:shadow-2xl hover:shadow-pink-100 
                        hover:border-pink-400 cursor-pointer 
                        transform hover:-translate-y-2">
                <div class="mb-3">
                    <img 
                        src="https://placehold.co/100x100/60A5FA/1e40af?text=O.S" 
                        alt="صورة عمران سعيد" 
                        class="w-24 h-24 md:w-28 md:h-28 rounded-full mx-auto object-cover 
                                    border-4 border-white shadow-xl ring-4 ring-pink-100 
                                    transition duration-300 group-hover:ring-pink-300"
                    />
                </div>
                <p class="text-lg font-bold text-gray-800 truncate mb-1" title="عمران سعيد">عمران سعيد</p>
                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 block">
                    عرض الملف 
                    <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1 group-hover:text-pink-800">
                        &larr; 
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection