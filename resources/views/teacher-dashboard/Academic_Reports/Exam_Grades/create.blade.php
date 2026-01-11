@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إنشاء تقرير اختبار جديد</h1>
            <a href="{{ route('Exam_Grade.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
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

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">بيانات التقرير</h2>
            </div>
            
            <form action="{{ route('Exam_Grade.store') }}" method="POST" id="createExamForm" class="p-6">
                @csrf    
                
                <!-- Classroom Selection -->
                <div class="mb-6">
                    <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-2">
                        الصف الدراسي
                    </label>
                    <select id="classroom_id" name="classroom_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
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
                    <!-- Student -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الطالب
                        </label>
                        <div class="relative">
                            <select id="student_id" name="student_id" required disabled
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                <option value="">اختر الصف أولاً...</option>
                            </select>
                            <div id="students_loading" class="hidden absolute right-3 top-2.5">
                                <div class="w-4 h-4 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Exam -->
                    <div>
                        <label for="exam_weecklies_id" class="block text-sm font-medium text-gray-700 mb-2">
                            الاختبار
                        </label>
                        <div class="relative">
                            <select id="exam_weecklies_id" name="exam_weecklies_id" required disabled
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                <option value="">اختر الصف أولاً...</option>
                            </select>
                            <div id="exams_loading" class="hidden absolute right-3 top-2.5">
                                <div class="w-4 h-4 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="mb-6" id="skills_section" style="display: none;">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">المهارات المحققة</h3>
                            <p class="text-sm text-gray-500">حدد المهارات التي حققها الطالب في هذا الاختبار</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span id="selected_count" class="text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                                0 مستويات محددة
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" id="select_all_skills" 
                                class="text-sm bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg border border-blue-200 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            تحديد الكل
                        </button>
                        <button type="button" id="deselect_all_skills" 
                                class="text-sm bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            إلغاء الكل
                        </button>
                    </div>
                    
                    <!-- Loading State -->
                    <div id="skills_loading" class="hidden">
                        <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                            <p class="mt-3 text-gray-600">جاري تحميل المهارات...</p>
                        </div>
                    </div>
                    
                    <!-- Skills Container -->
                    <div id="skills_container" class="space-y-3">
                        <!-- سيتم تعبئة المهارات هنا -->
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
                            النقاط / 20
                        </label>
                        <div class="relative">
                            <input type="number" name="exam_total_point" id="exam_total_point" 
                                   min="0" max="20" step="0.5" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                   placeholder="0 - 20">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="exam_note" class="block text-sm font-medium text-gray-700 mb-2">
                            ملاحظات المعلم
                        </label>
                        <textarea id="exam_note" name="exam_note" rows="3" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                                  placeholder="اكتب ملاحظاتك هنا..."></textarea>
                    </div>
                </div>

                <!-- Hidden Inputs for Selected Skills -->
                <div id="selected_skills_inputs"></div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('Exam_Grade.index') }}" 
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                        إلغاء
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        حفظ التقرير
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
        const selectedSkillsInputs = document.getElementById('selected_skills_inputs');
        const selectedCount = document.getElementById('selected_count');
        
        // State
        let selectedLevels = new Set();
        let classroomCache = {};

        // Classroom Change
        classroomSelect.addEventListener('change', async function() {
            const classroomId = this.value;
            
            if (!classroomId) {
                resetForm();
                return;
            }
            
            // Reset selects
            resetStudentAndExam();
            
            // Show loading
            showLoading('students', true);
            showLoading('exams', true);
            
            try {
                // Check cache first
                if (!classroomCache[classroomId]) {
                    const response = await fetch(`/ajax/get-classroom-data/${classroomId}`);
                    const data = await response.json();
                    
                    if (data.success) {
                        classroomCache[classroomId] = data;
                    } else {
                        throw new Error('Failed to load classroom data');
                    }
                }
                
                const data = classroomCache[classroomId];
                
                // Populate students
                populateSelect(studentSelect, data.students, 'اختر التلميذ...');
                
                // Populate exams
                populateSelect(examSelect, data.exams, 'اختر الاختبار...', 'id', 'title');
                
            } catch (error) {
                console.error('Error:', error);
                studentSelect.innerHTML = '<option value="">خطأ في تحميل البيانات</option>';
                examSelect.innerHTML = '<option value="">خطأ في تحميل البيانات</option>';
            } finally {
                showLoading('students', false);
                showLoading('exams', false);
            }
        });

        // Exam Change - Load Skills
        examSelect.addEventListener('change', async function() {
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
            
            // Reset selection
            selectedLevels.clear();
            updateSelectedCount();
            updateSelectedInputs();
            
            try {
                const response = await fetch(`/ajax/get-exam-skills/${examId}`);
                const data = await response.json();
                
                skillsLoading.classList.add('hidden');
                
                if (data.success && data.skills && data.skills.length > 0) {
                    renderSkills(data.skills);
                } else {
                    noSkills.classList.remove('hidden');
                }
                
            } catch (error) {
                console.error('Error:', error);
                skillsLoading.classList.add('hidden');
                skillsContainer.innerHTML = `
                    <div class="text-center py-6 text-red-500 bg-red-50 rounded-lg">
                        <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>حدث خطأ في تحميل المهارات</p>
                    </div>
                `;
            }
        });

        // Render Skills with beautiful UI
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
                            ${skill.levels.map(level => `
                                <div class="level-item flex items-center gap-3 p-2 bg-white rounded border border-gray-100 hover:bg-blue-50 transition duration-150">
                                    <input type="checkbox" 
                                           id="level_${level.level_id}" 
                                           name="level_ids[]" 
                                           value="${level.level_id}"
                                           class="level-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                           data-skill-id="${skill.skill_id}">
                                    
                                    <div class="flex-1">
                                        <label for="level_${level.level_id}" class="cursor-pointer block">
                                            <div class="font-medium text-gray-700">${level.level_name}</div>
                                            ${level.level_description ? 
                                                `<div class="text-sm text-gray-500 mt-1">${level.level_description}</div>` 
                                                : ''}
                                        </label>
                                    </div>
                                    
                                    <div class="w-3 h-3 rounded-full bg-gray-200 level-status"></div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
                
                skillsContainer.appendChild(skillCard);
            });
            
            // Add event listeners
            addCheckboxListeners();
        }

        // Add Event Listeners to Checkboxes
        function addCheckboxListeners() {
            // Skill Group Checkboxes
            document.querySelectorAll('.skill-group-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const skillId = this.dataset.skillId;
                    const levelCheckboxes = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]`);
                    
                    levelCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                        handleLevelSelection(cb.dataset.skillId, cb.value, this.checked);
                    });
                    
                    updateLevelStatus(skillId);
                    updateSelectedCount();
                    updateSelectedInputs();
                });
            });
            
            // Individual Level Checkboxes
            document.querySelectorAll('.level-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    handleLevelSelection(this.dataset.skillId, this.value, this.checked);
                    updateSkillGroupCheckbox(this.dataset.skillId);
                    updateLevelStatus(this.dataset.skillId);
                    updateSelectedCount();
                    updateSelectedInputs();
                });
            });
        }

        // Handle Level Selection
        function handleLevelSelection(skillId, levelId, isChecked) {
            if (isChecked) {
                selectedLevels.add(levelId);
            } else {
                selectedLevels.delete(levelId);
            }
        }

        // Update Skill Group Checkbox State
        function updateSkillGroupCheckbox(skillId) {
            const levelCheckboxes = document.querySelectorAll(`.level-checkbox[data-skill-id="${skillId}"]`);
            const skillCheckbox = document.querySelector(`.skill-group-checkbox[data-skill-id="${skillId}"]`);
            
            if (levelCheckboxes.length === 0) return;
            
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
            levelItems.forEach((checkbox, index) => {
                const statusDot = checkbox.closest('.level-item').querySelector('.level-status');
                if (checkbox.checked) {
                    statusDot.className = 'w-3 h-3 rounded-full bg-green-500 level-status';
                } else {
                    statusDot.className = 'w-3 h-3 rounded-full bg-gray-200 level-status';
                }
            });
        }

        // Update Selected Count
        function updateSelectedCount() {
            selectedCount.textContent = `${selectedLevels.size} مستويات محددة`;
            
            // Update count badge color
            if (selectedLevels.size > 0) {
                selectedCount.className = 'text-sm text-green-700 px-3 py-1 bg-green-100 rounded-full';
            } else {
                selectedCount.className = 'text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full';
            }
        }

        // Update Hidden Inputs
        function updateSelectedInputs() {
            selectedSkillsInputs.innerHTML = '';
            
            selectedLevels.forEach(levelId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_levels[]';
                input.value = levelId;
                selectedSkillsInputs.appendChild(input);
            });
        }

        // Select All Button
        document.getElementById('select_all_skills').addEventListener('click', function() {
            document.querySelectorAll('.level-checkbox').forEach(checkbox => {
                checkbox.checked = true;
                handleLevelSelection(checkbox.dataset.skillId, checkbox.value, true);
                updateSkillGroupCheckbox(checkbox.dataset.skillId);
                updateLevelStatus(checkbox.dataset.skillId);
            });
            
            document.querySelectorAll('.skill-group-checkbox').forEach(cb => {
                cb.checked = true;
                cb.indeterminate = false;
            });
            
            updateSelectedCount();
            updateSelectedInputs();
        });

        // Deselect All Button
        document.getElementById('deselect_all_skills').addEventListener('click', function() {
            document.querySelectorAll('.level-checkbox').forEach(checkbox => {
                checkbox.checked = false;
                handleLevelSelection(checkbox.dataset.skillId, checkbox.value, false);
                updateSkillGroupCheckbox(checkbox.dataset.skillId);
                updateLevelStatus(checkbox.dataset.skillId);
            });
            
            document.querySelectorAll('.skill-group-checkbox').forEach(cb => {
                cb.checked = false;
                cb.indeterminate = false;
            });
            
            updateSelectedCount();
            updateSelectedInputs();
        });

        // Helper Functions
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

        function showLoading(type, show) {
            const loadingDiv = document.getElementById(`${type}_loading`);
            const select = type === 'students' ? studentSelect : examSelect;
            
            if (show) {
                loadingDiv.classList.remove('hidden');
                select.disabled = true;
            } else {
                loadingDiv.classList.add('hidden');
                select.disabled = false;
            }
        }

        function resetStudentAndExam() {
            studentSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            examSelect.innerHTML = '<option value="">اختر الصف أولاً...</option>';
            studentSelect.disabled = true;
            examSelect.disabled = true;
            hideSkillsSection();
        }

        function hideSkillsSection() {
            skillsSection.style.display = 'none';
            skillsContainer.innerHTML = '';
            selectedLevels.clear();
            updateSelectedCount();
            updateSelectedInputs();
        }

        function resetForm() {
            resetStudentAndExam();
            classroomSelect.value = '';
        }

        // Form Validation
        document.getElementById('createExamForm').addEventListener('submit', function(e) {
            const scoreInput = document.getElementById('exam_total_point');
            const score = parseFloat(scoreInput.value);
            
            if (score < 0 || score > 20) {
                e.preventDefault();
                alert('يرجى إدخال درجة صحيحة بين 0 و 20');
                scoreInput.focus();
                return false;
            }
            
            if (selectedLevels.size === 0) {
                const proceed = confirm('لم يتم تحديد أي مهارات. هل تريد المتابعة بدون تحديد مهارات؟');
                if (!proceed) {
                    e.preventDefault();
                    return false;
                }
            }
            
            // Add loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <div class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></div>
                جاري الحفظ...
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
    
    .skill-group-checkbox:indeterminate {
        background-color: #3b82f6;
        border-color: #3b82f6;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10h8'/%3e%3c/svg%3e");
    }
    
    .level-item:hover {
        transform: translateX(2px);
    }
</style>

@endsection