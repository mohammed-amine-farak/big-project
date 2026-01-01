@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">🧠 التقارير النفسية للطلاب</h1>
                    <p class="text-gray-600 text-sm">إدارة وتقييم الجوانب النفسية والسلوكية للطلاب في الفصل</p>
                </div>
                <a href="{{route('StudentPsychology.create')}}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    تقرير جديد
                </a>
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

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية التقارير</h3>
            </div>

            <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                <!-- Student Filter -->
                <div class="md:col-span-1">
                    <label for="student_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        اسم الطالب
                    </label>
                    <select name="student_id" id="student_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الطلاب</option>
                        @foreach($students as $student)
                            <option value="{{ $student['id'] }}" {{ request('student_id') == $student['id'] ? 'selected' : '' }}>
                                {{ $student['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Classroom Filter -->
                <div class="md:col-span-1">
                    <label for="classroom_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الصف
                    </label>
                    <select name="classroom_id" id="classroom_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الصفوف</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="md:col-span-1">
                    <label for="status_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        حالة التقرير
                    </label>
                    <select name="status" id="status_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الحالات</option>
                        <option value="مسودة" {{ request('status') == 'مسودة' ? 'selected' : '' }}>مسودة</option>
                        <option value="مرسل_للإدارة" {{ request('status') == 'مرسل_للإدارة' ? 'selected' : '' }}>مرسل للإدارة</option>
                    </select>
                </div>

                <!-- Mood Filter -->
                <div class="md:col-span-1">
                    <label for="mood_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        المزاج
                    </label>
                    <select name="mood" id="mood_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الأحوال</option>
                        <option value="مبتهج" {{ request('mood') == 'مبتهج' ? 'selected' : '' }}>مبتهج</option>
                        <option value="هادئ" {{ request('mood') == 'هادئ' ? 'selected' : '' }}>هادئ</option>
                        <option value="قلق" {{ request('mood') == 'قلق' ? 'selected' : '' }}>قلق</option>
                        <option value="حزين" {{ request('mood') == 'حزين' ? 'selected' : '' }}>حزين</option>
                        <option value="غاضب" {{ request('mood') == 'غاضب' ? 'selected' : '' }}>غاضب</option>
                        <option value="متحمس" {{ request('mood') == 'متحمس' ? 'selected' : '' }}>متحمس</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-1 flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق
                    </button>
                    
                    @if(request()->anyFilled(['student_id', 'classroom_id', 'status', 'mood']))
                    <a href=""
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 whitespace-nowrap">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['student_id', 'classroom_id', 'status', 'mood']))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-1">
                    @if(request('student_id'))
                    @php
                        $selectedStudent = collect($students)->firstWhere('id', request('student_id'));
                    @endphp
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الطالب: {{ $selectedStudent['name'] ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['student_id' => null]) }}" class="text-blue-500 hover:text-blue-700">
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
                    <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الصف: {{ $selectedClassroom->class_name ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['classroom_id' => null]) }}" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('status'))
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الحالة: {{ request('status') == 'مسودة' ? 'مسودة' : 'مرسل للإدارة' }}
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-purple-500 hover:text-purple-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('mood'))
                    <span class="bg-amber-50 text-amber-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        المزاج: {{ request('mood') }}
                        <a href="{{ request()->fullUrlWithQuery(['mood' => null]) }}" class="text-amber-500 hover:text-amber-700">
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

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">مسودة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $reports->where('status', 'مسودة')->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">مرسل للإدارة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $reports->where('status', 'مرسل_للإدارة')->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">الطلاب</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $reports->pluck('student_name')->unique()->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

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
                            @if(request()->anyFilled(['student_id', 'classroom_id', 'status', 'mood']))
                                <span class="text-xs text-gray-500">(نتائج البحث)</span>
                            @endif
                        @else
                            لا توجد تقارير
                        @endif
                    </div>
                </div>
            </div>

            @if($reports->total() === 0)
                <!-- Compact Empty State -->
                <div class="bg-white p-6 sm:p-8 text-center border-b border-gray-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">لا توجد تقارير نفسية بعد</h3>
                            <p class="text-gray-500 text-sm">ابدأ بإضافة أول تقرير نفسي للطلاب</p>
                        </div>
                        <a href="{{route('StudentPsychology.create')}}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة تقرير جديد
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الطالب</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الصف</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">المزاج</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">السلوك</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">التاريخ</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reports as $report)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <div class="w-8 h-8 bg-purple-50 rounded flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                    <span class="font-medium text-gray-900 text-sm truncate max-w-[120px]">{{ $report->student->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium truncate max-w-[100px] inline-block">
                                                    {{ $report->classroom->class_name }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap">
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
                                                <span class="flex items-center gap-1 text-sm font-medium">
                                                    {{ $moodIcons[$report->mood] ?? '😐' }}
                                                    {{ $report->mood }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-sm hidden md:table-cell">
                                                @php
                                                    $behaviorColors = [
                                                        'ممتاز' => 'text-green-700 bg-green-50',
                                                        'جيد' => 'text-blue-700 bg-blue-50',
                                                        'مقبول' => 'text-amber-700 bg-amber-50',
                                                        'يحتاج_تحسين' => 'text-red-700 bg-red-50'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 rounded text-xs font-medium {{ $behaviorColors[$report->behavior] ?? 'text-gray-700 bg-gray-50' }}">
                                                    {{ $report->behavior }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm text-center hidden sm:table-cell">
                                                {{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                @if($report->status == 'مسودة')
                                                    <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs font-medium">
                                                        مسودة
                                                    </span>
                                                @else
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                                        مرسل للإدارة
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <!-- زر العرض -->
                                                    
                                                    <a href="{{route('StudentPsychology.show', $report->id)}}" 
                                                       class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                        عرض
                                                    </a>

                                                    @if ($report->status == 'مسودة')
                                                        <!-- زر التعديل -->
                                                        <a href="{{ route('StudentPsychology.edit', $report->id) }}" 
                                                           class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                            تعديل
                                                        </a>
                                                        
                                                        <!-- زر الإرسال -->
                                                        <form action="{{route('StudentPsychology.update-status', $report->id)}}" method="POST" 
                                                              onsubmit="return confirm('هل أنت متأكد من إرسال هذا التقرير للإدارة؟')" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                    class="bg-green-50 text-green-600 hover:bg-green-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                                إرسال
                                                            </button>
                                                        </form>
                                                        
                                                        <!-- زر الحذف -->
                                                        <form action="{{route('StudentPsychology.destroy', $report->id)}}" method="POST" 
                                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟')" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="bg-red-50 text-red-600 hover:bg-red-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                                حذف
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 text-xs">تم الإرسال</span>
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
                            <!-- Previous Page Link -->
                            @if ($reports->onFirstPage())
                                <span class="px-2 py-1 text-gray-400 bg-white border border-gray-300 rounded text-sm cursor-not-allowed">
                                    السابق
                                </span>
                            @else
                                <a href="{{ $reports->previousPageUrl() }}" 
                                   class="px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded text-sm hover:bg-gray-50 transition duration-200">
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
                                            <span class="px-2 py-1 text-white bg-blue-600 border border-blue-600 rounded text-sm font-medium">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" 
                                               class="px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded text-sm hover:bg-gray-50 transition duration-200">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($reports->hasMorePages())
                                <a href="{{ $reports->nextPageUrl() }}" 
                                   class="px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded text-sm hover:bg-gray-50 transition duration-200">
                                    التالي
                                </a>
                            @else
                                <span class="px-2 py-1 text-gray-400 bg-white border border-gray-300 rounded text-sm cursor-not-allowed">
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
    const studentFilter = document.getElementById('student_filter');
    const classroomFilter = document.getElementById('classroom_filter');
    const statusFilter = document.getElementById('status_filter');
    const moodFilter = document.getElementById('mood_filter');

    if (studentFilter) {
        studentFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }

    if (classroomFilter) {
        classroomFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }

    if (moodFilter) {
        moodFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }
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