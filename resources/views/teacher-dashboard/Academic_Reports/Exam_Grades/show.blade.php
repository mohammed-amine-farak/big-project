@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تفاصيل تقرير الاختبار</h1>
                <p class="text-sm text-gray-500 mt-1">رقم التقرير: #{{ $exam_grade->exam_schol_weeckly_reports_id }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('Exam_Grade.edit', $exam_grade->exam_schol_weeckly_reports_id) }}" 
                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل
                </a>
                <a href="{{ route('Exam_Grade.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @if($exam_grade->status === 'send')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    تم الإرسال
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    قيد المراجعة
                </span>
            @endif
        </div>

        <!-- Main Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Student Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">الطالب</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $exam_grade->student_name }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">رقم الطالب:</span>
                        <span class="font-medium">#{{ $exam_grade->student_id }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">الصف:</span>
                        <span class="font-medium">{{ $exam_grade->classroom_name }}</span>
                    </div>
                </div>
            </div>

            <!-- Exam Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">الاختبار</h3>
                        <p class="text-lg font-bold text-gray-900">{{ $exam_grade->exam_weeckly_title }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">رقم الاختبار:</span>
                        <span class="font-medium">#{{ $exam_grade->exam_weeckly_id }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">تاريخ الإنشاء:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($exam_grade->created_at)->format('Y/m/d') }}</span>
                    </div>
                </div>
            </div>

            <!-- Score Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">النتيجة</h3>
                        <div class="flex items-baseline gap-2">
                            <p class="text-3xl font-bold text-gray-900">{{ $exam_grade->exam_weeckly_total_point }}</p>
                            <p class="text-gray-500">/ 20</p>
                        </div>
                    </div>
                </div>
                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">النسبة</span>
                        <span class="font-medium">{{ round(($exam_grade->exam_weeckly_total_point / 20) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" 
                             style="width: {{ ($exam_grade->exam_weeckly_total_point / 20) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Notes Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">ملاحظات المعلم</h3>
            </div>
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-800">{{ $exam_grade->teacher_name }}</h4>
                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($exam_grade->updated_at)->format('Y/m/d H:i') }}
                            </span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-gray-700 whitespace-pre-line">{{ $exam_grade->exam_weeckly_note }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skills Achieved Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">المهارات المحققة</h3>
                    <div class="flex items-center gap-3">
                        <span class="text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                            {{ $totalLevels }} مستويات
                        </span>
                        <span class="text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                            {{ $totalSkills }} مهارات
                        </span>
                    </div>
                </div>
            </div>
            
            @if($totalLevels > 0)
                <!-- Level Statistics -->
                <div class="p-6 border-b border-gray-200">
                    <h4 class="font-medium text-gray-700 mb-3">توزيع المستويات المحققة</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-600 font-bold">1</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">المستوى الأول</p>
                                <p class="text-lg font-bold text-gray-800">{{ $level1Count }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-blue-600 font-bold">2</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">المستوى الثاني</p>
                                <p class="text-lg font-bold text-gray-800">{{ $level2Count }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-lg border border-purple-200">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="text-purple-600 font-bold">3</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">المستوى الثالث</p>
                                <p class="text-lg font-bold text-gray-800">{{ $level3Count }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills List -->
                <div class="divide-y divide-gray-200">
                    @foreach($groupedSkills as $skill)
                        <div class="p-6 hover:bg-gray-50 transition duration-150">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mt-1">
                                        <span class="text-blue-600 font-bold">{{ $loop->iteration }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $skill['skill_name'] }}</h4>
                                        @if($skill['skill_description'])
                                            <p class="text-sm text-gray-500 mt-1">{{ $skill['skill_description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                    {{ count($skill['levels']) }} مستويات
                                </span>
                            </div>
                            
                            <!-- Levels -->
                            <div class="space-y-2 pl-2 border-l-2 border-gray-200 ml-4">
                                @foreach($skill['levels'] as $level)
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="w-3 h-3 rounded-full 
                                            @if($level['level_type'] === 'level_3') bg-purple-500
                                            @elseif($level['level_type'] === 'level_2') bg-blue-500
                                            @else bg-green-500
                                            @endif">
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-medium text-gray-700">{{ $level['level_name'] }}</span>
                                                <span class="text-xs px-2 py-0.5 rounded-full
                                                    @if($level['level_type'] === 'level_3') bg-purple-100 text-purple-800
                                                    @elseif($level['level_type'] === 'level_2') bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800
                                                    @endif">
                                                    {{ str_replace('level_', 'مستوى ', $level['level_type']) }}
                                                </span>
                                                @if($level['validated_at'])
                                                    <span class="text-xs text-gray-500">
                                                        {{ \Carbon\Carbon::parse($level['validated_at'])->format('Y/m/d') }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($level['level_description'])
                                                <p class="text-sm text-gray-500">{{ $level['level_description'] }}</p>
                                            @endif
                                        </div>
                                        
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Skills -->
                <div class="p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <p class="mt-4 text-gray-500">لم يتم تحقيق أي مهارات في هذا التقرير</p>
                </div>
            @endif
        </div>

        <!-- Previous Report Comparison -->
        @if($previousReport)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">مقارنة مع التقرير السابق</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Previous Report -->
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-medium text-gray-700">التقرير السابق</h4>
                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($previousReport->created_at)->format('Y/m/d') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $previousReport->title }}</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-gray-800">{{ $previousReport->exam_total_point }}</span>
                            <span class="text-gray-500">/ 20</span>
                        </div>
                    </div>

                    <!-- Current Report -->
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-medium text-gray-700">التقرير الحالي</h4>
                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($exam_grade->created_at)->format('Y/m/d') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $exam_grade->exam_weeckly_title }}</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-gray-800">{{ $exam_grade->exam_weeckly_total_point }}</span>
                            <span class="text-gray-500">/ 20</span>
                        </div>
                    </div>
                </div>

                <!-- Progress Comparison -->
                @php
                    $previousScore = $previousReport->exam_total_point;
                    $currentScore = $exam_grade->exam_weeckly_total_point;
                    $scoreDifference = $currentScore - $previousScore;
                    $percentageDifference = ($scoreDifference / $previousScore) * 100;
                @endphp

                <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-700">التقدم المحرز</h4>
                        <span class="text-sm font-medium 
                            @if($scoreDifference > 0) text-green-600
                            @elseif($scoreDifference < 0) text-red-600
                            @else text-gray-600
                            @endif">
                            @if($scoreDifference > 0)
                                +{{ $scoreDifference }} نقطة
                            @elseif($scoreDifference < 0)
                                {{ $scoreDifference }} نقطة
                            @else
                                بدون تغيير
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500">السابق</span>
                                <span class="text-gray-500">الحالي</span>
                            </div>
                            <div class="relative h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="absolute top-0 left-0 h-full bg-gray-400" 
                                     style="width: {{ ($previousScore / 20) * 100 }}%"></div>
                                <div class="absolute top-0 left-0 h-full bg-green-500" 
                                     style="width: {{ ($currentScore / 20) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Report Metadata -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">معلومات النظام</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">رقم التقرير:</span>
                            <span class="font-medium">#{{ $exam_grade->exam_schol_weeckly_reports_id }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">تاريخ الإنشاء:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($exam_grade->created_at)->format('Y/m/d H:i') }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">تاريخ التحديث:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($exam_grade->updated_at)->format('Y/m/d H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">الحالة:</span>
                            @if($exam_grade->status === 'send')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    تم الإرسال
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    قيد المراجعة
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">المعلم:</span>
                            <span class="font-medium">{{ $exam_grade->teacher_name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">الصف:</span>
                            <span class="font-medium">{{ $exam_grade->classroom_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
            <!-- Print Button -->
            <button type="button" onclick="window.print()" 
                    class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                طباعة
            </button>
            
            <!-- Edit Button -->
            <a href="{{ route('Exam_Grade.edit', $exam_grade->exam_schol_weeckly_reports_id) }}" 
               class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                تعديل التقرير
            </a>
            
            <!-- Delete Button -->
            <form action="{{ route('Exam_Grade.destroy', $exam_grade->exam_schol_weeckly_reports_id) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    حذف
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .print-break-before {
            page-break-before: always;
        }
        .bg-white {
            background-color: white !important;
        }
        .shadow-sm {
            box-shadow: none !important;
        }
        .border {
            border: 1px solid #e5e7eb !important;
        }
        .p-8, .p-6, .p-4 {
            padding: 1rem !important;
        }
        .mb-6, .mb-4 {
            margin-bottom: 1rem !important;
        }
        .gap-6, .gap-4, .gap-3, .gap-2 {
            gap: 0.5rem !important;
        }
    }
</style>

<script>
    // Add print functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add page break before skills section for better printing
        const skillsSection = document.querySelector('.bg-white.rounded-xl.shadow-sm.border.border-gray-200.overflow-hidden.mb-6');
        if (skillsSection) {
            skillsSection.classList.add('print-break-before');
        }
        
        // Hide action buttons when printing
        const actionButtons = document.querySelector('.flex.justify-end.gap-3.mt-6.pt-6.border-t.border-gray-200');
        if (actionButtons) {
            actionButtons.classList.add('no-print');
        }
        
        // Hide edit/delete buttons in header when printing
        const headerButtons = document.querySelectorAll('.flex.items-center.gap-3');
        headerButtons.forEach(button => {
            button.classList.add('no-print');
        });
    });
</script>

@endsection