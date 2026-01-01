@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('StudentPsychology.show', $report) }}" 
                           class="text-gray-500 hover:text-gray-700 transition duration-200 flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة للتقرير
                        </a>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">✏️ تعديل التقرير النفسي</h1>
                    <p class="text-gray-600 text-sm">تعديل التقرير النفسي للطالب: {{ $report->student->user->name }}</p>
                </div>
                
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('StudentPsychology.show', $report) }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        إلغاء
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1">
                        <svg class="fill-current h-5 w-5 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm mb-1">حدثت الأخطاء التالية:</p>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('StudentPsychology.update', $report->id) }}" method="POST" class="p-5">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">المعلومات الأساسية</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Student Selection -->
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                الطالب <span class="text-red-500">*</span>
                            </label>

                            <!-- Preserve the actual student id in a hidden field (backend uses this) -->
                           

                            <!-- Editable text input for the student name (you can type anything) -->
                            <input  type="text" name="student_name" id="student_id" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   value="{{ old('student_name', $report->student->user->name) }}"
                                   placeholder="اكتب أو عدل اسم الطالب هنا..."
                                   readonly
                                   >
                             
                           
                           
                        </div>
                        
                        <!-- Classroom Selection -->
                        <div>
                            <label for="classroom_id" class="block text-sm font-medium text-gray-700 mb-2">
                                الصف <span class="text-red-500">*</span>
                            </label>
                            <input  type="text" name="classroom_id" id="classroom_id" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                   value="{{ $report->classroom->class_name }}"
                                   placeholder="اكتب أو عدل اسم الطالب هنا..."
                                   readonly
                                   >
                        </div>
                    </div>
                </div>

                <!-- Psychological Assessment -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">التقييم النفسي</h3>
                    
                    <div class="space-y-6">
                        <!-- Mood -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                المزاج العام <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                                @php
                                    $moods = [
                                        'مبتهج' => '😊 مبتهج',
                                        'هادئ' => '😐 هادئ',
                                        'قلق' => '😟 قلق',
                                        'حزين' => '😢 حزين',
                                        'غاضب' => '😠 غاضب',
                                        'متحمس' => '🤩 متحمس'
                                    ];
                                @endphp
                                @foreach($moods as $value => $label)
                                    <label class="relative">
                                        <input type="radio" name="mood" value="{{ $value }}"
                                               {{ old('mood', $report->mood) == $value ? 'checked' : '' }}
                                               class="sr-only peer" required>
                                        <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-3 text-center cursor-pointer 
                                                    hover:bg-gray-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 
                                                    transition duration-200">
                                            <div class="text-2xl mb-1">{{ explode(' ', $label)[0] }}</div>
                                            <span class="text-sm font-medium">{{ explode(' ', $label)[1] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Social Interaction -->
                        <div>
                            <label for="social_interaction" class="block text-sm font-medium text-gray-700 mb-2">
                                التفاعل الاجتماعي <span class="text-red-500">*</span>
                            </label>
                            <select name="social_interaction" id="social_interaction" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="">اختر مستوى التفاعل الاجتماعي</option>
                                <option value="منطوي" {{ old('social_interaction', $report->social_interaction) == 'منطوي' ? 'selected' : '' }}>منطوي</option>
                                <option value="متواصل_بشكل_معتدل" {{ old('social_interaction', $report->social_interaction) == 'متواصل_بشكل_معتدل' ? 'selected' : '' }}>متواصل بشكل معتدل</option>
                                <option value="اجتماعي" {{ old('social_interaction', $report->social_interaction) == 'اجتماعي' ? 'selected' : '' }}>اجتماعي</option>
                                <option value="قائد_مجموعة" {{ old('social_interaction', $report->social_interaction) == 'قائد_مجموعة' ? 'selected' : '' }}>قائد مجموعة</option>
                            </select>
                        </div>
                        
                        <!-- Concentration -->
                        <div>
                            <label for="concentration" class="block text-sm font-medium text-gray-700 mb-2">
                                التركيز والانتباه <span class="text-red-500">*</span>
                            </label>
                            <select name="concentration" id="concentration" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="">اختر مستوى التركيز</option>
                                <option value="ضعيف" {{ old('concentration', $report->concentration) == 'ضعيف' ? 'selected' : '' }}>ضعيف</option>
                                <option value="متوسط" {{ old('concentration', $report->concentration) == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                                <option value="جيد" {{ old('concentration', $report->concentration) == 'جيد' ? 'selected' : '' }}>جيد</option>
                                <option value="ممتاز" {{ old('concentration', $report->concentration) == 'ممتاز' ? 'selected' : '' }}>ممتاز</option>
                            </select>
                        </div>
                        
                        <!-- Participation -->
                        <div>
                            <label for="participation" class="block text-sm font-medium text-gray-700 mb-2">
                                المشاركة الفعالة <span class="text-red-500">*</span>
                            </label>
                            <select name="participation" id="participation" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="">اختر مستوى المشاركة</option>
                                <option value="سلبي" {{ old('participation', $report->participation) == 'سلبي' ? 'selected' : '' }}>سلبي</option>
                                <option value="مشارك_أحياناً" {{ old('participation', $report->participation) == 'مشارك_أحياناً' ? 'selected' : '' }}>مشارك أحياناً</option>
                                <option value="نشط" {{ old('participation', $report->participation) == 'نشط' ? 'selected' : '' }}>نشط</option>
                                <option value="مبادر" {{ old('participation', $report->participation) == 'مبادر' ? 'selected' : '' }}>مبادر</option>
                            </select>
                        </div>
                        
                        <!-- Behavior -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                السلوك العام <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                                @php
                                    $behaviors = [
                                        'ممتاز' => ['color' => 'bg-green-100 text-green-800 border-green-200', 'icon' => '⭐'],
                                        'جيد' => ['color' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => '👍'],
                                        'مقبول' => ['color' => 'bg-amber-100 text-amber-800 border-amber-200', 'icon' => '👌'],
                                        'يحتاج_تحسين' => ['color' => 'bg-red-100 text-red-800 border-red-200', 'icon' => '📝']
                                    ];
                                @endphp
                                @foreach($behaviors as $value => $data)
                                    <label class="relative">
                                        <input type="radio" name="behavior" value="{{ $value }}"
                                               {{ old('behavior', $report->behavior) == $value ? 'checked' : '' }}
                                               class="sr-only peer" required>
                                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center cursor-pointer 
                                                    hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 
                                                    transition duration-200 {{ $data['color'] }}">
                                            <div class="text-2xl mb-2">{{ $data['icon'] }}</div>
                                            <span class="font-medium">{{ $value }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">الملاحظات والتوصيات</h3>
                    
                    <div class="space-y-6">
                        <!-- Strengths -->
                        <div>
                            <label for="strengths" class="block text-sm font-medium text-gray-700 mb-2">
                                نقاط القوة
                            </label>
                            <textarea name="strengths" id="strengths" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="اكتب نقاط القوة والصفات الإيجابية للطالب...">{{ old('strengths', $report->strengths) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">حدد نقاط القوة والمواهب والصفات الإيجابية التي يتمتع بها الطالب</p>
                        </div>
                        
                        <!-- Challenges -->
                        <div>
                            <label for="challenges" class="block text-sm font-medium text-gray-700 mb-2">
                                التحديات والصعوبات
                            </label>
                            <textarea name="challenges" id="challenges" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="اكتب التحديات والصعوبات التي يواجهها الطالب...">{{ old('challenges', $report->challenges) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">حدد الصعوبات والتحديات التي يواجهها الطالب في الجوانب النفسية أو الاجتماعية</p>
                        </div>
                        
                        <!-- Recommendations -->
                        <div>
                            <label for="recommendations" class="block text-sm font-medium text-gray-700 mb-2">
                                التوصيات والمقترحات
                            </label>
                            <textarea name="recommendations" id="recommendations" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="اكتب التوصيات والمقترحات لتحسين حالة الطالب...">{{ old('recommendations', $report->recommendations) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">اقترح خطط عمل أو تدخلات لمساعدة الطالب في التغلب على التحديات</p>
                        </div>
                        
                        <!-- General Notes -->
                        <div>
                            <label for="general_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                ملاحظات عامة
                            </label>
                            <textarea name="general_notes" id="general_notes" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="اكتب أي ملاحظات إضافية...">{{ old('general_notes', $report->general_notes) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">ملاحظات عامة إضافية عن حالة الطالب</p>
                        </div>
                        
                        <!-- Teacher's Personal Note -->
                        <div>
                            <label for="teacher_note" class="block text-sm font-medium text-gray-700 mb-2">
                                ملاحظة المعلم الشخصية
                                <span class="text-xs text-gray-500 font-normal">(اختيارية)</span>
                            </label>
                            <textarea name="teacher_note" id="teacher_note" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="اكتب ملاحظتك الشخصية...">{{ old('teacher_note', $report->teacher_note) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">ملاحظة خاصة منك كمعلم، قد لا تظهر في التقارير الرسمية</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">ملاحظة:</span> التقرير حالياً في حالة 
                        <span class="font-medium {{ $report->status == 'مسودة' ? 'text-amber-600' : 'text-green-600' }}">
                            {{ $report->status == 'مسودة' ? 'مسودة' : 'مرسل للإدارة' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <a href="{{route('StudentPsychology.index')}}" 
                           class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg transition duration-200 text-center">
                            إلغاء
                        </a>
                        
                        <button type="submit" 
                                class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            حفظ التغييرات
                        </button>
                        
                        @if($report->status == 'مسودة')
                        <button type="button" onclick="sendToManagement()"
                                class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            حفظ وإرسال للإدارة
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send to Management Modal -->
<div id="sendModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">إرسال التقرير للإدارة</h3>
            <p class="text-gray-600 text-sm">هل أنت متأكد من إرسال هذا التقرير للإدارة؟ بعد الإرسال لا يمكنك تعديل التقرير.</p>
        </div>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeSendModal()"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200">
                إلغاء
            </button>
            <button type="button" onclick="submitAndSend()"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow transition duration-200">
                نعم، إرسال الآن
            </button>
        </div>
    </div>
</div>

<script>
    // Auto-update classroom when student changes
    document.getElementById('student_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const classroomId = selectedOption.getAttribute('data-classroom');
        if (classroomId) {
            document.getElementById('classroom_id').value = classroomId;
        }
    });

    // Send to management modal
    function sendToManagement() {
        document.getElementById('sendModal').classList.remove('hidden');
        document.getElementById('sendModal').classList.add('flex');
    }

    function closeSendModal() {
        document.getElementById('sendModal').classList.remove('flex');
        document.getElementById('sendModal').classList.add('hidden');
    }

    function submitAndSend() {
        // Create a hidden input for status
        const form = document.querySelector('form');
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = 'مرسل_للإدارة';
        form.appendChild(statusInput);
        
        // Submit the form
        form.submit();
    }

    // Character counters for textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const counter = document.createElement('div');
        counter.className = 'text-xs text-gray-500 text-left mt-1';
        counter.innerHTML = `عدد الأحرف: <span id="counter_${textarea.id}">${textarea.value.length}</span> / 1000`;
        textarea.parentNode.appendChild(counter);
        
        textarea.addEventListener('input', function() {
            document.getElementById(`counter_${this.id}`).textContent = this.value.length;
        });
    });

    // Auto-resize textareas
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
        autoResize(textarea);
    });
</script>

<style>
    /* Custom styling for radio buttons */
    input[type="radio"]:checked + div {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    /* Focus styles */
    select:focus, textarea:focus {
        outline: none;
        ring-width: 2px;
    }
    
    /* Modal animation */
    #sendModal {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
        
        .grid-cols-6 {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endsection