@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex-1 text-right">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">تفاصيل التقرير</h1>
                    <p class="text-gray-600">عرض كامل المعلومات حول المشكلة المبلغ عنها</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{route('lesson-reports.index')}}" 
                       class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Report Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-900">معلومات التقرير</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">عنوان التقرير</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $lessonReport->title }}</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">وصف المشكلة</label>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $lessonReport->description }}</p>
                                </div>
                            </div>

                            <!-- Affected Students -->
                           
                        </div>
                    </div>
                </div>

                <!-- Researcher Response Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-900">رد الباحث</h2>
                    </div>
                    <div class="p-6">
                        @if($lessonReport->researcher_response)
                            <!-- Existing Response -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">الرد الحالي</label>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $lessonReport->researcher_response }}</p>
                                    @if($lessonReport->resolved_at)
                                        <div class="mt-3 pt-3 border-t border-blue-200">
                                            <p class="text-sm text-blue-600">
                                                تم الحل في: {{ $lessonReport->resolved_at}}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Response Form -->
                        <form action="{{ route('lesson-reports.update', $lessonReport->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-4">
                                <!-- Response Textarea -->
                                <div>
                                    <label for="researcher_response" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $lessonReport->researcher_response ? 'تعديل الرد' : 'إضافة رد' }}
                                    </label>
                                    <textarea 
                                        id="researcher_response" 
                                        name="researcher_response" 
                                        rows="6" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="اكتب ردك هنا...">{{ old('researcher_response', $lessonReport->researcher_response) }}</textarea>
                                    @error('researcher_response')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status and Actions -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">حالة التقرير</label>
                                        <select 
                                            id="status" 
                                            name="status" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @php
                                                $statusOptions = [
                                                    'pending' => 'قيد الانتظار',
                                                    'under_review' => 'قيد المراجعة',
                                                    'resolved' => 'تم الحل',
                                                    'closed' => 'مغلق'
                                                ];
                                            @endphp
                                            @foreach($statusOptions as $value => $label)
                                                <option value="{{ $value }}" 
                                                    {{ $lessonReport->status == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Priority -->
                                    
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end gap-3 pt-4">
                                    <a href="{{route('lesson-reports.index')}}" 
                                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                        إلغاء
                                    </a>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                        {{ $lessonReport->researcher_response ? 'تحديث الرد' : 'إرسال الرد' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">حالة التقرير</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <!-- Current Status -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">الحالة الحالية:</span>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'under_review' => 'bg-blue-100 text-blue-800',
                                        'resolved' => 'bg-green-100 text-green-800',
                                        'closed' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $statusNames = [
                                        'pending' => 'قيد الانتظار',
                                        'under_review' => 'قيد المراجعة',
                                        'resolved' => 'تم الحل',
                                        'closed' => 'مغلق'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$lessonReport->status] }}">
                                    {{ $statusNames[$lessonReport->status] }}
                                </span>
                            </div>

                            <!-- Priority -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">الأولوية:</span>
                                @php
                                    $priorityColors = [
                                        'low' => 'bg-green-100 text-green-800',
                                        'medium' => 'bg-blue-100 text-blue-800',
                                        'high' => 'bg-orange-100 text-orange-800',
                                        'critical' => 'bg-red-100 text-red-800'
                                    ];
                                    $priorityNames = [
                                        'low' => 'منخفضة',
                                        'medium' => 'متوسطة',
                                        'high' => 'عالية',
                                        'critical' => 'حرجة'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $priorityColors[$lessonReport->priority] }}">
                                    {{ $priorityNames[$lessonReport->priority] }}
                                </span>
                            </div>

                            <!-- Problem Type -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">نوع المشكلة:</span>
                                @php
                                    $typeColors = [
                                        'content_issue' => 'bg-purple-100 text-purple-800',
                                        'difficulty_level' => 'bg-orange-100 text-orange-800',
                                        'technical_issue' => 'bg-red-100 text-red-800',
                                        'language_issue' => 'bg-blue-100 text-blue-800',
                                        'other' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $typeNames = [
                                        'content_issue' => 'محتوى',
                                        'difficulty_level' => 'صعوبة',
                                        'technical_issue' => 'تقنية',
                                        'language_issue' => 'لغوية',
                                        'other' => 'أخرى'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $typeColors[$lessonReport->problem_type] }}">
                                    {{ $typeNames[$lessonReport->problem_type] }}
                                </span>
                            </div>

                            <!-- Dates -->
                            <div class="pt-3 border-t border-gray-200 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">تاريخ الإرسال:</span>
                                    <span class="text-xs text-gray-700">{{ $lessonReport->created_at}}</span>
                                </div>
                                @if($lessonReport->resolved_at)
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">تاريخ الحل:</span>
                                    <span class="text-xs text-gray-700">{{ $lessonReport->resolved_at}}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">معلومات ذات صلة</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <!-- Lesson Info -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">الدرس</h4>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">{{ $lessonReport->lesson->title ?? 'غير محدد' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $lessonReport->lesson->subject->name ?? '' }}</p>
                            </div>
                        </div>

                        <!-- Teacher Info -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">المعلم</h4>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">{{ $lessonReport->teacher->user->name ?? 'غير محدد' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $lessonReport->teacher->user->email ?? '' }}</p>
                            </div>
                        </div>

                        <!-- Classroom Info -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">الفصل الدراسي</h4>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">{{ $lessonReport->classroom->class_name ?? 'غير محدد' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $lessonReport->classroom->study_level ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">إجراءات سريعة</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                           
                            
                            <a href="{{route('lessons.show',$lessonReport->lesson->id)}}" 
                               class="w-full flex items-center justify-center gap-2 bg-green-50 hover:bg-green-100 text-green-700 px-3 py-2 rounded-lg text-sm transition duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                عرض الدرس
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection