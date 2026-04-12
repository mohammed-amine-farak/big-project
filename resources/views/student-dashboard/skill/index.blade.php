@extends('layouts.student_dashboard')

@section('content')
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
.page { background: #f5f5f3; padding: 2rem 1.5rem; min-height: 100vh; direction: rtl; }
.max-w { max-width: 1200px; margin: 0 auto; }

.page-header { margin-bottom: 1.5rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.page-title { font-size: 22px; font-weight: 500; color: #1a1a1a; }
.page-sub { font-size: 13px; color: #6b6b6b; margin-top: 3px; }
.breadcrumb { font-size: 13px; color: #9b9b9b; display: flex; align-items: center; gap: 6px; }

.stats-row { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-bottom: 1.5rem; }
.stat { background: #fff; border-radius: 12px; padding: 1rem; border: 0.5px solid rgba(0,0,0,0.1); }
.stat-label { font-size: 12px; color: #6b6b6b; margin-bottom: 4px; }
.stat-num { font-size: 28px; font-weight: 600; color: #1a1a1a; }
.stat-num.g { color: #1D9E75; }
.stat-num.r { color: #DC2626; }

.overall-progress { background: #fff; border-radius: 16px; padding: 1.5rem; text-align: center; margin-bottom: 1.5rem; border: 0.5px solid rgba(0,0,0,0.1); }
.progress-ring { position: relative; width: 140px; height: 140px; margin: 0 auto 1rem; }
.progress-ring svg { transform: rotate(-90deg); }
.progress-ring-circle { fill: none; stroke-width: 10; }
.progress-ring-bg { stroke: #e5e7eb; }
.progress-ring-fill { stroke: #1D9E75; stroke-linecap: round; transition: stroke-dashoffset 0.5s ease; }
.progress-ring-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 28px; font-weight: 600; color: #1a1a1a; }

.toolbar { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.toolbar-label { font-size: 13px; color: #6b6b6b; white-space: nowrap; }
.pills { display: flex; gap: 6px; flex-wrap: wrap; }
.pill { padding: 5px 14px; border-radius: 999px; border: 0.5px solid rgba(0,0,0,0.2); font-size: 13px; color: #6b6b6b; background: transparent; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-block; }
.pill:hover { background: #f5f5f3; color: #1a1a1a; }
.pill.active { background: #1D9E75; border-color: #1D9E75; color: #fff; font-weight: 500; }

.skills-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1rem; }
.skill-card { background: #fff; border-radius: 12px; overflow: hidden; transition: all 0.2s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.1); cursor: pointer; }
.skill-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.card-header { padding: 1rem 1.25rem; border-bottom: 1px solid rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: space-between; }
.skill-name { font-size: 16px; font-weight: 600; color: #1a1a1a; }
.skill-badge { font-size: 12px; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
.badge-validated { background: #E1F5EE; color: #1D9E75; }
.badge-not { background: #FEE2E2; color: #DC2626; }
.card-body { padding: 1.25rem; }
.skill-desc { font-size: 13px; color: #6b6b6b; line-height: 1.6; margin-bottom: 1rem; }
.skill-status { display: flex; align-items: center; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(0,0,0,0.08); }
.status-icon { font-size: 20px; }
.status-text { font-size: 13px; font-weight: 500; }
.view-link { display: inline-flex; align-items: center; gap: 5px; margin-top: 12px; color: #1D9E75; font-size: 12px; font-weight: 500; text-decoration: none; transition: all 0.2s; }
.view-link:hover { gap: 10px; color: #0F6E56; }

.empty-state { text-align: center; padding: 4rem; background: #fff; border-radius: 12px; }
.empty-icon { width: 64px; height: 64px; margin: 0 auto 1rem; background: #f8f8f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

@media(max-width: 768px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .skills-grid { grid-template-columns: 1fr; }
}
</style>

<div class="page">
<div class="max-w">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">🎯 مهاراتي</div>
            <div class="page-sub">عرض جميع المهارات مع حالة الإتقان</div>
        </div>
        <div class="breadcrumb">
            لوحة التحكم
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <b>مهاراتي</b>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="stats-row">
        <div class="stat">
            <div class="stat-label">📊 إجمالي المهارات</div>
            <div class="stat-num">{{ $totalSkills }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">✅ مكتسبة</div>
            <div class="stat-num g">{{ $validatedSkills }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">❌ غير مكتسبة</div>
            <div class="stat-num r">{{ $notValidatedSkills }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">📈 نسبة الإتقان</div>
            <div class="stat-num g">{{ $masteryPercentage }}%</div>
        </div>
    </div>

    {{-- Overall Progress --}}
    <div class="overall-progress">
        <div class="stat-label">نسبة إتقان المهارات</div>
        <div class="progress-ring">
            <svg width="140" height="140">
                <circle class="progress-ring-circle progress-ring-bg" cx="70" cy="70" r="60"></circle>
                <circle class="progress-ring-circle progress-ring-fill" cx="70" cy="70" r="60"
                        stroke-dasharray="377" stroke-dashoffset="{{ 377 - (377 * $masteryPercentage / 100) }}"></circle>
            </svg>
            <div class="progress-ring-text">{{ $masteryPercentage }}%</div>
        </div>
        <div class="stat-label" style="margin-top: 0.5rem;">
            {{ $validatedSkills }} من {{ $totalSkills }} مهارة مكتسبة
        </div>
    </div>

    {{-- Subject Filter --}}
    @if(count($subjects) > 0)
    <div class="toolbar">
        <span class="toolbar-label">📖 المادة:</span>
        <div class="pills">
            <a href="{{ route('student.skills.index') }}" class="pill {{ !request('subject_id') ? 'active' : '' }}">جميع المواد</a>
            @foreach($subjects as $subject)
                <a href="{{ route('student.skills.index', ['subject_id' => $subject->id]) }}" 
                   class="pill {{ request('subject_id') == $subject->id ? 'active' : '' }}">
                    {{ $subject->name }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Skills Grid --}}
    @if(count($skills) > 0)
        <div class="skills-grid">
            @foreach($skills as $skill)
                <div class="skill-card" onclick="window.location='{{ route('student.skills.show', $skill['id']) }}'">
                    <div class="card-header">
                        <span class="skill-name">{{ $skill['name'] }}</span>
                        <span class="skill-badge {{ $skill['validated'] ? 'badge-validated' : 'badge-not' }}">
                            {{ $skill['status_text'] }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="skill-desc">{{ Str::limit($skill['description'], 100) }}</div>
                        <div class="skill-status">
                            <div class="status-icon">{{ $skill['icon'] }}</div>
                            <div class="status-text" style="color: {{ $skill['status_color'] }}">
                                {{ $skill['validated'] ? '✓ هذه المهارة مكتسبة' : '✗ هذه المهارة لم تكتسب بعد' }}
                            </div>
                        </div>
                        <div class="view-link">
                            عرض التفاصيل
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <div class="empty-title">لا توجد مهارات</div>
            <div class="empty-sub">لا توجد مهارات متاحة حالياً</div>
        </div>
    @endif

</div>
</div>
@endsection