@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-gray-800">إنشاء تقرير اختبار جديد</h1>
            <a href="{{ route('Exam_Grade.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                العودة إلى التقارير
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-4 shadow-md rounded-lg" role="alert">
            <!-- ... نفس كود النجاح ... -->
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
            <form action="{{ route('Exam_Grade.store') }}" method="POST" id="createExamForm">
                @csrf    
                
                <!-- Classroom Selection -->
                <div class="mb-6">
                    <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-1">
                        اختر الصف <span class="text-red-500">*</span>
                    </label>
                    <select id="classroom_id" name="classroom_id" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                        <option value="">اختر الصف...</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">
                                {{ $classroom->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Student and Exam Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Student Selection -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">
                            اختر التلميذ <span class="text-red-500">*</span>
                        </label>
                        <select id="student_id" name="student_id" required disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                            <option value="">اختر الصف أولاً...</option>
                        </select>
                        <div id="students_loading" class="hidden text-xs text-blue-500 mt-1">
                            جاري تحميل الطلاب...
                        </div>
                    </div>

                    <!-- Exam Selection -->
                    <div>
                        <label for="exam_weecklies_id" class="block text-sm font-medium text-gray-700 mb-1">
                            اختر الاختبار <span class="text-red-500">*</span>
                        </label>
                        <select id="exam_weecklies_id" name="exam_weecklies_id" required disabled
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                            <option value="">اختر الصف أولاً...</option>
                        </select>
                        <div id="exams_loading" class="hidden text-xs text-blue-500 mt-1">
                            جاري تحميل الاختبارات...
                        </div>
                    </div>
                </div>

                <!-- Skills and Levels Section -->
                <div class="mb-6" id="skills_section" style="display: none;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">المهارات والمستويات</h3>
                        <div class="flex items-center space-x-4">
                            <button type="button" id="select_all_skills" 
                                    class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded">
                                تحديد الكل
                            </button>
                            <button type="button" id="deselect_all_skills" 
                                    class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded">
                                إلغاء التحديد
                            </button>
                        </div>
                    </div>
                    
                    <div id="skills_loading" class="hidden text-center py-4">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <p class="text-blue-500 mt-2">جاري تحميل المهارات...</p>
                    </div>
                    
                    <div id="skills_container" class="space-y-6">
                        <!-- سيتم تعبئة المهارات هنا عبر AJAX -->
                    </div>
                    
                    <div id="no_skills" class="hidden text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">لا توجد مهارات لهذا الاختبار</p>
                    </div>
                </div>

                <!-- Score Input -->
                <div class="mb-6">
                    <label for="exam_total_point" class="block text-sm font-medium text-gray-700 mb-1">
                        مجموع النقاط <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="exam_total_point" id="exam_total_point" 
                           min="0" max="100" step="0.5" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150" 
                           placeholder="أدخل مجموع النقاط (0-100)">
                </div>

                <!-- Teacher Notes -->
                <div class="mb-6">
                    <label for="exam_note" class="block text-sm font-medium text-gray-700 mb-1">
                        ملاحظات الأستاذ <span class="text-red-500">*</span>
                    </label>
                    <textarea id="exam_note" name="exam_note" rows="4" required 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150" 
                              placeholder="أضف ملاحظاتك حول أداء التلميذ في هذا الاختبار..."></textarea>
                </div>

                <!-- Hidden Inputs for Selected Skills -->
                <div id="selected_skills_inputs">
                    <!-- سيتم إضافة inputs مخفية هنا -->
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('Exam_Grade.index') }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                        إلغاء والعودة
                    </a>
                    
                    <div class="flex gap-3">
                        <button type="submit" name="action" value="save"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            حفظ التقرير
                        </button>
                    </div>
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
        const selectedSkillsInputs = document.getElementById('selected_skills_inputs');
        
        // Arrays to store data
        let classroomData = {};
        let selectedSkills = new Set(); // لتخزين المهارات المختارة
        
        // Load classroom data (students + exams)
        classroomSelect.addEventListener('change', function() {
            const classroomId = this.value;
            
            if (!classroomId) {
                resetSelects();
                hideSkillsSection();
                return;
            }
            
            // Show loading for students and exams
            showLoading(studentSelect, 'students');
            showLoading(examSelect, 'exams');
            
            // Fetch classroom data
            fetch(`/ajax/get-classroom-data/${classroomId}`)
                .then(response => response.json())
                .then(data => {
                    hideLoading('students');
                    hideLoading('exams');
                    
                    if (data.success) {
                        classroomData[classroomId] = data;
                        
                        // Populate students
                        populateSelect(studentSelect, data.students, 'اختر التلميذ...');
                        
                        // Populate exams
                        populateSelect(examSelect, data.exams, 'اختر الاختبار...', 'id', 'title');
                    } else {
                        showError('حدث خطأ في تحميل البيانات');
                    }
                })
                .catch(error => {
                    hideLoading('students');
                    hideLoading('exams');
                    showError('فشل في تحميل البيانات');
                    console.error('Error:', error);
                });
        });
        
        // Load skills when exam changes
        examSelect.addEventListener('change', function() {
            const examId = this.value;
            
            if (!examId) {
                hideSkillsSection();
                return;
            }
            
            // Show skills section
            skillsSection.style.display = 'block';
            skillsLoading.classList.remove('hidden');
            skillsContainer.innerHTML = '';
            noSkills.classList.add('hidden');
            selectedSkills.clear();
            updateSelectedSkillsInputs();
            
            // Fetch skills for this exam
            fetch(`/ajax/get-exam-skills/${examId}`)
                .then(response => response.json())
                .then(data => {
                    skillsLoading.classList.add('hidden');
                    
                    if (data.success && data.skills && data.skills.length > 0) {
                        renderSkills(data.skills);
                    } else {
                        noSkills.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    skillsLoading.classList.add('hidden');
                    skillsContainer.innerHTML = `
                        <div class="text-center py-4 text-red-500">
                            <p>حدث خطأ في تحميل المهارات</p>
                        </div>
                    `;
                    console.error('Error:', error);
                });
        });
        
        // Render skills with checkboxes
        function renderSkills(skills) {
            skillsContainer.innerHTML = '';
            
            skills.forEach(skill => {
                const skillCard = document.createElement('div');
                skillCard.className = 'border border-gray-200 rounded-lg p-4 bg-gray-50';
                
                // Skill header
                skillCard.innerHTML = `
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h4 class="font-bold text-gray-800">${skill.skill_name}</h4>
                          
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" 
                                   id="skill_${skill.skill_id}" 
                                   class="skill-group-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   data-skill-id="${skill.skill_id}">
                            <label for="skill_${skill.skill_id}" class="text-sm text-gray-700">
                                تحديد جميع مستويات هذه المهارة
                            </label>
                        </div>
                    </div>
                    <div class="space-y-2" id="levels_${skill.skill_id}">
                        <!-- Levels will be added here -->
                    </div>
                `;
                
                skillsContainer.appendChild(skillCard);
                
                // Add levels for this skill
                const levelsContainer = document.getElementById(`levels_${skill.skill_id}`);
                skill.levels.forEach(level => {
                    const levelDiv = document.createElement('div');
                    levelDiv.className = 'flex items-center space-x-3 p-2 bg-white rounded border';
                    
                    levelDiv.innerHTML = `
                        <input type="checkbox" 
                               id="level_${level.level_id}" 
                               name="level_ids[]" 
                               value="${level.level_id}"
                               class="level-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                               data-skill-id="${skill.skill_id}"
                               data-level-id="${level.level_id}">
                        <div class="flex-1">
                            <label for="level_${level.level_id}" class="font-medium text-gray-700 cursor-pointer">
                                ${level.level_name}
                            </label>
                            <p class="text-sm text-gray-500">${level.level_description}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full ${level.exam_skill_status === 'send' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${level.exam_skill_status === 'send' ? 'مرسل' : 'قيد التقدم'}
                        </span>
                    `;
                    
                    levelsContainer.appendChild(levelDiv);
                });
            });
            
            // Add event listeners for checkboxes
            addCheckboxListeners();
        }
        
        // Add event listeners to checkboxes
        function addCheckboxListeners() {
            // Skill group checkboxes (select all levels in skill)
            document.querySelectorAll('.skill-group-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const skillId = this.dataset.skillId;
                    const levelCheckboxes = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]`);
                    
                    levelCheckboxes.forEach(levelCheckbox => {
                        levelCheckbox.checked = this.checked;
                        updateSelectedSkill(levelCheckbox.dataset.levelId, this.checked);
                    });
                    
                    updateSelectedSkillsInputs();
                });
            });
            
            // Individual level checkboxes
            document.querySelectorAll('.level-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const skillId = this.dataset.skillId;
                    updateSelectedSkill(this.dataset.levelId, this.checked);
                    updateSkillGroupCheckbox(skillId);
                    updateSelectedSkillsInputs();
                });
            });
        }
        
        // Update selected skills set
        function updateSelectedSkill(levelId, isChecked) {
            if (isChecked) {
                selectedSkills.add(levelId);
            } else {
                selectedSkills.delete(levelId);
            }
        }
        
        // Update skill group checkbox based on level selections
        function updateSkillGroupCheckbox(skillId) {
            const levelCheckboxes = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]`);
            const skillCheckbox = document.querySelector(`.skill-group-checkbox[data-skill-id="${skillId}"]`);
            
            if (levelCheckboxes.length > 0) {
                const allChecked = Array.from(levelCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(levelCheckboxes).some(cb => cb.checked);
                
                skillCheckbox.checked = allChecked;
                skillCheckbox.indeterminate = someChecked && !allChecked;
            }
        }
        
        // Update hidden inputs for selected skills
        function updateSelectedSkillsInputs() {
            selectedSkillsInputs.innerHTML = '';
            
            selectedSkills.forEach(levelId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_levels[]';
                input.value = levelId;
                selectedSkillsInputs.appendChild(input);
            });
            
            // Also add a count input
            const countInput = document.createElement('input');
            countInput.type = 'hidden';
            countInput.name = 'selected_levels_count';
            countInput.value = selectedSkills.size;
            selectedSkillsInputs.appendChild(countInput);
        }
        
        // Select all skills
        document.getElementById('select_all_skills').addEventListener('click', function() {
            document.querySelectorAll('.level-checkbox').forEach(checkbox => {
                checkbox.checked = true;
                updateSelectedSkill(checkbox.dataset.levelId, true);
            });
            
            document.querySelectorAll('.skill-group-checkbox').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.indeterminate = false;
            });
            
            updateSelectedSkillsInputs();
        });
        
        // Deselect all skills
        document.getElementById('deselect_all_skills').addEventListener('click', function() {
            document.querySelectorAll('.level-checkbox').forEach(checkbox => {
                checkbox.checked = false;
                updateSelectedSkill(checkbox.dataset.levelId, false);
            });
            
            document.querySelectorAll('.skill-group-checkbox').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.indeterminate = false;
            });
            
            updateSelectedSkillsInputs();
        });
        
        // Helper functions
        function populateSelect(select, data, defaultText, idField = 'id', nameField = 'name') {
            select.innerHTML = `<option value="">${defaultText}</option>`;
            
            if (data && data.length > 0) {
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item[idField];
                    option.textContent = item[nameField];
                    select.appendChild(option);
                });
                select.disabled = false;
            } else {
                select.innerHTML = `<option value="">لا توجد بيانات</option>`;
                select.disabled = true;
            }
        }
        
        function showLoading(select, type) {
            const loadingDiv = document.getElementById(`${type}_loading`);
            if (loadingDiv) loadingDiv.classList.remove('hidden');
            select.disabled = true;
        }
        
        function hideLoading(type) {
            const loadingDiv = document.getElementById(`${type}_loading`);
            if (loadingDiv) loadingDiv.classList.add('hidden');
        }
        
        function resetSelects() {
            studentSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            examSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            studentSelect.disabled = true;
            examSelect.disabled = true;
        }
        
        function hideSkillsSection() {
            skillsSection.style.display = 'none';
            skillsContainer.innerHTML = '';
            selectedSkills.clear();
            updateSelectedSkillsInputs();
        }
        
        function showError(message) {
            studentSelect.innerHTML = `<option value="">${message}</option>`;
            examSelect.innerHTML = `<option value="">${message}</option>`;
            studentSelect.disabled = true;
            examSelect.disabled = true;
        }
        
        // Form validation
        document.getElementById('createExamForm').addEventListener('submit', function(e) {
            const studentId = studentSelect.value;
            const examId = examSelect.value;
            const score = document.getElementById('exam_total_point').value;
            
            if (!studentId || studentSelect.disabled) {
                e.preventDefault();
                alert('يرجى اختيار تلميذ صحيح');
                return false;
            }
            
            if (!examId || examSelect.disabled) {
                e.preventDefault();
                alert('يرجى اختيار اختبار');
                return false;
            }
            
            // Optional: Validate that at least one skill is selected
            if (selectedSkills.size === 0) {
                const confirmSubmit = confirm('لم يتم تحديد أي مهارات. هل تريد المتابعة دون تحديد مهارات؟');
                if (!confirmSubmit) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
</script>

<style>
    .skill-group-checkbox:indeterminate {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    .level-checkbox:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    
    input[type="checkbox"]:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .bg-gray-50 {
        background-color: #f9fafb;
    }
</style>

@endsection