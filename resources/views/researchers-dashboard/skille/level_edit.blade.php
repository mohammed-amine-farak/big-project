@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">تعديل المستوى</h1>
                    <p class="text-gray-600 text-sm">تعديل معلومات المستوى: {{ $level->level_name }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('show_more_skills.show', $level->skill_id) }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للمهارة
                    </a>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">تعديل المستوى</h2>
                        <p class="text-sm text-gray-600">قم بتعديل معلومات المستوى</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <h4 class="font-medium mb-2">يوجد أخطاء في المدخلات:</h4>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('level.update', $level->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Level Name -->
                        <div>
                            <label for="level_name" class="block text-sm font-medium text-gray-700 mb-2">
                                اسم المستوى
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="level_name" 
                                   id="level_name" 
                                   required 
                                   value="{{ old('level_name', $level->level_name) }}"
                                   placeholder="أدخل اسم المستوى"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200
                                          {{ $errors->has('level_name') ? 'border-red-500' : '' }}">
                            @error('level_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Level Description -->
                        <div>
                            <label for="level_description" class="block text-sm font-medium text-gray-700 mb-2">
                                وصف المستوى
                            </label>
                            <textarea name="level_description" 
                                      id="level_description" 
                                      rows="4"
                                      placeholder="أدخل وصفًا تفصيليًا للمستوى..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200
                                             {{ $errors->has('level_description') ? 'border-red-500' : '' }}">{{ old('level_description', $level->level_description) }}</textarea>
                            @error('level_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Level Selection -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                                المستوى
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="level" 
                                    id="level" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200
                                           {{ $errors->has('level') ? 'border-red-500' : '' }}">
                                @php
                                    $existingLevels = \App\Models\level_skill::where('skill_id', $level->skill_id)
                                                                           ->where('id', '!=', $level->id)
                                                                           ->pluck('level')
                                                                           ->toArray();
                                    $allLevels = ['level_1', 'level_2', 'level_3'];
                                    $availableLevels = array_diff($allLevels, $existingLevels);
                                    // إضافة المستوى الحالي إلى القائمة المتاحة
                                    $availableLevels[] = $level->level;
                                    sort($availableLevels);
                                @endphp
                                
                                @foreach($availableLevels as $availableLevel)
                                    <option value="{{ $availableLevel }}" {{ old('level', $level->level) == $availableLevel ? 'selected' : '' }}>
                                        @if($availableLevel == 'level_1') 
                                            المستوى الأول (مبتدئ)
                                        @elseif($availableLevel == 'level_2') 
                                            المستوى الثاني (متوسط)
                                        @elseif($availableLevel == 'level_3') 
                                            المستوى الثالث (متقدم)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('level')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            
                            @if(!empty($existingLevels))
                            <div class="mt-2 text-sm text-gray-600">
                                <span class="font-medium">المستويات الأخرى في هذه المهارة:</span>
                                @foreach($existingLevels as $existingLevel)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1">
                                        @if($existingLevel == 'level_1') المستوى 1
                                        @elseif($existingLevel == 'level_2') المستوى 2
                                        @elseif($existingLevel == 'level_3') المستوى 3
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm hover-lift">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            حفظ التغييرات
                        </button>
                        
                        <a href="{{ route('show_more_skills.show', $level->skill_id) }}" 
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-8 py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Level Info Card -->
        <div class="mt-6 bg-gray-50 rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات المستوى</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">تاريخ الإنشاء</p>
                        <p class="text-gray-900 font-medium">{{ $level->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">آخر تحديث</p>
                        <p class="text-gray-900 font-medium">{{ $level->updated_at->format('Y-m-d') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">المهارة الأم</p>
                        <p class="text-gray-900 font-medium">{{ $level->skill->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}
.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
@endsection