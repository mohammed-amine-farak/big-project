@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📋 تقارير المشاكل في الدروس</h1>
                    <p class="text-gray-600 text-sm">تقارير المعلمين حول المشاكل التي يواجهها الطلاب في الدروس</p>
                </div>
                <div class="flex items-center gap-4">
                    @if(isset($reports[0]->researcher->user))
                    <div class="text-left hidden sm:block">
                        <p class="text-xs font-medium text-gray-600">الباحث المسؤول</p>
                        <p class="text-sm font-bold text-gray-900">
                            {{ $reports[0]->researcher->user->name ?? 'غير محدد' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ substr($reports[0]->researcher->user->name ?? 'ب', 0, 1) }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics Cards - Responsive Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <!-- Total Reports -->
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">إجمالي التقارير</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $reports->total() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Reports -->
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">قيد الانتظار</p>
                        <p class="text-lg font-bold text-yellow-600 truncate">
                            {{ $reports->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- High Priority -->
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">عالية الأولوية</p>
                        <p class="text-lg font-bold text-red-600 truncate">
                            {{ $reports->whereIn('priority', ['high', 'critical'])->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Resolved -->
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">تم الحل</p>
                        <p class="text-lg font-bold text-green-600 truncate">
                            {{ $reports->where('status', 'resolved')->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section - Improved Responsiveness -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية التقارير</h3>
            </div>

            <form action="{{ route('lesson-reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Title Filter -->
                <div class="md:col-span-1">
                    <label for="title_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        البحث بالعنوان
                    </label>
                    <input type="text" name="title" id="title_filter" placeholder="اكتب للبحث..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ request('title') }}">
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
                                {{ $lesson->title }} - {{ $lesson->subject->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Classroom Filter -->
                <div class="md:col-span-1">
                    <label for="classroom_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الفصل الدراسي
                    </label>
                    <select name="classroom_id" id="classroom_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الفصول</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->class_name }} - {{ $classroom->study_level ?? '' }}
                            </option>
                        @endforeach
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
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>قيد المراجعة</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلق</option>
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

                <!-- Action Buttons -->
                <div class="md:col-span-2 lg:col-span-5 flex items-end gap-2 justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق التصفية
                    </button>
                    
                    @if(request()->anyFilled(['title', 'lesson_id', 'classroom_id', 'status', 'priority']))
                    <a href="{{ route('lesson-reports.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['title', 'lesson_id', 'classroom_id', 'status', 'priority']))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-1">
                    @if(request('title'))
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        العنوان: "{{ request('title') }}"
                        <a href="{{ request()->fullUrlWithQuery(['title' => null]) }}" class="text-blue-500 hover:text-blue-700">
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
                    <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الدرس: {{ $selectedLesson->title ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['lesson_id' => null]) }}" class="text-indigo-500 hover:text-indigo-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('classroom_id'))
                    @php
                        $selectedClassroom = $classrooms->firstWhere('id', request('classroom_id'));
                    @endphp
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الفصل: {{ $selectedClassroom->class_name ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['classroom_id' => null]) }}" class="text-purple-500 hover:text-purple-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('status'))
                    @php
                        $statusNames = [
                            'pending' => 'قيد الانتظار',
                            'under_review' => 'قيد المراجعة',
                            'resolved' => 'تم الحل',
                            'closed' => 'مغلق'
                        ];
                    @endphp
                    <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الحالة: {{ $statusNames[request('status')] ?? request('status') }}
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('priority'))
                    @php
                        $priorityNames = [
                            'low' => 'منخفضة',
                            'medium' => 'متوسطة',
                            'high' => 'عالية',
                            'critical' => 'حرجة'
                        ];
                    @endphp
                    <span class="bg-amber-50 text-amber-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الأولوية: {{ $priorityNames[request('priority')] ?? request('priority') }}
                        <a href="{{ request()->fullUrlWithQuery(['priority' => null]) }}" class="text-amber-500 hover:text-amber-700">
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

        @if ($reports->count() === 0)
            <!-- Compact Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 text-center border border-gray-200">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">
                            @if(request()->anyFilled(['title', 'lesson_id', 'classroom_id', 'status', 'priority']))
                                لا توجد نتائج للبحث
                            @else
                                لا توجد تقارير
                            @endif
                        </h3>
                        <p class="text-gray-500 text-sm">
                            @if(request()->anyFilled(['title', 'lesson_id', 'classroom_id', 'status', 'priority']))
                                حاول تعديل معايير البحث الخاصة بك
                            @else
                                لم يتم إرسال أي تقارير عن مشاكل في الدروس بعد
                            @endif
                        </p>
                    </div>
                    @if(request()->anyFilled(['title', 'lesson_id', 'classroom_id', 'status', 'priority']))
                    <a href="{{ route('lesson-reports.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        عرض جميع التقارير
                    </a>
                    @else
                    <a href="{{ route('lessons.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        عرض الدروس
                    </a>
                    @endif
                </div>
            </div>
        @else
            <!-- Responsive Table Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="px-3 sm:px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            @if($reports->total() > 0)
                                عرض 
                                <span class="font-medium text-gray-900">{{ $reports->firstItem() }} - {{ $reports->lastItem() }}</span>
                                من أصل 
                                <span class="font-medium text-gray-900">{{ $reports->total() }}</span> 
                                تقرير
                            @endif
                            @if(request()->anyFilled(['title', 'lesson_id', 'classroom_id', 'status', 'priority']))
                                <span class="text-xs text-gray-500">(نتائج البحث)</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Table with Horizontal Scroll -->
                <div class="overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">التقرير</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الدرس</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">المعلم</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden xl:table-cell">الفصل</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">النوع</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الأولوية</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reports as $report)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- Report Title & Date -->
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <div class="w-8 h-8 bg-blue-50 rounded flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate max-w-[150px]">{{ $report->title }}</p>
                                                    <p class="text-xs text-gray-500">{{ $report->created_at}}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Lesson -->
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <p class="text-sm text-gray-900 truncate max-w-[120px]">{{ $report->lesson->title ?? 'غير محدد' }}</p>
                                            <p class="text-xs text-gray-500 truncate max-w-[120px]">{{ $report->lesson->subject->name ?? '' }}</p>
                                        </td>

                                        <!-- Teacher -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                            <div class="flex items-center gap-2 justify-end min-w-0">
                                                <span class="truncate max-w-[100px]">{{ $report->teacher->user->name ?? 'غير محدد' }}</span>
                                            </div>
                                        </td>

                                        <!-- Classroom -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 hidden xl:table-cell">
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs truncate max-w-[100px] inline-block">
                                                {{ $report->classroom->class_name ?? 'غير محدد' }}
                                            </span>
                                        </td>

                                        <!-- Problem Type -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
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
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $typeColors[$report->problem_type] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $typeNames[$report->problem_type] ?? $report->problem_type }}
                                            </span>
                                        </td>

                                        <!-- Priority -->
                                        <td class="px-3 py-3 whitespace-nowrap">
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
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $priorityColors[$report->priority] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $priorityNames[$report->priority] ?? $report->priority }}
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-3 py-3 whitespace-nowrap">
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
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusNames[$report->status] ?? $report->status }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('lesson-reports.show', $report->id) }}" 
                                                   class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                    عرض
                                                </a>
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
                <div class="px-3 sm:px-4 py-3 border-t border-gray-200 bg-gray-50">
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
                            {{ $reports->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
    /* Custom breakpoint for extra small screens */
    @media (min-width: 475px) {
        .xs\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleFilter = document.getElementById('title_filter');
    const lessonFilter = document.getElementById('lesson_filter');
    const classroomFilter = document.getElementById('classroom_filter');
    const statusFilter = document.getElementById('status_filter');
    const priorityFilter = document.getElementById('priority_filter');

    // Auto-submit form when select filters change
    [lessonFilter, classroomFilter, statusFilter, priorityFilter].forEach(filter => {
        filter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    });

    // Debounced search for title filter
    let searchTimeout;
    titleFilter.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length === 0 || this.value.length >= 2) {
                this.form.submit();
            }
        }, 500);
    });
});
</script>
@endsection