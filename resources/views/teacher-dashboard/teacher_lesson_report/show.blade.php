@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تفاصيل التقرير</h1>
                <p class="text-gray-600 mt-1">معلومات كاملة عن التقرير المقدم</p>
            </div>
            <div class="flex items-center gap-3">
                @if($report->status == 'pending')
                <a href="" 
                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل
                </a>
                @endif
                <a href="" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
            </div>
        </div>

        <!-- Report Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Report Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ $report->title }}</h2>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d H:i') }}
                                </span>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-gray-500">رقم التقرير: {{ $report->id }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($report->status == 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                قيد الانتظار
                            </span>
                        @elseif($report->status == 'in_progress')
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                قيد المعالجة
                            </span>
                        @elseif($report->status == 'resolved')
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                تم الحل
                            </span>
                        @elseif($report->status == 'closed')
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                مغلقة
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Report Content -->
            <div class="p-6">
                <!-- Basic Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Lesson Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-700">معلومات الدرس</h3>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">عنوان الدرس</p>
                                <p class="text-sm text-gray-800 font-medium">{{ $report->lesson->title ?? 'غير محدد' }}</p>
                            </div>
                            @if($report->classroom)
                            <div>
                                <p class="text-xs text-gray-500">الصف الدراسي</p>
                                <p class="text-sm text-gray-800">{{ $report->classroom->class_name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Priority & Type -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-700">التصنيف</h3>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">الأولوية</p>
                                @if($report->priority == 'critical')
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-red-800 bg-red-100 px-3 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        حرجة
                                    </span>
                                @elseif($report->priority == 'high')
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-orange-800 bg-orange-100 px-3 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        عالية
                                    </span>
                                @elseif($report->priority == 'medium')
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-yellow-800 bg-yellow-100 px-3 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        متوسطة
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-green-800 bg-green-100 px-3 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        منخفضة
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">نوع المشكلة</p>
                                @php
                                    $problemTypeLabels = [
                                        'content_issue' => 'مشكلة في المحتوى',
                                        'difficulty_level' => 'مستوى الصعوبة',
                                        'technical_issue' => 'مشكلة تقنية',
                                        'language_issue' => 'مشكلة لغوية',
                                        'other' => 'أخرى'
                                    ];
                                @endphp
                                <span class="text-xs font-medium text-purple-800 bg-purple-100 px-3 py-1 rounded-full">
                                    {{ $problemTypeLabels[$report->problem_type] ?? $report->problem_type }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- People Involved -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Reporter (Teacher) -->
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <h3 class="text-sm font-medium text-blue-700">المبلغ (المعلم)</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $report->teacher->user->name ?? 'معلّم' }}
                                </p>
                                <p class="text-xs text-gray-500">تاريخ الإبلاغ: {{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Assigned Researcher -->
                    @if($report->researcher)
                    <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <h3 class="text-sm font-medium text-emerald-700">الباحث المسؤول</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $report->researcher->user->name ?? 'باحث' }}
                                </p>
                                @if($report->researcher->user->email ?? false)
                                <p class="text-xs text-gray-500">{{ $report->researcher->user->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Problem Description -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">وصف المشكلة</h3>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="prose prose-sm max-w-none">
                            {!! nl2br(e($report->description)) !!}
                        </div>
                    </div>
                </div>

                <!-- Teacher's Suggested Solution -->
                @if($report->suggested_solution)
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">الحل المقترح من المعلم</h3>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="prose prose-sm max-w-none">
                            {!! nl2br(e($report->suggested_solution)) !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Researcher's Response -->
                @if($report->researcher_response || $report->admin_notes || $report->solution_provided)
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">رد الباحث</h3>
                        </div>
                        @if($report->resolved_at)
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded-full">
                            تم الرد في: {{ \Carbon\Carbon::parse($report->resolved_at)->format('Y-m-d') }}
                        </span>
                        @endif
                    </div>
                    
                    <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-200">
                        <!-- Researcher Response -->
                        @if($report->researcher_response)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-emerald-700 mb-2">رد الباحث</h4>
                            <div class="prose prose-sm max-w-none">
                                {!! nl2br(e($report->researcher_response)) !!}
                            </div>
                        </div>
                        @endif
                        
                        <!-- Solution Provided by Researcher -->
                        @if($report->solution_provided)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-emerald-700 mb-2">الحل المقدم من الباحث</h4>
                            <div class="prose prose-sm max-w-none">
                                {!! nl2br(e($report->solution_provided)) !!}
                            </div>
                        </div>
                        @endif
                        
                        <!-- Additional Notes -->
                        @if($report->admin_notes)
                        <div>
                            <h4 class="text-sm font-medium text-emerald-700 mb-2">ملاحظات إضافية</h4>
                            <div class="prose prose-sm max-w-none">
                                {!! nl2br(e($report->admin_notes)) !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @elseif($report->status == 'resolved' || $report->status == 'closed')
                <!-- Show empty state if report is resolved but no response -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">رد الباحث</h3>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500">لم يتم إضافة رد من الباحث بعد</p>
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">التاريخ الزمني</h3>
                    <div class="space-y-4">
                        <!-- Created -->
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">إنشاء التقرير</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        
                        <!-- Reported -->
                        @if($report->reported_at)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">تم الإبلاغ</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->reported_at)->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Resolved -->
                        @if($report->resolved_at)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">تم الحل</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->resolved_at)->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Updated -->
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">آخر تحديث</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->updated_at)->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        @if($report->updated_at != $report->created_at)
                        آخر تحديث: {{ \Carbon\Carbon::parse($report->updated_at)->format('Y-m-d H:i') }}
                        @else
                        تاريخ الإنشاء: {{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d H:i') }}
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                       
                        
                        @if($report->status == 'pending')
                        <form action="{{ route('teacher.lesson_reports.destroy', $report->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition duration-150"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا التقرير؟')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                حذف
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .prose {
        color: #374151;
        line-height: 1.75;
    }
    
    .prose p {
        margin-top: 0.75em;
        margin-bottom: 0.75em;
    }
    
    .prose a {
        color: #2563eb;
        text-decoration: underline;
    }
</style>

@endsection