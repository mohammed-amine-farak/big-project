@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl">
        <div class="p-8">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    ربط مهارة باختبار أسبوعي 📝
                </h1>
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; العودة
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- General Error Message --}}
        @if($errors->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                ❌ {{ $errors->first('error') }}
            </div>
        @endif


            <form action="{{ route('exam-skills.store') }}" method="POST" class="space-y-6" id="mainForm">
                @csrf
                
                {{-- Exam Selection --}}
                <div>
                    <label for="exam_id" class="block text-sm font-medium text-gray-700 mb-1">
                        اختر الاختبار الأسبوعي:
                    </label>
                    <select id="exam_id" name="exam_id" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- اختر الاختبار --</option>
                        @foreach ($results as $result)
                            <option value="{{ $result->id }}">
                                {{ $result->subject->name }} - {{ $result->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('exam_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Main Skill Levels Selection (Dynamic) --}}
                <div id="mainSkillLevelSection">
                    <label for="skill_level_id" class="block text-sm font-medium text-gray-700 mb-1">
                        اختر مستوى المهارة:
                    </label>
                    <select id="skill_level_id" name="skill_level_ids[]" required disabled
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- اختر مستوى المهارة --</option>
                    </select>
                    
                    {{-- Loading Indicator --}}
                    <div id="levelLoading" class="mt-2 hidden">
                        <div class="flex items-center text-green-600">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-green-600 mr-2"></div>
                            <span>جاري تحميل مستويات المهارة...</span>
                        </div>
                    </div>
                    
                    {{-- Error Message --}}
                    <div id="levelError" class="mt-2 text-red-600 hidden"></div>
                    
                    @error('skill_level_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Additional Skill Levels Container --}}
                <div id="additionalSkillLevelsContainer" class="space-y-4">
                    <!-- Additional skill levels will be added here dynamically -->
                </div>

                {{-- Add Another Skill Level Button --}}
                <div>
                    <button type="button" id="addAnotherSkillLevel" 
                            class="bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 transition duration-300 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة مستوى مهارة آخر
                    </button>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-md hover:bg-blue-700 transition duration-300">
                        حفظ الربط
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const examSelect = document.getElementById('exam_id');
    const levelSelect = document.getElementById('skill_level_id');
    const levelLoading = document.getElementById('levelLoading');
    const levelError = document.getElementById('levelError');
    const form = document.getElementById('mainForm');
    const addAnotherBtn = document.getElementById('addAnotherSkillLevel');
    const additionalContainer = document.getElementById('additionalSkillLevelsContainer');
    
    let skillLevelsData = []; // Store loaded skill levels
    let additionalCount = 0; // Counter for additional skill levels

    // When exam selection changes - Load Skill Levels directly
    examSelect.addEventListener('change', async function() {
        const examId = this.value;
        
        // Reset all skill level selections
        levelSelect.innerHTML = '<option value="">-- اختر مستوى المهارة --</option>';
        levelSelect.disabled = true;
        additionalContainer.innerHTML = '';
        additionalCount = 0;
        levelError.classList.add('hidden');
        levelError.textContent = '';

        if (!examId) return;

        try {
            // Show loading indicator for levels
            levelLoading.classList.remove('hidden');

            // Make Ajax request to get skill levels based on exam
            const response = await fetch('{{ route("get.skill.levels.by.exam") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ exam_id: examId })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            skillLevelsData = data.skill_levels || [];

            if (skillLevelsData.length > 0) {
                // Populate main skill levels dropdown
                populateSkillLevelSelect(levelSelect, skillLevelsData);
                levelSelect.disabled = false;
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'لا توجد مستويات مهارة متاحة';
                levelSelect.appendChild(option);
                levelError.classList.remove('hidden');
                levelError.textContent = 'لا توجد مستويات مهارة متاحة للاختبار المحدد.';
            }
        } catch (error) {
            console.error('Error fetching skill levels:', error);
            levelError.classList.remove('hidden');
            levelError.textContent = 'حدث خطأ في تحميل مستويات المهارة. يرجى المحاولة مرة أخرى.';
            
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'خطأ في تحميل المستويات';
            levelSelect.appendChild(option);
        } finally {
            // Hide loading indicator
            levelLoading.classList.add('hidden');
        }
    });

    // Function to populate skill level select
    function populateSkillLevelSelect(selectElement, levels) {
        selectElement.innerHTML = '<option value="">-- اختر مستوى المهارة --</option>';
        levels.forEach(level => {
            let levelText = level.name;
            if (level.description) {
                levelText += ' - ' + level.description;
            }
            if (level.skill_name) {
                levelText = level.skill_name + ' : ' + levelText;
            }
            

            
            const option = document.createElement('option');
            option.value = level.id;
            option.textContent = levelText;
            selectElement.appendChild(option);
        });
    }

    // Add another skill level selection
    addAnotherBtn.addEventListener('click', function() {
        if (skillLevelsData.length === 0) {
            alert('يرجى اختيار اختبار أولاً لتحميل مستويات المهارة.');
            return;
        }

        additionalCount++;
        const newSkillLevelDiv = document.createElement('div');
        newSkillLevelDiv.className = 'additional-skill-level border-t pt-4';
        newSkillLevelDiv.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-gray-700">
                    مستوى المهارة الإضافي ${additionalCount}:
                </label>
                <button type="button" class="remove-skill-level text-red-600 hover:text-red-800 font-medium">
                    ✕ حذف
                </button>
            </div>
            <select name="skill_level_ids[]" required
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- اختر مستوى المهارة --</option>
            </select>
        `;

        additionalContainer.appendChild(newSkillLevelDiv);

        // Populate the new select with skill levels
        const newSelect = newSkillLevelDiv.querySelector('select');
        populateSkillLevelSelect(newSelect, skillLevelsData);

        // Add remove functionality
        newSkillLevelDiv.querySelector('.remove-skill-level').addEventListener('click', function() {
            newSkillLevelDiv.remove();
            additionalCount--;
        });
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        const skillLevelSelects = document.querySelectorAll('select[name="skill_level_ids[]"]');
        let hasValidSelection = false;

        skillLevelSelects.forEach(select => {
            if (select.value) {
                hasValidSelection = true;
            }
        });

        if (!hasValidSelection) {
            e.preventDefault();
            alert('يرجى اختيار مستوى مهارة واحد على الأقل.');
        }
    });
});
</script>

<style>
.additional-skill-level {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection