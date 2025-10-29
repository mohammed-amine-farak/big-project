@extends('layouts.reseacher_dashboard')

@section('content')
<div class="mx-auto mt-12 px-6" style="max-width: 80%;">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">
            📝 تعديل مثال للقاعدة: <span class="text-blue-700">{{ $rule->title }}</span>
        </h1>
        <a href="{{ route('Example.index', $rule->id) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
            العودة إلى أمثلة القاعدة
        </a>
    </div>

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

    <div class="bg-white rounded-2xl shadow-xl p-8">
        {{-- The form action points to the 'update' route and uses the PUT method --}}
        <form action="{{route('Example.update',['rule' => $rule->id, 'example' => $example->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- This spoofs the PUT method for updates --}}

            <div class="mb-6">
                <label for="example_title" class="block text-gray-700 text-lg font-bold mb-2">عنوان المثال:</label>
                <input type="text" name="example_title" id="example_title"
                       class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       value="{{ old('example_title', $example->example_title) }}" required>
                @error('example_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="example_text" class="block text-gray-700 text-lg font-bold mb-2">نص المثال:</label>
                <textarea name="example_text" id="example_text" rows="6"
                          class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          required>{{ old('example_text', $example->example_text) }}</textarea>
                @error('example_text')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="example_description" class="block text-gray-700 text-lg font-bold mb-2">وصف المثال (اختياري):</label>
                <textarea name="example_description" id="example_description" rows="3"
                          class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >{{ old('example_description', $example->example_description) }}</textarea>
                @error('example_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Optional: Show the existing image and allow it to be replaced --}}
            @if ($example->image_url)
                <div class="mb-4">
                    <label class="block text-gray-700 text-lg font-bold mb-2">الصورة الحالية:</label>
                    {{-- Use Storage::url() to get the public URL for the stored image --}}
                    <img src="{{ Storage::url($example->image_url) }}" alt="{{ $example->image_alt_ar ?? '' }}" class="rounded-lg shadow-md max-w-sm">
                </div>
            @endif

            <div class="mb-6">
                <label for="image_url" class="block text-gray-700 text-lg font-bold mb-2">صورة المثال (اختياري، ارفع صورة جديدة لاستبدال الحالية):</label>
                <input type="file" name="image_url" id="image_url"
                       class="block w-full text-lg text-gray-700
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image_alt_ar" class="block text-gray-700 text-lg font-bold mb-2">وصف الصورة (للوصول وتحسين محركات البحث) (اختياري):</label>
                <input type="text" name="image_alt_ar" id="image_alt_ar"
                       class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       value="{{ old('image_alt_ar', $example->image_alt_ar) }}">
                @error('image_alt_ar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image_caption_ar" class="block text-gray-700 text-lg font-bold mb-2">تعليق الصورة (اختياري):</label>
                <input type="text" name="image_caption_ar" id="image_caption_ar"
                       class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       value="{{ old('image_caption_ar', $example->image_caption_ar) }}">
                @error('image_caption_ar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300 focus:outline-none focus:shadow-outline">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
