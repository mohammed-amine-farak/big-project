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

                    <!-- Lesson - Will be populated dynamically -->
                    <div>
                        <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الدرس *
                        </label>
                        <div class="relative">
                            <select id="lesson_id" name="lesson_id" required disabled
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 bg-gray-50">
                                <option value="">اختر الطالب أولاً...</option>
                            </select>
                            <div id="lessons_loading" class="hidden absolute right-3 top-3">
                                <div class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                        @error('lesson_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Progress Input -->
                <div class="mb-6">
                    <label for="progress" class="block text-sm font-medium text-gray-700 mb-2">
                        نسبة التقدم من التفاعل (%) *
                    </label>
                    <div class="relative">
                        <input type="range" 
                               id="progress_slider" 
                               name="progress" 
                               min="0" 
                               max="25" 
                               step="1" 
                               value="{{ old('progress', 0) }}"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                               required>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">القيمة:</span>
                                    <input type="number" 
                                           id="progress_value" 
                                           name="progress_input"
                                           min="0" 
                                           max="25" 
                                           step="1" 
                                           value="{{ old('progress', 0) }}"
                                           class="w-20 px-2 py-1 text-center border border-gray-300 rounded-lg"
                                           required>
                                    <span class="text-sm text-gray-600">%</span>
                                </div>
                                <div class="h-6 w-px bg-gray-300"></div>
                                <div>
                                    <span class="text-xs text-gray-500">الحد الأقصى: 25%</span>
                                </div>
                            </div>
                            <div id="progress_preview" class="text-sm font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                                0%
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">تحدد هذه النسبة مدى تقدم الطالب بناءً على تفاعله في الدرس (تضاف إلى تقدم الطالب الكلي)</p>
                    @error('progress')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
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
        
        // Progress elements
        const progressSlider = document.getElementById('progress_slider');
        const progressValue = document.getElementById('progress_value');
        const progressPreview = document.getElementById('progress_preview');
        
        // Loading elements
        const studentsLoading = document.getElementById('students_loading');
        const lessonsLoading = document.getElementById('lessons_loading');
        
        // State
        let currentClassroomId = null;

        // =============================================
        // Progress Input Sync (Slider & Number Input)
        // =============================================
        function updateProgress(value) {
            value = Math.min(25, Math.max(0, parseInt(value) || 0));
            
            if (progressSlider) progressSlider.value = value;
            if (progressValue) progressValue.value = value;
            
            if (progressPreview) {
                progressPreview.textContent = value + '%';
                
                if (value === 0) {
                    progressPreview.className = 'text-sm font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-700';
                } else if (value <= 5) {
                    progressPreview.className = 'text-sm font-medium px-3 py-1 rounded-full bg-red-100 text-red-700';
                } else if (value <= 10) {
                    progressPreview.className = 'text-sm font-medium px-3 py-1 rounded-full bg-yellow-100 text-yellow-700';
                } else if (value <= 20) {
                    progressPreview.className = 'text-sm font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-700';
                } else {
                    progressPreview.className = 'text-sm font-medium px-3 py-1 rounded-full bg-green-100 text-green-700';
                }
            }
            
            if (progressSlider) {
                const percentage = (value / 25) * 100;
                progressSlider.style.background = `linear-gradient(to right, #3b82f6 0%, #3b82f6 ${percentage}%, #e5e7eb ${percentage}%, #e5e7eb 100%)`;
            }
        }
        
        // Slider event
        if (progressSlider) {
            progressSlider.addEventListener('input', function() {
                updateProgress(this.value);
            });
            updateProgress(progressSlider.value);
        }
        
        // Number input event
        if (progressValue) {
            progressValue.addEventListener('input', function() {
                let value = parseInt(this.value);
                if (isNaN(value)) value = 0;
                if (value > 25) value = 25;
                if (value < 0) value = 0;
                updateProgress(value);
            });
        }

        // Character Counter
        noteContent.addEventListener('input', function() {
            const count = this.value.length;
            characterCount.textContent = `${count} حرف`;
            
            if (count === 0) {
                characterCount.className = 'text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full';
            } else if (count > 0 && count <= 500) {
                characterCount.className = 'text-sm text-green-600 px-3 py-1 bg-green-100 rounded-full';
            } else if (count > 500 && count <= 1000) {
                characterCount.className = 'text-sm text-blue-600 px-3 py-1 bg-blue-100 rounded-full';
            } else {
                characterCount.className = 'text-sm text-yellow-600 px-3 py-1 bg-yellow-100 rounded-full';
            }
            
            if (count > 19000) {
                characterCount.className = 'text-sm text-red-600 px-3 py-1 bg-red-100 rounded-full';
            }
        });

        noteContent.dispatchEvent(new Event('input'));

        // Classroom Change - Load Students
        classroomSelect.addEventListener('change', async function() {
            const classroomId = this.value;
            currentClassroomId = classroomId;
            
            if (!classroomId) {
                resetStudentSelect();
                resetLessonSelect();
                return;
            }
            
            resetStudentSelect();
            showStudentsLoading(true);
            
            try {
                const response = await fetch(`/ajax/get-classroom-students/${classroomId}`);
                const data = await response.json();
                
                if (data.success) {
                    populateStudentSelect(data.students);
                } else {
                    throw new Error('فشل في تحميل بيانات الطلاب');
                }
            } catch (error) {
                console.error('Error:', error);
                studentSelect.innerHTML = '<option value="">خطأ في تحميل البيانات</option>';
                studentSelect.disabled = true;
            } finally {
                showStudentsLoading(false);
            }
        });

        // Student Change - Load Lessons WITHOUT existing notes
        studentSelect.addEventListener('change', async function() {
            const studentId = this.value;
            
            if (!studentId) {
                resetLessonSelect();
                return;
            }
            
            // Reset and disable lesson select while loading
            lessonSelect.innerHTML = '<option value="">جاري تحميل الدروس...</option>';
            lessonSelect.disabled = true;
            showLessonsLoading(true);
            
            try {
                // Fetch lessons that don't have interaction notes for this student
                const response = await fetch(`/ajax/get-lessons-without-notes/${studentId}`);
                const data = await response.json();
                
                if (data.success && data.lessons && data.lessons.length > 0) {
                    lessonSelect.innerHTML = '<option value="">اختر الدرس...</option>';
                    data.lessons.forEach(lesson => {
                        const option = document.createElement('option');
                        option.value = lesson.id;
                        option.textContent = lesson.title;
                        lessonSelect.appendChild(option);
                    });
                    lessonSelect.disabled = false;
                } else {
                    lessonSelect.innerHTML = '<option value="">⚠️ لا توجد دروس متاحة (جميع الدروس لها ملاحظات)</option>';
                    lessonSelect.disabled = true;
                }
            } catch (error) {
                console.error('Error:', error);
                lessonSelect.innerHTML = '<option value="">خطأ في تحميل الدروس</option>';
                lessonSelect.disabled = true;
            } finally {
                showLessonsLoading(false);
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

        function showStudentsLoading(show) {
            if (studentsLoading) {
                if (show) {
                    studentsLoading.classList.remove('hidden');
                } else {
                    studentsLoading.classList.add('hidden');
                }
            }
        }

        function showLessonsLoading(show) {
            if (lessonsLoading) {
                if (show) {
                    lessonsLoading.classList.remove('hidden');
                } else {
                    lessonsLoading.classList.add('hidden');
                }
            }
        }

        function resetStudentSelect() {
            studentSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            studentSelect.disabled = true;
        }

        function resetLessonSelect() {
            lessonSelect.innerHTML = '<option value="">اختر الطالب أولاً...</option>';
            lessonSelect.disabled = true;
        }

        // Initialize if classroom is already selected
        const initialClassroomId = classroomSelect.value;
        if (initialClassroomId) {
            classroomSelect.dispatchEvent(new Event('change'));
        }

        // Form Validation
        document.getElementById('createNoteForm').addEventListener('submit', function(e) {
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
            
            const progressValueNum = parseInt(progressValue?.value || 0);
            if (progressValueNum < 0 || progressValueNum > 25) {
                e.preventDefault();
                alert('نسبة التقدم يجب أن تكون بين 0% و 25%');
                return false;
            }
            
            const classroomId = classroomSelect.value;
            const studentId = studentSelect.value;
            const lessonId = lessonSelect.value;
            
            if (!classroomId || !studentId || !lessonId) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
                return false;
            }
            
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
    
    #progress_slider {
        -webkit-appearance: none;
        appearance: none;
    }
    
    #progress_slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #3b82f6;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    
    #progress_slider::-webkit-slider-thumb:hover {
        transform: scale(1.2);
    }
    
    #progress_slider::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #3b82f6;
        cursor: pointer;
        border: 2px solid white;
    }
</style>

@endsection