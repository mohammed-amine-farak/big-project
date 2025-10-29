@extends('layouts.teacher_dashboard')

@section('content')
<div class="flex-1 p-6 lg:p-10 main-content-area">
    <div class="main-content-container">
        <h2 class="text-3xl font-bold mb-8 text-blue-900 text-center lg:text-right">
            تسجيل تقدم طالب في درس
        </h2>

        {{-- Start Form UI --}}
        <form action="{{route('student_progress.store')}}" 
              method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- حقل اختيار التلميذ --}}
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">
                    اختر التلميذ
                </label>
                <select id="student_id" name="student_id" required 
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- اختر تلميذًا --</option>
                    {{-- هذا الجزء يتطلب تمرير $students من المتحكم --}}
                    @foreach ($results as $result)
                   
                        <option value="{{ $result->id }}">{{ $result->name }}</option>
                    
                @endforeach
                </select>
                {{-- @error('student_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            {{-- حقل اختيار الدرس --}}
            <div>
                <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-1">اختر الدرس</label>
                <select id="lesson_id" name="lesson_id" required 
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- اختر درسًا --</option>
                    {{-- هذا الجزء يتطلب تمرير $lessons من المتحكم --}}
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }} ({{ $lesson->subject ?? 'غير محدد' }})</option>
                    @endforeach
                </select>
                {{-- @error('lesson_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            {{-- حقل نسبة الإنجاز الأولية مع شريط التقدم --}}
            <div>
                <label for="completion_percentage" class="block text-sm font-medium text-gray-700 mb-1">
                    نسبة الإنجاز الأولية (%)
                </label>
                <input 
                    type="number" 
                    id="completion_percentage" 
                    name="completion_percentage" 
                    min="0" 
                    max="100" 
                    value="0" 
                    oninput="updateProgressBar(this.value, 'lesson_progress_bar', 'lesson_progress_text')"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-center"
                >
                <div class="relative pt-1 mt-2">
                    <div class="overflow-hidden h-6 text-xs flex rounded bg-blue-200 border-2 border-blue-400">
                        <div 
                            id="lesson_progress_bar" 
                            style="width:0%" 
                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 transition-all duration-300 ease-in-out">
                        </div>
                    </div>
                    <div id="lesson_progress_text" class="text-sm font-bold absolute inset-0 flex items-center justify-center text-blue-900">
                        0%
                    </div>
                </div>
                {{-- @error('completion_percentage')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            {{-- زر الحفظ --}}
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-bold hover:bg-blue-700 transition duration-300 w-full">
                    حفظ تقدم الطالب
                </button>
            </div>
        </form>
        {{-- End Form UI --}}

    </div>
</div>

<script>
    function updateProgressBar(value, progressBarId, progressTextId) {
        let progress = Math.max(0, Math.min(100, parseInt(value) || 0));
        document.getElementById(progressBarId).style.width = progress + '%';
        document.getElementById(progressTextId).innerText = progress + '%';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialValue = document.getElementById('completion_percentage').value;
        updateProgressBar(initialValue, 'lesson_progress_bar', 'lesson_progress_text');
    });
</script>

@endsection