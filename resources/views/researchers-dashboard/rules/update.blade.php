{{-- resources/views/researchers-dashboard/rules/edit.blade.php --}}

@extends('layouts.reseacher_dashboard')

@section('content')
<div class="flex-1 p-6 lg:p-10 main-content-area">
    <div class="main-content-container">
        <h1 class="text-3xl font-bold mb-8 text-blue-900">تحديث القاعدة: {{ $rule->title }}</h1>

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <strong class="font-bold">عذراً!</strong>
                <span class="block sm:inline">كان هناك بعض المشاكل مع إدخالك.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form for updating the rule --}}
        <form method="POST" action="{{ route('rules.edit', $rule->id) }}" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT') {{-- IMPORTANT: Specify PUT method for updates --}}
    
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $rule->title) }}" {{-- Pre-fill with current title or old input --}}
                       required
                       class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('title')  @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">الوصف</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('description')  @enderror"
                >{{ old('description', $rule->description) }}</textarea> {{-- Pre-fill with current description or old input --}}
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-1">اختر الدرس</label>
                <select name="lessons_id" id="lesson_id" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('lessons_id')  @enderror">
                    <option value="">-- اختر درساً --</option>
                    {{-- Loop over the $lessons collection passed from the controller --}}
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}"
                            {{-- Check if this lesson is currently associated with the rule, or if it was selected in a previous submission --}}
                            {{ (old('lessons_id', $rule->lessons_id) == $lesson->id) ? 'selected' : '' }}
                        >
                            {{ $lesson->title }} ({{ $lesson->grade_level }})
                        </option>
                    @endforeach
                </select>
                @error('lessons_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">حفظ التغييرات</button>
        </form>
    </div>
</div>
@endsection