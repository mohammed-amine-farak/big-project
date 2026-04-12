@extends('layouts.student_dashboard')

@section('content')
<style>
.page { background: #f5f5f3; padding: 2rem 1.5rem; min-height: 100vh; direction: rtl; }
.max-w { max-width: 900px; margin: 0 auto; }

/* Modern Header */
.page-header { margin-bottom: 2rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.page-title { font-size: 28px; font-weight: 600; color: #1a1a1a; letter-spacing: -0.3px; }
.page-sub { font-size: 14px; color: #6b6b6b; margin-top: 4px; }
.breadcrumb { font-size: 13px; color: #9b9b9b; display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.8); padding: 6px 12px; border-radius: 40px; backdrop-filter: blur(4px); }
.breadcrumb b { color: #1D9E75; font-weight: 500; }

/* Modern Card */
.note-detail-card { 
    background: #fff; 
    border-radius: 24px; 
    overflow: hidden; 
    box-shadow: 0 8px 30px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.note-detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.08);
}

/* Gradient Header with Pattern */
.card-header { 
    background: linear-gradient(135deg, #1D9E75 0%, #0F6E56 100%);
    padding: 2rem 2rem;
    position: relative;
    overflow: hidden;
}
.card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
    background-size: 20px 20px;
    opacity: 0.5;
}
.card-header h2 { 
    color: #fff; 
    font-size: 24px; 
    font-weight: 600; 
    margin: 0;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 10px;
}
.card-header h2::before {
    content: '📝';
    font-size: 28px;
}

/* Card Body */
.card-body { padding: 2rem; }

/* Modern Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}
.info-item {
    background: #f8f8f6;
    border-radius: 16px;
    padding: 1rem;
    transition: all 0.2s ease;
}
.info-item:hover {
    background: #f0f0ee;
    transform: translateY(-2px);
}
.info-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #9b9b9b;
    margin-bottom: 8px;
}
.info-value {
    font-size: 15px;
    font-weight: 500;
    color: #1a1a1a;
}

/* Modern Badges */
.badge-modern {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 40px;
    font-size: 13px;
    font-weight: 500;
}
.bg-lesson { background: linear-gradient(135deg, #E6F1FB, #D4E4F5); color: #0C447C; }
.bg-subject { background: linear-gradient(135deg, #E1F5EE, #C8E8DD); color: #085041; }
.status-sent { background: linear-gradient(135deg, #E1F5EE, #C8E8DD); color: #1D9E75; }
.status-draft { background: linear-gradient(135deg, #FEF3C7, #FDE68A); color: #92400E; }

/* Note Content Box */
.note-content-box {
    background: linear-gradient(135deg, #fafaf8, #f5f5f3);
    border-radius: 20px;
    padding: 2rem;
    margin: 1.5rem 0;
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;
}
.note-content-box::before {
    content: '"';
    position: absolute;
    top: -10px;
    right: 20px;
    font-size: 60px;
    color: #1D9E75;
    opacity: 0.1;
    font-family: serif;
}
.note-content-box p {
    font-size: 16px;
    color: #2d2d2d;
    line-height: 1.8;
    margin: 0;
}

/* Quote Icon */
.quote-icon {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}
.quote-icon svg {
    width: 24px;
    height: 24px;
    color: #1D9E75;
    opacity: 0.6;
}
.quote-icon span {
    font-size: 12px;
    font-weight: 500;
    color: #9b9b9b;
    letter-spacing: 0.5px;
}

/* Modern Actions */
.actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(0,0,0,0.08);
}
.btn-modern {
    padding: 10px 24px;
    border-radius: 40px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.2s ease;
}
.btn-back {
    background: transparent;
    border: 1px solid rgba(0,0,0,0.15);
    color: #6b6b6b;
}
.btn-back:hover {
    background: #f5f5f3;
    border-color: #1D9E75;
    color: #1D9E75;
    transform: translateX(-4px);
}
.btn-print {
    background: transparent;
    border: 1px solid rgba(0,0,0,0.15);
    color: #6b6b6b;
}
.btn-print:hover {
    background: #f5f5f3;
    border-color: #8b5cf6;
    color: #8b5cf6;
}

/* Responsive */
@media(max-width: 640px) {
    .info-grid { grid-template-columns: 1fr; }
    .page-title { font-size: 22px; }
    .card-header h2 { font-size: 18px; }
    .card-body { padding: 1.5rem; }
    .note-content-box { padding: 1.5rem; }
    .actions { flex-direction: column; gap: 12px; }
    .btn-modern { width: 100%; justify-content: center; }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.note-detail-card {
    animation: fadeInUp 0.4s ease-out;
}
</style>

<div class="page">
<div class="max-w">

    {{-- Modern Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">تفاصيل الملاحظة</div>
            <div class="page-sub">عرض تفاصيل ملاحظة التفاعل من المعلم</div>
        </div>
        <div class="breadcrumb">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <a href="{{ route('student.lesson.index') }}" style="color: #6b6b6b; text-decoration: none;">الرئيسية</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('student.interaction_notes.index') }}" style="color: #6b6b6b; text-decoration: none;">ملاحظات التفاعل</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
            </svg>
            <b>تفاصيل الملاحظة</b>
        </div>
    </div>

    {{-- Modern Note Detail Card --}}
    <div class="note-detail-card">
        <div class="card-header">
            <h2>ملاحظة من المعلم</h2>
        </div>
        <div class="card-body">
            
            {{-- Modern Info Grid --}}
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">📚 الدرس</div>
                    <div class="info-value">{{ $note->lesson->title ?? 'الدرس' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">📖 المادة</div>
                    <div class="info-value">{{ $note->lesson->subject->name ?? 'غير محدد' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">👨‍🏫 المعلم</div>
                    <div class="info-value">{{ $note->teacher->user->name ?? 'المعلم' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">📅 التاريخ</div>
                    <div class="info-value">{{ $note->created_at->format('Y-m-d') }}</div>
                </div>
            </div>

            {{-- Modern Note Content --}}
            <div class="quote-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <span>محتوى الملاحظة</span>
            </div>
            <div class="note-content-box">
                <p>{{ $note->note_content }}</p>
            </div>

            {{-- Status Badge --}}
           
            {{-- Modern Actions --}}
            <div class="actions">
                <a href="{{ route('student.interaction_notes.index') }}" class="btn-modern btn-back">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة إلى القائمة
                </a>
              
            </div>
        </div>
    </div>

</div>
</div>

@endsection