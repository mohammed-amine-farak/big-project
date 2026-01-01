@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('StudentPsychology.index') }}" 
                           class="text-gray-500 hover:text-gray-700 transition duration-200 flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة للتقارير
                        </a>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">🧠 تقرير نفسي جديد</h1>
                    <p class="text-gray-600 text-sm">إنشاء تقرير نفسي وسلوكي جديد للطالب</p>
                </div>
            </div>
        </div>

        @if($classrooms->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">لا يوجد صفوف</h3>
                <p class="text-gray-600 mb-4">ليس لديك صفوف مدرسية.</p>
                <a href="{{ route('StudentPsychology.index') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200">
                    العودة للقائمة
                </a>
            </div>
        @else
            @if ($errors->any())
                <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="fill-current h-5 w-5 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 1 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm mb-1">حدثت الأخطاء التالية:</p>
                            <ul class="list-disc list-inside text-xs space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Create Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('StudentPsychology.store') }}" method="POST" class="p-5" id="psychologyForm">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                            <span class="text-blue-600">1.</span> المعلومات الأساسية
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Classroom Selection -->
                            <div>
                                <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    الصف <span class="text-red-500">*</span>
                                </label>
                                <select name="classroom_id" id="classroom_id" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">اختر الصف أولاً</option>
                                    @foreach($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}" 
                                                {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                            {{ $classroom->class_name }} - {{$classroom->subjects->name }} - {{$classroom->subjects->fieldOfStudy->study_level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Student Selection (Initially disabled) -->
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    الطالب <span class="text-red-500">*</span>
                                </label>
                                <select name="student_id" id="student_id" required disabled
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-gray-50">
                                    <option value="">الرجاء اختيار الصف أولاً</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1" id="student-help">يجب اختيار الصف أولاً لتظهر قائمة الطلاب</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rest of your form (same as before) -->
                    <!-- Psychological Assessment -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                            <span class="text-blue-600">2.</span> التقييم النفسي والسلوكي
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Mood -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    المزاج العام <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                                    @php
                                        $moods = [
                                            'مبتهج' => '😊',
                                            'هادئ' => '😐', 
                                            'قلق' => '😟',
                                            'حزين' => '😢',
                                            'غاضب' => '😠',
                                            'متحمس' => '🤩'
                                        ];
                                    @endphp
                                    @foreach($moods as $value => $icon)
                                        <label class="relative">
                                            <input type="radio" name="mood" value="{{ $value }}"
                                                   {{ old('mood', 'هادئ') == $value ? 'checked' : '' }}
                                                   class="sr-only peer" required>
                                            <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-3 text-center cursor-pointer 
                                                        hover:bg-gray-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 
                                                        transition duration-200">
                                                <div class="text-2xl mb-1">{{ $icon }}</div>
                                                <span class="text-sm font-medium">{{ $value }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Social Interaction -->
                            <div>
                                <label for="social_interaction" class="block text-sm font-medium text-gray-700 mb-2">
                                    التفاعل الاجتماعي <span class="text-red-500">*</span>
                                </label>
                                <select name="social_interaction" id="social_interaction" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">اختر مستوى التفاعل</option>
                                    <option value="منطوي" {{ old('social_interaction') == 'منطوي' ? 'selected' : '' }}>منطوي</option>
                                    <option value="متواصل_بشكل_معتدل" {{ old('social_interaction', 'متواصل_بشكل_معتدل') == 'متواصل_بشكل_معتدل' ? 'selected' : '' }}>متواصل بشكل معتدل</option>
                                    <option value="اجتماعي" {{ old('social_interaction') == 'اجتماعي' ? 'selected' : '' }}>اجتماعي</option>
                                    <option value="قائد_مجموعة" {{ old('social_interaction') == 'قائد_مجموعة' ? 'selected' : '' }}>قائد مجموعة</option>
                                </select>
                            </div>
                            
                            <!-- Concentration -->
                            <div>
                                <label for="concentration" class="block text-sm font-medium text-gray-700 mb-2">
                                    التركيز والانتباه <span class="text-red-500">*</span>
                                </label>
                                <select name="concentration" id="concentration" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">اختر مستوى التركيز</option>
                                    <option value="ضعيف" {{ old('concentration') == 'ضعيف' ? 'selected' : '' }}>ضعيف</option>
                                    <option value="متوسط" {{ old('concentration', 'متوسط') == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                                    <option value="جيد" {{ old('concentration') == 'جيد' ? 'selected' : '' }}>جيد</option>
                                    <option value="ممتاز" {{ old('concentration') == 'ممتاز' ? 'selected' : '' }}>ممتاز</option>
                                </select>
                            </div>
                            
                            <!-- Participation -->
                            <div>
                                <label for="participation" class="block text-sm font-medium text-gray-700 mb-2">
                                    المشاركة الفعالة <span class="text-red-500">*</span>
                                </label>
                                <select name="participation" id="participation" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">اختر مستوى المشاركة</option>
                                    <option value="سلبي" {{ old('participation') == 'سلبي' ? 'selected' : '' }}>سلبي</option>
                                    <option value="مشارك_أحياناً" {{ old('participation', 'مشارك_أحياناً') == 'مشارك_أحياناً' ? 'selected' : '' }}>مشارك أحياناً</option>
                                    <option value="نشط" {{ old('participation') == 'نشط' ? 'selected' : '' }}>نشط</option>
                                    <option value="مبادر" {{ old('participation') == 'مبادر' ? 'selected' : '' }}>مبادر</option>
                                </select>
                            </div>
                            
                            <!-- Behavior -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    السلوك العام <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                                    @php
                                        $behaviors = [
                                            'ممتاز' => '⭐',
                                            'جيد' => '👍',
                                            'مقبول' => '👌',
                                            'يحتاج_تحسين' => '📝'
                                        ];
                                    @endphp
                                    @foreach($behaviors as $value => $icon)
                                        <label class="relative">
                                            <input type="radio" name="behavior" value="{{ $value }}"
                                                   {{ old('behavior', 'جيد') == $value ? 'checked' : '' }}
                                                   class="sr-only peer" required>
                                            <div class="border-2 border-gray-200 rounded-lg p-4 text-center cursor-pointer 
                                                        hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 
                                                        transition duration-200">
                                                <div class="text-2xl mb-2">{{ $icon }}</div>
                                                <span class="font-medium">{{ $value }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                            <span class="text-blue-600">3.</span> الملاحظات والتوصيات
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Strengths -->
                            <div>
                                <label for="strengths" class="block text-sm font-medium text-gray-700 mb-2">
                                    نقاط القوة
                                </label>
                                <textarea name="strengths" id="strengths" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                          placeholder="ما هي نقاط القوة والصفات الإيجابية للطالب؟">{{ old('strengths') }}</textarea>
                            </div>
                            
                            <!-- Challenges -->
                            <div>
                                <label for="challenges" class="block text-sm font-medium text-gray-700 mb-2">
                                    التحديات والصعوبات
                                </label>
                                <textarea name="challenges" id="challenges" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                          placeholder="ما هي التحديات والصعوبات التي يواجهها الطالب؟">{{ old('challenges') }}</textarea>
                            </div>
                            
                            <!-- Recommendations -->
                            <div>
                                <label for="recommendations" class="block text-sm font-medium text-gray-700 mb-2">
                                    التوصيات والمقترحات
                                </label>
                                <textarea name="recommendations" id="recommendations" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                          placeholder="ما هي توصياتك لتحسين حالة الطالب؟">{{ old('recommendations') }}</textarea>
                            </div>
                            
                            <!-- General Notes -->
                            <div>
                                <label for="general_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    ملاحظات عامة
                                </label>
                                <textarea name="general_notes" id="general_notes" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                          placeholder="ملاحظات عامة إضافية...">{{ old('general_notes') }}</textarea>
                            </div>
                            
                            <!-- Teacher's Personal Note -->
                            <div>
                                <label for="teacher_note" class="block text-sm font-medium text-gray-700 mb-2">
                                    ملاحظة المعلم الشخصية
                                </label>
                                <textarea name="teacher_note" id="teacher_note" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                          placeholder="ملاحظتك الشخصية...">{{ old('teacher_note') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Status Selection -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                            <span class="text-blue-600">4.</span> حالة التقرير
                        </h3>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="status" value="مسودة" 
                                       {{ old('status', 'مسودة') == 'مسودة' ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="mr-2 text-sm font-medium text-gray-700">
                                    حفظ كمسودة
                                    <span class="text-xs text-gray-500 block">(يمكنك التعديل لاحقاً)</span>
                                </span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="radio" name="status" value="مرسل_للإدارة"
                                       {{ old('status') == 'مرسل_للإدارة' ? 'checked' : '' }}
                                       class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                <span class="mr-2 text-sm font-medium text-gray-700">
                                    إرسال للإدارة
                                    <span class="text-xs text-gray-500 block">(لا يمكن التعديل بعد الإرسال)</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('StudentPsychology.index') }}" 
                           class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg transition duration-200 text-center">
                            إلغاء والعودة
                        </a>
                        
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button type="submit" name="action" value="save"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                حفظ التقرير
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
    // Store all students data grouped by classroom
    const studentsByClassroom = @json($classrooms->mapWithKeys(function($classroom) {
        return [
            $classroom->id => $classroom->students->map(function($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->name ?? $student->name
                ];
            })
        ];
    }));
    
    // Function to populate students dropdown based on selected classroom
    function populateStudents(classroomId) {
        const studentSelect = document.getElementById('student_id');
        const studentHelp = document.getElementById('student-help');
        
        // Clear current options
        studentSelect.innerHTML = '<option value="">اختر الطالب</option>';
        
        if (!classroomId) {
            // If no classroom selected, disable student dropdown
            studentSelect.disabled = true;
            studentSelect.classList.add('bg-gray-50');
            studentHelp.textContent = 'يجب اختيار الصف أولاً لتظهر قائمة الطلاب';
            return;
        }
        
        // Get students for this classroom
        const students = studentsByClassroom[classroomId] || [];
        
        if (students.length === 0) {
            // No students in this classroom
            studentSelect.disabled = true;
            studentSelect.classList.add('bg-gray-50');
            const option = document.createElement('option');
            option.value = "";
            option.textContent = "لا يوجد طلاب في هذا الصف";
            option.disabled = true;
            studentSelect.appendChild(option);
            studentHelp.textContent = 'لا يوجد طلاب مسجلين في هذا الصف';
        } else {
            // Populate students
            studentSelect.disabled = false;
            studentSelect.classList.remove('bg-gray-50');
            
            students.forEach(student => {
                const option = document.createElement('option');
                option.value = student.id;
                option.textContent = student.name;
                studentSelect.appendChild(option);
            });
            
            // Select old value if exists
            const oldStudentId = "{{ old('student_id') }}";
            if (oldStudentId) {
                studentSelect.value = oldStudentId;
            }
            
            studentHelp.textContent = `${students.length} طالب متاح للاختيار`;
        }
    }
    
    // Event listener for classroom change
    document.getElementById('classroom_id').addEventListener('change', function() {
        const classroomId = this.value;
        populateStudents(classroomId);
    });
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialClassroomId = "{{ old('classroom_id') }}";
        
        if (initialClassroomId) {
            // If there's an old classroom value from validation errors
            document.getElementById('classroom_id').value = initialClassroomId;
            populateStudents(initialClassroomId);
        } else {
            // Otherwise, ensure student dropdown is disabled
            document.getElementById('student_id').disabled = true;
        }
        
        // Auto-resize textareas
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }
        
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                autoResize(this);
            });
            // Initial resize
            setTimeout(() => autoResize(textarea), 100);
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
    });
    
    // Form validation
    document.getElementById('psychologyForm').addEventListener('submit', function(e) {
        const studentSelect = document.getElementById('student_id');
        
        if (studentSelect.disabled || studentSelect.value === "") {
            e.preventDefault();
            alert('الرجاء اختيار طالب من القائمة');
            studentSelect.focus();
        }
    });
</script>

<style>
    input[type="radio"]:checked + div {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    @media (max-width: 640px) {
        .grid-cols-6 {
            grid-template-columns: repeat(3, 1fr);
        }
        .grid-cols-4 {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    textarea {
        resize: none;
        min-height: 100px;
    }
    
    select:disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }
</style>
@endsection