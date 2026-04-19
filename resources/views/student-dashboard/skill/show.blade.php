@extends('layouts.student_dashboard')

@section('content')
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
.page { background: #f5f5f3; padding: 2rem 1.5rem; min-height: 100vh; direction: rtl; }
.max-w { max-width: 900px; margin: 0 auto; }

.page-header { margin-bottom: 1.5rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.page-title { font-size: 22px; font-weight: 500; color: #1a1a1a; }
.page-sub { font-size: 13px; color: #6b6b6b; margin-top: 3px; }
.breadcrumb { font-size: 13px; color: #9b9b9b; display: flex; align-items: center; gap: 6px; }
.breadcrumb b { color: #6b6b6b; font-weight: 400; }
.breadcrumb a { color: #6b6b6b; text-decoration: none; }
.breadcrumb a:hover { color: #1D9E75; }

/* Skill Header Card */
.skill-header-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; }
.skill-name { font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 0.5rem; }
.skill-desc { font-size: 13px; color: #6b6b6b; line-height: 1.6; margin-bottom: 1rem; }
.progress-bar-container { margin-top: 1rem; }
.progress-label { display: flex; justify-content: space-between; font-size: 12px; color: #6b6b6b; margin-bottom: 6px; }
.progress-bar-bg { background: #efefed; border-radius: 999px; height: 6px; overflow: hidden; }
.progress-bar-fill { background: #1D9E75; height: 100%; border-radius: 999px; transition: width 0.3s ease; }

/* Levels Container */
.levels-container { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; margin-bottom: 1.5rem; overflow: hidden; }
.level-title { padding: 1rem 1.25rem; background: #f8f8f6; border-bottom: 0.5px solid rgba(0,0,0,0.1); font-size: 14px; font-weight: 600; color: #1a1a1a; }
.level-item { padding: 1.25rem; border-bottom: 0.5px solid rgba(0,0,0,0.08); transition: all 0.2s ease; }
.level-item:last-child { border-bottom: none; }
.level-item:hover { background: #fafaf8; }

.level-header { display: flex; align-items: center; gap: 15px; }
.level-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
.level-info { flex: 1; }
.level-name { font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 4px; }
.level-name span { font-size: 12px; font-weight: normal; color: #9b9b9b; }
.level-description { font-size: 12px; color: #6b6b6b; line-height: 1.5; margin-bottom: 8px; }
.level-status { display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }

/* Level Status Colors */
.level-validated { background: #E1F5EE; border-right: 3px solid #1D9E75; }
.level-validated .level-icon { background: #1D9E75; color: #fff; }
.level-validated .level-status { background: #1D9E75; color: #fff; }

.level-not-validated { background: #fff; border-right: 3px solid #DC2626; }
.level-not-validated .level-icon { background: #DC2626; color: #fff; }
.level-not-validated .level-status { background: #DC2626; color: #fff; }

.level-available { background: #fff; border-right: 3px solid #D97706; }
.level-available .level-icon { background: #D97706; color: #fff; }
.level-available .level-status { background: #D97706; color: #fff; }

.level-locked { background: #fafafa; border-right: 3px solid #9b9b9b; }
.level-locked .level-icon { background: #9b9b9b; color: #fff; }
.level-locked .level-status { background: #9b9b9b; color: #fff; }

/* Exam History */
.exams-container { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; margin-bottom: 1.5rem; overflow: hidden; }
.exam-title { padding: 1rem 1.25rem; background: #f8f8f6; border-bottom: 0.5px solid rgba(0,0,0,0.1); font-size: 14px; font-weight: 600; color: #1a1a1a; }
.exam-item { padding: 1rem 1.25rem; border-bottom: 0.5px solid rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.exam-item:last-child { border-bottom: none; }
.exam-item:hover { background: #fafaf8; }
.exam-info { flex: 1; }
.exam-name { font-size: 14px; font-weight: 500; color: #1a1a1a; margin-bottom: 4px; }
.exam-meta { display: flex; align-items: center; gap: 12px; font-size: 12px; color: #9b9b9b; }
.exam-level-badge { padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 500; background: #E6F1FB; color: #0C447C; }
.exam-score { padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; }
.score-high { background: #E1F5EE; color: #1D9E75; }
.score-medium { background: #FAEEDA; color: #D97706; }
.score-low { background: #FEE2E2; color: #DC2626; }

/* Buttons */
.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px; background: transparent; border: 0.5px solid rgba(0,0,0,0.2); border-radius: 8px; text-decoration: none; color: #6b6b6b; font-size: 13px; font-weight: 500; transition: all 0.15s; }
.btn-back:hover { background: #f5f5f3; border-color: #1D9E75; color: #1D9E75; }

/* Empty State */
.empty-state { text-align: center; padding: 3rem; background: #fff; border-radius: 12px; border: 0.5px solid rgba(0,0,0,0.1); }
.empty-icon { width: 52px; height: 52px; border-radius: 12px; background: #efefed; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.empty-icon svg { width: 24px; height: 24px; color: #9b9b9b; }
.empty-title { font-size: 15px; font-weight: 500; color: #1a1a1a; margin-bottom: 4px; }
.empty-sub { font-size: 13px; color: #6b6b6b; }

@media(max-width: 640px) {
    .level-header { flex-direction: column; text-align: center; }
    .exam-item { flex-direction: column; align-items: flex-start; }
    .btn-back { width: 100%; justify-content: center; }
}
</style>

<div class="page">
<div class="max-w">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">📖 تفاصيل المهارة</div>
            <div class="page-sub">عرض تفاصيل المهارة ومستوياتها</div>
        </div>
        <div class="breadcrumb">
            لوحة التحكم
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <a href="{{ route('student.skills.index') }}">مهاراتي</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <b>{{ Str::limit($skill->name, 30) }}</b>
        </div>
    </div>

    {{-- Skill Header Card --}}
    <div class="skill-header-card">
        <div class="skill-name">{{ $skill->name }}</div>
        <div class="skill-desc">{{ $skill->description ?? 'لا يوجد وصف لهذه المهارة' }}</div>
        <div class="progress-bar-container">
            <div class="progress-label">
                <span>التقدم في المهارة</span>
                <span>{{ $validatedLevelsCount }}/{{ $totalLevels }} مستوى مكتسب</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>
    </div>

    {{-- Levels Container --}}
    <div class="levels-container">
        <div class="level-title">🎯 مستويات المهارة</div>
        
        @foreach($skill->levelSkills as $level)
            @php
                if($level->validated) {
                    $levelClass = 'level-validated';
                } elseif($level->status == 'available') {
                    $levelClass = 'level-available';
                } elseif($level->status == 'locked') {
                    $levelClass = 'level-locked';
                } else {
                    $levelClass = 'level-not-validated';
                }
            @endphp
            
            <div class="level-item {{ $levelClass }}">
                <div class="level-header">
                    <div class="level-icon">{{ $level->status_icon }}</div>
                    <div class="level-info">
                        <div class="level-name">
                            {{ $level->level_name }}
                            <span>({{ $level->level == 'level_1' ? 'المستوى 1' : ($level->level == 'level_2' ? 'المستوى 2' : 'المستوى 3') }})</span>
                        </div>
                        <div class="level-description">{{ $level->level_description }}</div>
                        <div class="level-status">
                            {{ $level->status_icon }} {{ $level->status_text }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

  

    {{-- Back Button --}}
    <a href="{{ route('student.skills.index') }}" class="btn-back">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        العودة إلى قائمة المهارات
    </a>

</div>
</div>
@endsection