@extends('layouts.student_dashboard')

@section('content')
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
.page { background: #f5f5f3; padding: 2rem 1.5rem; min-height: 100vh; direction: rtl; }
.max-w { max-width: 1100px; margin: 0 auto; }

.page-header { margin-bottom: 1.5rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.page-title { font-size: 22px; font-weight: 500; color: #1a1a1a; }
.page-sub { font-size: 13px; color: #6b6b6b; margin-top: 3px; }
.breadcrumb { font-size: 13px; color: #9b9b9b; display: flex; align-items: center; gap: 6px; }
.breadcrumb b { color: #6b6b6b; font-weight: 400; }

.toolbar { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.toolbar-label { font-size: 13px; color: #6b6b6b; white-space: nowrap; }
.pills { display: flex; gap: 6px; flex-wrap: wrap; }
.pill { padding: 5px 14px; border-radius: 999px; border: 0.5px solid rgba(0,0,0,0.2); font-size: 13px; color: #6b6b6b; background: transparent; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-block; }
.pill:hover { background: #f5f5f3; color: #1a1a1a; }
.pill.active { background: #1D9E75; border-color: #1D9E75; color: #fff; font-weight: 500; }

.notes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1rem; }
.note-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden; transition: all 0.2s ease; }
.note-card:hover { border-color: rgba(0,0,0,0.25); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.card-top-bar { height: 3px; }
.bar-blue { background: #3b82f6; }
.bar-green { background: #1D9E75; }
.bar-purple { background: #8b5cf6; }
.card-body { padding: 1.25rem; }
.card-head { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; }
.badges { display: flex; gap: 6px; flex-wrap: wrap; }
.badge { font-size: 11px; padding: 3px 9px; border-radius: 999px; font-weight: 500; }
.bg-lesson { background: #E6F1FB; color: #0C447C; }
.bg-subject { background: #E1F5EE; color: #085041; }
.bg-sent { background: #E1F5EE; color: #085041; }
.card-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 6px; line-height: 1.4; }
.card-meta { font-size: 12px; color: #9b9b9b; display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
.card-meta span { display: flex; align-items: center; gap: 4px; }
.note-content { background: #f8f8f6; border-radius: 10px; padding: 1rem; margin-top: 12px; }
.note-content p { font-size: 13px; color: #4a4a4a; line-height: 1.6; }
.card-footer { display: flex; align-items: center; justify-content: flex-end; margin-top: 16px; padding-top: 12px; border-top: 0.5px solid rgba(0,0,0,0.08); }
.btn { padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; border: none; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
.btn-ghost { background: transparent; border: 0.5px solid rgba(0,0,0,0.2); color: #6b6b6b; }
.btn-ghost:hover { background: #f5f5f3; }

.empty-state { text-align: center; padding: 4rem 1rem; background: #fff; border-radius: 12px; border: 0.5px solid rgba(0,0,0,0.1); }
.empty-icon { width: 52px; height: 52px; border-radius: 12px; background: #efefed; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.empty-icon svg { width: 24px; height: 24px; color: #9b9b9b; }
.empty-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 4px; }
.empty-sub { font-size: 13px; color: #6b6b6b; }

.pagination { margin-top: 1.5rem; display: flex; justify-content: center; }

@media(max-width: 640px) {
    .notes-grid { grid-template-columns: 1fr; }
}
</style>

<div class="page">
<div class="max-w">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">📝 ملاحظات التفاعل</div>
            <div class="page-sub">ملاحظات المعلم حول مشاركتك وتفاعلك في الدروس</div>
        </div>
        <div class="breadcrumb">
            لوحة التحكم
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <b>ملاحظات التفاعل</b>
        </div>
    </div>

    {{-- Subject Filter Toolbar --}}
    <div class="toolbar">
        <span class="toolbar-label">📖 تصفية حسب المادة:</span>
        <div class="pills">
            <a href="{{ route('student.interaction_notes.index') }}" 
               class="pill {{ !request('subject_id') ? 'active' : '' }}">
                جميع المواد
            </a>
            @foreach($subjects as $subject)
                <a href="{{ route('student.interaction_notes.index', ['subject_id' => $subject->id]) }}"
                   class="pill {{ request('subject_id') == $subject->id ? 'active' : '' }}">
                    {{ $subject->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Notes Grid --}}
    @if($notes->count() > 0)
        <div class="notes-grid">
            @foreach($notes as $index => $note)
                @php
                    $colors = ['bar-blue', 'bar-green', 'bar-purple'];
                    $colorIndex = $index % count($colors);
                @endphp
                
                <div class="note-card">
                    <div class="card-top-bar {{ $colors[$colorIndex] }}"></div>
                    <div class="card-body">
                        <div class="card-head">
                            <div class="badges">
                                <span class="badge bg-lesson">
                                    📚 {{ Str::limit($note->lesson->title ?? 'الدرس', 30) }}
                                </span>
                                @if($note->lesson->subject)
                                <span class="badge bg-subject">
                                    📖 {{ $note->lesson->subject->name }}
                                </span>
                                @endif
                            </div>
                            @if($note->status === 'send')
                                <span class="badge bg-sent">✓ تم الإرسال</span>
                            @endif
                        </div>
                        
                        <div class="card-meta">
                            <span>
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $note->teacher->user->name ?? 'المعلم' }}
                            </span>
                            <span>
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $note->created_at->format('Y-m-d') }}
                            </span>
                        </div>
                        
                        <div class="note-content">
                            <p>{{ Str::limit($note->note_content, 120) }}</p>
                        </div>
                        
                        <div class="card-footer">
                            <a href="{{ route('student.interaction_notes.show', $note->id) }}" class="btn btn-ghost">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="pagination">
            {{ $notes->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="empty-title">📭 لا توجد ملاحظات</div>
            <div class="empty-sub">لا توجد ملاحظات تفاعل متاحة حالياً</div>
        </div>
    @endif

</div>
</div>
@endsection