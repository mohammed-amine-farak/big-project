@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">📨 ردود الإدارة على تقاريرك</h1>
                    <p class="text-gray-600 text-sm">جميع ردود الإدارة على التقارير النفسية التي أرسلتها</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{route('StudentPsychology.index')}}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        تقاريري
                    </a>
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
                <h3 class="text-sm font-semibold text-gray-700">تصفية الردود</h3>
            </div>

            <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Status Filter -->
                <div>
                    <label for="status_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        حالة الرد
                    </label>
                    <select name="status" id="status_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الحالات</option>
                        <option value="مقبول" {{ request('status') == 'مقبول' ? 'selected' : '' }}>مقبول</option>
                        <option value="مرفوض" {{ request('status') == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
                        <option value="تحت_المراجعة" {{ request('status') == 'تحت_المراجعة' ? 'selected' : '' }}>تحت المراجعة</option>
                        <option value="مكتمل" {{ request('status') == 'مكتمل' ? 'selected' : '' }}>مكتمل</option>
                        <option value="بحاجة_لمزيد_من_المعلومات" {{ request('status') == 'بحاجة_لمزيد_من_المعلومات' ? 'selected' : '' }}>بحاجة لمعلومات</option>
                        <option value="تم_المعالجة" {{ request('status') == 'تم_المعالجة' ? 'selected' : '' }}>تم المعالجة</option>
                    </select>
                </div>

                <!-- Priority Filter -->
                <div>
                    <label for="priority_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الأولوية
                    </label>
                    <select name="priority" id="priority_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الأولويات</option>
                        <option value="منخفض" {{ request('priority') == 'منخفض' ? 'selected' : '' }}>منخفض</option>
                        <option value="متوسط" {{ request('priority') == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                        <option value="مرتفع" {{ request('priority') == 'مرتفع' ? 'selected' : '' }}>مرتفع</option>
                        <option value="عاجل" {{ request('priority') == 'عاجل' ? 'selected' : '' }}>عاجل</option>
                    </select>
                </div>

                <!-- Response Type Filter -->
                <div>
                    <label for="type_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        نوع الرد
                    </label>
                    <select name="response_type" id="type_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الأنواع</option>
                        <option value="ملاحظات_عامة" {{ request('response_type') == 'ملاحظات_عامة' ? 'selected' : '' }}>ملاحظات عامة</option>
                        <option value="توصيات_علاجية" {{ request('response_type') == 'توصيات_علاجية' ? 'selected' : '' }}>توصيات علاجية</option>
                        <option value="تحويل_لمختص" {{ request('response_type') == 'تحويل_لمختص' ? 'selected' : '' }}>تحويل لمختص</option>
                        <option value="متابعة_داخلية" {{ request('response_type') == 'متابعة_داخلية' ? 'selected' : '' }}>متابعة داخلية</option>
                        <option value="إشعار_لأولياء_الأمور" {{ request('response_type') == 'إشعار_لأولياء_الأمور' ? 'selected' : '' }}>إشعار لأولياء الأمور</option>
                        <option value="غير_ذلك" {{ request('response_type') == 'غير_ذلك' ? 'selected' : '' }}>غير ذلك</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق
                    </button>
                    
                    @if(request()->anyFilled(['status', 'priority', 'response_type']))
                    <a href=""
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 whitespace-nowrap">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['status', 'priority', 'response_type']))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-1">
                    @if(request('status'))
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الحالة: {{ request('status') }}
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-blue-500 hover:text-blue-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('priority'))
                    <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الأولوية: {{ request('priority') }}
                        <a href="{{ request()->fullUrlWithQuery(['priority' => null]) }}" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('response_type'))
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        النوع: {{ request('response_type') }}
                        <a href="{{ request()->fullUrlWithQuery(['response_type' => null]) }}" class="text-purple-500 hover:text-purple-700">
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
                        <p class="text-xs font-medium text-gray-600 truncate">إجمالي الردود</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $responses->total() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">مقبولة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $responses->where('status', 'مقبول')->count() }}
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
                        <p class="text-xs font-medium text-gray-600 truncate">تحتاج متابعة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $responses->where('requires_follow_up', true)->count() }}
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
                        <p class="text-xs font-medium text-gray-600 truncate">عاجلة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $responses->where('is_urgent', true)->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-3 sm:px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if($responses->total() > 0)
                            عرض 
                            <span class="font-medium text-gray-900">{{ $responses->firstItem() }} - {{ $responses->lastItem() }}</span>
                            من أصل 
                            <span class="font-medium text-gray-900">{{ $responses->total() }}</span> 
                            رد
                            @if(request()->anyFilled(['status', 'priority', 'response_type']))
                                <span class="text-xs text-gray-500">(نتائج البحث)</span>
                            @endif
                        @else
                            لا توجد ردود
                        @endif
                    </div>
                </div>
            </div>

            @if($responses->total() === 0)
                <!-- Empty State -->
                <div class="bg-white p-6 sm:p-8 text-center border-b border-gray-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">لا توجد ردود بعد</h3>
                            <p class="text-gray-500 text-sm">لم تتلق أي ردود من الإدارة على تقاريرك بعد</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                عرض تقاريري
                            </a>
                            <a href="" 
                               class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                إنشاء تقرير جديد
                            </a>
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الطالب</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">نص الرد</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">الأولوية</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">التاريخ</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($responses as $response)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <!-- Student Column -->
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <div class="w-8 h-8 bg-purple-50 rounded flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="font-medium text-gray-900 text-sm truncate max-w-[120px]">
                                                            {{ $response->student_psychologies->student->user->name ?? 'غير معروف' }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 truncate max-w-[120px]">
                                                            {{ $response->student_psychologies->classroom->class_name ?? '' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <!-- Response Text Column -->
                                            <td class="px-3 py-3">
                                                <p class="text-gray-700 text-sm line-clamp-2 max-w-[200px]">
                                                    {{ Str::limit($response->response_text, 100) }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <span class="font-medium">النوع:</span> 
                                                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs">
                                                        {{ $response->response_type }}
                                                    </span>
                                                </p>
                                            </td>
                                            
                                            <!-- Status Column -->
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <div class="flex flex-col gap-1">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ 
                                                        $response->status == 'مقبول' ? 'bg-green-100 text-green-800' :
                                                        ($response->status == 'مرفوض' ? 'bg-red-100 text-red-800' :
                                                        ($response->status == 'تحت_المراجعة' ? 'bg-yellow-100 text-yellow-800' :
                                                        ($response->status == 'مكتمل' ? 'bg-blue-100 text-blue-800' :
                                                        'bg-gray-100 text-gray-800')))
                                                    }}">
                                                        {{ $response->status }}
                                                    </span>
                                                    
                                                    @if($response->requires_follow_up)
                                                    <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        متابعة
                                                    </span>
                                                    @endif
                                                    
                                                    @if($response->parent_notified)
                                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2 py-1 rounded text-xs">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                        </svg>
                                                        تم إشعار ولي الأمر
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <!-- Priority Column (hidden on mobile) -->
                                            <td class="px-3 py-3 whitespace-nowrap text-sm hidden md:table-cell">
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium {{ 
                                                    $response->priority == 'عاجل' ? 'bg-red-100 text-red-800' :
                                                    ($response->priority == 'مرتفع' ? 'bg-orange-100 text-orange-800' :
                                                    ($response->priority == 'متوسط' ? 'bg-blue-100 text-blue-800' :
                                                    'bg-gray-100 text-gray-800'))
                                                }}">
                                                    @if($response->priority == 'عاجل')
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                    </svg>
                                                    @endif
                                                    {{ $response->priority }}
                                                </span>
                                            </td>
                                            
                                            <!-- Date Column (hidden on mobile) -->
                                            <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm text-center hidden sm:table-cell">
                                                <div class="flex flex-col">
                                                    <span>{{ $response->created_at->format('Y-m-d')}}</span>
                                                    <span class="text-xs text-gray-400">{{ $response->created_at->format('H:i') }}</span>
                                                </div>
                                            </td>
                                            
                                            <!-- Actions Column -->
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <!-- View Button -->
                                                    <a href="{{route('student_psychology_response_show',$response->id)}}" 
                                                       class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                        عرض التفاصيل
                                                    </a>
                                                    
                                                    <!-- View Report Button -->
                                                    <a href="{{route('StudentPsychology.show', $response->student_psychologies->id)}}" 
                                                       class="bg-gray-50 text-gray-600 hover:bg-gray-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                        عرض التقرير
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
                @if($responses->hasPages())
                <div class="px-3 sm:px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-sm text-gray-700 text-center sm:text-right">
                            عرض 
                            <span class="font-medium">{{ $responses->firstItem() }}</span>
                            إلى 
                            <span class="font-medium">{{ $responses->lastItem() }}</span>
                            من 
                            <span class="font-medium">{{ $responses->total() }}</span>
                            نتيجة
                        </div>
                        
                        <div class="flex items-center space-x-1 space-x-reverse flex-wrap justify-center">
                            <!-- Previous Page Link -->
                            @if ($responses->onFirstPage())
                                <span class="px-2 py-1 text-gray-400 bg-white border border-gray-300 rounded text-sm cursor-not-allowed">
                                    السابق
                                </span>
                            @else
                                <a href="{{ $responses->previousPageUrl() }}" 
                                   class="px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded text-sm hover:bg-gray-50 transition duration-200">
                                    السابق
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($responses->links()->elements as $element)
                                <!-- "Three Dots" Separator -->
                                @if (is_string($element))
                                    <span class="px-2 py-1 text-gray-500">{{ $element }}</span>
                                @endif

                                <!-- Array Of Links -->
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $responses->currentPage())
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
                            @if ($responses->hasMorePages())
                                <a href="{{ $responses->nextPageUrl() }}" 
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

<!-- Add line-clamp utility -->
<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
    }
    
    @media (max-width: 640px) {
        .max-w-\[120px\] {
            max-width: 120px;
        }
        .max-w-\[200px\] {
            max-width: 200px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when select filters change
    const statusFilter = document.getElementById('status_filter');
    const priorityFilter = document.getElementById('priority_filter');
    const typeFilter = document.getElementById('type_filter');

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
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

    if (typeFilter) {
        typeFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }
});
</script>
@endsection