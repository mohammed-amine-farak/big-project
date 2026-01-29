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

        <!-- Messages -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">تفاصيل المشكلة</h2>
                        <p class="text-sm text-gray-600 mt-1">املأ النموذج أدناه للإبلاغ عن مشكلة في الدرس</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            حالة جديدة
                        </span>
                    </div>
                </div>
            </div>
            
            <form action="" method="POST" id="createReportForm" class="p-6">
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
                        الدرس *
                    </label>
                    <div class="relative">
                        <select id="lesson_id" name="lesson_id" required 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="">اختر الدرس...</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}" 
                                        data-researcher-id="{{ $lesson->researcher_id ?? '' }}"
                                        {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                    {{ $lesson->title }}
                                    @if($lesson->researcher)
                                        (الباحث: {{ $lesson->researcher->user->name ?? 'غير معروف' }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div id="lesson_loading" class="hidden absolute right-3 top-3">
                            <div class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </div>
                    @error('lesson_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Researcher Info (Auto-filled) -->
                <div id="researcher_info_container" class="mb-6 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    <h3 class="text-sm font-medium text-blue-800">الباحث المسؤول</h3>
                                </div>
                                <div id="researcher_details" class="text-sm text-blue-700">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                            </div>
                            <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded">
                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                سيتم توجيه التقرير لهذا الباحث
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden input for researcher_id -->
                    <input type="hidden" id="researcher_id" name="researcher_id" value="{{ old('researcher_id') }}">
                </div>

                <!-- Optional Fields Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Classroom -->
                    <div>
                        <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الصف الدراسي
                        </label>
                        <select id="classroom_id" name="classroom_id"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="">اختر الصف الدراسي (اختياري)</option>
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

                    <!-- Problem Type -->
                    <div>
                        <label for="problem_type" class="block text-sm font-medium text-gray-700 mb-2">
                            نوع المشكلة *
                        </label>
                        <select id="problem_type" name="problem_type" required 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="">اختر نوع المشكلة...</option>
                            <option value="technical" {{ old('problem_type') == 'technical' ? 'selected' : '' }}>مشكلة تقنية</option>
                            <option value="content" {{ old('problem_type') == 'content' ? 'selected' : '' }}>مشكلة في المحتوى</option>
                            <option value="pedagogical" {{ old('problem_type') == 'pedagogical' ? 'selected' : '' }}>مشكلة تربوية</option>
                            <option value="assessment" {{ old('problem_type') == 'assessment' ? 'selected' : '' }}>مشكلة في التقييم</option>
                            <option value="resource" {{ old('problem_type') == 'resource' ? 'selected' : '' }}>مشكلة في المصادر</option>
                            <option value="other" {{ old('problem_type') == 'other' ? 'selected' : '' }}>أخرى</option>
                        </select>
                        @error('problem_type')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Priority -->
                <div class="mb-6">
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                        الأولوية *
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <label class="relative flex items-center cursor-pointer">
                            <input type="radio" name="priority" value="low" class="sr-only peer" {{ old('priority') == 'low' ? 'checked' : '' }} required>
                            <div class="w-full p-3 border-2 border-gray-200 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-50 transition duration-150">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">منخفضة</span>
                                    <div class="w-3 h-3 rounded-full bg-green-500 opacity-0 peer-checked:opacity-100 transition duration-150"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">مشكلة بسيطة</p>
                            </div>
                        </label>
                        
                        <label class="relative flex items-center cursor-pointer">
                            <input type="radio" name="priority" value="medium" class="sr-only peer" {{ old('priority') == 'medium' ? 'checked' : '' }}>
                            <div class="w-full p-3 border-2 border-gray-200 rounded-lg peer-checked:border-yellow-500 peer-checked:bg-yellow-50 transition duration-150">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">متوسطة</span>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500 opacity-0 peer-checked:opacity-100 transition duration-150"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">مشكلة متوسطة</p>
                            </div>
                        </label>
                        
                        <label class="relative flex items-center cursor-pointer">
                            <input type="radio" name="priority" value="high" class="sr-only peer" {{ old('priority') == 'high' ? 'checked' : '' }}>
                            <div class="w-full p-3 border-2 border-gray-200 rounded-lg peer-checked:border-orange-500 peer-checked:bg-orange-50 transition duration-150">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">عالية</span>
                                    <div class="w-3 h-3 rounded-full bg-orange-500 opacity-0 peer-checked:opacity-100 transition duration-150"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">مشكلة مهمة</p>
                            </div>
                        </label>
                        
                        <label class="relative flex items-center cursor-pointer">
                            <input type="radio" name="priority" value="critical" class="sr-only peer" {{ old('priority') == 'critical' ? 'checked' : '' }}>
                            <div class="w-full p-3 border-2 border-gray-200 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50 transition duration-150">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">حرجة</span>
                                    <div class="w-3 h-3 rounded-full bg-red-500 opacity-0 peer-checked:opacity-100 transition duration-150"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">مشكلة طارئة</p>
                            </div>
                        </label>
                    </div>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
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
                            <p class="text-xs text-gray-500">يرجى تقديم وصف مفصل للمشكلة بما في ذلك الخطوات التي تؤدي إليها</p>
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
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span id="submit_text">إرسال التقرير</span>
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
        const researcherInfoContainer = document.getElementById('researcher_info_container');
        const researcherDetails = document.getElementById('researcher_details');
        const researcherIdInput = document.getElementById('researcher_id');
        const descriptionTextarea = document.getElementById('description');
        const solutionTextarea = document.getElementById('suggested_solution');
        const descriptionCount = document.getElementById('description_count');
        const solutionCount = document.getElementById('solution_count');
        const submitBtn = document.querySelector('button[type="submit"]');
        const submitText = document.getElementById('submit_text');
        
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
        
        // Lesson Change - Auto-fill researcher
        lessonSelect.addEventListener('change', async function() {
            const lessonId = this.value;
            const selectedOption = this.options[this.selectedIndex];
            const researcherIdFromData = selectedOption.getAttribute('data-researcher-id');
            
            // Hide researcher info container initially
            researcherInfoContainer.classList.add('hidden');
            researcherIdInput.value = '';
            
            if (!lessonId) {
                return;
            }
            
            // Show loading
            showLessonLoading(true);
            
            try {
                // Try to get researcher from data attribute first
                if (researcherIdFromData) {
                    const researcherName = selectedOption.textContent.match(/\(الباحث: (.+?)\)/);
                    if (researcherName) {
                        showResearcherInfo({
                            id: researcherIdFromData,
                            name: researcherName[1],
                            email: ''
                        });
                    } else {
                        // If not in text, fetch from server
                        await fetchResearcher(lessonId);
                    }
                } else {
                    // Fetch researcher from server
                    await fetchResearcher(lessonId);
                }
            } catch (error) {
                console.error('Error fetching researcher:', error);
                hideResearcherInfo();
            } finally {
                showLessonLoading(false);
            }
        });
        
        // Helper function to fetch researcher from server
        async function fetchResearcher(lessonId) {
            try {
                const response = await fetch(`/ajax/get-researcher-by-lesson/${lessonId}`);
                const data = await response.json();
                
                if (data.success) {
                    showResearcherInfo(data.researcher);
                } else {
                    hideResearcherInfo();
                }
            } catch (error) {
                console.error('Error:', error);
                hideResearcherInfo();
            }
        }
        
        // Show researcher information
        function showResearcherInfo(researcher) {
            researcherDetails.innerHTML = `
                <div class="font-medium">${researcher.name}</div>
                ${researcher.email ? `<div class="text-xs mt-1">${researcher.email}</div>` : ''}
            `;
            researcherIdInput.value = researcher.id;
            researcherInfoContainer.classList.remove('hidden');
        }
        
        // Hide researcher information
        function hideResearcherInfo() {
            researcherDetails.innerHTML = 'لا يوجد باحث مسؤول عن هذا الدرس';
            researcherIdInput.value = '';
            researcherInfoContainer.classList.add('hidden');
        }
        
        // Show/hide loading for lesson selection
        function showLessonLoading(show) {
            const loadingDiv = document.getElementById('lesson_loading');
            if (show) {
                loadingDiv.classList.remove('hidden');
            } else {
                loadingDiv.classList.add('hidden');
            }
        }
        
        // Initialize researcher info if lesson is already selected
        const initialLessonId = lessonSelect.value;
        if (initialLessonId) {
            lessonSelect.dispatchEvent(new Event('change'));
        }
        
        // Form Validation
        document.getElementById('createReportForm').addEventListener('submit', function(e) {
            // Validate description length
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
            
            // Validate all required fields
            const title = document.getElementById('title').value.trim();
            const lessonId = lessonSelect.value;
            const problemType = document.getElementById('problem_type').value;
            const priority = document.querySelector('input[name="priority"]:checked');
            
            if (!title || !lessonId || !problemType || !priority) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
                return false;
            }
            
            // Add loading state to submit button
            submitBtn.disabled = true;
            submitText.innerHTML = `
                <div class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></div>
                جاري الإرسال...
            `;
        });
        
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
            
            if (count > maxLength) {
                colorClass = 'text-sm text-red-600 px-3 py-1 bg-red-100 rounded-full';
            }
            
            countElement.className = colorClass;
        }
    });
</script>

<style>
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    select:disabled {
        background-color: #f9fafb;
        cursor: not-allowed;
    }
    
    textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    /* Focus styles */
    input:focus, select:focus, textarea:focus {
        outline: none;
        ring-width: 2px;
    }
    
    /* Custom radio button styles */
    input[type="radio"]:checked + div {
        border-width: 2px;
    }
    
    /* Priority colors */
    .peer-checked\:border-green-500 + div {
        border-color: #10b981;
    }
    
    .peer-checked\:bg-green-50 + div {
        background-color: #f0fdf4;
    }
    
    .peer-checked\:border-yellow-500 + div {
        border-color: #f59e0b;
    }
    
    .peer-checked\:bg-yellow-50 + div {
        background-color: #fefce8;
    }
    
    .peer-checked\:border-orange-500 + div {
        border-color: #f97316;
    }
    
    .peer-checked\:bg-orange-50 + div {
        background-color: #fff7ed;
    }
    
    .peer-checked\:border-red-500 + div {
        border-color: #ef4444;
    }
    
    .peer-checked\:bg-red-50 + div {
        background-color: #fef2f2;
    }
</style>

@endsection