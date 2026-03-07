@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📋 طلبات إنتاج الفيديوهات</h1>
                    <p class="text-gray-600 text-sm">طلبات إنتاج الفيديوهات التعليمية التي أرسلتها لمنشئي الفيديو</p>
                </div>
                <a href="{{route('researcher.production_requests.create')}}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    طلب إنتاج جديد
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
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM11 9v6H9V9h2zm0-4v2H9V5h2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">جميع الطلبات</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $totalRequests }}</p>
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
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $pendingCount }}</p>
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
                        <p class="text-xs font-medium text-gray-600 truncate">قيد التنفيذ</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $acceptedCount }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">بانتظار المراجعة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $submittedCount }}</p>
                    </div>
                    <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">مكتملة + مرفوضة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $approvedCount + $rejectedCount }}</p>
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
                <!-- Video Creator Filter -->
                <div class="md:col-span-1">
                    <label for="video_creator_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        منشئ الفيديو
                    </label>
                    <select name="video_creator_id" id="video_creator_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع المنشئين</option>
                        @foreach($videoCreators as $creator)
                            <option value="{{ $creator->id }}" {{ request('video_creator_id') == $creator->id ? 'selected' : '' }}>
                                {{ $creator->name }}
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>قيد التنفيذ</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>بانتظار المراجعة</option>
                        <option value="revision_required" {{ request('status') == 'revision_required' ? 'selected' : '' }}>يحتاج تعديل</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مكتمل</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div class="md:col-span-1">
                    <label for="date_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        تاريخ الطلب
                    </label>
                    <input type="date" name="created_date" id="date_filter" value="{{ request('created_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-4 flex items-center gap-2 mt-2">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق
                    </button>
                    
                    @if(request()->anyFilled(['video_creator_id', 'lesson_id', 'status', 'created_date']))
                    <a href=""
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['video_creator_id', 'lesson_id', 'status', 'created_date']))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-1">
                    @if(request('video_creator_id'))
                    @php
                        $selectedCreator = $videoCreators->firstWhere('id', request('video_creator_id'));
                    @endphp
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        المنشئ: {{ $selectedCreator->name ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['video_creator_id' => null]) }}" class="text-blue-500 hover:text-blue-700">
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
                    <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الدرس: {{ $selectedLesson->title ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['lesson_id' => null]) }}" class="text-green-500 hover:text-green-700">
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
                            'accepted' => 'قيد التنفيذ',
                            'submitted' => 'بانتظار المراجعة',
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

                    @if(request('created_date'))
                    <span class="bg-yellow-50 text-yellow-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        التاريخ: {{ request('created_date') }}
                        <a href="{{ request()->fullUrlWithQuery(['created_date' => null]) }}" class="text-yellow-500 hover:text-yellow-700">
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

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-3 sm:px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if($production_requests->count() > 0)
                            عرض 
                            <span class="font-medium text-gray-900">{{ $production_requests->firstItem() }}-{{ $production_requests->lastItem() }}</span> 
                            من 
                            <span class="font-medium text-gray-900">{{ $production_requests->total() }}</span> 
                            طلب
                        @else
                            لا توجد طلبات
                        @endif
                    </div>
                </div>
            </div>

            @if($production_requests->isEmpty())
                <div class="bg-white p-12 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">لا توجد طلبات إنتاج</h3>
                        <p class="text-gray-500 text-sm">لم تقم بإنشاء أي طلب إنتاج بعد</p>
                        <a href="" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إنشاء طلب جديد
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">#</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">عنوان الطلب</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">منشئ الفيديو</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">الدرس</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">القاعدة</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">تاريخ التسليم</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">الحالة</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">الفيديو</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($production_requests as $index => $request)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $production_requests->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900">{{ $request->title }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($request->description, 50) }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($request->video_creator_id)
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm text-gray-900">{{ $request->videoCreator->user->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">غير محدد</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm text-gray-900">{{ $request->lesson->title ?? 'غير محدد' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm text-gray-600">{{ $request->rule->title ?? '—' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm">
                                        {{ $request->deadline ? $request->deadline->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
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
                                                'accepted' => 'قيد التنفيذ',
                                                'submitted' => 'بانتظار المراجعة',
                                                'revision_required' => 'يحتاج تعديل',
                                                'approved' => 'مكتمل',
                                                'rejected' => 'مرفوض'
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$request->status] }}">
                                            {{ $statusTexts[$request->status] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
    @if($request->videos && $request->videos->count() > 0)
        @php $latestVideo = $request->videos->last(); @endphp
        <div class="flex flex-col items-center gap-1">
            <!-- أيقونة الفيديو مع العدد -->
           

            <!-- أزرار التحكم -->
            <div class="flex items-center gap-1 mt-1">
                <button type="button" 
                        onclick="playVideo('{{ asset('storage/' . $latestVideo->file_path) }}', '{{ $latestVideo->title }}')"
                        class="text-blue-600 hover:text-blue-800 p-1 rounded-full hover:bg-blue-50 transition-colors"
                        title="مشاهدة الفيديو">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>

                <a href="{{ asset('storage/' . $latestVideo->file_path) }}" 
                   download
                   class="text-green-600 hover:text-green-800 p-1 rounded-full hover:bg-green-50 transition-colors"
                   title="تحميل الفيديو">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>

                
            </div>

           
            
        </div>
    @else
        <span class="text-gray-400 text-xs">—</span>
    @endif
</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{route('researcher.production_requests.show',$request->id)}}" 
                                               class="text-blue-600 hover:text-blue-900 p-1" title="عرض التفاصيل">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            
                                            
                                            
                                            @if($request->status == 'pending')
                                                <a href="{{route('researcher.production_requests.edit',$request->id)}}" 
                                                   class="text-green-600 hover:text-green-900 p-1" title="تعديل">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $production_requests->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Video Player Modal -->

<div id="videoModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden shadow-2xl border border-gray-700/50 transform transition-all duration-300 scale-95 modal-enter">
        <!-- Modal Header -->
        <div class="relative px-6 py-4 flex items-center justify-between border-b border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 id="videoModalTitle" class="text-lg font-semibold text-white truncate max-w-md">عنوان الفيديو</h3>
                    <p class="text-xs text-gray-400">مشغل وسائط متطور</p>
                </div>
            </div>
            <button onclick="closeVideoModal()" class="text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 p-2 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 transform group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Video Player Area -->
        <div class="p-4 bg-gradient-to-br from-gray-950 to-gray-900">
            <div class="relative rounded-xl overflow-hidden shadow-2xl border border-gray-700/50">
                <video id="videoPlayer" controls class="w-full max-h-[65vh] mx-auto" controlsList="nodownload">
                    <source id="videoSource" src="" type="video/mp4">
                    متصفحك لا يدعم تشغيل الفيديو
                </video>
                
                <!-- Video Overlay (optional) -->
                <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-gradient-to-br from-gray-800 to-gray-900 border-t border-gray-700">
            <div class="flex items-center justify-between">
                <!-- Video Info -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span id="videoQuality" class="text-sm">HD 1080p</span>
                    </div>
                    <div class="w-1 h-1 bg-gray-600 rounded-full"></div>
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span id="videoDuration" class="text-sm">00:00</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <a id="downloadVideoBtn" href="#" download 
                       class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2 shadow-lg shadow-green-600/20 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        تحميل
                    </a>
                    
                    <button onclick="closeVideoModal()" 
                            class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2 shadow-lg transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS for animations -->
<style>
    #videoModal.modal-enter {
        animation: modalEnter 0.3s ease-out forwards;
    }
    
    @keyframes modalEnter {
        0% {
            opacity: 0;
            transform: scale(0.95);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* Custom video player styling */
    video::-webkit-media-controls-panel {
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    }
    
    video::-webkit-media-controls-play-button {
        background-color: rgba(255,255,255,0.2);
        border-radius: 50%;
        transition: all 0.2s;
    }
    
    video::-webkit-media-controls-play-button:hover {
        background-color: rgba(255,255,255,0.3);
        transform: scale(1.1);
    }
    
    video::-webkit-media-controls-timeline {
        border-radius: 10px;
        height: 6px;
    }
</style>

<!-- Enhanced JavaScript -->
<script>
function playVideo(videoUrl, videoTitle) {
    const modal = document.getElementById('videoModal');
    const modalContent = modal.querySelector('.bg-gradient-to-br');
    const videoPlayer = document.getElementById('videoPlayer');
    const videoSource = document.getElementById('videoSource');
    const modalTitle = document.getElementById('videoModalTitle');
    const downloadBtn = document.getElementById('downloadVideoBtn');
    
    // تحديث مصدر الفيديو
    videoSource.src = videoUrl;
    videoPlayer.load();
    
    // تحديث العنوان وزر التحميل
    modalTitle.textContent = videoTitle || 'مشاهدة الفيديو';
    downloadBtn.href = videoUrl;
    
    // استخراج معلومات الفيديو (اختياري)
    videoPlayer.onloadedmetadata = function() {
        const minutes = Math.floor(videoPlayer.duration / 60);
        const seconds = Math.floor(videoPlayer.duration % 60);
        document.getElementById('videoDuration').textContent = 
            minutes + ':' + (seconds < 10 ? '0' + seconds : seconds);
        
        // تقدير الجودة (اختياري)
        const videoWidth = videoPlayer.videoWidth;
        if (videoWidth >= 1920) {
            document.getElementById('videoQuality').textContent = 'Full HD 1080p';
        } else if (videoWidth >= 1280) {
            document.getElementById('videoQuality').textContent = 'HD 720p';
        } else {
            document.getElementById('videoQuality').textContent = 'SD 480p';
        }
    };
    
    // عرض المودال مع تأثير
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modalContent.classList.add('modal-enter');
    
    // منع التمرير في الخلفية
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const modalContent = modal.querySelector('.bg-gradient-to-br');
    const videoPlayer = document.getElementById('videoPlayer');
    
    // تأثير الإخفاء
    modalContent.classList.remove('modal-enter');
    modal.classList.add('opacity-0');
    
    setTimeout(() => {
        // إخفاء المودال
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'opacity-0');
        
        // إيقاف الفيديو
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
        
        // إعادة التمرير
        document.body.style.overflow = 'auto';
    }, 200);
}

// إغلاق المودال بالضغط على ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal();
    }
});

// إغلاق المودال بالنقر على الخلفية
document.getElementById('videoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeVideoModal();
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const creatorFilter = document.getElementById('video_creator_filter');
    const lessonFilter = document.getElementById('lesson_filter');
    const statusFilter = document.getElementById('status_filter');
    const dateFilter = document.getElementById('date_filter');

    // Auto-submit on filter change
    if (creatorFilter) {
        creatorFilter.addEventListener('change', function() { this.form.submit(); });
    }
    if (lessonFilter) {
        lessonFilter.addEventListener('change', function() { this.form.submit(); });
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', function() { this.form.submit(); });
    }
    if (dateFilter) {
        dateFilter.addEventListener('change', function() { this.form.submit(); });
    }
});
</script>
@endsection