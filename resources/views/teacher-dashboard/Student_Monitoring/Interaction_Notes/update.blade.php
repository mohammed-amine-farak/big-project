@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl">
        <div class="p-8">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">تحديت
                     ملاحظة تفاعل جديدة 📝</h1>
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; العودة
                </a>
            </div>

            <form action="{{route('Interaction_Notes_student.edit',$interaction_notes_student->interaction__notes_id)}}" method="POST" class="space-y-6">
               
                @method('PUT')
                 @csrf
               
                {{-- حقل اختيار التلميذ --}}
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">
                        اختر التلميذ:
                    </label>
                    <select id="student_id" name="student_id" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="{{$interaction_notes_student->student_id}}">{{$interaction_notes_student->student_name}}</option>
                     
                       @foreach ($results as $result)
                   
                        <option value="{{ $result->id }}">{{ $result->name }}</option>
                    
                @endforeach
                    </select>
                    @error('student_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- حقل اختيار الدرس --}}
                <div>
                    <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-1">
                        اختر الدرس:
                    </label>
                    <select id="lesson_id" name="lesson_id" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="{{$interaction_notes_student->interaction__notes_lesson_id}}">{{$interaction_notes_student->lesson_title}}</option>
                        @foreach ($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->title }}
                            </option>
                        @endforeach 
                    </select>
                    @error('lesson_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- حقل ملاحظة التفاعل --}}
                <div>
                    <label for="note_content" class="block text-sm font-medium text-gray-700 mb-1">
                        ملاحظة المعلم:
                    </label>
                    <textarea id="note_content" name="note_content" rows="6" required
                        
                              class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                              placeholder="اكتب ملاحظاتك حول تفاعل الطالب في هذا الدرس هنا...">{{$interaction_notes_student->note_content}}</textarea>
                    @error('note_content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- زر الإرسال --}}
                <div>
                    <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-md hover:bg-blue-700 transition duration-300">
                        حفظ الملاحظة
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection