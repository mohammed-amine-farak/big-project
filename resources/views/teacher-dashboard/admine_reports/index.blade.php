@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📋 تقاريري للإدارة</h1>
                    <p class="text-gray-600 text-sm">إدارة التقارير المرسلة للإدارة ومتابعة الردود</p>
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

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية التقارير</h3>
            </div>

            <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                <!-- Search Filter -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-xs font-medium text-gray-600 mb-1">
                        البحث
                    </label>
                    <input type="text" name="search" id="search" 
                           value="{{ request('search') }}"
                           placeholder="ابحث في العناوين والمحتوى..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Report Type Filter -->
                <div class="md:col-span-1">
                    <label for="report_type_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        نوع التقرير
                    </label>
                    <select name="report_type" id="report_type_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الأنواع</option>
                        @foreach($reportTypes as $key => $value)
                            <option value="{{ $key }}" {{ request('report_type') == $key ? 'selected' : '' }}>
                                {{ $value }}
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
                        @foreach($priorities as $key => $value)
                            <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Read Status Filter -->
                <div class="md:col-span-1">
                    <label for="read_status_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        حالة القراءة
                    </label>
                    <select name="is_read" id="read_status_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">الجميع</option>
                        <option value="read" {{ request('is_read') == 'read' ? 'selected' : '' }}>مقروء</option>
                        <option value="unread" {{ request('is_read') == 'unread' ? 'selected' : '' }}>غير مقروء</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-5 flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق
                    </button>
                    
                    @if(request()->anyFilled(['search', 'report_type', 'priority', 'is_read']))
                    <a href="{{ route('teacher_admine_reports.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 whitespace-nowrap">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['search', 'report_type', 'priority', 'is_read']))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-1">
                    @if(request('search'))
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        البحث: "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-blue-500 hover:text-blue-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('report_type'))
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        النوع: {{ $reportTypes[request('report_type')] ?? request('report_type') }}
                        <a href="{{ request()->fullUrlWithQuery(['report_type' => null]) }}" class="text-purple-500 hover:text-purple-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('priority'))
                    <span class="bg-red-50 text-red-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الأولوية: {{ $priorities[request('priority')] ?? request('priority') }}
                        <a href="{{ request()->fullUrlWithQuery(['priority' => null]) }}" class="text-red-500 hover:text-red-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('is_read'))
                    <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الحالة: {{ request('is_read') == 'read' ? 'مقروء' : 'غير مقروء' }}
                        <a href="{{ request()->fullUrlWithQuery(['is_read' => null]) }}" class="text-emerald-500 hover:text-emerald-700">
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
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['total'] }}</p>
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
                        <p class="text-xs font-medium text-gray-600 truncate">غير مقروء</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['unread'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">مقروء</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['read'] }}</p>
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
                        <p class="text-xs font-medium text-gray-600 truncate">عالية الأولوية</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['high_priority'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
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
                            @if(request()->anyFilled(['search', 'report_type', 'priority', 'is_read']))
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
                            <h3 class="text-base font-semibold text-gray-900 mb-1">لا توجد تقارير بعد</h3>
                            
                        </div>
                       
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">العنوان</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">النوع</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">المسؤول</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الأولوية</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">تاريخ الإرسال</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reports as $report)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-3 py-3">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <div class="w-8 h-8 bg-blue-50 rounded flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="font-medium text-gray-900 text-sm truncate max-w-[200px]">{{ $report->title }}</div>
                                                        <div class="text-xs text-gray-500 truncate max-w-[180px] hidden sm:block">
                                                            {{ Str::limit($report->description, 50) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-sm hidden lg:table-cell">
                                                <span class="bg-gray-50 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                                    {{ $reportTypes[$report->report_type] ?? $report->report_type }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center hidden md:table-cell">
                                                <div class="flex items-center justify-center gap-2">
                                                    @if($report->admin)
                                                    <div class="w-6 h-6 bg-purple-50 rounded-full flex items-center justify-center">
                                                        <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm text-gray-700">{{ $report->admin->user->name ?? 'غير معين' }}</span>
                                                    @else
                                                    <span class="text-xs text-gray-400">غير معين</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                @php
                                                    $priorityColors = [
                                                        'urgent' => 'bg-red-100 text-red-800',
                                                        'high' => 'bg-orange-100 text-orange-800',
                                                        'medium' => 'bg-blue-100 text-blue-800',
                                                        'low' => 'bg-gray-100 text-gray-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $priorityColors[$report->priority] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $priorities[$report->priority] ?? $report->priority }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm text-center hidden sm:table-cell">
                                                {{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                @if($report->is_read)
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                                        مقروء
                                                    </span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                                        غير مقروء
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <!-- زر العرض -->
                                                    <a href="{{route('teacher_admin_reports.show',$report->id)}}" 
                                                       class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                        عرض
                                                    </a>

                                                    <!-- زر الحذف -->
                                                    
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
    const reportTypeFilter = document.getElementById('report_type_filter');
    const priorityFilter = document.getElementById('priority_filter');
    const readStatusFilter = document.getElementById('read_status_filter');

    if (reportTypeFilter) {
        reportTypeFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }

    if (priorityFilter) {
        priorityFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }

    if (readStatusFilter) {
        readStatusFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }

    // Debounce search input
    let searchTimeout;
    const searchInput = document.getElementById('search');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
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