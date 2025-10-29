@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">تعديل الاختبار</h1>
                    <p class="text-gray-600 text-sm">قم بتحديث تفاصيل الاختبار والأسئلة</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('exam.show', $exam->id) }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للتفاصيل
                    </a>
                </div>
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
                <div class="text-green-800 font-medium text-sm">{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-red-800 font-medium text-sm">يرجى تصحيح الأخطاء التالية:</div>
                </div>
                <ul class="text-red-700 text-sm list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('exam.update', $exam->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Exam Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">تفاصيل الاختبار</h2>
                            <p class="text-sm text-gray-600">المعلومات الأساسية للاختبار</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Exam Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                عنوان الاختبار 
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" required
                                   placeholder="أدخل عنوان واضح للاختبار"
                                   value="{{ old('title', $exam->title) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- Lesson Selection -->
                        <div>
                            <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                                الدرس المرتبط
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="lesson_id" id="lesson_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="">اختر الدرس المناسب</option>
                                @foreach ($lessons as $lesson)
                                    <option value="{{ $lesson->id }}" {{ old('lesson_id', $exam->lesson_id) == $lesson->id ? 'selected' : '' }}>
                                        {{ $lesson->title }} 
                                        @if($lesson->grade_level)
                                            - {{ $lesson->grade_level }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                وقت البدء
                            </label>
                            <input type="datetime-local" id="start_time" name="start_time"
                                   value="{{ old('start_time', $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                وقت الانتهاء
                            </label>
                            <input type="datetime-local" id="end_time" name="end_time"
                                   value="{{ old('end_time', $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">أسئلة الاختبار</h2>
                                <p class="text-sm text-gray-600">أضف الأسئلة والخيارات مع تحديد الإجابة الصحيحة</p>
                            </div>
                        </div>
                        <button type="button" id="add-question-btn" 
                                class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة سؤال
                        </button>
                    </div>
                </div>

                <div id="questions-container" class="p-6 space-y-6">
                    @foreach($exam->questions as $index => $question)
                    <div class="question-block bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-6" data-question-index="{{ $index }}">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">سؤال {{ $index + 1 }}</span>
                                <span class="text-sm text-gray-500">اسحب لنقل الترتيب</span>
                            </div>
                            <button type="button" class="remove-question-btn text-red-600 hover:text-red-700 font-medium text-sm flex items-center gap-1 transition duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                حذف السؤال
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                نص السؤال 
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea name="questions[{{ $index }}][text]" placeholder="اكتب نص السؤال هنا..." rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old("questions.{$index}.text", $question->question_text) }}</textarea>
                        </div>

                        <div class="choices-container space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-medium text-gray-700">خيارات الإجابة</h4>
                                <span class="text-xs text-gray-500">حدد الإجابة الصحيحة</span>
                            </div>
                            
                            @foreach($question->choices as $choiceIndex => $choice)
                            <div class="choice-block bg-white p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-2 flex-1">
                                        <span class="bg-gray-100 text-gray-600 w-6 h-6 rounded-full flex items-center justify-center text-sm font-medium">{{ $choiceLetters[$choiceIndex] ?? $choiceIndex + 1 }}</span>
                                        <input type="text" name="questions[{{ $index }}][choices][{{ $choiceIndex }}][text]" placeholder="أدخل نص الخيار..." 
                                               value="{{ old("questions.{$index}.choices.{$choiceIndex}.text", $choice->choice_text) }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                                    </div>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="questions[{{ $index }}][correct_choice]" value="{{ $choiceIndex }}" 
                                               {{ old("questions.{$index}.correct_choice", $question->correct_choice) == $choiceIndex ? 'checked' : '' }}
                                               class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                                        <span class="text-sm font-medium text-gray-700">إجابة صحيحة</span>
                                    </label>
                                    <button type="button" class="remove-choice-btn text-gray-400 hover:text-red-500 transition duration-200 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" class="add-choice-btn mt-4 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة خيار
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6">
                <a href="{{ route('exam.show', $exam->id) }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg transition duration-200 text-center">
                    إلغاء
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-3 rounded-lg shadow-sm transition duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Question Template for New Questions -->
<template id="question-template">
    <div class="question-block bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">سؤال جديد</span>
                <span class="text-sm text-gray-500">اسحب لنقل الترتيب</span>
            </div>
            <button type="button" class="remove-question-btn text-red-600 hover:text-red-700 font-medium text-sm flex items-center gap-1 transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                حذف السؤال
            </button>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                نص السؤال 
                <span class="text-red-500">*</span>
            </label>
            <textarea name="questions[NEW_INDEX][text]" placeholder="اكتب نص السؤال هنا..." rows="3" 
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
        </div>

        <div class="choices-container space-y-3">
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-medium text-gray-700">خيارات الإجابة</h4>
                <span class="text-xs text-gray-500">حدد الإجابة الصحيحة</span>
            </div>
            
            <div class="choice-block bg-white p-4 rounded-lg border border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 flex-1">
                        <span class="bg-gray-100 text-gray-600 w-6 h-6 rounded-full flex items-center justify-center text-sm font-medium">أ</span>
                        <input type="text" name="questions[NEW_INDEX][choices][0][text]" placeholder="أدخل نص الخيار..." 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="questions[NEW_INDEX][correct_choice]" value="0" 
                               class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                        <span class="text-sm font-medium text-gray-700">إجابة صحيحة</span>
                    </label>
                    <button type="button" class="remove-choice-btn text-gray-400 hover:text-red-500 transition duration-200 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <button type="button" class="add-choice-btn mt-4 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة خيار
        </button>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const questionsContainer = document.getElementById('questions-container');
    const addQuestionBtn = document.getElementById('add-question-btn');
    const questionTemplate = document.getElementById('question-template');
    const choiceLetters = ['أ', 'ب', 'ج', 'د', 'هـ', 'و', 'ز', 'ح'];
    let questionCounter = {{ $exam->questions->count() }};

    const createQuestionTemplate = (questionIndex) => {
        const newQuestion = questionTemplate.content.cloneNode(true);
        const questionElement = newQuestion.querySelector('.question-block');
        
        // Update question index in all fields
        questionElement.querySelectorAll('[name]').forEach(element => {
            element.name = element.name.replace(/NEW_INDEX/g, questionIndex);
        });
        
        // Update question number
        const badge = questionElement.querySelector('.bg-blue-100');
        if (badge) {
            badge.textContent = `سؤال ${questionIndex + 1}`;
        }

        return questionElement;
    };

    const createChoiceTemplate = (choicesContainer, questionIndex, choiceIndex) => {
        const choiceLetter = choiceLetters[choiceIndex] || (choiceIndex + 1);
        const newChoice = document.createElement('div');
        newChoice.classList.add('choice-block', 'bg-white', 'p-4', 'rounded-lg', 'border', 'border-gray-200');
        
        newChoice.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 flex-1">
                    <span class="bg-gray-100 text-gray-600 w-6 h-6 rounded-full flex items-center justify-center text-sm font-medium">${choiceLetter}</span>
                    <input type="text" name="questions[${questionIndex}][choices][${choiceIndex}][text]" placeholder="أدخل نص الخيار..." 
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="questions[${questionIndex}][correct_choice]" value="${choiceIndex}" 
                           class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                    <span class="text-sm font-medium text-gray-700">إجابة صحيحة</span>
                </label>
                <button type="button" class="remove-choice-btn text-gray-400 hover:text-red-500 transition duration-200 p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;
        
        choicesContainer.appendChild(newChoice);
    };

    const updateFieldNames = () => {
        const questionBlocks = document.querySelectorAll('.question-block');
        questionBlocks.forEach((questionBlock, questionIndex) => {
            // Update question number badge
            const badge = questionBlock.querySelector('.bg-blue-100');
            if (badge) {
                badge.textContent = `سؤال ${questionIndex + 1}`;
            }

            // Update question textarea name
            const textarea = questionBlock.querySelector('textarea');
            if (textarea) {
                textarea.name = `questions[${questionIndex}][text]`;
            }

            // Update choices
            const choiceBlocks = questionBlock.querySelectorAll('.choice-block');
            choiceBlocks.forEach((choiceBlock, choiceIndex) => {
                const choiceLetter = choiceLetters[choiceIndex] || (choiceIndex + 1);
                
                // Update choice letter
                const letterSpan = choiceBlock.querySelector('.bg-gray-100');
                if (letterSpan) {
                    letterSpan.textContent = choiceLetter;
                }

                // Update choice input name
                const choiceInput = choiceBlock.querySelector('input[type="text"]');
                if (choiceInput) {
                    choiceInput.name = `questions[${questionIndex}][choices][${choiceIndex}][text]`;
                }

                // Update radio button
                const radio = choiceBlock.querySelector('input[type="radio"]');
                if (radio) {
                    radio.name = `questions[${questionIndex}][correct_choice]`;
                    radio.value = choiceIndex;
                }
            });
        });
    };

    // Event listeners
    addQuestionBtn.addEventListener('click', () => {
        const newQuestion = createQuestionTemplate(questionCounter);
        questionsContainer.appendChild(newQuestion);
        questionCounter++;
        updateFieldNames();
    });

    questionsContainer.addEventListener('click', (event) => {
        const target = event.target;
        
        // Add choice
        if (target.classList.contains('add-choice-btn')) {
            const choicesContainer = target.previousElementSibling;
            const questionBlock = target.closest('.question-block');
            const questionIndex = Array.from(questionsContainer.children).indexOf(questionBlock);
            const choiceCount = choicesContainer.querySelectorAll('.choice-block').length;
            
            if (choiceCount < 8) { // Limit to 8 choices
                createChoiceTemplate(choicesContainer, questionIndex, choiceCount);
                updateFieldNames();
            }
        }
        
        // Remove choice
        if (target.classList.contains('remove-choice-btn')) {
            const choiceBlock = target.closest('.choice-block');
            const choicesContainer = choiceBlock.parentElement;
            if (choicesContainer.querySelectorAll('.choice-block').length > 1) {
                choiceBlock.remove();
                updateFieldNames();
            }
        }
        
        // Remove question
        if (target.classList.contains('remove-question-btn')) {
            const questionBlock = target.closest('.question-block');
            if (document.querySelectorAll('.question-block').length > 1) {
                questionBlock.remove();
                updateFieldNames();
            }
        }
    });

    // Initialize field names
    updateFieldNames();
});
</script>

<style>
.question-block {
    transition: all 0.3s ease;
}

.choice-block {
    transition: all 0.2s ease;
}

.choice-block:hover {
    border-color: #8b5cf6;
}

.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}
</style>
@endsection