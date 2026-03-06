@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">➕ طلب إنتاج فيديو جديد</h1>
                <p class="text-sm text-gray-500 mt-1">أنشئ طلباً جديداً لإنتاج فيديو تعليمي</p>
            </div>
            <a href="" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-red-800">يوجد {{ $errors->count() }} أخطاء في النموذج</h4>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Create Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">معلومات الطلب</h2>
            </div>
            
            <div class="p-6">
                <form action="{{route('researcher.production_requests.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            عنوان الطلب <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                               placeholder="أدخل عنواناً واضحاً للطلب...">
                        @error('title')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            وصف الطلب <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4" required
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                  placeholder="اشرح بالتفصيل ماذا تريد في الفيديو...">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">اذكر التفاصيل المهمة: نوع الفيديو، العناصر المطلوبة، أي تعليمات خاصة</p>
                        @error('description')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid: Lesson & Rule -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Lesson Selection -->
                        <div>
                            <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                                الدرس المرتبط <span class="text-red-500">*</span>
                            </label>
                            <select id="lesson_id" name="lesson_id" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                <option value="">اختر الدرس...</option>
                                @foreach($lessons as $lesson)
                                    <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                        {{ $lesson->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lesson_id')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rule Selection (optional) -->
                        <div>
                            <label for="rule_id" class="block text-sm font-medium text-gray-700 mb-2">
                                القاعدة المرتبطة (اختياري)
                            </label>
                            <select id="rule_id" name="rule_id" disabled
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 bg-gray-50">
                                <option value="">اختر الدرس أولاً...</option>
                            </select>
                            <input type="hidden" id="rule_id_hidden" name="rule_id" value="{{ old('rule_id') }}">
                            <div id="rules_loading" class="hidden absolute right-3 top-3">
                                <div class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                            @error('rule_id')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Content Block (optional) -->
                    <div class="mb-6">
                        <label for="content_block_id" class="block text-sm font-medium text-gray-700 mb-2">
                            كتلة المحتوى (اختياري)
                        </label>
                        <select id="content_block_id" name="content_block_id" disabled
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 bg-gray-50">
                            <option value="">اختر القاعدة أولاً...</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">إذا كان الطلب خاصاً بكتلة محتوى معينة (فيديو)</p>
                        @error('content_block_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Video Creator Selection -->
                    <div class="mb-6">
                        <label for="video_creator_id" class="block text-sm font-medium text-gray-700 mb-2">
                            منشئ الفيديو <span class="text-red-500">*</span>
                        </label>
                        <select id="video_creator_id" name="video_creator_id" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="">اختر منشئ الفيديو...</option>
                            @foreach($videoCreators as $creator)
                                <option value="{{ $creator->id }}" {{ old('video_creator_id') == $creator->id ? 'selected' : '' }}
                                        data-specialization="{{ $creator->specialization }}">
                                    {{ $creator->name }} ({{ $creator->specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('video_creator_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reference File -->
                    <div class="mb-6">
                        <label for="reference_file" class="block text-sm font-medium text-gray-700 mb-2">
                            ملف مرجعي (PDF)
                        </label>
                        <input type="file" id="reference_file" name="reference_file" accept=".pdf,.doc,.docx"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                        <p class="text-xs text-gray-500 mt-1">يمكنك رفع ملف PDF أو Word يحتوي على شرح إضافي (اختياري)</p>
                        @error('reference_file')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deadline -->
                    <div class="mb-6">
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                            تاريخ التسليم المطلوب
                        </label>
                        <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}"
                               min="{{ date('Y-m-d') }}" 
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                        <p class="text-xs text-gray-500 mt-1">اختياري - إذا لم تحدد، سيتفق معك منشئ الفيديو على الموعد</p>
                        @error('deadline')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">الأولوية</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="low" {{ old('priority', 'medium') == 'low' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">منخفضة</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="medium" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">متوسطة</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="high" {{ old('priority') == 'high' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">عالية</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                <span class="text-sm text-gray-700">عاجل</span>
                            </label>
                        </div>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            ملاحظات إضافية
                        </label>
                        <textarea id="notes" name="notes" rows="3" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                  placeholder="أي ملاحظات إضافية لمنشئ الفيديو...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="" 
                           class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                            إلغاء
                        </a>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إنشاء الطلب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Dynamic Dropdowns -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lessonSelect = document.getElementById('lesson_id');
    const ruleSelect = document.getElementById('rule_id');
    const ruleHidden = document.getElementById('rule_id_hidden');
    const contentBlockSelect = document.getElementById('content_block_id');
    const rulesLoading = document.getElementById('rules_loading');

    // Load rules when lesson changes
    lessonSelect.addEventListener('change', async function() {
        const lessonId = this.value;
        
        // Reset selects
        ruleSelect.innerHTML = '<option value="">اختر القاعدة...</option>';
        ruleSelect.disabled = true;
        contentBlockSelect.innerHTML = '<option value="">اختر القاعدة أولاً...</option>';
        contentBlockSelect.disabled = true;
        
        if (!lessonId) return;

        // Show loading
        rulesLoading.classList.remove('hidden');
        
        try {
            const response = await fetch(`/ajax/get-lesson-rules/${lessonId}`);
            const data = await response.json();
            
            if (data.success && data.rules.length > 0) {
                ruleSelect.disabled = false;
                ruleSelect.classList.remove('bg-gray-50');
                
                data.rules.forEach(rule => {
                    const option = document.createElement('option');
                    option.value = rule.id;
                    option.textContent = rule.title;
                    ruleSelect.appendChild(option);
                });

                // Restore old value if exists
                if (ruleHidden.value) {
                    ruleSelect.value = ruleHidden.value;
                    ruleSelect.dispatchEvent(new Event('change'));
                }
            }
        } catch (error) {
            console.error('Error loading rules:', error);
        } finally {
            rulesLoading.classList.add('hidden');
        }
    });

    // Load content blocks when rule changes
    ruleSelect.addEventListener('change', async function() {
        const ruleId = this.value;
        ruleHidden.value = ruleId;
        
        // Reset content blocks select
        contentBlockSelect.innerHTML = '<option value="">اختر كتلة المحتوى...</option>';
        contentBlockSelect.disabled = true;
        
        if (!ruleId) return;

        // Show loading
        rulesLoading.classList.remove('hidden');
        
        try {
            const response = await fetch(`/ajax/get-rule-content-blocks/${ruleId}`);
            const data = await response.json();
            
            if (data.success && data.contentBlocks.length > 0) {
                contentBlockSelect.disabled = false;
                contentBlockSelect.classList.remove('bg-gray-50');
                
                // Add empty option
                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = 'بدون كتلة محددة';
                contentBlockSelect.appendChild(emptyOption);
                
                data.contentBlocks.forEach(block => {
                    const option = document.createElement('option');
                    option.value = block.id;
                    option.textContent = `${block.type} - ${block.content.substring(0, 50)}...`;
                    contentBlockSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading content blocks:', error);
        } finally {
            rulesLoading.classList.add('hidden');
        }
    });

    // Trigger change if old values exist
    if (lessonSelect.value) {
        lessonSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection