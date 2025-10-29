

@extends('layouts.reseacher_dashboard')

@section('content')
<div class="flex-1 p-6 lg:p-10 main-content-area">
    <div class="main-content-container">
        <h1 class="text-3xl font-bold mb-8 text-blue-900">Add New Rule</h1>

        <form method="POST" action="{{route('rules.store')}}" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
    
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" id="title" required class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
    
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">description</label>
                <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            </div>
            <div>
                <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-1">Select Lesson</label>
                <select name="lessons_id" id="lesson_id" required class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Choose a Lesson --</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }} ({{ $lesson->grade_level }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Save Rule</button>
        </form>
    </div>
    
</div>
@endsection

