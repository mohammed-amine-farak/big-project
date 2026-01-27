@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📝 الاختبارات الأسبوعية</h1>
                    <p class="text-gray-600 text-sm">عرض الاختبارات حسب الصف الدراسي</p>
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">إجمالي الاختبارات</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $exams->total() }}</p>
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
                        <p class="text-xs font-medium text-gray-600 truncate">الاختبارات هذا الشهر</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $monthlyCount }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">الصفوف</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $classrooms->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Filter Section - Only Classroom -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية حسب الصف</h3>
            </div>

            <form action="{{ route('teacher.exams.list') }}" method="GET" class="flex items-center gap-3">
                <!-- Classroom Filter Only -->
                <div class="flex-1">
                    <select name="classroom" id="classroom_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الصفوف</option>
                        @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ request('classroom') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تصفية
                    </button>
                    
                    @if(request()->filled('classroom'))
                    <a href="{{ route('teacher.exams.list') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 whitespace-nowrap">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filter Display -->
            @if(request()->filled('classroom'))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
                </div>
                <div class="flex flex-wrap gap-1">
                    @php
                        $selectedClassroom = $classrooms->firstWhere('id', request('classroom'));
                    @endphp
                    <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الصف: {{ $selectedClassroom->class_name ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['classroom' => null]) }}" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
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
                        @if($exams->total() > 0)
                            عرض 
                            <span class="font-medium text-gray-900">{{ $exams->firstItem() }} - {{ $exams->lastItem() }}</span>
                            من أصل 
                            <span class="font-medium text-gray-900">{{ $exams->total() }}</span> 
                            اختبار
                            @if(request()->filled('classroom'))
                                <span class="text-xs text-gray-500">(نتائج البحث)</span>
                            @endif
                        @else
                            لا توجد اختبارات
                        @endif
                    </div>
                </div>
            </div>

            @if($exams->isEmpty())
                <!-- Compact Empty State -->
                <div class="bg-white p-6 sm:p-8 text-center border-b border-gray-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">لا توجد اختبارات حالياً</h3>
                            <p class="text-gray-500 text-sm">لا توجد اختبارات متاحة للصفوف الدراسية</p>
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">اسم الاختبار</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الصف</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">المادة</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">التاريخ</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الملف</th>
                                        <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($exams as $exam)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <div class="w-8 h-8 bg-blue-50 rounded flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <span class="font-medium text-gray-900 text-sm truncate max-w-[120px]">{{ $exam->title }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs font-medium truncate max-w-[100px] inline-block">
                                                {{ $exam->classroom->class_name ?? 'غير معروف' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs font-medium truncate max-w-[100px] inline-block">
                                                {{ $exam->subject->name ?? 'غير معروف' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm text-center hidden sm:table-cell">
                                            {{ \Carbon\Carbon::parse($exam->created_at)->format('Y-m-d') }}
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-center">
                                            @if($exam->file_path)
                                                <span class="inline-flex items-center gap-1 text-green-600 text-xs">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    موجود
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">غير متوفر</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <a href="{{ route('teacher.exams.view', $exam->id) }}" 
                                                   class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                    عرض
                                                </a>
                                                <a href="{{ route('teacher.exams.print', $exam->id) }}" 
                                                   target="_blank"
                                                   class="bg-gray-50 text-gray-600 hover:bg-gray-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                    طباعة
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
                @if($exams->hasPages())
                <div class="px-3 sm:px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-sm text-gray-700 text-center sm:text-right">
                            عرض 
                            <span class="font-medium">{{ $exams->firstItem() }}</span>
                            إلى 
                            <span class="font-medium">{{ $exams->lastItem() }}</span>
                            من 
                            <span class="font-medium">{{ $exams->total() }}</span>
                            نتيجة
                        </div>
                        
                        <div class="flex items-center space-x-1 space-x-reverse flex-wrap justify-center">
                            <!-- Previous Page Link -->
                            @if ($exams->onFirstPage())
                                <span class="px-2 py-1 text-gray-400 bg-white border border-gray-300 rounded text-sm cursor-not-allowed">
                                    السابق
                                </span>
                            @else
                                <a href="{{ $exams->previousPageUrl() }}" 
                                   class="px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded text-sm hover:bg-gray-50 transition duration-200">
                                    السابق
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($exams->links()->elements as $element)
                                <!-- "Three Dots" Separator -->
                                @if (is_string($element))
                                    <span class="px-2 py-1 text-gray-500">{{ $element }}</span>
                                @endif

                                <!-- Array Of Links -->
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $exams->currentPage())
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
                            @if ($exams->hasMorePages())
                                <a href="{{ $exams->nextPageUrl() }}" 
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
    const classroomFilter = document.getElementById('classroom_filter');

    // Auto-submit form when classroom filter changes
    classroomFilter.addEventListener('change', function() {
        if (this.value) {
            this.form.submit();
        }
    });
});
</script>

<style>
    /* Custom breakpoint for extra small screens */
    @media (min-width: 475px) {
        .xs\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .xs\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
</style>
@endsection