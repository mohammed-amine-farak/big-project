@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">إبلاغ عن مشكلة في الدرس</h1>
                <p class="text-gray-600 mt-1">ساعدنا في تحسين تجربة التعليم بالإبلاغ عن المشاكل التي تواجهها</p>
            </div>
            <a href="" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة إلى التقارير
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">بيانات التقرير</h2>
            </div>
            
            <form action="{{ route('lesson_reports.store') }}" method="POST" id="createReportForm" class="p-6">
                @csrf
                
                <!-- Report Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        عنوان المشكلة *
                    </label>
                    <input type="text" id="title" name="title" required 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                           placeholder="مثال: مشكلة في شرح مفهوم الجبر الأساسي">
                    @error('title')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lesson Selection -->
                <div class="mb-6">
                    <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                        اختر الدرس *
                    </label>
                    <div class="relative">
                        <select id="lesson_id" name="lesson_id" required 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 appearance-none">
                            <option value="">اختر الدرس...</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                    {{ $lesson->title }}
                                    @if($lesson->researcher && $lesson->researcher->name)
                                        - الباحث: {{ $lesson->researcher->name }}
                                    @elseif($lesson->researcher)
                                        - الباحث: {{ $lesson->researcher->user->name ?? 'غير معروف' }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">سيتم توجيه التقرير إلى الباحث المسؤول عن الدرس المختار</p>
                    @error('lesson_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Selected Lesson Info (Optional Display) -->
                <div id="selectedLessonInfo" class="mb-6 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800">معلومات الدرس المختار</h4>
                                <div class="text-sm text-blue-700 mt-1">
                                    <div id="lessonTitleDisplay" class="font-medium"></div>
                                    <div id="researcherInfo" class="mt-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Classroom Selection -->
                <div class="mb-6">
                    <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-2">
                        الصف الدراسي (اختياري)
                    </label>
                    <select id="classroom_id" name="classroom_id"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                        <option value="">اختر الصف الدراسي...</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->class_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Problem Type and Priority -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Problem Type -->
                    <div>
                        <label for="problem_type" class="block text-sm font-medium text-gray-700 mb-2">
                            نوع المشكلة *
                        </label>
                        <!-- In your create.blade.php, update the problem_type dropdown -->
<select id="problem_type" name="problem_type" required 
        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
    <option value="">اختر نوع المشكلة...</option>
    <option value="content_issue" {{ old('problem_type') == 'content_issue' ? 'selected' : '' }}>مشكلة في المحتوى</option>
    <option value="difficulty_level" {{ old('problem_type') == 'difficulty_level' ? 'selected' : '' }}>مستوى الصعوبة</option>
    <option value="technical_issue" {{ old('problem_type') == 'technical_issue' ? 'selected' : '' }}>مشكلة تقنية</option>
    <option value="language_issue" {{ old('problem_type') == 'language_issue' ? 'selected' : '' }}>مشكلة لغوية</option>
    <option value="other" {{ old('problem_type') == 'other' ? 'selected' : '' }}>أخرى</option>
</select>
                        @error('problem_type')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            الأولوية *
                        </label>
                        <select id="priority" name="priority" required 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="">اختر مستوى الأولوية...</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                            <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>حرجة</option>
                        </select>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Problem Description -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">وصف المشكلة *</h3>
                            <p class="text-sm text-gray-500">صف المشكلة بتفصيل واضح</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span id="description_count" class="text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                                0 حرف
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <textarea id="description" name="description" rows="6" required 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                  placeholder="صف المشكلة التي تواجهك في الدرس...">{{ old('description') }}</textarea>
                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-gray-500">يرجى تقديم وصف مفصل للمشكلة</p>
                            <p class="text-xs text-gray-500">الحد الأقصى: 5000 حرف</p>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Suggested Solution -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">الحل المقترح (اختياري)</h3>
                            <p class="text-sm text-gray-500">اقترح حلاً إن كان لديك فكرة عن كيفية معالجة المشكلة</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span id="solution_count" class="text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                                0 حرف
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <textarea id="suggested_solution" name="suggested_solution" rows="4"
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                  placeholder="اقترح حلاً أو فكرة لمعالجة المشكلة...">{{ old('suggested_solution') }}</textarea>
                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-gray-500">الحلول المقترحة تساعد الباحثين في فهم المشكلة بشكل أفضل</p>
                            <p class="text-xs text-gray-500">الحد الأقصى: 3000 حرف</p>
                        </div>
                        @error('suggested_solution')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        إرسال التقرير
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const lessonSelect = document.getElementById('lesson_id');
        const lessonInfoContainer = document.getElementById('selectedLessonInfo');
        const lessonTitleDisplay = document.getElementById('lessonTitleDisplay');
        const researcherInfo = document.getElementById('researcherInfo');
        const descriptionTextarea = document.getElementById('description');
        const solutionTextarea = document.getElementById('suggested_solution');
        const descriptionCount = document.getElementById('description_count');
        const solutionCount = document.getElementById('solution_count');
        
        // Character Counters
        descriptionTextarea.addEventListener('input', function() {
            updateCharacterCount(this, descriptionCount, 5000);
        });
        
        solutionTextarea.addEventListener('input', function() {
            updateCharacterCount(this, solutionCount, 3000);
        });
        
        // Initialize character counts
        descriptionTextarea.dispatchEvent(new Event('input'));
        solutionTextarea.dispatchEvent(new Event('input'));
        
        // Lesson Selection
        lessonSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const lessonTitle = selectedOption.textContent.split('-')[0].trim();
            
            if (this.value) {
                // Show lesson info
                lessonTitleDisplay.textContent = lessonTitle;
                
                // Try to extract researcher info from option text
                const optionText = selectedOption.textContent;
                if (optionText.includes('الباحث:')) {
                    const researcherText = optionText.split('الباحث:')[1].trim();
                    researcherInfo.innerHTML = `
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <span>الباحث المسؤول: <span class="font-medium">${researcherText}</span></span>
                        </div>
                    `;
                } else {
                    researcherInfo.innerHTML = `
                        <div class="flex items-center gap-2 text-yellow-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>لا يوجد باحث مسؤول عن هذا الدرس</span>
                        </div>
                    `;
                }
                
                lessonInfoContainer.classList.remove('hidden');
            } else {
                lessonInfoContainer.classList.add('hidden');
            }
        });
        
        // Initialize lesson info if lesson is already selected
        if (lessonSelect.value) {
            lessonSelect.dispatchEvent(new Event('change'));
        }
        
        // Helper function to update character count
        function updateCharacterCount(textarea, countElement, maxLength) {
            const count = textarea.value.length;
            countElement.textContent = `${count} حرف`;
            
            // Update count badge color
            let colorClass = 'text-sm px-3 py-1 rounded-full';
            
            if (count === 0) {
                colorClass += ' text-gray-600 bg-gray-100';
            } else if (count <= maxLength * 0.7) {
                colorClass += ' text-green-600 bg-green-100';
            } else if (count <= maxLength * 0.9) {
                colorClass += ' text-yellow-600 bg-yellow-100';
            } else {
                colorClass += ' text-red-600 bg-red-100';
            }
            
            countElement.className = colorClass;
        }
        
        // Simple form validation
        document.getElementById('createReportForm').addEventListener('submit', function(e) {
            const descLength = descriptionTextarea.value.trim().length;
            const solutionLength = solutionTextarea.value.trim().length;
            
            if (descLength === 0) {
                e.preventDefault();
                alert('يرجى كتابة وصف للمشكلة');
                descriptionTextarea.focus();
                return false;
            }
            
            if (descLength > 5000) {
                e.preventDefault();
                alert('وصف المشكلة يجب أن لا يتجاوز 5000 حرف');
                descriptionTextarea.focus();
                return false;
            }
            
            if (solutionLength > 3000) {
                e.preventDefault();
                alert('الحل المقترح يجب أن لا يتجاوز 3000 حرف');
                solutionTextarea.focus();
                return false;
            }
        });
    });
</script>

<style>
    textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    /* Custom select arrow */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: left 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-left: 2.5rem;
        padding-right: 0.75rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>

@endsection