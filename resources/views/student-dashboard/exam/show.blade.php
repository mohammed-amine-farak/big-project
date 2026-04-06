@extends('layouts.student_dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('student.lessons.show', $lesson) }}" 
               class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                العودة إلى الدرس
            </a>
            
            <div class="rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 p-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-bold tracking-wider text-purple-400 uppercase">اختبار</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $exam->title }}</h1>
                        @if($exam->subject)
                            <p class="text-slate-400">{{ $exam->subject }}</p>
                        @endif
                    </div>
                    
                    <div class="flex gap-3">
                        <div class="text-center px-4 py-2 rounded-xl bg-white/5">
                            <div class="text-2xl font-bold text-purple-400">{{ $exam->questions->count() }}</div>
                            <div class="text-xs text-slate-400">أسئلة</div>
                        </div>
                        @if($exam->start_time && $exam->end_time)
                        <div class="text-center px-4 py-2 rounded-xl bg-white/5">
                            <div class="text-2xl font-bold text-purple-400" id="timer-display">--:--</div>
                            <div class="text-xs text-slate-400">الوقت المتبقي</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($hasTaken)
            <!-- Already Taken Alert -->
            <div class="rounded-2xl bg-amber-500/10 border border-amber-500/20 p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-amber-500/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">لقد قمت بالفعل بحل هذا الاختبار</h3>
                <p class="text-slate-400 mb-4">يمكنك عرض نتيجتك أو العودة إلى الدرس</p>
                <div class="flex gap-3 justify-center">
                    <a href="{{ route('student.exam.results', $exam) }}" 
                       class="px-6 py-2 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition-all">
                        عرض النتيجة
                    </a>
                    <a href="{{ route('student.lessons.show', $lesson) }}" 
                       class="px-6 py-2 rounded-xl bg-white/5 text-white border border-white/10 hover:bg-white/10 transition-all">
                        العودة للدرس
                    </a>
                </div>
            </div>
        @else
            <!-- Exam Form -->
            <form id="examForm" action="{{ route('student.exam.submit', $exam) }}" method="POST" class="space-y-6">
                @csrf
                
                @foreach($exam->questions as $index => $question)
                <div class="rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 overflow-hidden hover:border-purple-500/30 transition-all duration-300">
                    <div class="px-6 py-4 border-b border-white/10 bg-gradient-to-r from-purple-500/5 to-transparent">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold bg-purple-500/10 text-purple-400">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <h3 class="text-lg font-bold text-white">{{ $question->question_text }}</h3>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        @foreach($question->choices as $choice)
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-white/10 hover:border-purple-500/30 cursor-pointer transition-all group">
                            <input type="radio" 
                                   name="answers[{{ $question->id }}]" 
                                   value="{{ $choice->id }}"
                                   class="mt-1 w-4 h-4 text-purple-500 bg-transparent border-white/30 focus:ring-purple-500 focus:ring-2">
                            <span class="text-slate-300 group-hover:text-white transition-colors">{{ $choice->choice_text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
                
                <!-- Submit Button -->
                <div class="sticky bottom-4 rounded-2xl bg-slate-800/90 backdrop-blur-md border border-white/10 p-4">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-slate-400">
                                <span class="text-white font-bold" id="answered-count">0</span> / {{ $exam->questions->count() }} تم الإجابة
                            </div>
                            <div class="w-px h-6 bg-white/10"></div>
                            <div class="text-sm text-slate-400">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span id="remaining-time"></span>
                            </div>
                        </div>
                        
                        <button type="button" onclick="confirmSubmit()"
                                class="px-8 py-3 rounded-xl font-bold transition-all hover:scale-105 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40">
                            تأكيد الإرسال
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm">
    <div class="max-w-md w-full mx-4">
        <div class="rounded-2xl bg-slate-800 border border-white/10 p-6 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-amber-500/20 flex items-center justify-center">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">تأكيد الإرسال</h3>
            <p class="text-slate-400 mb-4">هل أنت متأكد من إرسال إجاباتك؟ لا يمكنك تعديل الإجابات بعد الإرسال.</p>
            <div class="flex gap-3">
                <button onclick="closeModal()" 
                        class="flex-1 px-4 py-2 rounded-xl bg-white/5 text-white border border-white/10 hover:bg-white/10 transition-all">
                    إلغاء
                </button>
                <button onclick="submitExam()" 
                        class="flex-1 px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-medium hover:scale-105 transition-all">
                    تأكيد الإرسال
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Timer functionality
@if($exam->start_time && $exam->end_time)
let endTime = new Date('{{ $exam->end_time }}').getTime();
let timerInterval;

function updateTimer() {
    const now = new Date().getTime();
    const distance = endTime - now;
    
    if (distance <= 0) {
        clearInterval(timerInterval);
        document.getElementById('timer-display').textContent = '00:00';
        // Auto submit when time runs out
        alert('انتهى الوقت المحدد للاختبار. سيتم إرسال إجاباتك تلقائياً.');
        submitExam();
        return;
    }
    
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    document.getElementById('timer-display').textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

timerInterval = setInterval(updateTimer, 1000);
updateTimer();
@endif

// Track answered questions
function updateAnsweredCount() {
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    const answered = new Set();
    
    radioButtons.forEach(radio => {
        if (radio.checked) {
            answered.add(radio.name);
        }
    });
    
    document.getElementById('answered-count').textContent = answered.size;
}

// Listen to radio button changes
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', updateAnsweredCount);
});

// Initial count
updateAnsweredCount();

// Confirmation modal
function confirmSubmit() {
    const answered = document.getElementById('answered-count').textContent;
    const total = {{ $exam->questions->count() }};
    
    if (parseInt(answered) < total) {
        if (!confirm(`لقد أجبت على ${answered} من أصل ${total} سؤال. هل تريد الإرسال؟`)) {
            return;
        }
    }
    
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
}

function submitExam() {
    document.getElementById('examForm').submit();
}

// Prevent accidental page refresh
window.addEventListener('beforeunload', function(e) {
    const answered = document.getElementById('answered-count').textContent;
    if (parseInt(answered) > 0) {
        e.preventDefault();
        e.returnValue = 'هل أنت متأكد من مغادرة الصفحة؟ سيتم فقدان إجاباتك.';
        return e.returnValue;
    }
});

// Auto-save answers to localStorage (optional)
function saveAnswers() {
    const formData = new FormData(document.getElementById('examForm'));
    const answers = {};
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('answers[')) {
            answers[key] = value;
        }
    }
    localStorage.setItem('exam_{{ $exam->id }}_answers', JSON.stringify(answers));
}

function loadAnswers() {
    const saved = localStorage.getItem('exam_{{ $exam->id }}_answers');
    if (saved) {
        const answers = JSON.parse(saved);
        for (const [name, value] of Object.entries(answers)) {
            const radio = document.querySelector(`input[name="${name}"][value="${value}"]`);
            if (radio) radio.checked = true;
        }
        updateAnsweredCount();
    }
}

// Save answers every 30 seconds
setInterval(saveAnswers, 30000);
loadAnswers();

// Clear saved answers on submit
document.getElementById('examForm').addEventListener('submit', function() {
    localStorage.removeItem('exam_{{ $exam->id }}_answers');
});
</script>

<style>
input[type="radio"] {
    accent-color: #8b5cf6;
}
</style>
@endsection