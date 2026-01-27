@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $exam->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">تفاصيل كاملة للاختبار</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    طباعة
                </button>
                <a href="{{ route('teacher.exams.list') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
            </div>
        </div>

        <!-- Main Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Classroom Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">الصف الدراسي</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $exam->classroom->class_name ?? 'غير معروف' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">رقم الصف:</span>
                        <span class="font-medium">#{{ $exam->classroom_id }}</span>
                    </div>
                </div>
            </div>

            <!-- Subject Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">المادة</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $exam->subject->name ?? 'غير معروف' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">رقم المادة:</span>
                        <span class="font-medium">#{{ $exam->subject_id }}</span>
                    </div>
                </div>
            </div>

            <!-- Researcher Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">الباحث</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $exam->researcher->user->name ?? 'غير معروف' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">رقم الباحث:</span>
                        <span class="font-medium">#{{ $exam->researcher_id }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Section -->
        <!-- File Section - Fixed -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">ملف الاختبار</h3>
            @php
                // Try multiple paths
                $filePath = $exam->file_path;
                $fileExists = false;
                $fileUrl = null;
                
                if ($filePath) {
                    // Try direct public path
                    if (file_exists(public_path($filePath))) {
                        $fileExists = true;
                        $fileUrl = asset($filePath);
                    }
                    // Try storage path
                    elseif (file_exists(storage_path('app/public/' . $filePath))) {
                        $fileExists = true;
                        $fileUrl = asset('storage/' . $filePath);
                    }
                    // Try removing leading slash
                    elseif (str_starts_with($filePath, '/')) {
                        $cleanPath = ltrim($filePath, '/');
                        if (file_exists(public_path($cleanPath))) {
                            $fileExists = true;
                            $fileUrl = asset($cleanPath);
                        }
                    }
                }
            @endphp
            
            @if($fileExists)
            <span class="text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full">
                ✓ يوجد ملف
            </span>
            @else
            <span class="text-sm bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full">
                ⚠ لا يوجد ملف
            </span>
            @endif
        </div>
    </div>
    
    @if($fileExists)
    <div class="p-6">
        <div class="text-center py-8 bg-blue-50 rounded-xl border-2 border-dashed border-blue-200">
            <div class="text-6xl mb-4 text-blue-500">📄</div>
            <p class="text-gray-600 mb-2">الاختبار متوفر كملف مرفق</p>
            <div class="flex justify-center gap-4">
                <a href="{{ $fileUrl }}" 
                   target="_blank"
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    فتح الملف
                </a>
                <a href="{{ $fileUrl }}" 
                   download
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    تحميل الملف
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="p-6">
        <div class="text-center py-12 bg-gray-50 rounded-xl">
            <div class="text-6xl mb-4 text-gray-400">📝</div>
            <p class="text-gray-600 mb-2">لا يوجد ملف للاختبار</p>
            @if($exam->file_path)
            <div class="bg-red-50 p-3 rounded-lg mt-4 mb-4">
                <p class="text-sm text-red-600">مسار الملف في قاعدة البيانات:</p>
                <p class="text-xs font-mono bg-gray-100 p-2 rounded mt-1">{{ $exam->file_path }}</p>
            </div>
            @endif
            <p class="text-sm text-gray-500">يمكنك طباعة هذه الصفحة كنسخة من الاختبار</p>
        </div>
    </div>
    @endif
</div>
        <!-- Skills & Levels Section -->
        @if($exam->weeklySkills && $exam->weeklySkills->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">المهارات والمستويات المغطاة</h3>
                    <div class="flex items-center gap-3">
                        @php
                            $level1Count = $exam->weeklySkills->where('levelSkill.level', 'level_1')->count();
                            $level2Count = $exam->weeklySkills->where('levelSkill.level', 'level_2')->count();
                            $level3Count = $exam->weeklySkills->where('levelSkill.level', 'level_3')->count();
                        @endphp
                        <span class="text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                            {{ $exam->weeklySkills->count() }} مهارات
                        </span>
                        <span class="text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                            {{ $level1Count + $level2Count + $level3Count }} مستويات
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Level Statistics -->
            <div class="p-6 border-b border-gray-200">
                <h4 class="font-medium text-gray-700 mb-3">توزيع المستويات</h4>
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
                @foreach($exam->weeklySkills as $index => $skill)
                    @if($skill->levelSkill && $skill->levelSkill->skill)
                    <div class="p-6 hover:bg-gray-50 transition duration-150">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mt-1">
                                    <span class="text-blue-600 font-bold">{{ $index + 1 }}</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $skill->levelSkill->skill->name }}</h4>
                                    @if($skill->levelSkill->skill->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $skill->levelSkill->skill->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                @if($skill->levelSkill->level === 'level_3') مستوى متقدم
                                @elseif($skill->levelSkill->level === 'level_2') مستوى متوسط
                                @else مستوى مبتدئ
                                @endif
                            </span>
                        </div>
                        
                        <!-- Level Details -->
                        <div class="space-y-2 pl-2 border-l-2 border-gray-200 ml-4">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="w-3 h-3 rounded-full 
                                    @if($skill->levelSkill->level === 'level_3') bg-purple-500
                                    @elseif($skill->levelSkill->level === 'level_2') bg-blue-500
                                    @else bg-green-500
                                    @endif">
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-gray-700">{{ $skill->levelSkill->level_name }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded-full
                                            @if($skill->levelSkill->level === 'level_3') bg-purple-100 text-purple-800
                                            @elseif($skill->levelSkill->level === 'level_2') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ str_replace('level_', 'مستوى ', $skill->levelSkill->level) }}
                                        </span>
                                    </div>
                                    @if($skill->levelSkill->level_description)
                                        <p class="text-sm text-gray-500">{{ $skill->levelSkill->level_description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">المهارات والمستويات المغطاة</h3>
            </div>
            <div class="p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <p class="mt-4 text-gray-500">لا توجد مهارات مرتبطة بهذا الاختبار</p>
            </div>
        </div>
        @endif

        <!-- Exam Metadata -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">معلومات النظام</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">رقم الاختبار:</span>
                            <span class="font-medium">#{{ $exam->id }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">تاريخ الإنشاء:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($exam->created_at)->format('Y/m/d H:i') }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">تاريخ التحديث:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($exam->updated_at)->format('Y/m/d H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">حالة الاختبار:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✓ متاح للطباعة
                            </span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">عدد المهارات:</span>
                            <span class="font-medium">{{ $exam->weeklySkills ? $exam->weeklySkills->count() : 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">ملف الاختبار:</span>
                            @if($exam->file_path)
                                <span class="font-medium text-green-600">موجود</span>
                            @else
                                <span class="font-medium text-yellow-600">غير موجود</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
            <!-- Print Button -->
           
            
            <!-- Back Button -->
            <a href="{{ route('teacher.exams.list') }}" 
               class="px-5 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-150 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة للقائمة
            </a>
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
        .flex.justify-end {
            display: none !important;
        }
        .rounded-xl {
            border-radius: 0.25rem !important;
        }
        .rounded-lg {
            border-radius: 0.125rem !important;
        }
        .text-2xl {
            font-size: 1.5rem !important;
        }
        .text-lg {
            font-size: 1.125rem !important;
        }
    }
</style>



@endsection