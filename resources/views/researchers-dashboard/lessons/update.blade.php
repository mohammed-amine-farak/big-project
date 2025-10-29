@extends('layouts.reseacher_dashboard')
@section('content')
<div class="flex-1 p-6 lg:p-10 main-content-area">
    <div class="main-content-container">
        <h2 class="text-3xl font-bold mb-8 text-blue-900">تعديل درس جديد</h2>

        <form method="POST" action="{{ route('lessons.edit', $lesson->id) }}"  class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان الدرس</label>
                <input value="{{$lesson->title}}" type="text" id="title" name="title" required class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">وصف الدرس</label>
                <textarea   id="description" name="content" rows="4" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{$lesson->content}}</textarea>
            </div>

            <div>
          <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">المادة</label>
                <select id="subject_id" name="subject_id" required
                class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="{{$lesson->subject->id}}" class="text-gray-400">{{$lesson->subject->name}}-{{ $lesson->subject->fieldOfStudy->name}}-{{ $lesson->subject->fieldOfStudy->study_level}}</option>
                @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" class="text-gray-700">
                    {{ $subject->name }} - {{ $subject->fieldOfStudy->name }} - {{ $subject->fieldOfStudy->study_level }}
                </option>
            @endforeach
            </select>
            </div>

           

            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-bold hover:bg-blue-700 transition duration-300">
                    حفظ الدرس
                </button>
            </div>
        </form>
    </div>
</div>

@endsection