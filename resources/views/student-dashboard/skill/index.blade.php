@extends('layouts.student_dashboard')

@section('content')
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
.page { background: #f5f5f3; padding: 2rem 1.5rem; min-height: 100vh; direction: rtl; }
.max-w { max-width: 1200px; margin: 0 auto; }

/* Header */
.page-header { margin-bottom: 1.5rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.page-title { font-size: 22px; font-weight: 500; color: #1a1a1a; }
.page-sub { font-size: 13px; color: #6b6b6b; margin-top: 3px; }
.breadcrumb { font-size: 13px; color: #9b9b9b; display: flex; align-items: center; gap: 6px; }

/* Stats Cards */
.stats-row { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-bottom: 1.5rem; }
.stat { background: #fff; border-radius: 12px; padding: 1rem; border: 0.5px solid rgba(0,0,0,0.1); }
.stat-label { font-size: 12px; color: #6b6b6b; margin-bottom: 4px; }
.stat-num { font-size: 28px; font-weight: 600; color: #1a1a1a; }
.stat-num.g { color: #1D9E75; }
.stat-num.a { color: #D97706; }

/* Progress Ring */
.overall-progress { background: #fff; border-radius: 16px; padding: 1.5rem; text-align: center; margin-bottom: 1.5rem; border: 0.5px solid rgba(0,0,0,0.1); }
.progress-ring { position: relative; width: 140px; height: 140px; margin: 0 auto 1rem; }
.progress-ring svg { transform: rotate(-90deg); }
.progress-ring-circle { fill: none; stroke-width: 10; }
.progress-ring-bg { stroke: #e5e7eb; }
.progress-ring-fill { stroke: #1D9E75; stroke-linecap: round; transition: stroke-dashoffset 0.5s ease; }
.progress-ring-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 28px; font-weight: 600; color: #1a1a1a; }

/* Toolbar Filter */
.toolbar { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.toolbar-label { font-size: 13px; color: #6b6b6b; white-space: nowrap; }
.pills { display: flex; gap: 6px; flex-wrap: wrap; }
.pill { padding: 5px 14px; border-radius: 999px; border: 0.5px solid rgba(0,0,0,0.2); font-size: 13px; color: #6b6b6b; background: transparent; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-block; }
.pill:hover { background: #f5f5f3; color: #1a1a1a; }
.pill.active { background: #1D9E75; border-color: #1D9E75; color: #fff; font-weight: 500; }

/* Skills Grid */
.skills-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1rem; }
.skill-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden; transition: all 0.2s ease; }
.skill-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.card-header { padding: 1rem 1.25rem; background: #f8f8f6; border-bottom: 0.5px solid rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; }
.skill-name { font-size: 16px; font-weight: 600; color: #1a1a1a; }
.skill-badge { font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.badge-completed { background: #E1F5EE; color: #1D9E75; }
.badge-progress { background: #FAEEDA; color: #D97706; }
.badge-not { background: #FEE2E2; color: #DC2626; }
.card-body { padding: 1.25rem; }
.skill-desc { font-size: 13px; color: #6b6b6b; margin-bottom: 1rem; line-height: 1.5; }

/* Level Indicators */
.levels-container { margin: 1rem 0; }
.level-item { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 0.5px solid rgba(0,0,0,0.05); }
.level-indicator { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; }
.level-validated { background: #E1F5EE; color: #1D9E75; }
.level-current { background: #FAEEDA; color: #D97706; border: 2px solid #D97706; }
.level-locked { background: #efefed; color: #9b9b9b; }
.level-info { flex: 1; }
.level-name { font-size: 14px; font-weight: 500; color: #1a1a1a; }
.level-desc { font-size: 11px; color: #9b9b9b; }
.level-check { width: 24px; text-align: center; }
.level-check svg { width: 18px; height: 18px; }

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
            <div class="page-sub">تتبع المهارات التي أتقنتها والمهارات التي تحتاج إلى تطوير</div>
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
            <div class="stat-label">✅ المهارات المتقنة</div>
            <div class="stat-num g">{{ $validatedSkills }}/{{ $totalSkills }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">🔄 قيد التطوير</div>
            <div class="stat-num a"></div>
        </div>
        <div class="stat">
            <div class="stat-label">📚 إجمالي المستويات</div>
            <div class="stat-num"></div>
        </div>
        <div class="stat">
            <div class="stat-label">🏆 أعلى مستوى</div>
            <div class="stat-num g"></div>
        </div>
    </div>

    {{-- Overall Progress Ring --}}
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

    {{-- Skills Grid --}}
    @if(count($skills) > 0)
        <div class="skills-grid">
            @foreach($skills as $skill)
                @php
                    $level1Validated = $skill['level_1_validated'] ?? false;
                    $level2Validated = $skill['level_2_validated'] ?? false;
                    $level3Validated = $skill['level_3_validated'] ?? false;
                    
                    if ($level3Validated) {
                        $badgeClass = 'badge-completed';
                        $badgeText = 'متقن';
                        $skillStatus = 'completed';
                    } elseif ($level2Validated) {
                        $badgeClass = 'badge-progress';
                        $badgeText = 'متقدم';
                        $skillStatus = 'progress';
                    } elseif ($level1Validated) {
                        $badgeClass = 'badge-progress';
                        $badgeText = 'قيد التعلم';
                        $skillStatus = 'progress';
                    } else {
                        $badgeClass = 'badge-not';
                        $badgeText = 'لم يبدأ';
                        $skillStatus = 'not';
                    }
                @endphp

                <div class="skill-card">
                    <div class="card-header">
                        <span class="skill-name">{{ $skill['name'] }}</span>
                        <span class="skill-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                    </div>
                    <div class="card-body">
                        <div class="skill-desc">{{ $skill['description'] }}</div>
                        
                        <div class="levels-container">
                            {{-- Level 1 --}}
                            <div class="level-item">
                                <div class="level-indicator {{ $level1Validated ? 'level-validated' : ($level2Validated || $level3Validated ? 'level-validated' : 'level-locked') }}">
                                    {{ $level1Validated ? '✓' : '1' }}
                                </div>
                                <div class="level-info">
                                    <div class="level-name">المستوى الأساسي</div>
                                    <div class="level-desc">فهم المفاهيم الأساسية</div>
                                </div>
                                <div class="level-check">
                                    @if($level1Validated)
                                        <svg fill="none" stroke="#1D9E75" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Level 2 --}}
                            <div class="level-item">
                                <div class="level-indicator {{ $level2Validated ? 'level-validated' : ($level3Validated ? 'level-validated' : ($level1Validated ? 'level-current' : 'level-locked')) }}">
                                    {{ $level2Validated ? '✓' : '2' }}
                                </div>
                                <div class="level-info">
                                    <div class="level-name">المستوى المتوسط</div>
                                    <div class="level-desc">تطبيق المفاهيم في مسائل متنوعة</div>
                                </div>
                                <div class="level-check">
                                    @if($level2Validated)
                                        <svg fill="none" stroke="#1D9E75" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Level 3 --}}
                            <div class="level-item">
                                <div class="level-indicator {{ $level3Validated ? 'level-validated' : ($level2Validated ? 'level-current' : 'level-locked') }}">
                                    {{ $level3Validated ? '✓' : '3' }}
                                </div>
                                <div class="level-info">
                                    <div class="level-name">المستوى المتقدم</div>
                                    <div class="level-desc">التحليل والتركيب وحل المسائل المعقدة</div>
                                </div>
                                <div class="level-check">
                                    @if($level3Validated)
                                        <svg fill="none" stroke="#1D9E75" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <div class="empty-title">لا توجد مهارات بعد</div>
            <div class="empty-sub">سيتم عرض المهارات التي تكتسبها من خلال الاختبارات الأسبوعية</div>
        </div>
    @endif

</div>
</div>
@endsection