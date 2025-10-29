@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-8xl mx-auto">
        <!-- Compact Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">📚 جميع القواعد</h1>
                    <p class="text-gray-600 text-sm">نظرة شاملة على جميع القواعد والمحتوى التعليمي</p>
                </div>
                <a href="{{ route('rules.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة قاعدة
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-green-800 font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-red-800 font-medium">{{ session('error') }}</div>
            </div>
        @endif

        <!-- Compact Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">


            

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">قواعد نشطة</p>
                        <p class="text-lg font-bold text-gray-900">{{ $rules->count() }}</p>
                    </div>
                    <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">أحدث إضافة</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $rules->count() > 0 ? $rules->first()->created_at->diffForHumans() : 'لا يوجد' }}
                        </p>
                    </div>
                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700">تصفية القواعد</h3>
            </div>

            <form action="{{ route('rules.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <!-- Title Filter -->
                <div>
                    <label for="title_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        البحث بالعنوان
                    </label>
                    <input type="text" name="title" id="title_filter" placeholder="اكتب للبحث..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ request('title') }}">
                </div>

                <!-- Lesson Filter -->
                <div>
                    <label for="lesson_filter" class="block text-xs font-medium text-gray-600 mb-1">
                        الدرس المرتبط
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

                <!-- Action Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق التصفية
                    </button>
                    
                    @if(request()->anyFilled(['title', 'lesson_id']))
                    <a href="{{ route('rules.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm transition duration-200">
                        إعادة التعيين
                    </a>
                    @endif
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request()->anyFilled(['title', 'lesson_id']))
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

                    @if(request('lesson_id'))
                    @php
                        $selectedLesson = $lessons->firstWhere('id', request('lesson_id'));
                    @endphp
                    <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                        الدرس: {{ $selectedLesson->title ?? 'غير معروف' }}
                        <a href="{{ request()->fullUrlWithQuery(['lesson_id' => null]) }}" class="text-emerald-500 hover:text-emerald-700">
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

        @if ($rules->count() === 0)
            <!-- Compact Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-200">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">لا يوجد قواعد بعد</h3>
                        <p class="text-gray-500 text-sm">ابدأ بإنشاء أول قاعدة لك</p>
                    </div>
                    <a href="{{ route('rules.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إنشاء قاعدة جديدة
                    </a>
                </div>
            </div>
        @else
            <!-- Compact Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            @if($rules->total() > 0)
                                عرض 
                                <span class="font-medium text-gray-900">{{ $rules->firstItem() }} - {{ $rules->lastItem() }}</span>
                                من أصل 
                                <span class="font-medium text-gray-900">{{ $rules->total() }}</span> 
                                قاعدة
                            @else
                                عرض <span class="font-medium text-gray-900">{{ $rules->count() }}</span> قاعدة
                            @endif
                            @if(request()->anyFilled(['title', 'lesson_id']))
                                <span class="text-xs text-gray-500">(نتائج البحث)</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العنوان</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوصف</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الدرس المرتبط</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rules as $rule)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-blue-50 rounded flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">{{ $rule->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <span class="text-gray-600 text-sm max-w-xs truncate">
                                                {{ Str::limit($rule->description, 30) }}
                                            </span>
                                            <a href="#"
                                                class="text-blue-600 hover:text-blue-800 text-xs font-medium whitespace-nowrap open-description-modal"
                                                data-rule-title="{{ $rule->title }}"
                                                data-rule-description="{{ addslashes(nl2br($rule->description)) }}">
                                                عرض
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs font-medium">
                                            {{ $rule->lesson->title ?? 'غير محدد' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500 text-sm">
                                        {{ $rule->created_at?->format('Y-m-d') ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('Example.index', $rule->id) }}" 
                                               class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200">
                                                الأمثلة
                                            </a>
                                            <a href="{{ route('rules.edit', $rule->id) }}" 
                                               class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200">
                                                تعديل
                                            </a>
                                            <form action="{{ route('rules.destroy', $rule->id) }}" method="POST" 
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه القاعدة؟ سيتم حذف جميع الأمثلة المرتبطة بها أيضاً.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-50 text-red-600 hover:bg-red-100 px-2 py-1 rounded text-xs font-medium transition-colors duration-200">
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

                <!-- Pagination -->
                @if($rules->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-sm text-gray-700">
                            عرض 
                            <span class="font-medium">{{ $rules->firstItem() }}</span>
                            إلى 
                            <span class="font-medium">{{ $rules->lastItem() }}</span>
                            من 
                            <span class="font-medium">{{ $rules->total() }}</span>
                            نتيجة
                        </div>
                        
                        <div class="flex items-center space-x-1 space-x-reverse">
                            <!-- Previous Page Link -->
                            @if ($rules->onFirstPage())
                                <span class="px-3 py-1 text-gray-400 bg-white border border-gray-300 rounded-lg text-sm cursor-not-allowed">
                                    السابق
                                </span>
                            @else
                                <a href="{{ $rules->previousPageUrl() }}" 
                                   class="px-3 py-1 text-gray-700 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition duration-200">
                                    السابق
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($rules->links()->elements as $element)
                                <!-- "Three Dots" Separator -->
                                @if (is_string($element))
                                    <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
                                @endif

                                <!-- Array Of Links -->
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $rules->currentPage())
                                            <span class="px-3 py-1 text-white bg-blue-600 border border-blue-600 rounded-lg text-sm font-medium">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" 
                                               class="px-3 py-1 text-gray-700 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition duration-200">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($rules->hasMorePages())
                                <a href="{{ $rules->nextPageUrl() }}" 
                                   class="px-3 py-1 text-gray-700 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition duration-200">
                                    التالي
                                </a>
                            @else
                                <span class="px-3 py-1 text-gray-400 bg-white border border-gray-300 rounded-lg text-sm cursor-not-allowed">
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

<!-- Description Modal -->
<div id="ruleDescriptionModal"
     class="hidden fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-8 text-center sm:block sm:p-0">
        <div id="modalOverlay"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-right w-full">
                        <h3 class="text-2xl leading-6 font-bold text-gray-900 mb-4" id="modalTitle"></h3>
                        <div class="mt-2 text-right">
                            <p class="text-lg text-gray-700 whitespace-pre-line" id="modalDescription"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                        id="closeModalButton"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('ruleDescriptionModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalOverlay = document.getElementById('modalOverlay');
    const closeModalButton = document.getElementById('closeModalButton');

    function showModal(title, description) {
        modalTitle.textContent = title;
        modalDescription.innerHTML = description;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        modalTitle.textContent = '';
        modalDescription.innerHTML = '';
    }

    document.querySelectorAll('.open-description-modal').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            const title = this.dataset.ruleTitle;
            const description = this.dataset.ruleDescription;

            showModal(title, description);
        });
    });

    if (modalOverlay) {
        modalOverlay.addEventListener('click', hideModal);
    }
    if (closeModalButton) {
        closeModalButton.addEventListener('click', hideModal);
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            hideModal();
        }
    });

    // Filter functionality
    const titleFilter = document.getElementById('title_filter');
    const lessonFilter = document.getElementById('lesson_filter');

    // Auto-submit form when select filters change
    lessonFilter.addEventListener('change', function() {
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