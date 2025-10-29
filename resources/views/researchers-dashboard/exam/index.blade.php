@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📋 جميع الاختبارات</h1>
                    <p class="text-gray-600 text-sm">نظرة شاملة على جميع الاختبارات والتقييمات</p>
                </div>
                <a href="{{ route('exam.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    إنشاء اختبار
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-green-800 font-medium text-sm">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Compact Stats -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
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
                        <p class="text-xs font-medium text-gray-600 truncate">اختبارات نشطة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $exams->where('start_time', '<=', now())->where('end_time', '>=', now())->count() }}
                        </p>
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
                        <p class="text-xs font-medium text-gray-600 truncate">قادمة</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $exams->where('start_time', '>', now())->count() }}
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
                        <p class="text-xs font-medium text-gray-600 truncate">منتهية</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $exams->where('end_time', '<', now())->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
        <h3 class="text-sm font-semibold text-gray-700">تصفية الاختبارات</h3>
    </div>

    <form action="{{ route('exam.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <!-- Title Filter -->
        <div class="md:col-span-1">
            <label for="title_filter" class="block text-xs font-medium text-gray-600 mb-1">
                بحث بالعنوان
            </label>
            <input type="text" name="title" id="title_filter" placeholder="ابحث بعنوان الاختبار..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   value="{{ request('title') }}">
        </div>

        <!-- Subject Filter -->
        <div class="md:col-span-1">
            <label for="subject_filter" class="block text-xs font-medium text-gray-600 mb-1">
                المادة الدراسية
            </label>
            <select name="subject_id" id="subject_filter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">جميع المواد</option>
                @foreach($subjects as $id => $name)
                    <option value="{{ $id }}" {{ request('subject_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
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
                @foreach($lessons as $id => $title)
                    <option value="{{ $id }}" {{ request('lesson_id') == $id ? 'selected' : '' }}>
                        {{ $title }}
                    </option>
                @endforeach
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
            
            @if(request()->anyFilled(['title', 'subject_id', 'lesson_id']))
            <a href="{{ route('exam.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 whitespace-nowrap">
                إعادة التعيين
            </a>
            @endif
        </div>
    </form>

    <!-- Active Filters Display -->
    @if(request()->anyFilled(['title', 'subject_id', 'lesson_id']))
    <div class="mt-3 pt-3 border-t border-gray-200">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="text-xs font-medium text-gray-600">التصفيات المطبقة:</span>
        </div>
        <div class="flex flex-wrap gap-1">
            @if(request('title'))
            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                العنوان: "{{ request('title') }}"
                <a href="{{ request()->fullUrlWithQuery(['title' => null]) }}" class="text-blue-500 hover:text-blue-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </span>
            @endif

            @if(request('subject_id'))
            @php
                $selectedSubject = $subjects->firstWhere('id', request('subject_id'));
            @endphp
            <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                المادة: {{ $selectedSubject->name ?? 'غير معروف' }}
                <a href="{{ request()->fullUrlWithQuery(['subject_id' => null]) }}" class="text-emerald-500 hover:text-emerald-700">
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
            <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                الدرس: {{ $selectedLesson->title ?? 'غير معروف' }}
                <a href="{{ request()->fullUrlWithQuery(['lesson_id' => null]) }}" class="text-purple-500 hover:text-purple-700">
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

        @if ($exams->isEmpty())
            <!-- Compact Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 text-center border border-gray-200">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">لا يوجد اختبارات بعد</h3>
                        <p class="text-gray-500 text-sm">ابدأ بإنشاء أول اختبار لك</p>
                    </div>
                    <a href="{{ route('exam.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إنشاء اختبار جديد
                    </a>
                </div>
            </div>
        @else
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
                            @else
                                عرض <span class="font-medium text-gray-900">{{ $exams->count() }}</span> اختبار
                            @endif
                            @if(request()->anyFilled(['title', 'subject', 'status']))
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">العنوان</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">المادة</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الدرس</th>

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
                                                    <span class="font-medium text-gray-900 text-sm truncate max-w-[150px]">{{ $exam->title }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium truncate max-w-[120px] inline-block">
                                                    {{ $exam->lesson->subject->name ?? 'غير محدد' }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium truncate max-w-[120px] inline-block">
                                                    {{ $exam->lesson->title ?? 'غير محدد' }}
                                                </span>
                                            </td>
                                           
                                            
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <div class="flex items-center justify-center gap-1">
                                                    <a href="{{ route('exam.show', $exam->id) }}" 
                                                       class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                        عرض
                                                    </a>
                                                    <a href="{{ route('exam.edit', $exam->id) }}" 
                                                       class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                        تعديل
                                                    </a>
                                                    <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" 
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الاختبار؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="bg-red-50 text-red-600 hover:bg-red-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
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
            </div>
        @endif
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleFilter = document.getElementById('title_filter');
        const subjectFilter = document.getElementById('subject_filter');
        const lessonFilter = document.getElementById('lesson_filter');
    
        // Auto-submit form when select filters change
        subjectFilter.addEventListener('change', function() {
            this.form.submit();
        });
    
        lessonFilter.addEventListener('change', function() {
            this.form.submit();
        });
    
        // Debounced search for title filter
        let searchTimeout;
        titleFilter.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    });
    </script>
@endsection