{{-- resources/views/admin/classrooms/edit.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">✏️ تعديل الفصل الدراسي</h1>
                    <p class="text-gray-600 text-sm">قم بتعديل البيانات الأساسية للفصل الدراسي</p>
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

        <!-- Warning Message -->
        <div class="bg-blue-50 border-r-4 border-blue-500 p-4 mb-6 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 ml-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-800">ملاحظة هامة</p>
                    <p class="text-sm text-blue-700 mt-1">لا يمكن تعديل المعلم أو المادة بعد إنشاء الفصل للحفاظ على سلامة البيانات الأكاديمية.</p>
                </div>
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

        <!-- Form -->
        <form action="{{ route('admin.classrooms.update', $classroom) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">📋 المعلومات الأساسية</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Class Name (English) -->
                        <div>
                            <label for="class_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                اسم الفصل (بالإنجليزية) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="class_name" 
                                   id="class_name" 
                                   value="{{ old('class_name', $classroom->class_name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="مثال: Math_Class_A"
                                   required>
                            @error('class_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Class Name (Arabic) -->
                        <div>
                            <label for="class_name_ar" class="block text-sm font-semibold text-gray-700 mb-2">
                                اسم الفصل (بالعربية) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="class_name_ar" 
                                   id="class_name_ar" 
                                   value="{{ old('class_name_ar', $classroom->class_name_ar) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="مثال: فصل الرياضيات أ"
                                   required>
                            @error('class_name_ar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Grade Level -->
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
                                    <option value="{{ $level }}" {{ old('grade_level', $classroom->grade_level) == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade_level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Max Students -->
                        <div>
                            <label for="max_students" class="block text-sm font-semibold text-gray-700 mb-2">
                                الحد الأقصى للطلاب <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="max_students" 
                                   id="max_students" 
                                   value="{{ old('max_students', $classroom->max_students) }}"
                                   min="1"
                                   max="100"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @php
                                $currentEnrolled = App\Models\student_classroom::where('classroom_id', $classroom->id)->count();
                            @endphp
                            <p class="text-xs text-gray-500 mt-1">عدد الطلاب المسجلين حالياً: <strong>{{ $currentEnrolled }}</strong></p>
                            <p class="text-xs text-yellow-600 mt-1">⚠️ لا يمكن تقليل العدد عن عدد الطلاب المسجلين حالياً ({{ $currentEnrolled }})</p>
                            @error('max_students')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- School and Study Year Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">🏫 معلومات المدرسة والسنة الدراسية</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Study Year -->
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
                                    <option value="{{ $year->id }}" {{ old('study_year_id', $classroom->study_year_id) == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name_ar }}
                                    </option>
                                @endforeach
                            </select>
                            @error('study_year_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- School -->
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
                                    <option value="{{ $school->id }}" {{ old('school_id', $classroom->school_id) == $school->id ? 'selected' : '' }}>
                                        {{ $school->name ?? 'غير معروف' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Teacher and Subject Information (READ-ONLY) -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">👨‍🏫 معلومات المعلم والمادة (غير قابلة للتعديل)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Teacher (Read-only) -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                المعلم
                            </label>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $classroom->teacher->user->name ?? 'غير معروف' }}</p>
                                    <p class="text-xs text-gray-500">تخصص: {{ $classroom->teacher->subject ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                            <!-- Hidden input to keep the teacher_id in the form -->
                            <input type="hidden" name="teacher_id" value="{{ $classroom->teacher_id }}">
                            <p class="text-xs text-gray-400 mt-2">لا يمكن تغيير المعلم بعد إنشاء الفصل</p>
                        </div>
                        
                        <!-- Subject (Read-only) -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                المادة
                            </label>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $classroom->subjects->name ?? 'غير معروف' }}</p>
                                    <p class="text-xs text-gray-500">المجال: {{ $classroom->subjects->fieldOfStudy->name ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                            <!-- Hidden input to keep the subject_id in the form -->
                            <input type="hidden" name="subject_id" value="{{ $classroom->subject_id }}">
                            <p class="text-xs text-gray-400 mt-2">لا يمكن تغيير المادة بعد إنشاء الفصل</p>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">📝 وصف الفصل</h3>
                    <div>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="أدخل وصفاً مفصلاً للفصل الدراسي...">{{ old('description', $classroom->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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
                                   {{ old('is_active', $classroom->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="mr-3 text-sm font-medium text-gray-700">فعال</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">إذا كان الفصل غير فعال، لن يتمكن الطلاب من التسجيل فيه</p>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end gap-3 p-6 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.classrooms.index') }}" 
                   class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    إلغاء
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    تحديث الفصل الدراسي
                </button>
            </div>
        </form>
    </div>
</div>
@endsection