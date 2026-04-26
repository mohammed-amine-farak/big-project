{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">👥 إدارة المستخدمين</h1>
                    <p class="text-gray-600 text-sm">إدارة حسابات المستخدمين والتحقق من طلبات التسجيل</p>
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

        @if (session('warning'))
            <div class="bg-yellow-100 border-r-4 border-yellow-500 text-yellow-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1">
                        <svg class="fill-current h-5 w-5 text-yellow-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ session('warning') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">إجمالي المستخدمين</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">⏳ قيد المراجعة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['pending'] }}</p>
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
                        <p class="text-xs font-medium text-gray-600 truncate">✅ مقبول</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['approved'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">❌ مرفوض</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['rejected'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row Stats -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">👨‍🏫 معلمين</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['teachers'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">🎓 طلاب</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['students'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">🔬 باحثين</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['researchers'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">🎥 منشئي فيديو</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $stats['video_creators'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-pink-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
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
                <h3 class="text-sm font-semibold text-gray-700">تصفية المستخدمين</h3>
            </div>

            <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-1">
                    <label class="block text-xs font-medium text-gray-600 mb-1">بحث</label>
                    <input type="text" name="search" placeholder="اسم أو بريد إلكتروني..." 
                           value="{{ request('search') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="md:col-span-1">
                    <label class="block text-xs font-medium text-gray-600 mb-1">نوع المستخدم</label>
                    <select name="user_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">الكل</option>
                        <option value="teacher" {{ request('user_type') == 'teacher' ? 'selected' : '' }}>معلم</option>
                        <option value="student" {{ request('user_type') == 'student' ? 'selected' : '' }}>طالب</option>
                        <option value="researcher" {{ request('user_type') == 'researcher' ? 'selected' : '' }}>باحث</option>
                        <option value="video_creator" {{ request('user_type') == 'video_creator' ? 'selected' : '' }}>منشئ فيديو</option>
                        <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>مدير</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-xs font-medium text-gray-600 mb-1">حالة الحساب</label>
                    <select name="account_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">الكل</option>
                        <option value="pending" {{ request('account_status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                        <option value="approved" {{ request('account_status') == 'approved' ? 'selected' : '' }}>مقبول</option>
                        <option value="rejected" {{ request('account_status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                    </select>
                </div>

                <div class="md:col-span-1 flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق
                    </button>
                    
                    @if(request()->anyFilled(['search', 'user_type', 'account_status']))
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 whitespace-nowrap">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="mb-4">
            <button onclick="bulkApprove()" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                قبول المحددين
            </button>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-3 sm:px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if($users->count() > 0)
                            عرض 
                            <span class="font-medium text-gray-900">{{ $users->firstItem() ?? 0 }}</span> 
                            إلى 
                            <span class="font-medium text-gray-900">{{ $users->lastItem() ?? 0 }}</span>
                            من 
                            <span class="font-medium text-gray-900">{{ $users->total() }}</span>
                            مستخدم
                        @else
                            لا توجد مستخدمين
                        @endif
                    </div>
                </div>
            </div>

            @if($users->isEmpty())
                <div class="bg-white p-6 sm:p-8 text-center border-b border-gray-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">لا توجد نتائج</h3>
                            <p class="text-gray-500 text-sm">لم يتم العثور على مستخدمين مطابقين للبحث</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            <input type="checkbox" id="selectAll" class="checkbox rounded border-gray-300">
                                        </th>
                                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">#</th>
                                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الاسم</th>
                                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">البريد الإلكتروني</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">نوع الحساب</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">تاريخ التسجيل</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $index => $user)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-3 py-3 whitespace-nowrap text-center">
                                            <input type="checkbox" class="user-checkbox checkbox rounded border-gray-300" value="{{ $user->id }}">
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm">
                                            {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                @if($user->account_status == 'rejected' && $user->rejection_reason)
                                                    <div class="text-xs text-red-600 mt-1 max-w-[200px] truncate">
                                                        سبب الرفض: {{ Str::limit($user->rejection_reason, 30) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-gray-600 text-sm">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-center">
                                            @php
                                                $badgeClass = '';
                                                $icon = '';
                                                $typeText = '';
                                                if($user->user_type == 'teacher') {
                                                    $badgeClass = 'bg-indigo-100 text-indigo-700';
                                                    $icon = '👨‍🏫';
                                                    $typeText = 'معلم';
                                                } elseif($user->user_type == 'student') {
                                                    $badgeClass = 'bg-purple-100 text-purple-700';
                                                    $icon = '🎓';
                                                    $typeText = 'طالب';
                                                } elseif($user->user_type == 'researcher') {
                                                    $badgeClass = 'bg-teal-100 text-teal-700';
                                                    $icon = '🔬';
                                                    $typeText = 'باحث';
                                                } elseif($user->user_type == 'video_creator') {
                                                    $badgeClass = 'bg-pink-100 text-pink-700';
                                                    $icon = '🎥';
                                                    $typeText = 'منشئ فيديو';
                                                } else {
                                                    $badgeClass = 'bg-gray-100 text-gray-700';
                                                    $icon = '👑';
                                                    $typeText = 'مدير';
                                                }
                                            @endphp
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                                {{ $icon }} {{ $typeText }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm text-center hidden sm:table-cell">
                                            {{ $user->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-center">
                                            @if($user->account_status == 'approved')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    ✅ مقبول
                                                </span>
                                            @elseif($user->account_status == 'pending')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                                    ⏳ قيد المراجعة
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                    ❌ مرفوض
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                                   class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap"
                                                   title="عرض التفاصيل">
                                                    عرض
                                                </a>
                                                @if($user->account_status == 'pending')
                                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="bg-green-50 text-green-600 hover:bg-green-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap"
                                                            onclick="return confirm('هل تريد قبول هذا المستخدم؟')"
                                                            title="قبول">
                                                        قبول
                                                    </button>
                                                </form>
                                                <button onclick="showRejectModal({{ $user->id }})" 
                                                        class="bg-red-50 text-red-600 hover:bg-red-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap"
                                                        title="رفض">
                                                    رفض
                                                </button>
                                                @endif
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="bg-gray-50 text-gray-600 hover:bg-gray-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap"
                                                            onclick="return confirm('هل تريد حذف هذا المستخدم؟')"
                                                            title="حذف">
                                                        حذف
                                                    </button>
                                                </form>
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

        <div class="mt-6">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 16px; padding: 2rem; max-width: 500px; width: 90%; margin: 0 auto;">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 1rem;">رفض حساب المستخدم</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 8px;">سبب الرفض</label>
                <textarea name="rejection_reason" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" placeholder="اكتب سبب رفض الحساب..." required></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeRejectModal()" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 8px; background: #fff; cursor: pointer;">إلغاء</button>
                <button type="submit" style="padding: 8px 16px; border: none; border-radius: 8px; background: #DC2626; color: #fff; cursor: pointer;">رفض</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(cb => cb.checked = this.checked);
        });
    }
});

// Bulk approve function
function bulkApprove() {
    const checkboxes = document.querySelectorAll('.user-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        alert('الرجاء تحديد مستخدمين على الأقل');
        return;
    }
    
    if (confirm(`هل تريد قبول ${ids.length} مستخدم؟`)) {
        fetch('{{ route("admin.users.bulk-approve") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء محاولة قبول المستخدمين');
        });
    }
}

// Show reject modal
function showRejectModal(userId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/users/${userId}/reject`;
    modal.style.display = 'flex';
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'none';
}
</script>

<style>
    /* Custom breakpoint for extra small screens */
    @media (min-width: 475px) {
        .xs\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    
    .checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
</style>
@endsection