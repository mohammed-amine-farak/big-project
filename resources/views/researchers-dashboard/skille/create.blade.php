@extends('layouts.reseacher_dashboard')

@section('content')

<div class="p-8">
<div class="max-w-4xl mx-auto">
<div class="flex justify-between items-center mb-6">
<h1 class="text-4xl font-bold text-gray-800">إضافة مهارة جديدة</h1>
<a href="#" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
العودة إلى المهارات
</a>
</div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
        {{-- Form for adding a new skill --}}
        <form action="{{route('skills.store')}}" method="POST">
            @csrf

            <!-- Skill Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-lg font-medium text-gray-700 mb-2">اسم المهارة (عربي)</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-base p-3 transition duration-150" placeholder="مثال: التحليل، الإبداع">
            </div>

            <!-- Skill Description Field -->
            <div class="mb-6">
                <label for="description" class="block text-lg font-medium text-gray-700 mb-2">وصف المهارة</label>
                <textarea name="description" id="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-base p-3 transition duration-150" placeholder="أدخل وصفًا تفصيليًا للمهارة..."></textarea>
            </div>

            <!-- Skill Subject Field -->
            <div class="mb-6">
                


              

                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">المادة</label>
                    <select id="subject_id" name="subject_id" required
                    class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" class="text-gray-400">-- اختر مادة --</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" class="text-gray-700">
                            {{ $subject->name }} - {{ $subject->fieldOfStudy->name }} - {{ $subject->fieldOfStudy->study_level }}
                        </option>
                    @endforeach
                </select>
            
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                    حفظ المهارة
                </button>
            </div>
        </form>
    </div>
</div>

</div>

@endsection