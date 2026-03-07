@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">✏️ تعديل طلب الإنتاج</h1>
                <p class="text-sm text-gray-500 mt-1">طلب #{{ $production_request->id }}: {{ $production_request->title }}</p>
            </div>
            <a href="{{ route('researcher.production_requests.show', $production_request->id) }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
        </div>

        <!-- Warning Message -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-yellow-800">تنبيه هام</h4>
                    <p class="text-sm text-yellow-700 mt-1">
                        يمكنك تعديل هذا الطلب فقط إذا كان لا يزال في حالة "في الانتظار". 
                        بمجرد أن يقبله منشئ الفيديو، لن تتمكن من تعديله.
                    </p>
                </div>
            </div>
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

        <!-- Edit Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-l from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">تعديل معلومات الطلب</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('researcher.production_requests.update', $production_request->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            عنوان الطلب <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title', $production_request->title) }}" required
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
                                  placeholder="اشرح بالتفصيل ماذا تريد في الفيديو...">{{ old('description', $production_request->description) }}</textarea>
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
                                    <option value="{{ $lesson->id }}" {{ old('lesson_id', $production_request->lesson_id) == $lesson->id ? 'selected' : '' }}>
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
                            <select id="rule_id" name="rule_id"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                <option value="">اختر القاعدة...</option>
                                @foreach($rules ?? [] as $rule)
                                    <option value="{{ $rule->id }}" {{ old('rule_id', $production_request->rule_id) == $rule->id ? 'selected' : '' }}>
                                        {{ $rule->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="rules_loading" class="hidden">
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
                        <select id="content_block_id" name="content_block_id"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="">اختر كتلة المحتوى...</option>
                            @foreach($contentBlocks ?? [] as $block)
                                <option value="{{ $block->id }}" {{ old('content_block_id', $production_request->content_block_id) == $block->id ? 'selected' : '' }}>
                                    {{ $block->type }} - {{ Str::limit($block->content, 50) }}
                                </option>
                            @endforeach
                        </select>
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
                                <option value="{{ $creator->id }}" {{ old('video_creator_id', $production_request->video_creator_id) == $creator->id ? 'selected' : '' }}
                                        data-specialization="{{ $creator->specialization }}">
                                    {{ $creator->name }} ({{ $creator->specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('video_creator_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Reference File -->
                    @if($production_request->reference_file_path)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">الملف المرجعي الحالي</label>
                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm text-gray-700">{{ basename($production_request->reference_file_path) }}</span>
                            </div>
                            <a href="{{ asset('storage/' . $production_request->reference_file_path) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                عرض
                            </a>
                        </div>
                        <div class="mt-2">
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="delete_reference_file" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-red-600">حذف الملف المرجعي الحالي</span>
                            </label>
                        </div>
                    </div>
                    @endif

                    <!-- New Reference File -->
                    <div class="mb-6">
                        <label for="reference_file" class="block text-sm font-medium text-gray-700 mb-2">
                            رفع ملف مرجعي جديد (اختياري)
                        </label>
                        <input type="file" id="reference_file" name="reference_file" accept=".pdf,.doc,.docx"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX - الحد الأقصى 10 ميجابايت</p>
                        @error('reference_file')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deadline -->
                    <div class="mb-6">
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                            تاريخ التسليم المطلوب
                        </label>
                        <input type="date" id="deadline" name="deadline" value="{{ old('deadline', $production_request->deadline ? $production_request->deadline->format('Y-m-d') : '') }}"
                               min="{{ date('Y-m-d') }}" 
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                        @error('deadline')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">الأولوية</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="low" {{ old('priority', $production_request->priority ?? 'medium') == 'low' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">منخفضة</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="medium" {{ old('priority', $production_request->priority ?? 'medium') == 'medium' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">متوسطة</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="high" {{ old('priority', $production_request->priority) == 'high' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">عالية</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="priority" value="urgent" {{ old('priority', $production_request->priority) == 'urgent' ? 'checked' : '' }}>
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
                                  placeholder="أي ملاحظات إضافية لمنشئ الفيديو...">{{ old('notes', $production_request->notes) }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('researcher.production_requests.show', $production_request->id) }}" 
                           class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                            إلغاء
                        </a>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            تحديث الطلب
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
    const contentBlockSelect = document.getElementById('content_block_id');
    const rulesLoading = document.getElementById('rules_loading');
    
    const currentRuleId = "{{ $production_request->rule_id }}";
    const currentContentBlockId = "{{ $production_request->content_block_id }}";

    // Load rules when lesson changes
    lessonSelect.addEventListener('change', async function() {
        const lessonId = this.value;
        
        // Reset selects
        ruleSelect.innerHTML = '<option value="">اختر القاعدة...</option>';
        ruleSelect.disabled = !lessonId;
        contentBlockSelect.innerHTML = '<option value="">اختر كتلة المحتوى...</option>';
        contentBlockSelect.disabled = true;
        
        if (!lessonId) return;

        // Show loading
        if (rulesLoading) rulesLoading.classList.remove('hidden');
        
        try {
            const response = await fetch(`/ajax/get-lesson-rules/${lessonId}`);
            const data = await response.json();
            
            if (data.success && data.rules.length > 0) {
                ruleSelect.disabled = false;
                
                data.rules.forEach(rule => {
                    const option = document.createElement('option');
                    option.value = rule.id;
                    option.textContent = rule.title;
                    if (rule.id == currentRuleId) {
                        option.selected = true;
                    }
                    ruleSelect.appendChild(option);
                });

                // Load content blocks if a rule was selected
                if (currentRuleId) {
                    ruleSelect.value = currentRuleId;
                    ruleSelect.dispatchEvent(new Event('change'));
                }
            }
        } catch (error) {
            console.error('Error loading rules:', error);
        } finally {
            if (rulesLoading) rulesLoading.classList.add('hidden');
        }
    });

    // Load content blocks when rule changes
    ruleSelect.addEventListener('change', async function() {
        const ruleId = this.value;
        
        contentBlockSelect.innerHTML = '<option value="">اختر كتلة المحتوى...</option>';
        contentBlockSelect.disabled = !ruleId;
        
        if (!ruleId) return;

        try {
            const response = await fetch(`/ajax/get-rule-content-blocks/${ruleId}`);
            const data = await response.json();
            
            if (data.success && data.contentBlocks.length > 0) {
                contentBlockSelect.disabled = false;
                
                data.contentBlocks.forEach(block => {
                    const option = document.createElement('option');
                    option.value = block.id;
                    option.textContent = `${block.type} - ${block.content.substring(0, 50)}...`;
                    if (block.id == currentContentBlockId) {
                        option.selected = true;
                    }
                    contentBlockSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading content blocks:', error);
        }
    });

    // Trigger initial load if lesson is selected
    if (lessonSelect.value) {
        lessonSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection