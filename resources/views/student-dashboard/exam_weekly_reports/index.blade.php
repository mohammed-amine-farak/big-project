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

.reports-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1rem; }
.report-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden; transition: all 0.2s ease; }
.report-card:hover { border-color: rgba(0,0,0,0.25); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.card-top-bar { height: 3px; }
.bar-green { background: #1D9E75; }
.bar-orange { background: #EF9F27; }
.bar-red { background: #DC2626; }
.card-body { padding: 1.25rem; }
.card-head { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; }
.badges { display: flex; gap: 6px; flex-wrap: wrap; }
.badge { font-size: 11px; padding: 3px 9px; border-radius: 999px; font-weight: 500; }
.bg-exam { background: #E6F1FB; color: #0C447C; }
.bg-score-high { background: #E1F5EE; color: #085041; }
.bg-score-medium { background: #FAEEDA; color: #633806; }
.bg-score-low { background: #FEE2E2; color: #991B1B; }
.card-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 8px; }
.score-large { font-size: 28px; font-weight: 600; margin: 12px 0; display: inline-block; }
.score-large span { font-size: 14px; font-weight: normal; color: #6b6b6b; }
.note-preview { font-size: 13px; color: #6b6b6b; line-height: 1.6; margin: 12px 0; }
.card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 16px; padding-top: 12px; border-top: 0.5px solid rgba(0,0,0,0.08); }
.meta { font-size: 12px; color: #9b9b9b; display: flex; align-items: center; gap: 4px; }
.btn { padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.15s; }
.btn-ghost { background: transparent; border: 0.5px solid rgba(0,0,0,0.2); color: #6b6b6b; }
.btn-ghost:hover { background: #f5f5f3; }
.btn-teal { background: #1D9E75; color: #fff; }
.btn-teal:hover { background: #0F6E56; }

.empty-state { grid-column: 1/-1; text-align: center; padding: 4rem 1rem; }
.empty-icon { width: 52px; height: 52px; border-radius: 12px; background: #efefed; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.empty-icon svg { width: 24px; height: 24px; color: #9b9b9b; }
.empty-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 4px; }
.empty-sub { font-size: 13px; color: #6b6b6b; }

.pagination { margin-top: 1.5rem; display: flex; justify-content: center; }

@media(max-width: 640px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .reports-grid { grid-template-columns: 1fr; }
}
</style>

<div class="page">
<div class="max-w">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">📝 نتائج الاختبارات الأسبوعية</div>
            <div class="page-sub">عرض نتائج وتقارير الاختبارات الأسبوعية الخاصة بك</div>
        </div>
        <div class="breadcrumb">
            لوحة التحكم
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <b>الاختبارات الأسبوعية</b>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="stats-row">
        <div class="stat">
            <div class="stat-label">📋 عدد الاختبارات</div>
            <div class="stat-num">{{ $totalReports }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">⭐ متوسط النقطة</div>
            <div class="stat-num g">{{ number_format($averagePoints, 1) }}/20</div>
        </div>
        <div class="stat">
            <div class="stat-label">🏆 أعلى نقطة</div>
            <div class="stat-num g">{{ $bestScore }}/20</div>
        </div>
        <div class="stat">
            <div class="stat-label">📈 مجموع النقاط</div>
            <div class="stat-num">{{ $totalPoints }}/{{ $totalReports * 20 }}</div>
        </div>
    </div>

    {{-- Filter Toolbar --}}
    @if($reports->count() > 0)
    <div class="toolbar">
        <span class="toolbar-label">📖 تصفية حسب الاختبار:</span>
        <div class="pills">
            <a href="{{ route('student.exam_weekly_reports.index') }}" 
               class="pill {{ !request('exam_weeklies_id') ? 'active' : '' }}">
                جميع الاختبارات
            </a>
            @foreach($exams as $exam)
                @if($exam)
                <a href="{{ route('student.exam_weekly_reports.index', ['exam_weeklies_id' => $exam->id]) }}"
                   class="pill {{ request('exam_weeklies_id') == $exam->id ? 'active' : '' }}">
                    {{ Str::limit($exam->title ?? 'اختبار', 20) }}
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- Reports Grid --}}
    @if($reports->count() > 0)
        <div class="reports-grid">
            @foreach($reports as $report)
                @php
                    $score = $report->exam_total_point;
                    if ($score >= 16) {
                        $barClass = 'bar-green';
                        $badgeClass = 'bg-score-high';
                        $scoreText = 'ممتاز';
                        $scoreColor = '#1D9E75';
                    } elseif ($score >= 14) {
                        $barClass = 'bar-green';
                        $badgeClass = 'bg-score-high';
                        $scoreText = 'جيد جداً';
                        $scoreColor = '#1D9E75';
                    } elseif ($score >= 12) {
                        $barClass = 'bar-orange';
                        $badgeClass = 'bg-score-medium';
                        $scoreText = 'جيد';
                        $scoreColor = '#D97706';
                    } elseif ($score >= 10) {
                        $barClass = 'bar-orange';
                        $badgeClass = 'bg-score-medium';
                        $scoreText = 'مقبول';
                        $scoreColor = '#D97706';
                    } else {
                        $barClass = 'bar-red';
                        $badgeClass = 'bg-score-low';
                        $scoreText = 'ضعيف';
                        $scoreColor = '#DC2626';
                    }
                @endphp

                <div class="report-card">
                    <div class="card-top-bar {{ $barClass }}"></div>
                    <div class="card-body">
                        <div class="card-head">
                            <div class="badges">
                                <span class="badge bg-exam">
                                    📚 {{ Str::limit($report->examWeekly->title ?? 'اختبار أسبوعي', 30) }}
                                </span>
                                <span class="badge {{ $badgeClass }}">
                                    {{ $scoreText }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="score-large" style="color: {{ $scoreColor }}">
                            {{ $score }}<span>/20</span>
                        </div>
                        
                        <div class="note-preview">
                            {{ Str::limit($report->exam_note, 100) }}
                        </div>
                        
                        <div class="card-footer">
                            <div class="meta">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $report->teacher->user->name ?? 'المعلم' }}
                            </div>
                            <div class="meta">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $report->created_at->format('Y-m-d') }}
                            </div>
                            <a href="{{ route('student.exam_weekly_reports.show', $report) }}" class="btn btn-ghost">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                التفاصيل
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="pagination">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="empty-title">📭 لا توجد نتائج بعد</div>
            <div class="empty-sub">لم يتم إضافة أي تقارير اختبارات أسبوعية لك حتى الآن</div>
        </div>
    @endif

</div>
</div>
@endsection