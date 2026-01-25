@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إنشاء ملاحظة تفاعل جديدة</h1>
            <a href="{{ route('Interaction_Notes_student.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">بيانات الملاحظة</h2>
            </div>
            
            <form action="{{ route('Interaction_Notes_student.store') }}" method="POST" id="createNoteForm" class="p-6">
                @csrf
                
                <!-- Classroom Selection -->
                <div class="mb-6">
                    <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-2">
                        الصف الدراسي *
                    </label>
                    <select id="classroom_id" name="classroom_id" required 
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

                <!-- Student and Lesson Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Student -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الطالب *
                        </label>
                        <div class="relative">
                            <select id="student_id" name="student_id" required disabled
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 bg-gray-50">
                                <option value="">اختر الصف أولاً...</option>
                            </select>
                            <div id="students_loading" class="hidden absolute right-3 top-3">
                                <div class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                        @error('student_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lesson -->
                    <div>
                        <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الدرس *
                        </label>
                        <select id="lesson_id" name="lesson_id" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="">اختر الدرس...</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                    {{ $lesson->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('lesson_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">ملاحظة التفاعل</h3>
                            <p class="text-sm text-gray-500">اكتب ملاحظاتك حول تفاعل الطالب في هذا الدرس</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span id="character_count" class="text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                                0 حرف
                            </span>
                        </div>
                    </div>
                    
                    <!-- Notes Textarea -->
                    <div>
                        <textarea id="note_content" name="note_content" rows="6" required 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                  placeholder="وصف تفصيلي لتفاعل الطالب خلال الدرس...">{{ old('note_content') }}</textarea>
                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-gray-500">يمكنك كتابة ملاحظات مفصلة حول مشاركة الطالب، مستوى الفهم، السلوك، وغيرها</p>
                            <p class="text-xs text-gray-500">الحد الأقصى: 20000 حرف</p>
                        </div>
                        @error('note_content')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('Interaction_Notes_student.index') }}" 
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                        إلغاء
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <span id="submit_text">حفظ الملاحظة</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const classroomSelect = document.getElementById('classroom_id');
        const studentSelect = document.getElementById('student_id');
        const lessonSelect = document.getElementById('lesson_id');
        const noteContent = document.getElementById('note_content');
        const characterCount = document.getElementById('character_count');
        const submitBtn = document.querySelector('button[type="submit"]');
        const submitText = document.getElementById('submit_text');
        
        // State
        let currentClassroomId = null;

        // Character Counter
        noteContent.addEventListener('input', function() {
            const count = this.value.length;
            characterCount.textContent = `${count} حرف`;
            
            // Update count badge color
            if (count === 0) {
                characterCount.className = 'text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full';
            } else if (count > 0 && count <= 500) {
                characterCount.className = 'text-sm text-green-600 px-3 py-1 bg-green-100 rounded-full';
            } else if (count > 500 && count <= 1000) {
                characterCount.className = 'text-sm text-blue-600 px-3 py-1 bg-blue-100 rounded-full';
            } else {
                characterCount.className = 'text-sm text-yellow-600 px-3 py-1 bg-yellow-100 rounded-full';
            }
            
            // Show warning if approaching limit
            if (count > 19000) {
                characterCount.className = 'text-sm text-red-600 px-3 py-1 bg-red-100 rounded-full';
            }
        });

        // Initialize character count
        noteContent.dispatchEvent(new Event('input'));

        // Classroom Change
        classroomSelect.addEventListener('change', async function() {
            const classroomId = this.value;
            currentClassroomId = classroomId;
            
            if (!classroomId) {
                resetStudentSelect();
                return;
            }
            
            // Reset student select
            resetStudentSelect();
            
            // Show loading
            showLoading(true);
            
            try {
                // Fetch students for this classroom
                const response = await fetch(`/ajax/get-classroom-students/${classroomId}`);
                const data = await response.json();
                
                if (data.success) {
                    // Populate students dropdown
                    populateStudentSelect(data.students);
                } else {
                    throw new Error('فشل في تحميل بيانات الطلاب');
                }
                
            } catch (error) {
                console.error('Error:', error);
                studentSelect.innerHTML = '<option value="">خطأ في تحميل البيانات</option>';
                studentSelect.disabled = true;
            } finally {
                showLoading(false);
            }
        });

        // Helper Functions
        function populateStudentSelect(students) {
            studentSelect.innerHTML = '<option value="">اختر التلميذ...</option>';
            
            if (students && students.length > 0) {
                students.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.id;
                    option.textContent = student.name;
                    studentSelect.appendChild(option);
                });
                studentSelect.disabled = false;
            } else {
                studentSelect.innerHTML = '<option value="">لا توجد بيانات</option>';
                studentSelect.disabled = true;
            }
        }

        function showLoading(show) {
            const loadingDiv = document.getElementById('students_loading');
            
            if (show) {
                loadingDiv.classList.remove('hidden');
            } else {
                loadingDiv.classList.add('hidden');
            }
        }

        function resetStudentSelect() {
            studentSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            studentSelect.disabled = true;
        }

        // Initialize student select if classroom is already selected
        const initialClassroomId = classroomSelect.value;
        if (initialClassroomId) {
            classroomSelect.dispatchEvent(new Event('change'));
        }

        // Form Validation
        document.getElementById('createNoteForm').addEventListener('submit', function(e) {
            // Validate note content length
            const noteLength = noteContent.value.trim().length;
            
            if (noteLength === 0) {
                e.preventDefault();
                alert('يرجى كتابة ملاحظة التفاعل');
                noteContent.focus();
                return false;
            }
            
            if (noteLength > 20000) {
                e.preventDefault();
                alert('ملاحظة التفاعل يجب أن لا تتجاوز 20000 حرف');
                noteContent.focus();
                return false;
            }
            
            // Validate all required fields
            const classroomId = classroomSelect.value;
            const studentId = studentSelect.value;
            const lessonId = lessonSelect.value;
            
            if (!classroomId || !studentId || !lessonId) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
                return false;
            }
            
            // Add loading state to submit button
            submitBtn.disabled = true;
            submitText.innerHTML = `
                <div class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></div>
                جاري الحفظ...
            `;
        });
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
        min-height: 150px;
    }
    
    /* Focus styles */
    input:focus, select:focus, textarea:focus {
        outline: none;
        ring-width: 2px;
    }
</style>

@endsection