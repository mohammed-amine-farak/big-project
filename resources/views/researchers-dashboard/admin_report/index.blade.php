@extends('layouts.reseacher_dashboard')

@section('content')
@php
    // Status colors and names
    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'under_review' => 'bg-orange-100 text-orange-800', 
        'in_progress' => 'bg-blue-100 text-blue-800',
        'resolved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'closed' => 'bg-gray-100 text-gray-800'
    ];
    
    $statusNames = [
        'pending' => 'قيد الانتظار',
        'under_review' => 'قيد المراجعة',
        'in_progress' => 'قيد المعالجة',
        'resolved' => 'تم الحل',
        'rejected' => 'مرفوض',
        'closed' => 'مغلق'
    ];

    // Priority colors and names
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

    // Report type names
    $typeNames = [
        'financial' => 'مالي',
        'administrative' => 'إداري',
        'technical' => 'تقني',
        'human_resources' => 'موارد بشرية',
        'infrastructure' => 'بنية تحتية',
        'academic' => 'أكاديمي',
        'research' => 'بحثي',
        'security' => 'أمني',
        'other' => 'أخرى'
    ];

    // Calculate statistics from ALL records (not just current page)
    $allReports = $reports->getCollection();
    $totalReports = $reports->total();
    $pendingCount = $allReports->where('status', 'pending')->count();
    $underReviewCount = $allReports->where('status', 'under_review')->count();
    $inProgressCount = $allReports->where('status', 'in_progress')->count();
@endphp

<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📋 تقارير الإدارة المرسلة</h1>
                    <p class="text-gray-600 text-sm">تقارير إدارية تحتاج إلى بحث وتحليل من قبلك</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-left hidden sm:block">
                        <p class="text-xs font-medium text-gray-600">الباحث المسؤول</p>
                        <p class="text-sm font-bold text-gray-900">
                            {{ $reports->first()->researcher_name ?? 'غير محدد' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ substr($reports->first()->researcher_name ?? 'ب', 0, 1) }}
                    </div>
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
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $totalReports }}</p>
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
                            {{ $pendingCount }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Under Review -->
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">قيد المراجعة</p>
                        <p class="text-lg font-bold text-orange-600 truncate">
                            {{ $underReviewCount }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- In Progress -->
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">قيد المعالجة</p>
                        <p class="text-lg font-bold text-blue-600 truncate">
                            {{ $inProgressCount }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-700">تصفية التقارير</h3>
                </div>
                <div class="text-xs text-gray-500">
                    {{ $totalReports }} تقرير
                </div>
            </div>

            <form action="{{ route('admine_report.index') }}" method="GET" class="space-y-4">
                <!-- First Row of Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Title Filter -->
                    <div>
                        <label for="title_filter" class="block text-xs font-medium text-gray-600 mb-1">
                            البحث بالعنوان
                        </label>
                        <input type="text" name="title" id="title_filter" placeholder="اكتب للبحث..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ request('title') }}">
                    </div>

                    <!-- Admin Filter -->
                    <div>
                        <label for="admin_filter" class="block text-xs font-medium text-gray-600 mb-1">
                            المرسل (المسؤول)
                        </label>
                        <select name="admin_id" id="admin_filter"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">جميع المسؤولين</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->name ?? 'غير معروف' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Report Type Filter -->
                    <div>
                        <label for="type_filter" class="block text-xs font-medium text-gray-600 mb-1">
                            نوع التقرير
                        </label>
                        <select name="report_type" id="type_filter"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">جميع الأنواع</option>
                            @foreach($typeNames as $value => $name)
                                <option value="{{ $value }}" {{ request('report_type') == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status_filter" class="block text-xs font-medium text-gray-600 mb-1">
                            الحالة
                        </label>
                        <select name="status" id="status_filter"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">جميع الحالات</option>
                            @foreach($statusNames as $value => $name)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Row of Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Priority Filter -->
                    <div>
                        <label for="priority_filter" class="block text-xs font-medium text-gray-600 mb-1">
                            الأولوية
                        </label>
                        <select name="priority" id="priority_filter"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">جميع الأولويات</option>
                            @foreach($priorityNames as $value => $name)
                                <option value="{{ $value }}" {{ request('priority') == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-xs font-medium text-gray-600 mb-1">
                            من تاريخ
                        </label>
                        <input type="date" name="date_from" id="date_from"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-xs font-medium text-gray-600 mb-1">
                            إلى تاريخ
                        </label>
                        <input type="date" name="date_to" id="date_to"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ request('date_to') }}">
                    </div>

                    <!-- Deadline From -->
                    <div>
                        <label for="deadline_from" class="block text-xs font-medium text-gray-600 mb-1">
                            موعد نهائي من
                        </label>
                        <input type="date" name="deadline_from" id="deadline_from"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ request('deadline_from') }}">
                    </div>

                    <!-- Deadline To -->
                    <div>
                        <label for="deadline_to" class="block text-xs font-medium text-gray-600 mb-1">
                            موعد نهائي إلى
                        </label>
                        <input type="date" name="deadline_to" id="deadline_to"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ request('deadline_to') }}">
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div class="flex items-center gap-4">
                        <label class="text-xs font-medium text-gray-600">ترتيب حسب:</label>
                        <select name="sort" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>تاريخ الإرسال</option>
                            <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>الموعد النهائي</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>العنوان</option>
                            <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>الحالة</option>
                            <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>الأولوية</option>
                        </select>
                        <select name="direction" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="desc" {{ request('direction', 'desc') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <!-- Active Filters Display -->
                    @if(request()->anyFilled(['title', 'admin_id', 'report_type', 'status', 'priority', 'date_from', 'date_to', 'deadline_from', 'deadline_to']))
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                        </div>
                        <div class="flex flex-wrap gap-1">
                            @foreach(request()->except(['page', 'sort', 'direction']) as $key => $value)
                                @if(!empty($value))
                                    @php
                                        $filterLabels = [
                                            'title' => 'العنوان',
                                            'admin_id' => 'المسؤول',
                                            'report_type' => 'النوع',
                                            'status' => 'الحالة',
                                            'priority' => 'الأولوية',
                                            'date_from' => 'من تاريخ',
                                            'date_to' => 'إلى تاريخ',
                                            'deadline_from' => 'موعد من',
                                            'deadline_to' => 'موعد إلى'
                                        ];
                                        
                                        $displayValue = $value;
                                        if ($key == 'report_type') $displayValue = $typeNames[$value] ?? $value;
                                        if ($key == 'status') $displayValue = $statusNames[$value] ?? $value;
                                        if ($key == 'priority') $displayValue = $priorityNames[$value] ?? $value;
                                        if ($key == 'admin_id') {
                                            $admin = $admins->firstWhere('id', $value);
                                            $displayValue = $admin->name ?? $value;
                                        }
                                    @endphp
                                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                                        {{ $filterLabels[$key] ?? $key }}: {{ $displayValue }}
                                        <a href="{{ request()->fullUrlWithQuery([$key => null]) }}" class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </a>
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center gap-2">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            تطبيق التصفية
                        </button>
                        
                        @if(request()->anyFilled(['title', 'admin_id', 'report_type', 'status', 'priority', 'date_from', 'date_to', 'deadline_from', 'deadline_to', 'sort', 'direction']))
                        <a href="{{ route('admine_report.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            إعادة التعيين
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        @if($reports->count() === 0)
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 text-center border border-gray-200">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">
                            @if(request()->anyFilled(['title', 'admin_id', 'report_type', 'status', 'priority', 'date_from', 'date_to', 'deadline_from', 'deadline_to']))
                                لا توجد نتائج للبحث
                            @else
                                لا توجد تقارير
                            @endif
                        </h3>
                        <p class="text-gray-500 text-sm">
                            @if(request()->anyFilled(['title', 'admin_id', 'report_type', 'status', 'priority', 'date_from', 'date_to', 'deadline_from', 'deadline_to']))
                                حاول تعديل معايير البحث الخاصة بك
                            @else
                                لم يتم إرسال أي تقارير إدارية إليك بعد
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Reports Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="px-3 sm:px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            عرض 
                            <span class="font-medium text-gray-900">{{ $reports->firstItem() }} - {{ $reports->lastItem() }}</span>
                            من أصل 
                            <span class="font-medium text-gray-900">{{ $reports->total() }}</span> 
                            تقرير
                            @if(request()->anyFilled(['title', 'admin_id', 'report_type', 'status', 'priority', 'date_from', 'date_to', 'deadline_from', 'deadline_to']))
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">المرسل</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">النوع</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden xl:table-cell">الموعد النهائي</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">تاريخ الإرسال</th>
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
                                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Admin Sender -->
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2 justify-end">
                                                <div class="text-right">
                                                    <p class="text-sm text-gray-900 truncate max-w-[120px]">
                                                        {{ $report->admin_name ?? 'غير معروف' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 truncate max-w-[120px]">
                                                        مسؤول
                                                    </p>
                                                </div>
                                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                    {{ substr($report->admin_name ?? 'م', 0, 1) }}
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Report Type -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">
                                                {{ $typeNames[$report->report_type] ?? $report->report_type }}
                                            </span>
                                        </td>

                                        <!-- Deadline -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">
                                            @if($report->deadline)
                                                @php
                                                    $deadline = \Carbon\Carbon::parse($report->deadline);
                                                @endphp
                                                <span class="text-xs {{ $deadline->isPast() ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                                                    {{ $deadline->format('Y-m-d') }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">غير محدد</span>
                                            @endif
                                        </td>

                                        <!-- Sent Date -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                            <span class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}</span>
                                        </td>

                                        <!-- Priority -->
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $priorityColors[$report->priority] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $priorityNames[$report->priority] ?? $report->priority }}
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusNames[$report->status] ?? $report->status }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('admine_report.show', $report->id) }}" 
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
    @media (min-width: 475px) {
        .xs\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* Custom pagination styles */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .page-item .page-link {
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }

    .page-item.active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .page-item:not(.active) .page-link:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }

    .page-item.disabled .page-link {
        color: #9ca3af;
        pointer-events: none;
        background-color: #f9fafb;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change (optional)
    const filters = ['admin_filter', 'type_filter', 'status_filter', 'priority_filter', 'sort', 'direction'];
    
    filters.forEach(filterId => {
        const filter = document.getElementById(filterId);
        if (filter) {
            filter.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });

    // Debounced search for title filter
    const titleFilter = document.getElementById('title_filter');
    let searchTimeout;
    
    if (titleFilter) {
        titleFilter.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length === 0 || this.value.length >= 2) {
                    this.form.submit();
                }
            }, 800);
        });
    }
});
</script>
@endsection