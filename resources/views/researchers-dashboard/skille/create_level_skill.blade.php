@extends('layouts.reseacher_dashboard')

@section('content')
<div class="flex-1 p-6 lg:p-10 main-content-area">
    <div class="main-content-container">
        <h1 class="text-3xl font-bold mb-8 text-blue-900">إضافة مستوى جديد</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('store_level') }}" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            <input type="hidden" name="skill_id" value="{{ $id }}">
            
            <div>
                <label for="level_name" class="block text-sm font-medium text-gray-700 mb-1">اسم المستوى</label>
                <input type="text" name="level_name" id="level_name" required 
                       value="{{ old('level_name') }}"
                       class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
    
            <div>
                <label for="level_description" class="block text-sm font-medium text-gray-700 mb-1">وصف المستوى</label>
                <textarea name="level_description" id="level_description" rows="4" 
                          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('level_description') }}</textarea>
            </div>
            
            <div>
                <label for="level" class="block text-sm font-medium text-gray-700 mb-1">المستوى</label>
                <select name="level" id="level" required 
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- اختر المستوى --</option>
                    @php
                        $existingLevels = \App\Models\level_skill::where('skill_id', $id)->pluck('level')->toArray();
                        $allLevels = ['level_1', 'level_2', 'level_3'];
                        $availableLevels = array_diff($allLevels, $existingLevels);
                    @endphp
                    
                    @foreach($availableLevels as $level)
                        <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>
                            @if($level == 'level_1') 
                                المستوى الأول (مبتدئ)
                            @elseif($level == 'level_2') 
                                المستوى الثاني (متوسط)
                            @elseif($level == 'level_3') 
                                المستوى الثالث (متقدم)
                            @endif
                        </option>
                    @endforeach
                    
                    @if(empty($availableLevels))
                        <option value="" disabled>جميع المستويات مضافة لهذه المهارة</option>
                    @endif
                </select>
                
                @if(!empty($existingLevels))
                <div class="mt-2 text-sm text-gray-600">
                    <span class="font-medium">المستويات المضافة:</span>
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
            
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200 
                           {{ empty($availableLevels) ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ empty($availableLevels) ? 'disabled' : '' }}>
                إضافة المستوى
            </button>
            
            @if(empty($availableLevels))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mt-4">
                <p>⚠️ هذه المهارة تحتوي بالفعل على جميع المستويات الثلاثة.</p>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection