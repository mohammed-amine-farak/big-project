@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header with Back Button -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{route('StudentPsychology.index')}}" 
                           class="text-gray-500 hover:text-gray-700 transition duration-200 flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة للتقارير
                        </a>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">👁️ عرض التقرير النفسي</h1>
                    <p class="text-gray-600 text-sm">تفاصيل التقرير النفسي والسلوكي للطالب</p>
                </div>
                
                <div class="flex items-center gap-2 flex-shrink-0">
                    @if($report->status == 'مسودة')
                    <a href="" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        تعديل التقرير
                    </a>
                    @endif
                    
                    <button onclick="printReport()" 
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
    </svg>
    طباعة التقرير
</button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1">
                        <svg class="fill-current h-5 w-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Student Info and Status -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Student Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">معلومات الطالب</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xl font-bold text-gray-900 truncate">{{ $report->student->user->name }}</h4>
                                <p class="text-gray-600 text-sm">الرقم الأكاديمي: {{ $report->student->academic_number ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">الصف</p>
                                <p class="font-medium text-gray-900">{{ $report->classroom->class_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ التقرير</p>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}</p>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-1">المعلم</p>
                            <p class="font-medium text-gray-900">{{ $report->teacher->user->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">حالة التقرير</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">الحالة الحالية</span>
                            @if($report->status == 'مسودة')
                                <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm font-medium">
                                    مسودة
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    مرسل للإدارة
                                </span>
                            @endif
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-2">آخر تحديث</p>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($report->updated_at)->format('Y-m-d H:i') }}</p>
                        </div>
                        
                        @if($report->status == 'مسودة')
                        <form action="{{route('StudentPsychology.update-status',$report->id)}}" method="POST" class="pt-4 border-t border-gray-200">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    onclick="return confirm('هل أنت متأكد من إرسال هذا التقرير للإدارة؟')"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                إرسال للإدارة
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Psychological Assessment -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Mood and Behavior Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">الملخص النفسي والسلوكي</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Mood -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-medium text-gray-700">المزاج العام</span>
                                @php
                                    $moodIcons = [
                                        'مبتهج' => '😊',
                                        'هادئ' => '😐', 
                                        'قلق' => '😟',
                                        'حزين' => '😢',
                                        'غاضب' => '😠',
                                        'متحمس' => '🤩'
                                    ];
                                @endphp
                                <span class="text-2xl">{{ $moodIcons[$report->mood] ?? '😐' }}</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 text-center">
                                <span class="text-lg font-bold text-gray-900">{{ $report->mood }}</span>
                            </div>
                        </div>
                        
                        <!-- Behavior -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-medium text-gray-700">السلوك</span>
                                @php
                                    $behaviorIcons = [
                                        'ممتاز' => '⭐',
                                        'جيد' => '👍',
                                        'مقبول' => '👌',
                                        'يحتاج_تحسين' => '📝'
                                    ];
                                @endphp
                                <span class="text-2xl">{{ $behaviorIcons[$report->behavior] ?? '📊' }}</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 text-center">
                                @php
                                    $behaviorColors = [
                                        'ممتاز' => 'text-green-700',
                                        'جيد' => 'text-blue-700',
                                        'مقبول' => 'text-amber-700',
                                        'يحتاج_تحسين' => 'text-red-700'
                                    ];
                                @endphp
                                <span class="text-lg font-bold {{ $behaviorColors[$report->behavior] ?? 'text-gray-700' }}">
                                    {{ $report->behavior }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Assessment -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">التقييم التفصيلي</h3>
                    
                    <div class="space-y-6">
                        <!-- Social Interaction -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-700">التفاعل الاجتماعي</span>
                                <span class="text-sm font-medium text-blue-600">{{ $report->social_interaction }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $socialProgress = [
                                        'منطوي' => 25,
                                        'متواصل_بشكل_معتدل' => 50,
                                        'اجتماعي' => 75,
                                        'قائد_مجموعة' => 100
                                    ];
                                @endphp
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $socialProgress[$report->social_interaction] ?? 50 }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Concentration -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-700">التركيز والانتباه</span>
                                <span class="text-sm font-medium text-green-600">{{ $report->concentration }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $concentrationProgress = [
                                        'ضعيف' => 25,
                                        'متوسط' => 50,
                                        'جيد' => 75,
                                        'ممتاز' => 100
                                    ];
                                @endphp
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $concentrationProgress[$report->concentration] ?? 50 }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Participation -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-700">المشاركة الفعالة</span>
                                <span class="text-sm font-medium text-purple-600">{{ $report->participation }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $participationProgress = [
                                        'سلبي' => 25,
                                        'مشارك_أحياناً' => 50,
                                        'نشط' => 75,
                                        'مبادر' => 100
                                    ];
                                @endphp
                                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $participationProgress[$report->participation] ?? 50 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes and Recommendations -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Strengths -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800">نقاط القوة</h4>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 min-h-[120px]">
                            @if($report->strengths)
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $report->strengths }}</p>
                            @else
                                <p class="text-gray-400 text-sm italic">لا توجد نقاط قوة مسجلة</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Challenges -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800">التحديات والصعوبات</h4>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 min-h-[120px]">
                            @if($report->challenges)
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $report->challenges }}</p>
                            @else
                                <p class="text-gray-400 text-sm italic">لا توجد تحديات مسجلة</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Recommendations -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 md:col-span-2">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800">التوصيات والمقترحات</h4>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 min-h-[120px]">
                            @if($report->recommendations)
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $report->recommendations }}</p>
                            @else
                                <p class="text-gray-400 text-sm italic">لا توجد توصيات مسجلة</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- General Notes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800">ملاحظات عامة</h4>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 min-h-[100px]">
                        @if($report->general_notes)
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $report->general_notes }}</p>
                        @else
                            <p class="text-gray-400 text-sm italic">لا توجد ملاحظات عامة مسجلة</p>
                        @endif
                    </div>
                </div>
                
                <!-- Teacher's Personal Note -->
                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 p-5 border-l-4 border-l-emerald-500">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">ملاحظة المعلم الشخصية</h4>
                    </div>
                    <div class="bg-emerald-50 rounded-lg p-4 min-h-[100px]">
                        @if($report->teacher_note)
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $report->teacher_note }}</p>
                        @else
                            <p class="text-gray-400 text-sm italic">لا توجد ملاحظة شخصية من المعلم</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3 justify-between">
            <div class="flex gap-3">
                <a href="{{route('StudentPsychology.index')}}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة للقائمة
                </a>
                
                @if($report->status == 'مسودة')
                <a href="{{ route('StudentPsychology.edit', $report->id) }}" 
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل التقرير
                </a>
                @endif
            </div>
            
            <div class="flex gap-3">
                @if($report->status == 'مسودة')
                <form action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('هل أنت متأكد من حذف هذا التقرير؟ لا يمكن التراجع عن هذا الإجراء.')"
                            class="bg-red-50 hover:bg-red-100 text-red-600 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        حذف التقرير
                    </button>
                </form>
                @endif
                
               <button onclick="printReport()" 
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
    </svg>
    طباعة التقرير
</button>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<script>
function printReport() {
    // حفظ الـ HTML الأصلي
    const originalHTML = document.body.innerHTML;
    
    // الحصول على المحتوى المراد طباعته
    const printContent = document.querySelector('.max-w-6xl').innerHTML;
    
    // إعداد صفحة الطباعة
    document.body.innerHTML = `
        <!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>التقرير النفسي - ${document.title}</title>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    margin: 0;
                    padding: 20px;
                    background: white;
                }
                .report-header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #333;
                    padding-bottom: 20px;
                }
                .report-header h1 {
                    margin: 0;
                    font-size: 24px;
                    color: #2c3e50;
                }
                .student-info {
                    background: #f8f9fa;
                    padding: 15px;
                    margin-bottom: 20px;
                    border: 1px solid #dee2e6;
                }
                .section {
                    margin-bottom: 25px;
                    page-break-inside: avoid;
                }
                .section-title {
                    background: #2c3e50;
                    color: white;
                    padding: 8px 15px;
                    margin: 0 0 10px 0;
                    font-size: 18px;
                }
                .assessment-box {
                    padding: 10px;
                    margin: 5px 0;
                    border: 1px solid #ddd;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 10px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: right;
                }
                th {
                    background-color: #f8f9fa;
                }
                button {
                    display: none;
                }
                @page {
                    size: A4;
                    margin: 20mm;
                }
                @media print {
                    body {
                        padding: 0;
                    }
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="report-container">
                ${printContent}
            </div>
        </body>
        </html>
    `;
    
    // طباعة الصفحة
    window.print();
    
    // استعادة الـ HTML الأصلي
    document.body.innerHTML = originalHTML;
    
    // إعادة تحميل الأحداث
    window.location.reload();
}
</script>

@endsection