@extends('layouts.video_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">🎬 طلبات الإنتاج</h1>
                    <p class="text-gray-600 text-sm">إدارة طلبات إنتاج الفيديوهات من الباحثين</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-medium">
                        طلبات جديدة: {{ $production_requests->where('status', 'pending')->count() }}
                    </span>
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

        @if (session('error'))
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1">
                        <svg class="fill-current h-5 w-5 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM11 9v6H9V9h2zm0-4v2H9V5h2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards based on status -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-6 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">جميع الطلبات</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $production_requests->count() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">في الانتظار</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $production_requests->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">تم القبول</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $production_requests->where('status', 'accepted')->count() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">تم التسليم</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $production_requests->where('status', 'submitted')->count() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">يحتاج تعديل</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $production_requests->where('status', 'revision_required')->count() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">مكتمل + مرفوض</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $production_requests->whereIn('status', ['approved', 'rejected'])->count() }}
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

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية الطلبات</h3>
            </div>

            <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Researcher Filter -->
                <div class="md:col-span-1">
                    <label for="researcher_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        اسم الباحث
                    </label>
                    <select name="researcher_id" id="researcher_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">جميع الباحثين</option>
                        @foreach($researchers as $researcher)
                            <option value="{{ $researcher->id }}" {{ request('researcher_id') == $researcher->id ? 'selected' : '' }}>
                                {{ $researcher->name }}
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">جميع الدروس</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="md:col-span-1">
                    <label for="status_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        حالة الطلب
                    </label>
                    <select name="status" id="status_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">جميع الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>تم القبول</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>تم التسليم</option>
                        <option value="revision_required" {{ request('status') == 'revision_required' ? 'selected' : '' }}>يحتاج تعديل</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مكتمل</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                    </select>
                </div>

                <!-- Deadline Filter -->
                <div class="md:col-span-1">
                    <label for="deadline_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        تاريخ التسليم
                    </label>
                    <input type="date" name="deadline" id="deadline_filter" value="{{ request('deadline') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-4 flex items-center gap-2 mt-2">
                    <button type="submit"
                            class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق
                    </button>
                    
                    @if(request()->anyFilled(['researcher_id', 'lesson_id', 'status', 'deadline']))
                    <a href=""
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['researcher_id', 'lesson_id', 'status', 'deadline']))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-1">
                    @if(request('researcher_id'))
                    @php
                        $selectedResearcher = $researchers->firstWhere('id', request('researcher_id'));
                    @endphp
                    <span class="bg-orange-50 text-orange-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الباحث: {{ $selectedResearcher->name ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['researcher_id' => null]) }}" class="text-orange-500 hover:text-orange-700">
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
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الدرس: {{ $selectedLesson->title ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['lesson_id' => null]) }}" class="text-blue-500 hover:text-blue-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('status'))
                    @php
                        $statusLabels = [
                            'pending' => 'في الانتظار',
                            'accepted' => 'تم القبول',
                            'submitted' => 'تم التسليم',
                            'revision_required' => 'يحتاج تعديل',
                            'approved' => 'مكتمل',
                            'rejected' => 'مرفوض'
                        ];
                    @endphp
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الحالة: {{ $statusLabels[request('status')] ?? request('status') }}
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-purple-500 hover:text-purple-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                    @endif

                    @if(request('deadline'))
                    <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        تاريخ التسليم: {{ request('deadline') }}
                        <a href="{{ request()->fullUrlWithQuery(['deadline' => null]) }}" class="text-green-500 hover:text-green-700">
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

        <!-- Responsive Table Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-3 sm:px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if($production_requests->count() > 0)
                            عرض 
                            <span class="font-medium text-gray-900">{{ $production_requests->count() }}</span> 
                            طلب
                            @if(request()->anyFilled(['researcher_id', 'lesson_id', 'status', 'deadline']))
                                <span class="text-xs text-gray-500">(نتائج البحث)</span>
                            @endif
                        @else
                            لا توجد طلبات
                        @endif
                    </div>
                    <div class="text-xs text-gray-500">
                        آخر تحديث: {{ now()->format('Y-m-d H:i') }}
                    </div>
                </div>
            </div>

            @if($production_requests->isEmpty())
                <!-- Compact Empty State -->
                <div class="bg-white p-6 sm:p-8 text-center border-b border-gray-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">لا توجد طلبات إنتاج</h3>
                            <p class="text-gray-500 text-sm">ستظهر هنا طلبات إنتاج الفيديوهات من الباحثين</p>
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الباحث</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">عنوان الطلب</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الدرس/القاعدة</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الملف المرجعي</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">تاريخ التسليم</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">التواريخ</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($production_requests as $request)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <div class="w-8 h-8 bg-purple-50 rounded flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                    <span class="font-medium text-gray-900 text-sm truncate max-w-[120px]">{{ $request->researcher->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3">
                                                <span class="font-medium text-gray-900 text-sm">{{ $request->title }}</span>
                                                @if($request->description)
                                                <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ Str::limit($request->description, 50) }}</p>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3">
                                                <span class="text-gray-700 text-sm">{{ $request->lesson->title ?? 'غير محدد' }}</span>
                                                @if($request->rule)
                                                <p class="text-xs text-gray-500">القاعدة: {{ $request->rule->title }}</p>
                                                @endif
                                                @if($request->content_block_id)
                                                <p class="text-xs text-gray-400">كتلة محتوى #{{ $request->content_block_id }}</p>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                @if($request->reference_file || $request->reference_file_path)
                                                    <a href="{{ asset($request->reference_file_path ?? 'storage/'.$request->reference_file) }}" 
                                                       target="_blank"
                                                       class="text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1"
                                                       title="تحميل الملف المرجعي">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span class="text-xs">ملف</span>
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm text-center">
                                                {{ $request->deadline ? \Carbon\Carbon::parse($request->deadline)->format('Y-m-d') : 'غير محدد' }}
                                                @if($request->deadline && $request->status == 'accepted')
                                                    @php
                                                        $daysLeft = \Carbon\Carbon::parse($request->deadline)->diffInDays(now(), false);
                                                    @endphp
                                                    @if($daysLeft < 0)
                                                        <span class="text-red-500 block text-xs">متأخر {{ abs($daysLeft) }} يوم</span>
                                                    @elseif($daysLeft <= 3)
                                                        <span class="text-orange-500 block text-xs">{{ $daysLeft }} أيام متبقية</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-gray-100 text-gray-800',
                                                        'accepted' => 'bg-blue-100 text-blue-800',
                                                        'submitted' => 'bg-yellow-100 text-yellow-800',
                                                        'revision_required' => 'bg-orange-100 text-orange-800',
                                                        'approved' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800'
                                                    ];
                                                    $statusTexts = [
                                                        'pending' => 'في الانتظار',
                                                        'accepted' => 'تم القبول',
                                                        'submitted' => 'تم التسليم',
                                                        'revision_required' => 'يحتاج تعديل',
                                                        'approved' => 'مكتمل',
                                                        'rejected' => 'مرفوض'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $statusTexts[$request->status] ?? $request->status }}
                                                </span>
                                                @if($request->revision_details && $request->status == 'revision_required')
                                                    <span class="block text-xs text-orange-600 mt-1 cursor-help" 
                                                          title="{{ $request->revision_details }}">
                                                        ⚠️ تعديل
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                <div class="flex flex-col items-center text-xs">
                                                    @if($request->accepted_at)
                                                    <span class="text-gray-500" title="تاريخ القبول">
                                                        ✅ {{ $request->accepted_at->format('m-d') }}
                                                    </span>
                                                    @endif
                                                    @if($request->submitted_at)
                                                    <span class="text-gray-500" title="تاريخ التسليم">
                                                        📤 {{ $request->submitted_at->format('m-d') }}
                                                    </span>
                                                    @endif
                                                    @if($request->approved_at)
                                                    <span class="text-gray-500" title="تاريخ الموافقة">
                                                        👍 {{ $request->approved_at->format('m-d') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    @if($request->status == 'pending')
                                                        <a href="" 
                                                           class="bg-green-50 text-green-600 hover:bg-green-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                            قبول
                                                        </a>
                                                        <a href="" 
                                                           class="bg-red-50 text-red-600 hover:bg-red-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap"
                                                           onclick="return confirm('هل أنت متأكد من رفض هذا الطلب؟')">
                                                            رفض
                                                        </a>
                                                    @endif

                                                    @if($request->status == 'accepted')
                                                        <a href="" 
                                                           class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                            رفع الفيديو
                                                        </a>
                                                    @endif

                                                    @if($request->status == 'revision_required')
                                                        <a href="" 
                                                           class="bg-orange-50 text-orange-600 hover:bg-orange-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                            تعديل
                                                        </a>
                                                    @endif

                                                    @if($request->status == 'submitted')
                                                        <span class="text-gray-400 text-xs px-2 py-1">بانتظار المراجعة</span>
                                                    @endif

                                                    @if(in_array($request->status, ['approved', 'rejected']))
                                                        <span class="text-gray-400 text-xs px-2 py-1">مكتمل</span>
                                                    @endif

                                                    <a href="" 
                                                       class="text-blue-600 hover:text-blue-900 p-1" title="عرض التفاصيل">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>

                                                    @if($request->notes)
                                                        <span class="text-gray-400 p-1 cursor-help" title="{{ $request->notes }}">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </span>
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
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const researcherFilter = document.getElementById('researcher_filter');
    const lessonFilter = document.getElementById('lesson_filter');
    const statusFilter = document.getElementById('status_filter');
    const deadlineFilter = document.getElementById('deadline_filter');

    // Auto-submit form when select filters change
    if (researcherFilter) {
        researcherFilter.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }

    if (lessonFilter) {
        lessonFilter.addEventListener('change', function() {
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

    if (deadlineFilter) {
        deadlineFilter.addEventListener('change', function() {
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