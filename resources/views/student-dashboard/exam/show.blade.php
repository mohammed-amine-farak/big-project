@extends('layouts.student_dashboard')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --bg: #080b14;
    --surface: #0d1120;
    --surface-2: #141828;
    --surface-3: #1c2235;
    --border: rgba(255,255,255,0.06);
    --border-hover: rgba(139,92,246,0.35);
    --text-primary: #f0f2ff;
    --text-secondary: #8892b0;
    --text-muted: #4a5568;
    --accent: #7c3aed;
    --accent-bright: #a78bfa;
    --accent-glow: rgba(124,58,237,0.2);
    --emerald: #10b981;
    --emerald-glow: rgba(16,185,129,0.15);
    --amber: #f59e0b;
    --font-display: 'Syne', sans-serif;
    --font-body: 'DM Sans', sans-serif;
}

.exam-root {
    min-height: 100vh;
    background: var(--bg);
    font-family: var(--font-body);
    color: var(--text-primary);
    position: relative;
    overflow-x: hidden;
}

/* Ambient background orbs */
.exam-root::before {
    content: '';
    position: fixed;
    top: -30%;
    right: -20%;
    width: 70vw;
    height: 70vw;
    background: radial-gradient(circle, rgba(124,58,237,0.08) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.exam-root::after {
    content: '';
    position: fixed;
    bottom: -20%;
    left: -15%;
    width: 50vw;
    height: 50vw;
    background: radial-gradient(circle, rgba(16,185,129,0.05) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}

.exam-inner {
    max-width: 860px;
    margin: 0 auto;
    padding: 2rem 1.5rem 6rem;
    position: relative;
    z-index: 1;
}

/* Back link */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.02em;
    margin-bottom: 2rem;
    transition: color 0.2s;
    font-family: var(--font-body);
}
.back-link:hover { color: var(--accent-bright); }
.back-link svg { width: 16px; height: 16px; }

/* Header card */
.exam-header {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.exam-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--accent), transparent);
    opacity: 0.6;
}

.exam-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(124,58,237,0.12);
    border: 1px solid rgba(124,58,237,0.25);
    border-radius: 100px;
    padding: 4px 12px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--accent-bright);
    margin-bottom: 1rem;
}
.exam-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--accent-bright);
    animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}

.exam-title {
    font-family: var(--font-display);
    font-size: clamp(1.6rem, 4vw, 2.2rem);
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.2;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.exam-subject {
    color: var(--text-secondary);
    font-size: 0.95rem;
    font-weight: 300;
}

.exam-meta-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
}

.meta-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 0.6rem 1rem;
}
.meta-chip-value {
    font-family: var(--font-display);
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--accent-bright);
    line-height: 1;
}
.meta-chip-label {
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* Timer chip special */
.meta-chip.timer {
    border-color: rgba(16,185,129,0.2);
    background: rgba(16,185,129,0.04);
}
.meta-chip.timer .meta-chip-value {
    color: var(--emerald);
}

/* Already taken state */
.taken-card {
    background: var(--surface);
    border: 1px solid rgba(245,158,11,0.2);
    border-radius: 20px;
    padding: 3rem 2rem;
    text-align: center;
}
.taken-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(245,158,11,0.1);
    border: 1px solid rgba(245,158,11,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}
.taken-icon svg { width: 28px; height: 28px; color: var(--amber); }
.taken-title {
    font-family: var(--font-display);
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.taken-subtitle { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 2rem; }
.taken-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.65rem 1.4rem;
    border-radius: 12px;
    font-family: var(--font-body);
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
}
.btn-emerald {
    background: rgba(16,185,129,0.12);
    color: var(--emerald);
    border: 1px solid rgba(16,185,129,0.25);
}
.btn-emerald:hover {
    background: rgba(16,185,129,0.2);
    transform: translateY(-1px);
}
.btn-ghost {
    background: var(--surface-2);
    color: var(--text-secondary);
    border: 1px solid var(--border);
}
.btn-ghost:hover { background: var(--surface-3); color: var(--text-primary); }

/* Questions */
.questions-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.question-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    transition: border-color 0.25s, box-shadow 0.25s;
    animation: fadeUp 0.4s ease both;
}
.question-card:hover {
    border-color: rgba(124,58,237,0.2);
    box-shadow: 0 0 0 1px rgba(124,58,237,0.08), 0 8px 32px rgba(0,0,0,0.3);
}
.question-card.answered {
    border-color: rgba(124,58,237,0.3);
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

.question-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem 1.5rem 1.25rem;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, rgba(124,58,237,0.04) 0%, transparent 60%);
}

.question-num {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--surface-3);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-muted);
    transition: all 0.25s;
    letter-spacing: 0;
}
.question-card.answered .question-num {
    background: var(--accent-glow);
    border-color: rgba(124,58,237,0.3);
    color: var(--accent-bright);
}

.question-text {
    font-size: 1rem;
    font-weight: 400;
    color: var(--text-primary);
    line-height: 1.65;
    padding-top: 6px;
}

.choices-list {
    padding: 1.25rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.choice-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.85rem 1rem;
    border-radius: 12px;
    border: 1px solid var(--border);
    cursor: pointer;
    transition: all 0.18s ease;
    position: relative;
    overflow: hidden;
}
.choice-label::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(124,58,237,0.06) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.2s;
}
.choice-label:hover {
    border-color: rgba(124,58,237,0.3);
    background: rgba(124,58,237,0.04);
}
.choice-label:hover::before { opacity: 1; }

/* Custom radio */
.choice-radio {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.18s ease;
    background: transparent;
    position: relative;
    z-index: 1;
}
.choice-radio::after {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--accent-bright);
    opacity: 0;
    transform: scale(0);
    transition: all 0.18s ease;
}

input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
input[type="radio"]:checked + .choice-label {
    border-color: rgba(124,58,237,0.4);
    background: rgba(124,58,237,0.07);
}
input[type="radio"]:checked + .choice-label .choice-radio {
    border-color: var(--accent-bright);
    background: rgba(124,58,237,0.15);
}
input[type="radio"]:checked + .choice-label .choice-radio::after {
    opacity: 1;
    transform: scale(1);
}

.choice-text {
    font-size: 0.92rem;
    color: var(--text-secondary);
    line-height: 1.5;
    transition: color 0.18s;
    position: relative;
    z-index: 1;
}
input[type="radio"]:checked + .choice-label .choice-text {
    color: var(--text-primary);
}

/* Sticky footer bar */
.submit-bar {
    position: fixed;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 3rem);
    max-width: 860px;
    background: rgba(13,17,32,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 1rem 1.25rem;
    z-index: 100;
    box-shadow: 0 -4px 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(124,58,237,0.08);
}
.submit-bar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.progress-section {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.progress-track {
    position: relative;
    width: 120px;
    height: 4px;
    background: var(--surface-3);
    border-radius: 100px;
    overflow: hidden;
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent), var(--accent-bright));
    border-radius: 100px;
    transition: width 0.3s ease;
    width: 0%;
}

.progress-text {
    font-size: 0.82rem;
    color: var(--text-secondary);
    white-space: nowrap;
}
.progress-text strong {
    color: var(--text-primary);
    font-weight: 600;
    font-family: var(--font-display);
}

.timer-text {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    color: var(--text-secondary);
}
.timer-text svg { width: 14px; height: 14px; }

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
    color: #fff;
    font-family: var(--font-display);
    font-size: 0.92rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 20px rgba(124,58,237,0.3);
    white-space: nowrap;
}
.btn-submit:hover {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    transform: translateY(-1px);
    box-shadow: 0 6px 28px rgba(124,58,237,0.4);
}
.btn-submit:active { transform: translateY(0); }
.btn-submit svg { width: 16px; height: 16px; }

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 200;
    background: rgba(0,0,0,0.75);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.modal-overlay.open {
    display: flex;
}
.modal-box {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 24px;
    padding: 2rem;
    max-width: 420px;
    width: 100%;
    text-align: center;
    position: relative;
    animation: modalIn 0.25s ease;
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.95) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.modal-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(245,158,11,0.1);
    border: 1px solid rgba(245,158,11,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
}
.modal-icon svg { width: 26px; height: 26px; color: var(--amber); }
.modal-title {
    font-family: var(--font-display);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.6rem;
}
.modal-desc { color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.75rem; }
.modal-actions { display: flex; gap: 10px; }
.modal-actions .btn { flex: 1; justify-content: center; }
.btn-confirm {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border: none;
    box-shadow: 0 4px 16px rgba(16,185,129,0.3);
}
.btn-confirm:hover { box-shadow: 0 6px 22px rgba(16,185,129,0.4); transform: translateY(-1px); }
</style>

<div class="exam-root">
    <div class="exam-inner">

        <a href="{{ route('student.lessons.show', $lesson) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            العودة إلى الدرس
        </a>

        <!-- Header -->
        <div class="exam-header">
            <div class="exam-badge">
                <div class="exam-badge-dot"></div>
                اختبار
            </div>
            <h1 class="exam-title">{{ $exam->title }}</h1>
            @if($exam->subject)
                <p class="exam-subject">{{ $exam->subject }}</p>
            @endif

            <div class="exam-meta-row">
                <div class="meta-chip">
                    <svg width="16" height="16" fill="none" stroke="#a78bfa" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 8h14M7 4h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                    </svg>
                    <div>
                        <div class="meta-chip-value">{{ $exam->questions->count() }}</div>
                        <div class="meta-chip-label">سؤال</div>
                    </div>
                </div>
                @if($exam->start_time && $exam->end_time)
                <div class="meta-chip timer">
                    <svg width="16" height="16" fill="none" stroke="#10b981" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                    </svg>
                    <div>
                        <div class="meta-chip-value" id="timer-display">--:--</div>
                        <div class="meta-chip-label">الوقت المتبقي</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($hasTaken)
            <div class="taken-card">
                <div class="taken-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="taken-title">لقد أكملت هذا الاختبار</h3>
                <p class="taken-subtitle">يمكنك عرض نتيجتك أو العودة إلى الدرس</p>
                <div class="taken-actions">
                    <a href="{{ route('student.exam.results', $exam) }}" class="btn btn-emerald">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        عرض النتيجة
                    </a>
                    <a href="{{ route('student.lessons.show', $lesson) }}" class="btn btn-ghost">
                        العودة للدرس
                    </a>
                </div>
            </div>
        @else
            <form id="examForm" action="{{ route('student.exam.submit', $exam) }}" method="POST">
                @csrf
                <div class="questions-list">
                    @foreach($exam->questions as $index => $question)
                    <div class="question-card" id="qcard-{{ $question->id }}" style="animation-delay: {{ $index * 0.05 }}s">
                        <div class="question-header">
                            <div class="question-num" id="qnum-{{ $question->id }}">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <p class="question-text">{{ $question->question_text }}</p>
                        </div>
                        <div class="choices-list">
                            @foreach($question->choices as $ci => $choice)
                            <div style="position: relative;">
                                <input type="radio"
                                       id="choice-{{ $choice->id }}"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $choice->id }}"
                                       data-qid="{{ $question->id }}">
                                <label for="choice-{{ $choice->id }}" class="choice-label">
                                    <div class="choice-radio">
                                        <span style="width:8px;height:8px;border-radius:50%;background:var(--accent-bright);opacity:0;transform:scale(0);transition:all 0.18s ease;" class="radio-dot"></span>
                                    </div>
                                    <span class="choice-text">{{ $choice->choice_text }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>

            <!-- Submit bar -->
            <div class="submit-bar">
                <div class="submit-bar-inner">
                    <div class="progress-section">
                        <div>
                            <div class="progress-text" style="margin-bottom:6px;">
                                <strong id="answered-count">0</strong> / {{ $exam->questions->count() }} تم الإجابة
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill" id="progress-fill"></div>
                            </div>
                        </div>
                        @if($exam->start_time && $exam->end_time)
                        <div class="timer-text">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 7v5l3 3"/>
                            </svg>
                            <span id="remaining-time"></span>
                        </div>
                        @endif
                    </div>

                    <button type="button" onclick="confirmSubmit()" class="btn-submit">
                        تأكيد الإرسال
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

    </div>
</div>

<!-- Confirm Modal -->
<div id="confirmModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="modal-title">تأكيد الإرسال</h3>
        <p class="modal-desc">هل أنت متأكد من إرسال إجاباتك؟<br>لا يمكنك تعديل الإجابات بعد الإرسال.</p>
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-ghost">إلغاء</button>
            <button onclick="submitExam()" class="btn btn-confirm">تأكيد الإرسال</button>
        </div>
    </div>
</div>

<script>
const TOTAL_QUESTIONS = {{ $exam->questions->count() }};

// Timer


// Progress tracking
function updateProgress() {
    const radios = document.querySelectorAll('input[type="radio"]');
    const answered = new Set();
    radios.forEach(r => { if(r.checked) answered.add(r.name); });
    const count = answered.size;
    document.getElementById('answered-count').textContent = count;
    const pct = TOTAL_QUESTIONS > 0 ? (count / TOTAL_QUESTIONS * 100) : 0;
    document.getElementById('progress-fill').style.width = pct + '%';
}

// Style radio dot + card state
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        updateProgress();
        const qid = this.dataset.qid;
        const card = document.getElementById('qcard-' + qid);
        const num  = document.getElementById('qnum-' + qid);
        if(card) card.classList.add('answered');
        // Update dots in this question
        const dots = document.querySelectorAll(`input[data-qid="${qid}"] ~ label .radio-dot, label[for="${this.id}"] .radio-dot`);
        document.querySelectorAll(`input[data-qid="${qid}"]`).forEach(r => {
            const dot = r.nextElementSibling?.querySelector('.radio-dot');
            if(dot) { dot.style.opacity = r.checked ? '1' : '0'; dot.style.transform = r.checked ? 'scale(1)' : 'scale(0)'; }
        });
    });
});

updateProgress();

// Modal
function confirmSubmit() {
    const answered = parseInt(document.getElementById('answered-count').textContent);
    if(answered < TOTAL_QUESTIONS) {
        if(!confirm(`لقد أجبت على ${answered} من أصل ${TOTAL_QUESTIONS} سؤال. هل تريد الإرسال؟`)) return;
    }
    document.getElementById('confirmModal').classList.add('open');
}
function closeModal() { document.getElementById('confirmModal').classList.remove('open'); }
function submitExam() { document.getElementById('examForm').submit(); }

window.addEventListener('beforeunload', function(e) {
    const answered = parseInt(document.getElementById('answered-count').textContent);
    if(answered > 0) { e.preventDefault(); e.returnValue = 'هل أنت متأكد من مغادرة الصفحة؟'; return e.returnValue; }
});

// Auto-save
function saveAnswers() {
    const answers = {};
    document.querySelectorAll('input[type="radio"]:checked').forEach(r => { answers[r.name] = r.value; });
    localStorage.setItem('exam_{{ $exam->id }}_answers', JSON.stringify(answers));
}
function loadAnswers() {
    const saved = localStorage.getItem('exam_{{ $exam->id }}_answers');
    if(!saved) return;
    const answers = JSON.parse(saved);
    for(const [name, value] of Object.entries(answers)) {
        const radio = document.querySelector(`input[name="${name}"][value="${value}"]`);
        if(radio) { radio.checked = true; radio.dispatchEvent(new Event('change')); }
    }
}
setInterval(saveAnswers, 30000);
loadAnswers();
document.getElementById('examForm').addEventListener('submit', function() {
    localStorage.removeItem('exam_{{ $exam->id }}_answers');
});
</script>

@endsection