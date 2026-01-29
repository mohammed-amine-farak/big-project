@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📋 تقاريري حول مشاكل الدروس</h1>
                    <p class="text-gray-600 text-sm">جميع التقارير التي قمتُ بإرسالها بخصوص الدروس</p>
                </div>
                <a href=""
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    إبلاغ عن مشكلة جديدة
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
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

        @if (session('error'))
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1">
                        <svg class="fill-current h-5 w-5 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter Section (ONLY Researcher, Lesson, Status, Priority, Problem Type) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية التقارير</h3>
            </div>

            <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                <!-- Researcher Filter -->
                <div class="md:col-span-1">
                    <label for="researcher_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الباحث
                    </label>
                    <select name="researcher_id" id="researcher_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الباحثين</option>
                        @foreach($researchers as $researcher)
                            <option value="{{ $researcher->id }}" {{ request('researcher_id') == $researcher->id ? 'selected' : '' }}>
                                {{ $researcher->user->name ?? 'باحث' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lesson Filter -->
                <div class="md:col-span-1">
                    <label for="lesson_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الدرس
                    </label>
                    <select name="lesson_id" id="lesson_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الدروس</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                {{ Str::limit($lesson->title, 25) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Problem Type Filter -->
                <div class="md:col-span-1">
                    <label for="type_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        نوع المشكلة
                    </label>
                    <select name="problem_type" id="type_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الأنواع</option>
                        @foreach($problemTypes as $type)
                            <option value="{{ $type }}" {{ request('problem_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Priority Filter -->
                <div class="md:col-span-1">
                    <label for="priority_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الأولوية
                    </label>
                    <select name="priority" id="priority_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الأولويات</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                        <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>حرجة</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="md:col-span-1">
                    <label for="status_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الحالة
                    </label>
                    <select name="status" id="status_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلقة</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-5 flex justify-end gap-2 pt-2">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق التصفية
                    </button>
                    
                    @if(request()->anyFilled(['researcher_id', 'lesson_id', 'problem_type', 'priority', 'status']))
                    <a href=""
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['researcher_id', 'lesson_id', 'problem_type', 'priority', 'status']))
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if(request('researcher_id'))
                    @php
                        $selectedResearcher = $researchers->firstWhere('id', request('researcher_id'));
                    @endphp
                    <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs flex items-center gap-2">
                        الباحث: {{ $selectedResearcher->user->name ?? 'باحث غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['researcher_id' => null]) }}" 
                           class="text-blue-500 hover:text-blue-700" title="إزالة التصفية">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('lesson_id'))
                    @php
                        $selectedLesson = $lessons->firstWhere('id', request('lesson_id'));
                    @endphp
                    <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs flex items-center gap-2">
                        الدرس: {{ $selectedLesson->title ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['lesson_id' => null]) }}" 
                           class="text-emerald-500 hover:text-emerald-700" title="إزالة التصفية">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('problem_type'))
                    <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs flex items-center gap-2">
                        نوع المشكلة: {{ request('problem_type') }}
                        <a href="{{ request()->fullUrlWithQuery(['problem_type' => null]) }}" 
                           class="text-purple-500 hover:text-purple-700" title="إزالة التصفية">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('priority'))
                    @php
                        $priorityLabels = [
                            'low' => 'منخفضة',
                            'medium' => 'متوسطة',
                            'high' => 'عالية',
                            'critical' => 'حرجة'
                        ];
                    @endphp
                    <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs flex items-center gap-2">
                        الأولوية: {{ $priorityLabels[request('priority')] ?? request('priority') }}
                        <a href="{{ request()->fullUrlWithQuery(['priority' => null]) }}" 
                           class="text-red-500 hover:text-red-700" title="إزالة التصفية">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('status'))
                    @php
                        $statusLabels = [
                            'pending' => 'قيد الانتظار',
                            'in_progress' => 'قيد المعالجة',
                            'resolved' => 'تم الحل',
                            'closed' => 'مغلقة'
                        ];
                    @endphp
                    <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs flex items-center gap-2">
                        الحالة: {{ $statusLabels[request('status')] ?? request('status') }}
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" 
                           class="text-green-500 hover:text-green-700" title="إزالة التصفية">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">إجمالي التقارير</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $reports->total() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">قيد الانتظار</p>
                        <p class="text-lg font-bold text-yellow-600 truncate">
                            {{ $reports->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">عالية الأولوية</p>
                        <p class="text-lg font-bold text-red-600 truncate">
                            {{ $reports->whereIn('priority', ['high', 'critical'])->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">تم الحل</p>
                        <p class="text-lg font-bold text-green-600 truncate">
                            {{ $reports->where('status', 'resolved')->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if($reports->total() > 0)
                            عرض 
                            <span class="font-medium text-gray-900">{{ $reports->firstItem() }} - {{ $reports->lastItem() }}</span>
                            من أصل 
                            <span class="font-medium text-gray-900">{{ $reports->total() }}</span> 
                            تقرير
                            @if(request()->anyFilled(['researcher_id', 'lesson_id', 'problem_type', 'priority', 'status']))
                                <span class="text-xs text-gray-500">(نتائج البحث)</span>
                            @endif
                        @else
                            لا توجد تقارير
                        @endif
                    </div>
                </div>
            </div>

            @if($reports->total() === 0)
                <!-- Empty State -->
                <div class="bg-white p-8 text-center border-b border-gray-200">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">لا توجد تقارير بعد</h3>
                            <p class="text-gray-500 text-sm mb-4">ابدأ بإرسال أول تقرير عن مشكلة في الدرس</p>
                        </div>
                        <a href="" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إبلاغ عن مشكلة جديدة
                        </a>
                    </div>
                </div>
            @else
                <!-- Table with Horizontal Scroll -->
                <div class="overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">التقرير</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الباحث</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الدرس</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">نوع المشكلة</th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الأولوية</th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reports as $report)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-4 py-4">
                                            <div class="flex items-start gap-3 min-w-0">
                                                <div class="w-10 h-10 bg-blue-50 rounded flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-gray-900 text-sm truncate">{{ $report->title }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d H:i') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-4 py-4">
                                            <div class="text-gray-700 text-sm">
                                                {{ $report->researcher->user->name ?? 'غير معروف' }}
                                            </div>
                                        </td>
                                        
                                        <td class="px-4 py-4">
                                            <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-medium truncate max-w-[150px] inline-block">
                                                {{ $report->lesson->title ?? '—' }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-4 py-4 hidden md:table-cell">
                                            <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded text-xs font-medium">
                                                {{ $report->problem_type }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-4 py-4 text-center">
                                            @if($report->priority == 'critical')
                                                <span class="bg-red-100 text-red-800 px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    حرجة
                                                </span>
                                            @elseif($report->priority == 'high')
                                                <span class="bg-orange-100 text-orange-800 px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    عالية
                                                </span>
                                            @elseif($report->priority == 'medium')
                                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    متوسطة
                                                </span>
                                            @else
                                                <span class="bg-green-100 text-green-800 px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    منخفضة
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-4 py-4 text-center">
                                            @if($report->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1.5 rounded-full text-xs font-medium">
                                                    قيد الانتظار
                                                </span>
                                            @elseif($report->status == 'in_progress')
                                                <span class="bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-xs font-medium">
                                                    قيد المعالجة
                                                </span>
                                            @elseif($report->status == 'resolved')
                                                <span class="bg-green-100 text-green-800 px-3 py-1.5 rounded-full text-xs font-medium">
                                                    تم الحل
                                                </span>
                                            @elseif($report->status == 'closed')
                                                <span class="bg-gray-100 text-gray-800 px-3 py-1.5 rounded-full text-xs font-medium">
                                                    مغلقة
                                                </span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 px-3 py-1.5 rounded-full text-xs font-medium">
                                                    {{ $report->status }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href=""
                                                   class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    عرض
                                                </a>
                                                
                                                @if($report->status == 'pending')
                                                <a href="" 
                                                   class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-3 py-1.5 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    تعديل
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                @if($reports->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-sm text-gray-700 text-center sm:text-right">
                            عرض 
                            <span class="font-medium">{{ $reports->firstItem() }}</span>
                            إلى 
                            <span class="font-medium">{{ $reports->lastItem() }}</span>
                            من 
                            <span class="font-medium">{{ $reports->total() }}</span>
                            نتيجة
                        </div>
                        
                        <div class="flex items-center space-x-1 space-x-reverse flex-wrap justify-center">
                            <!-- Previous Page Link -->
                            @if ($reports->onFirstPage())
                                <span class="px-3 py-1.5 text-gray-400 bg-white border border-gray-300 rounded-lg text-sm cursor-not-allowed">
                                    السابق
                                </span>
                            @else
                                <a href="{{ $reports->previousPageUrl() }}" 
                                   class="px-3 py-1.5 text-gray-700 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition duration-200">
                                    السابق
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($reports->links()->elements as $element)
                                <!-- "Three Dots" Separator -->
                                @if (is_string($element))
                                    <span class="px-2 py-1 text-gray-500">{{ $element }}</span>
                                @endif

                                <!-- Array Of Links -->
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $reports->currentPage())
                                            <span class="px-3 py-1.5 text-white bg-blue-600 border border-blue-600 rounded-lg text-sm font-medium">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" 
                                               class="px-3 py-1.5 text-gray-700 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition duration-200">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($reports->hasMorePages())
                                <a href="{{ $reports->nextPageUrl() }}" 
                                   class="px-3 py-1.5 text-gray-700 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition duration-200">
                                    التالي
                                </a>
                            @else
                                <span class="px-3 py-1.5 text-gray-400 bg-white border border-gray-300 rounded-lg text-sm cursor-not-allowed">
                                    التالي
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when select filters change
    const filters = [
        'researcher_filter',
        'lesson_filter',
        'type_filter',
        'priority_filter',
        'status_filter'
    ];

    filters.forEach(filterId => {
        const element = document.getElementById(filterId);
        if (element) {
            element.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
});
</script>

<style>
    /* Custom breakpoint for extra small screens */
    @media (min-width: 475px) {
        .xs\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>
@endsection