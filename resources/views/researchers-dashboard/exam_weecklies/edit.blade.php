@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-800">تعديل الامتحان الأسبوعي</h1>
            <a href="{{route('exam_weeckly.index')}}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                العودة إلى الامتحانات
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
            <form action="{{ route('exam_weeklies.update', $exam->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Exam Title Field -->
                <div class="mb-6">
                    <label for="title" class="block text-lg font-medium text-gray-700 mb-2">عنوان الامتحان</label>
                    <input type="text" name="title" id="title" required 
                           value="{{ old('title', $exam->title) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-base p-3 transition duration-150" 
                           placeholder="مثال: امتحان الأسبوع الأول - الرياضيات">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject Field -->
                <div class="mb-6">
                    <label for="subject_id" class="block text-lg font-medium text-gray-700 mb-2">المادة الدراسية</label>
                    <select id="subject_id" name="subject_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-base p-3 transition duration-150">
                        <option value="" class="text-gray-400">-- اختر المادة --</option>
                        @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}
                                class="text-gray-700">
                            {{ $subject->name }} 
                            @if($subject->fieldOfStudy)
                                | {{ $subject->fieldOfStudy->name }} | {{ $subject->fieldOfStudy->study_level ?? 'غير محدد' }}
                            @else
                                | غير محدد
                            @endif
                        </option>
                    @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Classroom Field -->
                <div class="mb-6">
                    <label for="classroom_id" class="block text-lg font-medium text-gray-700 mb-2">الفصل الدراسي</label>
                    <select id="classroom_id" name="classroom_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-base p-3 transition duration-150">
                        <option value="" class="text-gray-400">-- اختر الفصل --</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" 
                                    {{ old('classroom_id', $exam->classroom_id) == $classroom->id ? 'selected' : '' }}
                                    class="text-gray-700">
                                {{ $classroom->class_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload Field -->
                <div class="mb-6">
                    <label for="file_path" class="block text-lg font-medium text-gray-700 mb-2">رفع ملف الامتحان</label>
                    
                    <!-- Current file info -->
                    @if($exam->file_path)
                    <div class="mb-3 p-3 bg-green-50 rounded-lg border border-green-200">
                        <p class="text-sm text-green-700 mb-2">الملف الحالي:</p>
                        <div class="flex items-center justify-between">
                            <a href="{{ Storage::url($exam->file_path) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                عرض الملف الحالي
                            </a>
                            <span class="text-xs text-gray-500">(اختياري) اتركه فارغاً للحفاظ على الملف الحالي</span>
                        </div>
                    </div>
                    @endif

                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md transition duration-150 hover:border-blue-400">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file_path" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>اختر ملف جديد</span>
                                    <input id="file_path" name="file_path" type="file" class="sr-only" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                </label>
                                <p class="pl-1">أو اسحب وأفلت</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PDF, DOC, DOCX, JPG, PNG (الحد الأقصى: 10MB)
                            </p>
                        </div>
                    </div>
                    @error('file_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-4 space-x-reverse">
                    <a href="{{route('exam_weeckly.index')}}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-full shadow-lg transition duration-300">
                        إلغاء
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                        تحديث الامتحان
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log('Edit form script loaded with jQuery');

    // File upload preview
    $('#file_path').change(function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            $('label[for="file_path"] span').text(fileName);
            console.log('New file selected:', fileName);
        }
    });

    // AJAX for filtering classrooms based on subject
    $('#subject_id').change(function() {
        const subjectId = $(this).val();
        const classroomSelect = $('#classroom_id');
        const currentSelected = classroomSelect.val();
        
        console.log('Subject changed to:', subjectId);

        if (!subjectId) {
            classroomSelect.html('<option value="" class="text-gray-400">-- اختر الفصل --</option>');
            return;
        }

        // Show loading state
        classroomSelect.html('<option value="" class="text-gray-400">-- جاري تحميل الفصول --</option>');
        classroomSelect.prop('disabled', true);

        // Make AJAX request with jQuery
        $.ajax({
            url: '{{ route("get.classrooms.by.subject") }}',
            method: 'POST',
            data: {
                subject_id: subjectId,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                console.log('AJAX success, received data:', data);
                
                // Populate classroom select with filtered classrooms
                classroomSelect.html('<option value="" class="text-gray-400">-- اختر الفصل --</option>');
                
                if (data.classrooms && data.classrooms.length > 0) {
                    console.log(`Adding ${data.classrooms.length} classrooms`);
                    
                    data.classrooms.forEach(function(classroom) {
                        const selected = (classroom.id == currentSelected || classroom.id == '{{ old('classroom_id', $exam->classroom_id) }}') ? 'selected' : '';
                        classroomSelect.append(
                            `<option value="${classroom.id}" ${selected} class="text-gray-700">${classroom.class_name}</option>`
                        );
                    });
                } else {
                    console.log('No classrooms found for this subject');
                    classroomSelect.html('<option value="" class="text-gray-400">-- لا توجد فصول لهذه المادة --</option>');
                }
                
                classroomSelect.prop('disabled', false);
                console.log('Classroom select updated successfully');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.log('XHR response:', xhr.responseText);
                classroomSelect.html('<option value="" class="text-gray-400">-- خطأ في تحميل الفصول --</option>');
                classroomSelect.prop('disabled', false);
            }
        });
    });

    // Load classrooms when page loads based on selected subject
    const currentSubjectId = $('#subject_id').val();
    if (currentSubjectId) {
        console.log('Loading classrooms for initial subject:', currentSubjectId);
        $('#subject_id').trigger('change');
    }
});
</script>
<style>
    .border-dashed:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }
    
    input, select, textarea {
        transition: all 0.2s ease-in-out;
    }
    
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }

    select:disabled {
        background-color: #f9fafb;
        color: #6b7280;
        cursor: not-allowed;
    }
</style>
@endsection