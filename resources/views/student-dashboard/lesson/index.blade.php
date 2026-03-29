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

.stats-row { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-bottom: 1.5rem; }
.stat { background: #efefed; border-radius: 8px; padding: 14px 16px; }
.stat-label { font-size: 12px; color: #6b6b6b; margin-bottom: 4px; }
.stat-num { font-size: 26px; font-weight: 500; color: #1a1a1a; }
.stat-num.g { color: #0F6E56; }
.stat-num.a { color: #854F0B; }
.stat-num.m { color: #9b9b9b; }

.section-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; flex-wrap: wrap; gap: 8px; }
.section-title { font-size: 14px; font-weight: 500; color: #1a1a1a; }
.ftabs { display: flex; gap: 4px; }
.ftab { padding: 4px 12px; border-radius: 999px; font-size: 12px; border: 0.5px solid rgba(0,0,0,0.1); color: #6b6b6b; background: transparent; cursor: pointer; transition: all 0.15s; }
.ftab:hover, .ftab.active { background: #efefed; color: #1a1a1a; border-color: rgba(0,0,0,0.2); }

.lessons-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem; }
.lesson-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden; transition: border-color 0.15s; }
.lesson-card:hover { border-color: rgba(0,0,0,0.25); }
.card-top-bar { height: 3px; }
.bar-g { background: #1D9E75; }
.bar-a { background: #EF9F27; }
.bar-n { background: rgba(0,0,0,0.15); }
.card-body { padding: 1.25rem; }
.card-head { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; }
.badges { display: flex; gap: 6px; flex-wrap: wrap; }
.badge { font-size: 11px; padding: 3px 9px; border-radius: 999px; font-weight: 500; }
.bg-g { background: #E1F5EE; color: #085041; }
.bg-a { background: #FAEEDA; color: #633806; }
.bg-n { background: #efefed; color: #5f5e5a; }
.bg-b { background: #E6F1FB; color: #0C447C; }
.card-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 6px; line-height: 1.4; }
.card-desc { font-size: 13px; color: #6b6b6b; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 16px; padding-top: 12px; border-top: 0.5px solid rgba(0,0,0,0.08); }
.meta { font-size: 12px; color: #9b9b9b; display: flex; align-items: center; gap: 4px; }
.meta svg { width: 14px; height: 14px; }
.actions { display: flex; gap: 6px; }
.btn { padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; border: none; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; }
.btn-ghost { background: transparent; border: 0.5px solid rgba(0,0,0,0.2); color: #6b6b6b; }
.btn-ghost:hover { background: #f5f5f3; }
.btn-teal { background: #1D9E75; color: #fff; }
.btn-teal:hover { background: #0F6E56; }
.btn-dark { background: #085041; color: #fff; }
.btn-dark:hover { background: #04342C; }

.empty-state { grid-column: 1/-1; text-align: center; padding: 4rem 1rem; }
.empty-icon { width: 52px; height: 52px; border-radius: 12px; background: #efefed; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.empty-icon svg { width: 24px; height: 24px; color: #9b9b9b; }
.empty-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 4px; }
.empty-sub { font-size: 13px; color: #6b6b6b; }

.select-prompt { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; padding: 4rem 2rem; text-align: center; }
.select-prompt-icon { width: 52px; height: 52px; border-radius: 12px; background: #E1F5EE; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
.select-prompt-icon svg { width: 24px; height: 24px; color: #1D9E75; }
.select-prompt-title { font-size: 17px; font-weight: 500; color: #1a1a1a; margin-bottom: 6px; }
.select-prompt-sub { font-size: 13px; color: #6b6b6b; }

@media(max-width: 640px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .lessons-grid { grid-template-columns: 1fr; }
    .ftabs { flex-wrap: wrap; }
}
</style>

<div class="page">
<div class="max-w">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">الدروس</div>
            <div class="page-sub">تصفح جميع الدروس المتاحة</div>
        </div>
        <div class="breadcrumb">
            لوحة التحكم
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <b>الدروس</b>
        </div>
    </div>

    {{-- Subject Toolbar --}}
    <div class="toolbar">
        <span class="toolbar-label">المادة:</span>
        <div class="pills">
            @foreach($subjects as $subject)
                <a href="{{ route('student.lesson.index', ['subject_id' => $subject->id]) }}"
                   class="pill {{ $selectedSubjectId == $subject->id ? 'active' : '' }}">
                    {{ $subject->name }}
                </a>
            @endforeach
        </div>
    </div>

    @if($selectedSubjectId)

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat">
                <div class="stat-label">إجمالي الدروس</div>
                <div class="stat-num">{{ $totalLessons }}</div>
            </div>
            <div class="stat">
                <div class="stat-label">مكتمل</div>
                <div class="stat-num g">{{ $completedLessons }}</div>
            </div>
            <div class="stat">
                <div class="stat-label">قيد التعلم</div>
                <div class="stat-num a">{{ $inProgressLessons }}</div>
            </div>
            <div class="stat">
                <div class="stat-label">لم يبدأ</div>
                <div class="stat-num m">{{ $notStartedLessons }}</div>
            </div>
        </div>

        {{-- Section Header + Filter Tabs --}}
        <div class="section-head">
            <div class="section-title">جميع الدروس</div>
            <div class="ftabs">
                <div class="ftab active" onclick="filterCards(this,'all')">الكل</div>
                <div class="ftab" onclick="filterCards(this,'in_progress')">قيد التعلم</div>
                <div class="ftab" onclick="filterCards(this,'completed')">مكتمل</div>
                <div class="ftab" onclick="filterCards(this,'not_started')">لم يبدأ</div>
            </div>
        </div>

        {{-- Lessons Grid --}}
        <div class="lessons-grid" id="lessonsGrid">
            @forelse($lessonsWithProgress as $item)
                @php
                    if ($item['status'] === 'completed') {
                        $barClass    = 'bar-g';
                        $badgeClass  = 'bg-g';
                        $statusText  = 'مكتمل';
                        $btnClass    = 'btn-dark';
                        $btnText     = 'مراجعة';
                    } elseif ($item['status'] === 'in_progress') {
                        $barClass    = 'bar-a';
                        $badgeClass  = 'bg-a';
                        $statusText  = 'قيد التعلم';
                        $btnClass    = 'btn-teal';
                        $btnText     = 'متابعة';
                    } else {
                        $barClass    = 'bar-n';
                        $badgeClass  = 'bg-n';
                        $statusText  = 'لم يبدأ';
                        $btnClass    = 'btn-teal';
                        $btnText     = 'بدء';
                    }
                @endphp

                <div class="lesson-card" data-status="{{ $item['status'] }}">
                    <div class="card-top-bar {{ $barClass }}"></div>
                    <div class="card-body">
                        <div class="card-head">
                            <div class="badges">
                                <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                @if($item['subject'])
                                    <span class="badge bg-b">{{ $item['subject']->name }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-title">{{ $item['title'] }}</div>
                        <div class="card-desc">{{ $item['description'] ?? 'شرح مفصل للدرس...' }}</div>
                        <div class="card-footer">
                            <div class="meta">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $item['created_at']->diffForHumans() }}
                            </div>
                            <div class="actions">
                                <a href="{{ route('student.lessons.show', $item['id']) }}" class="btn btn-ghost">تفاصيل</a>
                                <a href="{{ route('student.lessons.show', $item['id']) }}" class="btn {{ $btnClass }}">{{ $btnText }}</a>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="empty-title">لا توجد دروس</div>
                    <div class="empty-sub">لم يتم إضافة دروس لهذه المادة بعد</div>
                </div>
            @endforelse
        </div>

    @else

        {{-- No subject selected --}}
        <div class="select-prompt">
            <div class="select-prompt-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="select-prompt-title">اختر مادة للبدء</div>
            <div class="select-prompt-sub">الرجاء اختيار مادة من الأزرار أعلاه لعرض الدروس</div>
        </div>

    @endif

</div>
</div>

<script>
function filterCards(el, status) {
    document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('.lesson-card').forEach(card => {
        card.style.display = (status === 'all' || card.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endsection