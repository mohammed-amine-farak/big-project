@extends('layouts.reseacher_dashboard')

@section('content')
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
                           
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                     
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
                        <p class="text-lg font-bold text-gray-900 truncate">34</p>
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
                        <p class="text-lg font-bold text-yellow-600 truncate">12</p>
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
                        <p class="text-lg font-bold text-orange-600 truncate">8</p>
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
                        <p class="text-lg font-bold text-blue-600 truncate">14</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية التقارير</h3>
            </div>

            <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Title Filter -->
                <div class="md:col-span-1">
                    <label for="title_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        البحث بالعنوان
                    </label>
                    <input type="text" name="title" id="title_filter" placeholder="اكتب للبحث..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ request('title') }}">
                </div>

                <!-- Admin Filter -->
                <div class="md:col-span-1">
                    <label for="admin_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        المرسل (المسؤول)
                    </label>
                    <select name="admin_id" id="admin_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع المسؤولين</option>
                        <option value="1" {{ request('admin_id') == '1' ? 'selected' : '' }}>أ. محمد أحمد - مدير أكاديمي</option>
                        <option value="2" {{ request('admin_id') == '2' ? 'selected' : '' }}>أ. سارة خالد - مديرة تقنية</option>
                        <option value="3" {{ request('admin_id') == '3' ? 'selected' : '' }}>أ. علي حسين - مدير مالي</option>
                    </select>
                </div>

                <!-- Report Type Filter -->
                <div class="md:col-span-1">
                    <label for="type_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        نوع التقرير
                    </label>
                    <select name="report_type" id="type_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الأنواع</option>
                        <option value="financial" {{ request('report_type') == 'financial' ? 'selected' : '' }}>مالي</option>
                        <option value="administrative" {{ request('report_type') == 'administrative' ? 'selected' : '' }}>إداري</option>
                        <option value="technical" {{ request('report_type') == 'technical' ? 'selected' : '' }}>تقني</option>
                        <option value="human_resources" {{ request('report_type') == 'human_resources' ? 'selected' : '' }}>موارد بشرية</option>
                        <option value="infrastructure" {{ request('report_type') == 'infrastructure' ? 'selected' : '' }}>بنية تحتية</option>
                        <option value="academic" {{ request('report_type') == 'academic' ? 'selected' : '' }}>أكاديمي</option>
                        <option value="research" {{ request('report_type') == 'research' ? 'selected' : '' }}>بحثي</option>
                        <option value="security" {{ request('report_type') == 'security' ? 'selected' : '' }}>أمني</option>
                        <option value="other" {{ request('report_type') == 'other' ? 'selected' : '' }}>أخرى</option>
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
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
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
                    
                    @if(request()->anyFilled(['title', 'admin_id', 'report_type', 'status', 'priority']))
                    <a href=""
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-3 sm:px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        عرض 
                        <span class="font-medium text-gray-900">1 - 8</span>
                        من أصل 
                        <span class="font-medium text-gray-900">34</span> 
                        تقرير
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
                                <!-- Sample Report 1 - Pending -->
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
                                                <p class="text-sm font-medium text-gray-900 truncate max-w-[150px]">تحليل نتائج الطلاب في مادة الرياضيات</p>
                                                <p class="text-xs text-gray-500">طلب بحث وتحليل إحصائي</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Admin Sender -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2 justify-end">
                                            <div class="text-right">
                                                <p class="text-sm text-gray-900 truncate max-w-[120px]">أ. محمد أحمد</p>
                                                <p class="text-xs text-gray-500 truncate max-w-[120px]">مدير أكاديمي</p>
                                            </div>
                                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                م
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Report Type -->
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">
                                            بحثي
                                        </span>
                                    </td>

                                    <!-- Deadline -->
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">
                                        <span class="text-xs text-red-600 font-medium">2024-02-15</span>
                                    </td>

                                    <!-- Sent Date -->
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                        <span class="text-xs text-gray-600">2024-01-20</span>
                                    </td>

                                    <!-- Priority -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            عالية
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            قيد الانتظار
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="#" 
                                               class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                عرض
                                            </a>
                                            <a href="#" 
                                               class="bg-green-50 text-green-600 hover:bg-green-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                بدء البحث
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Sample Report 2 - In Progress -->
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="w-8 h-8 bg-orange-50 rounded flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate max-w-[150px]">دراسة تأثير المنصة التعليمية على التحصيل الدراسي</p>
                                                <p class="text-xs text-gray-500">طلب دراسة تقييمية</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2 justify-end">
                                            <div class="text-right">
                                                <p class="text-sm text-gray-900 truncate max-w-[120px]">أ. سارة خالد</p>
                                                <p class="text-xs text-gray-500 truncate max-w-[120px]">مديرة تقنية</p>
                                            </div>
                                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                س
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                            تقني
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">
                                        <span class="text-xs text-gray-600">2024-03-01</span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                        <span class="text-xs text-gray-600">2024-01-18</span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            متوسطة
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            قيد المعالجة
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="#" 
                                               class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                عرض
                                            </a>
                                            <a href="#" 
                                               class="bg-green-50 text-green-600 hover:bg-green-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                متابعة
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Sample Report 3 - Under Review -->
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="w-8 h-8 bg-yellow-50 rounded flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate max-w-[150px]">تحليل احتياجات التدريب للمعلمين</p>
                                                <p class="text-xs text-gray-500">طلب دراسة احتياجات</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2 justify-end">
                                            <div class="text-right">
                                                <p class="text-sm text-gray-900 truncate max-w-[120px]">أ. علي حسين</p>
                                                <p class="text-xs text-gray-500 truncate max-w-[120px]">مدير مالي</p>
                                            </div>
                                            <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                ع
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                            موارد بشرية
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">
                                        <span class="text-xs text-gray-600">2024-02-20</span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                        <span class="text-xs text-gray-600">2024-01-15</span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            منخفضة
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            قيد المراجعة
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="#" 
                                               class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                عرض
                                            </a>
                                            <a href="#" 
                                               class="bg-purple-50 text-purple-600 hover:bg-purple-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                إكمال
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-3 sm:px-4 py-3 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-sm text-gray-700 text-center sm:text-right">
                        عرض 
                        <span class="font-medium">1</span>
                        إلى 
                        <span class="font-medium">8</span>
                        من 
                        <span class="font-medium">34</span>
                        نتيجة
                    </div>
                    
                    <div class="flex items-center space-x-1 space-x-reverse flex-wrap justify-center">
                        <nav class="flex items-center gap-1">
                            <a href="#" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">1</a>
                            <a href="#" class="px-3 py-1 bg-white text-gray-700 rounded text-sm hover:bg-gray-50">2</a>
                            <a href="#" class="px-3 py-1 bg-white text-gray-700 rounded text-sm hover:bg-gray-50">3</a>
                            <a href="#" class="px-3 py-1 bg-white text-gray-700 rounded text-sm hover:bg-gray-50">4</a>
                            <a href="#" class="px-3 py-1 bg-white text-gray-700 rounded text-sm hover:bg-gray-50">5</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (min-width: 475px) {
        .xs\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleFilter = document.getElementById('title_filter');
    const adminFilter = document.getElementById('admin_filter');
    const typeFilter = document.getElementById('type_filter');
    const statusFilter = document.getElementById('status_filter');
    const priorityFilter = document.getElementById('priority_filter');

    // Auto-submit form when select filters change
    [adminFilter, typeFilter, statusFilter, priorityFilter].forEach(filter => {
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