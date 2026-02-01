@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تفاصيل تقرير للإدارة</h1>
                <p class="text-sm text-gray-500 mt-1">رقم التقرير: #{{ $report->id }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('teacher_admine_reports.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة للقائمة
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @if($report->is_read)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    مقروء
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    غير مقروء
                </span>
            @endif
        </div>

        <!-- Main Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Report Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">التقرير</h3>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $report->title }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">رقم التقرير:</span>
                        <span class="font-medium">#{{ $report->id }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">النوع:</span>
                        @php
                            $reportTypes = [
                                'administrative' => 'إداري',
                                'academic' => 'أكاديمي',
                                'technical' => 'تقني',
                                'other' => 'أخرى'
                            ];
                        @endphp
                        <span class="font-medium">{{ $reportTypes[$report->report_type] ?? $report->report_type }}</span>
                    </div>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">المسؤول المختص</h3>
                        <p class="text-lg font-bold text-gray-900">{{ $report->admin->user->name ?? 'غير معين' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">رقم المسؤول:</span>
                        <span class="font-medium">#{{ $report->admin_id ?? 'غير معين' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">التاريخ:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($report->created_at)->format('Y/m/d') }}</span>
                    </div>
                </div>
            </div>

            <!-- Priority Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">الأولوية</h3>
                        @php
                            $priorities = [
                                'urgent' => 'عاجلة',
                                'high' => 'عالية',
                                'medium' => 'متوسطة',
                                'low' => 'منخفضة'
                            ];
                            
                            $priorityColors = [
                                'urgent' => 'text-red-600',
                                'high' => 'text-orange-600',
                                'medium' => 'text-blue-600',
                                'low' => 'text-gray-600'
                            ];
                        @endphp
                        <p class="text-2xl font-bold {{ $priorityColors[$report->priority] ?? 'text-gray-600' }}">
                            {{ $priorities[$report->priority] ?? $report->priority }}
                        </p>
                    </div>
                </div>
                <!-- Deadline Progress Bar -->
                @if($report->deadline)
                <div class="mt-4">
                    @php
                        $now = now();
                        $deadline = \Carbon\Carbon::parse($report->deadline);
                        $daysRemaining = $now->diffInDays($deadline, false);
                        $totalDays = $report->created_at->diffInDays($deadline);
                        $passedDays = $report->created_at->diffInDays($now);
                        $percentage = $totalDays > 0 ? min(100, ($passedDays / $totalDays) * 100) : 100;
                        
                        $progressColor = 'bg-green-600';
                        if ($daysRemaining <= 0) {
                            $progressColor = 'bg-red-600';
                        } elseif ($daysRemaining <= 3) {
                            $progressColor = 'bg-orange-600';
                        } elseif ($daysRemaining <= 7) {
                            $progressColor = 'bg-yellow-600';
                        }
                    @endphp
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">الموعد النهائي:</span>
                        <span class="font-medium 
                            @if($daysRemaining <= 0) text-red-600
                            @elseif($daysRemaining <= 3) text-orange-600
                            @elseif($daysRemaining <= 7) text-yellow-600
                            @else text-green-600
                            @endif">
                            {{ $deadline->format('Y/m/d') }}
                            @if($daysRemaining >= 0)
                                ({{ $daysRemaining }} يوم)
                            @endif
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="{{ $progressColor }} h-2.5 rounded-full" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Report Content Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">محتوى التقرير</h3>
            </div>
            <div class="p-6">
                <div class="prose max-w-none">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $report->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attachments Section -->
        @if($report->related_documents && count($report->related_documents) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">الملفات المرفقة</h3>
                    <span class="text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                        {{ count($report->related_documents) }} ملفات
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($report->related_documents as $index => $document)
                        @php
                            $fileName = basename($document);
                            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                            $icon = 'file';
                            $color = 'bg-gray-100 text-gray-600';
                            
                            if (in_array($fileExt, ['pdf'])) {
                                $icon = 'file-pdf';
                                $color = 'bg-red-100 text-red-600';
                            } elseif (in_array($fileExt, ['doc', 'docx'])) {
                                $icon = 'file-word';
                                $color = 'bg-blue-100 text-blue-600';
                            } elseif (in_array($fileExt, ['xls', 'xlsx'])) {
                                $icon = 'file-excel';
                                $color = 'bg-green-100 text-green-600';
                            } elseif (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $icon = 'file-image';
                                $color = 'bg-purple-100 text-purple-600';
                            }
                        @endphp
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 {{ $color }} rounded-lg flex items-center justify-center flex-shrink-0">
                                    @if($icon === 'file-pdf')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif($icon === 'file-word')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif($icon === 'file-excel')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif($icon === 'file-image')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-800 truncate">{{ $fileName }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 uppercase">{{ $fileExt }}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $document) }}" 
                                   target="_blank"
                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    عرض الملف
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Sender Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">معلومات المرسل</h3>
            </div>
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">{{ $report->teacher->user->name ?? 'غير معروف' }}</h4>
                                <p class="text-gray-500">معلم</p>
                            </div>
                            <span class="text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                                مرسل التقرير
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">
                                        أرسل في: {{ \Carbon\Carbon::parse($report->created_at)->format('Y/m/d H:i') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">
                                        رقم المعلم: #{{ $report->teacher->id ?? 'غير معروف' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <span class="font-medium">#{{ $report->id }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">تاريخ الإنشاء:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($report->created_at)->format('Y/m/d H:i') }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">تاريخ التحديث:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($report->updated_at)->format('Y/m/d H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">الحالة:</span>
                            @if($report->is_read)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    مقروء
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    غير مقروء
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">النوع:</span>
                            <span class="font-medium">{{ $reportTypes[$report->report_type] ?? $report->report_type }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">الأولوية:</span>
                            <span class="font-medium {{ $priorityColors[$report->priority] ?? 'text-gray-600' }}">
                                {{ $priorities[$report->priority] ?? $report->priority }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($report->deadline)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-1">الموعد النهائي</h4>
                            <p class="text-sm text-gray-500">تاريخ إنهاء المعالجة المتوقع</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold 
                                @if($daysRemaining <= 0) text-red-600
                                @elseif($daysRemaining <= 3) text-orange-600
                                @elseif($daysRemaining <= 7) text-yellow-600
                                @else text-green-600
                                @endif">
                                {{ $deadline->format('Y/m/d') }}
                            </p>
                            @if($daysRemaining >= 0)
                                <p class="text-sm text-gray-500">{{ $daysRemaining }} يوم متبقي</p>
                            @else
                                <p class="text-sm text-red-500">تجاوز الموعد بـ {{ abs($daysRemaining) }} يوم</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between gap-3 mt-6 pt-6 border-t border-gray-200">
            <!-- Previous Button -->
            @if($previousReport)
                <a href="{{ route('teacher_admin_reports.show', $previousReport->id) }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    السابق
                </a>
            @else
                <div></div>
            @endif
            
            <!-- Back Button -->
            <a href="{{ route('teacher_admine_reports.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة للقائمة
            </a>
            
            <!-- Next Button -->
            @if($nextReport)
                <a href="{{ route('teacher_admin_reports.show', $nextReport->id) }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    التالي
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <div></div>
            @endif
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
        // Add page break before attachments section for better printing
        const attachmentsSection = document.querySelector('.bg-white.rounded-xl.shadow-sm.border.border-gray-200.overflow-hidden.mb-6');
        if (attachmentsSection) {
            attachmentsSection.classList.add('print-break-before');
        }
        
        // Hide navigation buttons when printing
        const navButtons = document.querySelector('.flex.justify-between.gap-3.mt-6.pt-6.border-t.border-gray-200');
        if (navButtons) {
            navButtons.classList.add('no-print');
        }
        
        // Hide back button in header when printing
        const headerButtons = document.querySelector('.flex.items-center.gap-3');
        if (headerButtons) {
            headerButtons.classList.add('no-print');
        }
    });
</script>

@endsection