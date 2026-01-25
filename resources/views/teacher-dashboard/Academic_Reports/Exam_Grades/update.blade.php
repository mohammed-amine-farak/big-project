@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">تعديل تقرير اختبار</h1>
            <a href="{{ route('Exam_Grade.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة للقائمة
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">تعديل بيانات التقرير</h2>
                <p class="text-sm text-gray-500 mt-1">التقرير ID: {{ $exam_grade->exam_schol_weeckly_reports_id }}</p>
            </div>
            
            <form action="{{ route('Exam_Grade.update', $exam_grade->exam_schol_weeckly_reports_id) }}" method="POST" id="updateExamForm" class="p-6">
                @csrf
                @method('PUT')
                
                <!-- Hidden field for report ID -->
                <input type="hidden" name="report_id" value="{{ $exam_grade->exam_schol_weeckly_reports_id }}">
                
                <!-- Classroom Selection -->
                <div class="mb-6">
                    <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-2">
                        الصف الدراسي *
                    </label>
                    <select id="classroom_id" name="classroom_id" required 
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                        <option value="{{ $exam_grade->classroom_id }}">
                            {{ $exam_grade->classroom_name }}
                        </option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">
                                {{ $classroom->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Student and Exam Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Student -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الطالب *
                        </label>
                        <div class="relative">
                            <select id="student_id" name="student_id" required 
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                <option value="{{ $exam_grade->student_id }}">
                                    {{ $exam_grade->student_name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Exam -->
                    <div>
                        <label for="exam_weecklies_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الاختبار *
                        </label>
                        <div class="relative">
                            <select id="exam_weecklies_id" name="exam_weecklies_id" required 
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                <option value="{{ $exam_grade->exam_weeckly_id }}">
                                    {{ $exam_grade->exam_weeckly_title }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="mb-6" id="skills_section">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">المهارات المحققة</h3>
                            <p class="text-sm text-gray-500">حدد المهارات التي حققها الطالب في هذا الاختبار</p>
                            <p class="text-xs text-blue-600 mt-1">
                                <span class="font-semibold">ملاحظة:</span> عند تحديد مستوى أعلى (مثل مستوى 3)، يتم تلقائيًا تحديد المستويات الأدنى (2 و 1)
                            </p>
                            <p class="text-xs text-green-600 mt-1">
                                <span class="font-semibold">✓ المستويات المحققة مسبقاً:</span> معلمة بنجاح ولا يمكن إلغاء تحديدها
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span id="selected_count" class="text-sm px-3 py-1 bg-gray-100 rounded-full">
                                0 مستويات محددة
                            </span>
                            <span id="new_levels_count" class="text-sm px-3 py-1 bg-blue-100 text-blue-700 rounded-full hidden">
                                0 جديدة
                            </span>
                        </div>
                    </div>
                    
                    <!-- Already Validated Notification -->
                    <div id="already_validated_notification" class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-blue-800 font-medium">معلومات</p>
                                <p class="text-blue-700 text-sm mt-1" id="already_validated_text">
                                    جاري تحميل المهارات...
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" id="select_all_new" 
                                class="text-sm bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg border border-blue-200 flex items-center gap-1 transition duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            تحديد جميع الجديدة
                        </button>
                        <button type="button" id="deselect_all_new" 
                                class="text-sm bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 flex items-center gap-1 transition duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            إلغاء جميع الجديدة
                        </button>
                    </div>
                    
                    <!-- Loading State -->
                    <div id="skills_loading" class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <p class="mt-3 text-gray-600">جاري تحميل المهارات...</p>
                    </div>
                    
                    <!-- Skills Container -->
                    <div id="skills_container" class="space-y-3">
                        <!-- Skills will be loaded here by JavaScript -->
                    </div>
                    
                    <!-- Empty State -->
                    <div id="no_skills" class="hidden">
                        <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <p class="mt-3 text-gray-500">لا توجد مهارات مرتبطة بهذا الاختبار</p>
                        </div>
                    </div>
                </div>

                <!-- Score and Notes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Score -->
                    <div>
                        <label for="exam_total_point" class="block text-sm font-medium text-gray-700 mb-2">
                            النقاط / 20 *
                        </label>
                        <div class="relative">
                            <input type="number" name="exam_total_point" id="exam_total_point" 
                                   value="{{ $exam_grade->exam_weeckly_total_point }}"
                                   min="0" max="20" step="0.5" required 
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                   placeholder="0 - 20">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="exam_note" class="block text-sm font-medium text-gray-700 mb-2">
                            ملاحظات المعلم *
                        </label>
                        <textarea id="exam_note" name="exam_note" rows="3" required 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                  placeholder="اكتب ملاحظاتك هنا...">{{ $exam_grade->exam_weeckly_note }}</textarea>
                    </div>
                </div>

                <!-- Hidden Inputs for Selected Skills -->
                <div id="selected_skills_inputs">
                    <!-- Already validated levels will be added here by PHP -->
                    @foreach($alreadyValidatedLevels as $levelId)
                        <input type="hidden" name="selected_levels[]" value="{{ $levelId }}">
                    @endforeach
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('Exam_Grade.index') }}" 
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                        إلغاء
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <span id="submit_text">تحديث التقرير</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const classroomSelect = document.getElementById('classroom_id');
        const studentSelect = document.getElementById('student_id');
        const examSelect = document.getElementById('exam_weecklies_id');
        const skillsSection = document.getElementById('skills_section');
        const skillsContainer = document.getElementById('skills_container');
        const skillsLoading = document.getElementById('skills_loading');
        const noSkills = document.getElementById('no_skills');
        const alreadyValidatedNotification = document.getElementById('already_validated_notification');
        const alreadyValidatedText = document.getElementById('already_validated_text');
        const selectedSkillsInputs = document.getElementById('selected_skills_inputs');
        const selectedCount = document.getElementById('selected_count');
        const newLevelsCount = document.getElementById('new_levels_count');
        const submitBtn = document.querySelector('button[type="submit"]');
        const submitText = document.getElementById('submit_text');
        
        // State
        let selectedLevels = new Set();
        let alreadyValidatedLevels = new Set();
        let currentClassroomId = "{{ $exam_grade->classroom_id }}";
        let currentStudentId = "{{ $exam_grade->student_id }}";
        let currentExamId = "{{ $exam_grade->exam_weeckly_id }}";
        let skillLevelsData = {};

        // Initialize already validated levels from PHP
        @foreach($alreadyValidatedLevels as $levelId)
            alreadyValidatedLevels.add("{{ $levelId }}");
            selectedLevels.add("{{ $levelId }}"); // Add to selected levels as well
        @endforeach

        // Update counts on load
        updateSelectedCount();

        // Load skills automatically on page load
        loadSkillsForUpdate();

        // Function to load skills for update
        async function loadSkillsForUpdate() {
            if (!currentExamId || !currentStudentId) {
                console.log('Missing examId or studentId:', currentExamId, currentStudentId);
                return;
            }
            
            console.log('Loading skills for update - exam:', currentExamId, 'student:', currentStudentId);
            
            // Show loading
            skillsLoading.classList.remove('hidden');
            skillsContainer.innerHTML = '';
            noSkills.classList.add('hidden');
            
            try {
                const url = `/ajax/get-exam-skills/${currentExamId}/${currentStudentId}`;
                console.log('Fetching URL:', url);
                
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Skills data loaded:', data);
                
                skillsLoading.classList.add('hidden');
                
                if (data.success && data.skills && data.skills.length > 0) {
                    // Store already validated levels from response
                    if (data.already_validated_levels) {
                        data.already_validated_levels.forEach(levelId => {
                            alreadyValidatedLevels.add(levelId.toString());
                            selectedLevels.add(levelId.toString()); // Add to selected
                        });
                    }
                    
                    // Store skill hierarchy data
                    data.skills.forEach(skill => {
                        skillLevelsData[skill.skill_id] = {
                            levels: skill.levels.map(level => ({
                                id: level.level_id.toString(),
                                type: level.level_type,
                                order: getLevelOrder(level.level_type),
                                already_validated: level.already_validated
                            }))
                        };
                    });
                    
                    renderSkills(data.skills);
                    
                    // Show notification about already validated levels
                    if (data.already_validated_count > 0) {
                        alreadyValidatedNotification.classList.remove('hidden');
                        alreadyValidatedText.textContent = `هناك ${data.already_validated_count} مستوى محقق مسبقاً. هذه المستويات معلمة ولا يمكن إلغاء تحديدها.`;
                    }
                } else {
                    const errorMessage = data.message || 'لا توجد مهارات مرتبطة بهذا الاختبار';
                    noSkills.classList.remove('hidden');
                    noSkills.innerHTML = `
                        <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <p class="mt-3 text-gray-500">${errorMessage}</p>
                        </div>
                    `;
                }
                
            } catch (error) {
                console.error('Error loading skills:', error);
                skillsLoading.classList.add('hidden');
                skillsContainer.innerHTML = `
                    <div class="text-center py-6 text-red-500 bg-red-50 rounded-lg">
                        <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>حدث خطأ في تحميل المهارات</p>
                        <p class="text-sm text-red-400 mt-1">${error.message}</p>
                    </div>
                `;
            }
        }

        // Get level order for hierarchy
        function getLevelOrder(levelType) {
            const order = {
                'level_1': 1,
                'level_2': 2,
                'level_3': 3
            };
            return order[levelType] || 0;
        }

        // Render Skills - Show ALL levels
        function renderSkills(skills) {
            skillsContainer.innerHTML = '';
            
            skills.forEach((skill, index) => {
                const skillCard = document.createElement('div');
                skillCard.className = 'bg-gray-50 rounded-lg border border-gray-200 overflow-hidden transition-all duration-200 hover:shadow-sm';
                
                skillCard.innerHTML = `
                    <div class="p-4">
                        <!-- Skill Header -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-bold">${index + 1}</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">${skill.skill_name}</h4>
                                    ${skill.skill_description ? 
                                        `<p class="text-sm text-gray-500 mt-1">${skill.skill_description}</p>` 
                                        : ''}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                    ${skill.levels.length} مستويات
                                </span>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="skill-group-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                           data-skill-id="${skill.skill_id}">
                                    <span class="mr-2 text-sm text-gray-600">الكل</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Levels -->
                        <div class="space-y-2 pl-2 border-l-2 border-gray-200 ml-4">
                            ${skill.levels.map(level => {
                                const isAlreadyValidated = alreadyValidatedLevels.has(level.level_id.toString());
                                const isChecked = isAlreadyValidated || selectedLevels.has(level.level_id.toString());
                                const isDisabled = isAlreadyValidated;
                                
                                return `
                                    <div class="level-item flex items-center gap-3 p-2 ${isAlreadyValidated ? 'bg-green-50 border-green-200' : 'bg-white border-gray-100'} rounded border hover:bg-blue-50 transition duration-150">
                                        <input type="checkbox" 
                                               id="level_${level.level_id}" 
                                               name="level_ids[]" 
                                               value="${level.level_id}"
                                               ${isChecked ? 'checked' : ''}
                                               ${isDisabled ? 'disabled' : ''}
                                               class="level-checkbox h-4 w-4 ${isAlreadyValidated ? 'text-green-600 cursor-not-allowed' : 'text-blue-600'} rounded border-gray-300 focus:ring-blue-500"
                                               data-skill-id="${skill.skill_id}"
                                               data-level-type="${level.level_type}"
                                               data-level-order="${getLevelOrder(level.level_type)}"
                                               data-already-validated="${isAlreadyValidated}">
                                        
                                        <div class="flex-1">
                                            <label for="level_${level.level_id}" class="cursor-pointer block">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-medium ${isAlreadyValidated ? 'text-green-700' : 'text-gray-700'}">${level.level_name}</span>
                                                    <span class="text-xs px-2 py-0.5 rounded-full ${
                                                        level.level_type === 'level_3' ? 'bg-purple-100 text-purple-800' :
                                                        level.level_type === 'level_2' ? 'bg-blue-100 text-blue-800' :
                                                        'bg-green-100 text-green-800'
                                                    }">
                                                        ${level.level_type.replace('level_', 'مستوى ')}
                                                    </span>
                                                    ${isAlreadyValidated ? `
                                                        <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-800">
                                                            ✓ محقق سابقاً
                                                        </span>
                                                    ` : ''}
                                                </div>
                                                ${level.level_description ? 
                                                    `<div class="text-sm ${isAlreadyValidated ? 'text-green-600' : 'text-gray-500'} mt-1">${level.level_description}</div>` 
                                                    : ''}
                                            </label>
                                        </div>
                                        
                                        <div class="w-3 h-3 rounded-full ${isAlreadyValidated ? 'bg-green-500' : isChecked ? 'bg-blue-500' : 'bg-gray-200'} level-status"></div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                `;
                
                skillsContainer.appendChild(skillCard);
            });
            
            // Add event listeners
            addCheckboxListeners();
            updateSelectedCount();
            updateSelectedInputs();
            
            // Update skill group checkboxes based on current selection
            updateAllSkillGroupCheckboxes();
        }

        // Update all skill group checkboxes
        function updateAllSkillGroupCheckboxes() {
            document.querySelectorAll('.skill-group-checkbox').forEach(checkbox => {
                const skillId = checkbox.dataset.skillId;
                updateSkillGroupCheckbox(skillId);
            });
        }

        // Add Event Listeners to Checkboxes
        function addCheckboxListeners() {
            // Skill Group Checkboxes
            document.querySelectorAll('.skill-group-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const skillId = this.dataset.skillId;
                    const levelCheckboxes = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]:not([disabled])`);
                    
                    // Apply hierarchical selection when selecting all
                    if (this.checked) {
                        // Find the highest level to select (only from enabled checkboxes)
                        let highestLevelOrder = 0;
                        levelCheckboxes.forEach(cb => {
                            const order = parseInt(cb.dataset.levelOrder);
                            if (order > highestLevelOrder) {
                                highestLevelOrder = order;
                            }
                        });
                        
                        // Select all levels up to the highest (only enabled ones)
                        levelCheckboxes.forEach(cb => {
                            const order = parseInt(cb.dataset.levelOrder);
                            if (order <= highestLevelOrder) {
                                if (!cb.checked) {
                                    cb.checked = true;
                                    selectedLevels.add(cb.value);
                                }
                            }
                        });
                    } else {
                        // Deselect all (only enabled ones)
                        levelCheckboxes.forEach(cb => {
                            if (cb.checked) {
                                cb.checked = false;
                                selectedLevels.delete(cb.value);
                            }
                        });
                    }
                    
                    updateLevelStatus(skillId);
                    updateSelectedCount();
                    updateSelectedInputs();
                });
            });
            
            // Individual Level Checkboxes
            document.querySelectorAll('.level-checkbox:not([disabled])').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const skillId = this.dataset.skillId;
                    const levelOrder = parseInt(this.dataset.levelOrder);
                    const isChecked = this.checked;
                    
                    if (isChecked) {
                        // Select this level
                        selectedLevels.add(this.value);
                        
                        // Get all levels for this skill (only enabled ones)
                        const allLevelsInSkill = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]:not([disabled])`);
                        
                        // Select all lower levels
                        allLevelsInSkill.forEach(cb => {
                            const cbOrder = parseInt(cb.dataset.levelOrder);
                            if (cbOrder < levelOrder && !cb.checked) {
                                cb.checked = true;
                                selectedLevels.add(cb.value);
                            }
                        });
                    } else {
                        // Deselect this level
                        selectedLevels.delete(this.value);
                        
                        // Check if we need to deselect higher levels
                        const allLevelsInSkill = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]:not([disabled])`);
                        let higherLevelSelected = false;
                        
                        // Check if any higher level is selected
                        allLevelsInSkill.forEach(cb => {
                            const cbOrder = parseInt(cb.dataset.levelOrder);
                            if (cbOrder > levelOrder && cb.checked) {
                                higherLevelSelected = true;
                            }
                        });
                        
                        // If no higher level is selected, deselect all lower levels
                        if (!higherLevelSelected) {
                            allLevelsInSkill.forEach(cb => {
                                const cbOrder = parseInt(cb.dataset.levelOrder);
                                if (cbOrder <= levelOrder && cb.checked) {
                                    cb.checked = false;
                                    selectedLevels.delete(cb.value);
                                }
                            });
                        }
                    }
                    
                    updateSkillGroupCheckbox(skillId);
                    updateLevelStatus(skillId);
                    updateSelectedCount();
                    updateSelectedInputs();
                });
            });
        }

        // Update Skill Group Checkbox State
        function updateSkillGroupCheckbox(skillId) {
            const levelCheckboxes = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]:not([disabled])`);
            const skillCheckbox = document.querySelector(`.skill-group-checkbox[data-skill-id="${skillId}"]`);
            
            if (!skillCheckbox || levelCheckboxes.length === 0) return;
            
            const checkedCount = Array.from(levelCheckboxes).filter(cb => cb.checked).length;
            
            if (checkedCount === 0) {
                skillCheckbox.checked = false;
                skillCheckbox.indeterminate = false;
            } else if (checkedCount === levelCheckboxes.length) {
                skillCheckbox.checked = true;
                skillCheckbox.indeterminate = false;
            } else {
                skillCheckbox.checked = false;
                skillCheckbox.indeterminate = true;
            }
        }

        // Update Level Status Dots
        function updateLevelStatus(skillId) {
            const levelItems = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]`);
            levelItems.forEach((checkbox) => {
                const statusDot = checkbox.closest('.level-item').querySelector('.level-status');
                if (statusDot) {
                    if (checkbox.disabled) {
                        statusDot.className = 'w-3 h-3 rounded-full bg-green-500 level-status';
                    } else if (checkbox.checked) {
                        statusDot.className = 'w-3 h-3 rounded-full bg-blue-500 level-status';
                    } else {
                        statusDot.className = 'w-3 h-3 rounded-full bg-gray-200 level-status';
                    }
                }
            });
        }

        // Update Selected Count
        function updateSelectedCount() {
            const totalSelected = selectedLevels.size;
            const newSelectedCount = Array.from(selectedLevels).filter(level => !alreadyValidatedLevels.has(level)).length;
            
            selectedCount.textContent = `${totalSelected} مستويات محددة`;
            newLevelsCount.textContent = `${newSelectedCount} جديدة`;
            
            // Update count badge colors
            if (totalSelected > 0) {
                selectedCount.className = 'text-sm text-green-700 px-3 py-1 bg-green-100 rounded-full';
            } else {
                selectedCount.className = 'text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full';
            }
            
            if (newSelectedCount > 0) {
                newLevelsCount.classList.remove('hidden');
            } else {
                newLevelsCount.classList.add('hidden');
            }
        }

        // Update Hidden Inputs
        function updateSelectedInputs() {
            // Remove existing hidden inputs (except those added by PHP)
            document.querySelectorAll('#selected_skills_inputs input[name="selected_levels[]"]').forEach(input => {
                if (!input.hasAttribute('data-php')) {
                    input.remove();
                }
            });
            
            // Add all selected levels
            selectedLevels.forEach(levelId => {
                // Check if already exists (added by PHP)
                const existingInput = document.querySelector(`#selected_skills_inputs input[value="${levelId}"]`);
                if (!existingInput) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_levels[]';
                    input.value = levelId;
                    selectedSkillsInputs.appendChild(input);
                }
            });
        }

        // Select All NEW Button
        document.getElementById('select_all_new').addEventListener('click', function() {
            document.querySelectorAll('.level-checkbox:not([disabled])').forEach(checkbox => {
                if (!checkbox.checked) {
                    checkbox.checked = true;
                    selectedLevels.add(checkbox.value);
                }
            });
            
            // Update skill group checkboxes
            document.querySelectorAll('.skill-group-checkbox').forEach(cb => {
                const skillId = cb.dataset.skillId;
                updateSkillGroupCheckbox(skillId);
                updateLevelStatus(skillId);
            });
            
            updateSelectedCount();
            updateSelectedInputs();
        });

        // Deselect All NEW Button
        document.getElementById('deselect_all_new').addEventListener('click', function() {
            document.querySelectorAll('.level-checkbox:not([disabled])').forEach(checkbox => {
                if (checkbox.checked) {
                    checkbox.checked = false;
                    selectedLevels.delete(checkbox.value);
                }
            });
            
            // Update skill group checkboxes
            document.querySelectorAll('.skill-group-checkbox').forEach(cb => {
                const skillId = cb.dataset.skillId;
                updateSkillGroupCheckbox(skillId);
                updateLevelStatus(skillId);
            });
            
            updateSelectedCount();
            updateSelectedInputs();
        });

        // Form Validation
        document.getElementById('updateExamForm').addEventListener('submit', function(e) {
            // Validate score
            const scoreInput = document.getElementById('exam_total_point');
            const score = parseFloat(scoreInput.value);
            
            if (score < 0 || score > 20) {
                e.preventDefault();
                alert('يرجى إدخال درجة صحيحة بين 0 و 20');
                scoreInput.focus();
                return false;
            }
            
            // Calculate new levels count
            const newLevelsCountValue = Array.from(selectedLevels).filter(level => !alreadyValidatedLevels.has(level)).length;
            
            if (selectedLevels.size === 0) {
                const proceed = confirm('لم يتم تحديد أي مهارات. هل تريد المتابعة بدون تحديد مهارات؟');
                if (!proceed) {
                    e.preventDefault();
                    return false;
                }
            } else if (newLevelsCountValue === 0 && alreadyValidatedLevels.size > 0) {
                const proceed = confirm('جميع المستويات المحددة محققة مسبقاً. هل تريد المتابعة؟');
                if (!proceed) {
                    e.preventDefault();
                    return false;
                }
            }
            
            // Add loading state to submit button
            submitBtn.disabled = true;
            submitText.innerHTML = `
                <div class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></div>
                جاري التحديث...
            `;
        });
    });
</script>

<style>
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    input[type="checkbox"]:checked {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    
    input[type="checkbox"]:disabled {
        background-color: #10b981;
        border-color: #10b981;
    }
    
    input[type="checkbox"]:disabled:checked {
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .skill-group-checkbox:indeterminate {
        background-color: #3b82f6;
        border-color: #3b82f6;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10h8'/%3e%3c/svg%3e");
    }
    
    .level-item:hover {
        transform: translateX(2px);
    }
    
    select:disabled {
        background-color: #f9fafb;
        cursor: not-allowed;
    }
</style>

@endsection