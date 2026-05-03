{{-- resources/views/admin/classrooms/create.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">➕ إضافة فصل دراسي جديد</h1>
                    <p class="text-gray-600 text-sm">أدخل بيانات الفصل الدراسي الجديد</p>
                </div>
                <a href="{{ route('admin.classrooms.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm mb-2">يرجى تصحيح الأخطاء التالية:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Validation Message Area -->
        <div id="validation-message" class="hidden mb-6 p-4 rounded-lg shadow-sm"></div>

        <!-- Form -->
        <form action="{{ route('admin.classrooms.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" id="classroomForm">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">📋 المعلومات الأساسية</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="class_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                اسم الفصل (بالإنجليزية) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="class_name" 
                                   id="class_name" 
                                   value="{{ old('class_name') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="مثال: Math_Class_A"
                                   required>
                        </div>
                        
                        <div>
                            <label for="class_name_ar" class="block text-sm font-semibold text-gray-700 mb-2">
                                اسم الفصل (بالعربية) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="class_name_ar" 
                                   id="class_name_ar" 
                                   value="{{ old('class_name_ar') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="مثال: فصل الرياضيات أ"
                                   required>
                        </div>
                        
                        <div>
                            <label for="grade_level" class="block text-sm font-semibold text-gray-700 mb-2">
                                المستوى الدراسي <span class="text-red-500">*</span>
                            </label>
                            <select name="grade_level" 
                                    id="grade_level" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">اختر المستوى الدراسي</option>
                                @foreach($gradeLevels as $level)
                                    <option value="{{ $level }}" {{ old('grade_level') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="max_students" class="block text-sm font-semibold text-gray-700 mb-2">
                                الحد الأقصى للطلاب <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="max_students" 
                                   id="max_students" 
                                   value="{{ old('max_students', 30) }}"
                                   min="1"
                                   max="100"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>
                </div>
                
                <!-- Academic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">🎓 المعلومات الأكاديمية</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="study_year_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                السنة الدراسية <span class="text-red-500">*</span>
                            </label>
                            <select name="study_year_id" 
                                    id="study_year_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">اختر السنة الدراسية</option>
                                @foreach($studyYears as $year)
                                    <option value="{{ $year->id }}" {{ old('study_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="school_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                المدرسة <span class="text-red-500">*</span>
                            </label>
                            <select name="school_id" 
                                    id="school_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">اختر المدرسة</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name ?? 'غير معروف' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Teacher Selection -->
                        <div>
                            <label for="teacher_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                المعلم <span class="text-red-500">*</span>
                            </label>
                            <select name="teacher_id" 
                                    id="teacher_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">اختر المعلم</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" 
                                            data-subject="{{ $teacher->subject }}"
                                            {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name ?? 'غير معروف' }} - (تخصص: {{ $teacher->subject }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1" id="teacher-subject-info"></p>
                        </div>
                        
                        <!-- Subject Selection -->
                        <div>
                            <label for="subject_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                المادة <span class="text-red-500">*</span>
                            </label>
                            <select name="subject_id" 
                                    id="subject_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">اختر المادة</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" 
                                            data-subject-name="{{ $subject->name }}"
                                            {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }} - {{ $subject->fieldOfStudy->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">📝 وصف الفصل</h3>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="أدخل وصفاً مفصلاً للفصل الدراسي...">{{ old('description') }}</textarea>
                </div>
                
                <!-- Status -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">⚙ حالة الفصل</h3>
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   class="sr-only peer"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="mr-3 text-sm font-medium text-gray-700">فعال</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end gap-3 p-6 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.classrooms.index') }}" 
                   class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    إلغاء
                </a>
                <button type="submit" 
                        id="submitBtn"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    حفظ الفصل الدراسي
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const teacherSelect = document.getElementById('teacher_id');
    const subjectSelect = document.getElementById('subject_id');
    const validationMessage = document.getElementById('validation-message');
    const teacherSubjectInfo = document.getElementById('teacher-subject-info');
    const submitBtn = document.getElementById('submitBtn');
    
    function validateTeacherSubject() {
        const teacherId = teacherSelect.value;
        const subjectId = subjectSelect.value;
        
        if (!teacherId || !subjectId) {
            validationMessage.classList.add('hidden');
            teacherSubjectInfo.innerHTML = '';
            submitBtn.disabled = false;
            return;
        }
        
        // Get teacher subject from selected option
        const selectedTeacher = teacherSelect.options[teacherSelect.selectedIndex];
        const teacherSubject = selectedTeacher.getAttribute('data-subject');
        
        // Get subject name from selected option
        const selectedSubject = subjectSelect.options[subjectSelect.selectedIndex];
        const subjectName = selectedSubject.getAttribute('data-subject-name');
        
        if (!teacherSubject || !subjectName) {
            return;
        }
        
        // Compare teacher subject with subject name
        if (teacherSubject === subjectName) {
            validationMessage.className = 'mb-6 p-4 rounded-lg shadow-sm bg-green-100 border-r-4 border-green-500';
            validationMessage.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-sm text-green-700">✓ المعلم "${selectedTeacher.text.split(' -')[0]}" متخصص في مادة "${subjectName}"</p>
                </div>
            `;
            validationMessage.classList.remove('hidden');
            teacherSubjectInfo.innerHTML = `<span class="text-green-600">✓ متخصص في هذه المادة</span>`;
            submitBtn.disabled = false;
        } else {
            validationMessage.className = 'mb-6 p-4 rounded-lg shadow-sm bg-red-100 border-r-4 border-red-500';
            validationMessage.innerHTML = `
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 ml-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <p class="text-sm text-red-700 font-medium">خطأ في تخصص المعلم</p>
                        <p class="text-sm text-red-600 mt-1">المعلم "${selectedTeacher.text.split(' -')[0]}" تخصصه هو "${teacherSubject}"، لكنك اخترت مادة "${subjectName}".</p>
                        <p class="text-sm text-red-600 mt-1">يرجى اختيار معلم متخصص في مادة "${subjectName}" أو اختيار المادة المناسبة لتخصص المعلم.</p>
                    </div>
                </div>
            `;
            validationMessage.classList.remove('hidden');
            teacherSubjectInfo.innerHTML = `<span class="text-red-600">✗ غير متخصص في هذه المادة (تخصصه: ${teacherSubject})</span>`;
            submitBtn.disabled = true;
        }
    }
    
    teacherSelect.addEventListener('change', validateTeacherSubject);
    subjectSelect.addEventListener('change', validateTeacherSubject);
    
    // Display teacher subject info when teacher is selected
    teacherSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const teacherSubject = selectedOption.getAttribute('data-subject');
        if (teacherSubject) {
            teacherSubjectInfo.innerHTML = `<span class="text-gray-600">تخصص المعلم: ${teacherSubject}</span>`;
        } else {
            teacherSubjectInfo.innerHTML = '';
        }
    });
    
    // Trigger validation on page load if both are selected
    if (teacherSelect.value && subjectSelect.value) {
        validateTeacherSubject();
    }
});
</script>
@endpush
@endsection