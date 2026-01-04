@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-gray-800">إنشاء تقرير اختبار جديد</h1>
            <a href="{{ route('Exam_Grade.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                العودة إلى التقارير
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-4 shadow-md rounded-lg" role="alert">
            <div class="flex items-center">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-4 shadow-md rounded-lg" role="alert">
            <div class="flex items-center">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold mb-1">حدثت الأخطاء التالية:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
            <form action="{{ route('Exam_Grade.store') }}" method="POST" id="createExamForm">
                @csrf    
                
                <!-- Classroom Selection -->
                <div class="mb-6">
                    <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-1">
                        اختر الصف <span class="text-red-500">*</span>
                    </label>
                    <select id="classroom_id" name="classroom_id" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                        <option value="">اختر الصف...</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">
                                {{ $classroom->class_name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">اختر الصف أولاً لعرض الطلاب والاختبارات الخاصة به</p>
                </div>

                <!-- Student and Exam Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Student Selection -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">
                            اختر التلميذ <span class="text-red-500">*</span>
                        </label>
                        <select id="student_id" name="student_id" required disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                            <option value="">اختر الصف أولاً...</option>
                        </select>
                        <div id="students_loading" class="hidden text-xs text-blue-500 mt-1">
                            جاري تحميل الطلاب...
                        </div>
                        <div id="no_students" class="hidden text-xs text-red-500 mt-1">
                            لا يوجد طلاب في هذا الصف
                        </div>
                    </div>

                    <!-- Exam Selection -->
                    <div>
                        <label for="exam_weecklies_id" class="block text-sm font-medium text-gray-700 mb-1">
                            اختر الاختبار <span class="text-red-500">*</span>
                        </label>
                        <select id="exam_weecklies_id" name="exam_weecklies_id" required disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                            <option value="">اختر الصف أولاً...</option>
                        </select>
                        <div id="exams_loading" class="hidden text-xs text-blue-500 mt-1">
                            جاري تحميل الاختبارات...
                        </div>
                        <div id="no_exams" class="hidden text-xs text-red-500 mt-1">
                            لا يوجد اختبارات لهذا الصف
                        </div>
                    </div>
                </div>

                <!-- Score Input -->
                <div class="mb-6">
                    <label for="exam_total_point" class="block text-sm font-medium text-gray-700 mb-1">
                        مجموع النقاط <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="exam_total_point" id="exam_total_point" 
                           min="0" max="100" step="0.5" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150" 
                           placeholder="أدخل مجموع النقاط (0-100)">
                </div>

                <!-- Teacher Notes -->
                <div class="mb-6">
                    <label for="exam_note" class="block text-sm font-medium text-gray-700 mb-1">
                        ملاحظات الأستاذ <span class="text-red-500">*</span>
                    </label>
                    <textarea id="exam_note" name="exam_note" rows="4" required 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150" 
                              placeholder="أضف ملاحظاتك حول أداء التلميذ في هذا الاختبار..."></textarea>
                </div>

                <!-- Status Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">حالة التقرير</label>
                    <div class="flex gap-6">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="status" value="مسودة" checked
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">
                                حفظ كمسودة
                                <span class="text-xs text-gray-500 block">(يمكنك التعديل لاحقاً)</span>
                            </span>
                        </label>
                        
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="status" value="مرسل_للإدارة"
                                   class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                            <span class="text-sm font-medium text-gray-700">
                                إرسال للإدارة
                                <span class="text-xs text-gray-500 block">(لا يمكن التعديل بعد الإرسال)</span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('Exam_Grade.index') }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                        إلغاء والعودة
                    </a>
                    
                    <div class="flex gap-3">
                        <button type="submit" name="action" value="save"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            حفظ التقرير
                        </button>
                    </div>
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
        const examSelect = document.getElementById('exam_weecklies_id');
        const studentsLoading = document.getElementById('students_loading');
        const examsLoading = document.getElementById('exams_loading');
        const noStudents = document.getElementById('no_students');
        const noExams = document.getElementById('no_exams');
        
        // Auto-resize textarea
        const textarea = document.getElementById('exam_note');
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
        
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Confirm before sending to management
        const sendRadio = document.querySelector('input[value="مرسل_للإدارة"]');
        if (sendRadio) {
            sendRadio.addEventListener('change', function() {
                if (this.checked && !confirm('هل أنت متأكد من إرسال التقرير للإدارة؟ بعد الإرسال لا يمكنك تعديل التقرير.')) {
                    document.querySelector('input[value="مسودة"]').checked = true;
                }
            });
        }

        // Validate score input
        const scoreInput = document.getElementById('exam_total_point');
        scoreInput.addEventListener('input', function() {
            let value = parseFloat(this.value);
            if (value < 0) {
                this.value = 0;
            } else if (value > 100) {
                this.value = 100;
            }
        });

        // Load classroom data when classroom changes
        classroomSelect.addEventListener('change', function() {
            const classroomId = this.value;
            
            if (!classroomId) {
                // Reset everything
                resetSelects();
                return;
            }
            
            // Show loading
            studentsLoading.classList.remove('hidden');
            examsLoading.classList.remove('hidden');
            noStudents.classList.add('hidden');
            noExams.classList.add('hidden');
            
            studentSelect.disabled = true;
            examSelect.disabled = true;
            
            // Fetch classroom data (students + exams)
            fetch(`/ajax/get-classroom-data/${classroomId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    studentsLoading.classList.add('hidden');
                    examsLoading.classList.add('hidden');
                    
                    if (data.success) {
                        // Handle students
                        if (data.students && data.students.length > 0) {
                            populateSelect(studentSelect, data.students, 'اختر التلميذ...');
                            studentSelect.disabled = false;
                        } else {
                            studentSelect.innerHTML = '<option value="">لا يوجد طلاب</option>';
                            studentSelect.disabled = true;
                            noStudents.classList.remove('hidden');
                        }
                        
                        // Handle exams
                        if (data.exams && data.exams.length > 0) {
                            populateSelect(examSelect, data.exams, 'اختر الاختبار...', 'id', 'title');
                            examSelect.disabled = false;
                        } else {
                            examSelect.innerHTML = '<option value="">لا يوجد اختبارات</option>';
                            examSelect.disabled = true;
                            noExams.classList.remove('hidden');
                        }
                    } else {
                        showError('حدث خطأ في تحميل البيانات');
                    }
                })
                .catch(error => {
                    studentsLoading.classList.add('hidden');
                    examsLoading.classList.add('hidden');
                    showError('فشل في تحميل البيانات');
                    console.error('Error:', error);
                });
        });

        // Helper function to populate select
        function populateSelect(select, data, defaultText, idField = 'id', nameField = 'name') {
            select.innerHTML = `<option value="">${defaultText}</option>`;
            
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[idField];
                option.textContent = item[nameField];
                select.appendChild(option);
            });
        }

        // Helper function to reset selects
        function resetSelects() {
            studentSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            examSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            
            studentSelect.disabled = true;
            examSelect.disabled = true;
            
            noStudents.classList.add('hidden');
            noExams.classList.add('hidden');
        }

        // Helper function to show error
        function showError(message) {
            studentSelect.innerHTML = `<option value="">${message}</option>`;
            examSelect.innerHTML = `<option value="">${message}</option>`;
            
            studentSelect.disabled = true;
            examSelect.disabled = true;
        }

        // Form validation
        const form = document.getElementById('createExamForm');
        form.addEventListener('submit', function(e) {
            const studentId = studentSelect.value;
            const examId = examSelect.value;
            const score = document.getElementById('exam_total_point').value;
            
            // Validate student
            if (!studentId || studentSelect.disabled) {
                e.preventDefault();
                alert('يرجى اختيار تلميذ صحيح');
                studentSelect.focus();
                return false;
            }
            
            // Validate exam
            if (!examId || examSelect.disabled) {
                e.preventDefault();
                alert('يرجى اختيار اختبار');
                examSelect.focus();
                return false;
            }
            
            // Validate score
            if (!score || score < 0 || score > 100) {
                e.preventDefault();
                alert('يرجى إدخال درجة صحيحة بين 0 و 100');
                document.getElementById('exam_total_point').focus();
                return false;
            }
            
            // Additional validation if needed
            const classroomId = classroomSelect.value;
            if (!classroomId) {
                e.preventDefault();
                alert('يرجى اختيار صف');
                classroomSelect.focus();
                return false;
            }
        });
    });
</script>

<style>
    input[type="radio"]:checked + span {
        font-weight: bold;
    }
    
    textarea {
        resize: none;
        min-height: 100px;
    }
    
    select, input, textarea {
        transition: all 0.15s ease-in-out;
    }
    
    select:focus, input:focus, textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    select:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #f9fafb;
    }
    
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

@endsection