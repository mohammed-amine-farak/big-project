@extends('layouts.student_dashboard')

@section('content')
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
.page { background: #f5f5f3; padding: 2rem 1.5rem; min-height: 100vh; direction: rtl; }
.max-w { max-width: 900px; margin: 0 auto; }

.page-header { margin-bottom: 1.5rem; }
.page-title { font-size: 22px; font-weight: 500; color: #1a1a1a; }
.breadcrumb { font-size: 13px; color: #9b9b9b; display: flex; align-items: center; gap: 6px; margin-top: 5px; }
.breadcrumb a { color: #6b6b6b; text-decoration: none; }
.breadcrumb a:hover { color: #1D9E75; }

/* Skill Header Card */
.skill-header-card { background: #fff; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; border: 0.5px solid rgba(0,0,0,0.1); }
.skill-name { font-size: 24px; font-weight: 600; color: #1a1a1a; margin-bottom: 0.5rem; }
.skill-desc { font-size: 14px; color: #6b6b6b; line-height: 1.6; margin-bottom: 1rem; }
.progress-bar-container { margin-top: 1rem; }
.progress-label { display: flex; justify-content: space-between; font-size: 12px; color: #6b6b6b; margin-bottom: 6px; }
.progress-bar-bg { background: #efefed; border-radius: 10px; height: 8px; overflow: hidden; }
.progress-bar-fill { background: #1D9E75; height: 100%; border-radius: 10px; transition: width 0.3s ease; }

/* Levels Container */
.levels-container { background: #fff; border-radius: 16px; margin-bottom: 1.5rem; border: 0.5px solid rgba(0,0,0,0.1); overflow: hidden; }
.level-title { padding: 1rem 1.5rem; background: #f8f8f6; border-bottom: 0.5px solid rgba(0,0,0,0.1); font-size: 16px; font-weight: 600; color: #1a1a1a; }
.level-item { padding: 1.5rem; border-bottom: 0.5px solid rgba(0,0,0,0.08); transition: all 0.2s ease; }
.level-item:last-child { border-bottom: none; }
.level-item:hover { transform: translateX(-5px); }

/* Level Colors */
.level-validated { background: linear-gradient(135deg, #E8F5E9, #C8E6C9); border-right: 4px solid #1D9E75; }
.level-validated .level-icon { background: #1D9E75; color: white; }
.level-validated .level-name { color: #1D9E75; }

.level-not-validated { background: #fff; border-right: 4px solid #DC2626; }
.level-not-validated .level-icon { background: #DC2626; color: white; }
.level-not-validated .level-name { color: #DC2626; }

.level-available { background: #fff; border-right: 4px solid #D97706; }
.level-available .level-icon { background: #D97706; color: white; }
.level-available .level-name { color: #D97706; }

.level-locked { background: #fafafa; border-right: 4px solid #9b9b9b; }
.level-locked .level-icon { background: #9b9b9b; color: white; }
.level-locked .level-name { color: #9b9b9b; }

.level-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
.level-info { flex: 1; }
.level-name { font-size: 18px; font-weight: 600; margin-bottom: 6px; }
.level-name span { font-size: 14px; font-weight: normal; color: #6b6b6b; }
.level-description { font-size: 13px; color: #6b6b6b; line-height: 1.5; }
.level-status { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; margin-top: 12px; }
.status-validated { background: #1D9E75; color: white; }
.status-not { background: #DC2626; color: white; }
.status-available { background: #D97706; color: white; }
.status-locked { background: #9b9b9b; color: white; }

/* Exam History */
.exams-container { background: #fff; border-radius: 16px; border: 0.5px solid rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 1.5rem; }
.exam-title { padding: 1rem 1.5rem; background: #f8f8f6; border-bottom: 0.5px solid rgba(0,0,0,0.1); font-size: 16px; font-weight: 600; color: #1a1a1a; }
.exam-item { padding: 1rem 1.5rem; border-bottom: 0.5px solid rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.exam-item:last-child { border-bottom: none; }
.exam-info { flex: 1; }
.exam-name { font-size: 14px; font-weight: 500; color: #1a1a1a; margin-bottom: 4px; }
.exam-meta { display: flex; align-items: center; gap: 15px; font-size: 12px; color: #9b9b9b; }
.exam-level-badge { padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 500; background: #E1F5EE; color: #1D9E75; }
.exam-score { padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 600; }
.score-high { background: #E1F5EE; color: #1D9E75; }
.score-medium { background: #FAEEDA; color: #D97706; }
.score-low { background: #FEE2E2; color: #DC2626; }

.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: transparent; border: 0.5px solid rgba(0,0,0,0.2); border-radius: 8px; text-decoration: none; color: #6b6b6b; font-size: 13px; transition: all 0.2s; }
.btn-back:hover { background: #f5f5f3; border-color: #1D9E75; color: #1D9E75; }

.empty-state { text-align: center; padding: 3rem; background: #fff; border-radius: 12px; }

@media(max-width: 640px) {
    .level-item { flex-direction: column; text-align: center; }
    .level-header { flex-direction: column; }
    .exam-item { flex-direction: column; align-items: flex-start; }
}
</style>

<div class="page">
<div class="max-w">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-title">📖 تفاصيل المهارة</div>
        <div class="breadcrumb">
            <a href="">الرئيسية</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('student.skills.index') }}">مهاراتي</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span style="color: #1a1a1a;">{{ $skill->name }}</span>
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
                $levelClass = '';
                $levelBorderColor = '';
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
                <div class="level-header" style="display: flex; align-items: center; gap: 15px;">
                    <div class="level-icon">{{ $level->status_icon }}</div>
                    <div class="level-info">
                        <div class="level-name">
                            {{ $level->level_name }}
                            <span>({{ $level->level == 'level_1' ? 'المستوى 1' : ($level->level == 'level_2' ? 'المستوى 2' : 'المستوى 3') }})</span>
                        </div>
                        <div class="level-description">{{ $level->level_description }}</div>
                        <div class="level-status status-{{ $level->status }}">
                            {{ $level->status_icon }} {{ $level->status_text }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Exam History --}}
    @if(count($examHistory) > 0)
    <div class="exams-container">
        <div class="exam-title">📝 سجل الاختبارات</div>
        @foreach($examHistory as $exam)
            @php
                $score = $exam->exam_total_point;
                if($score >= 16) {
                    $scoreClass = 'score-high';
                } elseif($score >= 12) {
                    $scoreClass = 'score-medium';
                } else {
                    $scoreClass = 'score-low';
                }
            @endphp
            <div class="exam-item">
                <div class="exam-info">
                    <div class="exam-name">{{ $exam->exam_title }}</div>
                    <div class="exam-meta">
                        <span>📅 {{ \Carbon\Carbon::parse($exam->created_at)->format('Y-m-d') }}</span>
                        <span class="exam-level-badge">{{ $exam->level_name }}</span>
                    </div>
                </div>
                <div class="exam-score {{ $scoreClass }}">
                    {{ $score }}/20
                </div>
            </div>
        @endforeach
    </div>
    @endif

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