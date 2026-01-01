@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">🏫 لوحة تحكم المعلم</h1>
                    <p class="text-gray-600 text-sm">مرحباً بك في نظام إدارة الفصل الدراسي - نظرة شاملة على أداء طلابك</p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-gray-900">الأستاذ خالد أحمد</p>
                        <p class="text-xs text-gray-600">معلم الفصل والمشرف الأكاديمي</p>
                    </div>
                    <img 
                        src="https://placehold.co/48x48/8B5CF6/ffffff?text=خ" 
                        alt="صورة المعلم" 
                        class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover"
                    />
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">إجمالي الطلاب</p>
                        <p class="text-lg font-bold text-gray-900 truncate">8</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">الدروس المكتملة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">24</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">التقارير الأسبوعية</p>
                        <p class="text-lg font-bold text-gray-900 truncate">12</p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">متوسط التقدم</p>
                        <p class="text-lg font-bold text-gray-900 truncate">78%</p>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800">الإجراءات السريعة</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="" class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-4 transition duration-200 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-blue-700 text-sm">تقدم الطلاب</p>
                            <p class="text-xs text-blue-600">إدارة تقدم الدروس</p>
                        </div>
                    </div>
                </a>

                <a href="" class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 transition duration-200 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-green-700 text-sm">التقارير</p>
                            <p class="text-xs text-green-600">الاختبارات الأسبوعية</p>
                        </div>
                    </div>
                </a>

                <a href="" class="bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-4 transition duration-200 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-purple-700 text-sm">الدروس</p>
                            <p class="text-xs text-purple-600">إدارة المحتوى التعليمي</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg p-4 transition duration-200 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-amber-700 text-sm">الطلاب</p>
                            <p class="text-xs text-amber-600">معلومات الطلاب</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Students Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Section Header -->
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">طلاب الفصل</h3>
                        <p class="text-sm text-gray-600">فريق الفصل المكون من 8 طلاب</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">
                            8 طلاب
                        </span>
                    </div>
                </div>
            </div>

            <!-- Students Grid -->
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @php
                        $students = [
                            ['name' => 'علياء محمد', 'color' => 'bg-yellow-500', 'initials' => 'A.M'],
                            ['name' => 'فهد ناصر', 'color' => 'bg-orange-500', 'initials' => 'F.N'],
                            ['name' => 'سارة يوسف', 'color' => 'bg-blue-500', 'initials' => 'S.Y'],
                            ['name' => 'ماجد بدر', 'color' => 'bg-green-500', 'initials' => 'M.B'],
                            ['name' => 'نور خالد', 'color' => 'bg-purple-500', 'initials' => 'N.K'],
                            ['name' => 'ياسين علي', 'color' => 'bg-pink-500', 'initials' => 'Y.A'],
                            ['name' => 'ليلى حسن', 'color' => 'bg-rose-500', 'initials' => 'L.H'],
                            ['name' => 'عمران سعيد', 'color' => 'bg-indigo-500', 'initials' => 'O.S']
                        ];
                    @endphp

                    @foreach($students as $student)
                    <div class="bg-gray-50 hover:bg-white border border-gray-200 rounded-xl p-4 text-center group transition-all duration-300 ease-in-out hover:shadow-md hover:border-purple-300 cursor-pointer transform hover:-translate-y-1">
                        <div class="mb-3">
                            <div class="w-16 h-16 {{ $student['color'] }} rounded-full mx-auto flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                {{ $student['initials'] }}
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-800 truncate mb-2" title="{{ $student['name'] }}">
                            {{ $student['name'] }}
                        </p>
                        <a href="#" class="text-purple-600 hover:text-purple-800 text-xs font-medium inline-flex items-center gap-1 transition duration-200">
                            عرض الملف
                            <svg class="w-3 h-3 transform transition-transform duration-300 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-8">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800">أحدث النشاطات</h3>
            </div>
            
            <div class="space-y-3">
                @foreach([
                    ['action' => 'تم تحديث تقرير', 'student' => 'علياء محمد', 'time' => 'منذ 2 ساعة', 'color' => 'green'],
                    ['action' => 'تم إضافة درس جديد', 'student' => '-', 'time' => 'منذ 4 ساعات', 'color' => 'blue'],
                    ['action' => 'تم تسجيل تقدم', 'student' => 'فهد ناصر', 'time' => 'منذ 6 ساعات', 'color' => 'purple'],
                    ['action' => 'تم إرسال تقرير', 'student' => 'سارة يوسف', 'time' => 'منذ يوم', 'color' => 'amber']
                ] as $activity)
                <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition duration-200">
                    <div class="w-2 h-2 bg-{{ $activity['color'] }}-500 rounded-full flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800">
                            <span class="font-medium">{{ $activity['action'] }}</span>
                            @if($activity['student'] != '-')
                            <span class="text-gray-600">لـ</span>
                            <span class="font-medium text-gray-900">{{ $activity['student'] }}</span>
                            @endif
                        </p>
                    </div>
                    <span class="text-xs text-gray-500 whitespace-nowrap">{{ $activity['time'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
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
@endsection