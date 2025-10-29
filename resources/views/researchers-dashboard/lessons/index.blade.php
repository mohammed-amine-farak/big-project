@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📚 جميع الدروس</h1>
                    <p class="text-gray-600 text-sm">نظرة شاملة على جميع الدروس والمحتوى التعليمي</p>
                </div>
                <a href="{{ route('lessons.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة درس
                </a>
            </div>
        </div>

        <!-- Compact Stats - Responsive Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">دروسي</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $totalLessonsCount }}</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-600 truncate">المستويات</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $fieldStudies->unique('study_level')->count() }}
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
                        <p class="text-xs font-medium text-gray-600 truncate">الشعب</p>
                        <p class="text-lg font-bold text-gray-900 truncate">
                            {{ $fieldStudies->count() }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section - Improved Responsiveness -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية الدروس</h3>
            </div>

            <form action="{{ route('lessons.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Title Filter -->
                <div class="md:col-span-1">
                    <label for="title_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        البحث بالعنوان
                    </label>
                    <input type="text" name="title" id="title_filter" placeholder="اكتب للبحث..."
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
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Field of Study Filter -->
                <div class="md:col-span-1">
                    <label for="field_study_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الشعبة
                    </label>
                    <select name="field_study_id" id="field_study_filter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الشعب</option>
                        @foreach($fieldStudies as $fieldStudy)
                            <option value="{{ $fieldStudy->id }}" {{ request('field_study_id') == $fieldStudy->id ? 'selected' : '' }}>
                                {{ $fieldStudy->name }}
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
                    
                    @if(request()->anyFilled(['title', 'subject_id', 'field_study_id']))
                    <a href="{{ route('lessons.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200 whitespace-nowrap">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['title', 'subject_id', 'field_study_id']))
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

                    @if(request('field_study_id'))
                    @php
                        $selectedFieldStudy = $fieldStudies->firstWhere('id', request('field_study_id'));
                    @endphp
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الشعبة: {{ $selectedFieldStudy->name ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['field_study_id' => null]) }}" class="text-purple-500 hover:text-purple-700">
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

        @if ($lessons->count() === 0)
            <!-- Compact Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 text-center border border-gray-200">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">لا يوجد دروس بعد</h3>
                        <p class="text-gray-500 text-sm">ابدأ بإنشاء أول درس لك</p>
                    </div>
                    <a href="{{ route('lessons.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إنشاء درس جديد
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
                            @if($lessons->total() > 0)
                                عرض 
                                <span class="font-medium text-gray-900">{{ $lessons->firstItem() }} - {{ $lessons->lastItem() }}</span>
                                من أصل 
                                <span class="font-medium text-gray-900">{{ $lessons->total() }}</span> 
                                درس
                            @else
                                عرض <span class="font-medium text-gray-900">{{ $lessons->count() }}</span> درس
                            @endif
                            @if(request()->anyFilled(['title', 'subject_id', 'field_study_id']))
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
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">المستوى</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">الشعبة</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">الوصف</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden xl:table-cell">الباحث</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">التاريخ</th>
                                        <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($lessons as $lesson)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <div class="w-8 h-8 bg-blue-50 rounded flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                    <span class="font-medium text-gray-900 text-sm truncate max-w-[150px]">{{ $lesson->title }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium truncate max-w-[120px] inline-block">
                                                    {{ $lesson->subject->name }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-gray-600 text-sm hidden sm:table-cell">
                                                {{ $lesson->subject->fieldOfStudy->study_level ?? 'غير محدد' }}
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-gray-600 text-sm hidden lg:table-cell">
                                                {{ $lesson->subject->fieldOfStudy->name ?? 'غير محدد' }}
                                            </td>
                                            <td class="px-3 py-3 hidden md:table-cell">
                                                <div class="flex items-center gap-1">
                                                    <span class="text-gray-600 text-sm max-w-[120px] truncate">
                                                        {{ Str::limit($lesson->content, 25) }}
                                                    </span>
                                                    <a href="{{ route('lessons.show', $lesson->id) }}" 
                                                       class="text-blue-600 hover:text-blue-800 text-xs font-medium whitespace-nowrap">
                                                        عرض
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap hidden xl:table-cell">
                                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs truncate max-w-[100px] inline-block">
                                                    {{ $lesson->researcher->name ?? 'غير محدد' }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-gray-500 text-sm hidden lg:table-cell">
                                                {{ $lesson->created_at }}
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-1">
                                                    <a href="{{ route('lessons.update', $lesson->id) }}" 
                                                       class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200 whitespace-nowrap">
                                                        تعديل
                                                    </a>
                                                    
                                                    <form action="{{ route('lessons.delete', $lesson->id) }}" method="POST" 
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
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
                @if($lessons->hasPages())
                <div class="px-3 sm:px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-sm text-gray-700 text-center sm:text-right">
                            عرض 
                            <span class="font-medium">{{ $lessons->firstItem() }}</span>
                            إلى 
                            <span class="font-medium">{{ $lessons->lastItem() }}</span>
                            من 
                            <span class="font-medium">{{ $lessons->total() }}</span>
                            نتيجة
                        </div>
                        
                        <div class="flex items-center space-x-1 space-x-reverse flex-wrap justify-center">
                            <!-- Previous Page Link -->
                            @if ($lessons->onFirstPage())
                                <span class="px-2 py-1 text-gray-400 bg-white border border-gray-300 rounded text-sm cursor-not-allowed">
                                    السابق
                                </span>
                            @else
                                <a href="{{ $lessons->previousPageUrl() }}" 
                                   class="px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded text-sm hover:bg-gray-50 transition duration-200">
                                    السابق
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($lessons->links()->elements as $element)
                                <!-- "Three Dots" Separator -->
                                @if (is_string($element))
                                    <span class="px-2 py-1 text-gray-500">{{ $element }}</span>
                                @endif

                                <!-- Array Of Links -->
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $lessons->currentPage())
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
                            @if ($lessons->hasMorePages())
                                <a href="{{ $lessons->nextPageUrl() }}" 
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
    const fieldStudyFilter = document.getElementById('field_study_filter');

    // Auto-submit form when select filters change
    subjectFilter.addEventListener('change', function() {
        if (this.value) {
            this.form.submit();
        }
    });

    fieldStudyFilter.addEventListener('change', function() {
        if (this.value) {
            this.form.submit();
        }
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