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

.progress-wrapper { margin: 12px 0 8px; }
.progress-bar-bg { background: #efefed; border-radius: 999px; height: 4px; overflow: hidden; }
.progress-bar-fill { background: #1D9E75; height: 100%; border-radius: 999px; transition: width 0.3s ease; }
.progress-text { font-size: 11px; color: #6b6b6b; margin-top: 4px; display: flex; justify-content: space-between; }

.skills-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1rem; }
.skill-card { background: #fff; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden; transition: all 0.2s ease; }
.skill-card:hover { border-color: rgba(0,0,0,0.25); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
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
.btn { padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; border: none; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
.btn-ghost { background: transparent; border: 0.5px solid rgba(0,0,0,0.2); color: #6b6b6b; }
.btn-ghost:hover { background: #f5f5f3; }
.btn-teal { background: #1D9E75; color: #fff; }
.btn-teal:hover { background: #0F6E56; }
.btn-dark { background: #085041; color: #fff; }
.btn-dark:hover { background: #04342C; }

.classroom-info { font-size: 11px; color: #9b9b9b; margin-top: 8px; padding-top: 8px; border-top: 0.5px solid rgba(0,0,0,0.05); display: flex; gap: 12px; }
.classroom-info span { display: flex; align-items: center; gap: 4px; }

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
    .skills-grid { grid-template-columns: 1fr; }
    .ftabs { flex-wrap: wrap; }
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

    {{-- Subject Toolbar --}}
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

    {{-- Stats --}}
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
            <div class="stat-label">📈 نسبة الإتقان</div>
            <div class="stat-num g">{{ $masteryPercentage }}%</div>
        </div>
    </div>

    {{-- Section Header + Filter Tabs --}}
    <div class="section-head">
        <div class="section-title">🎯 جميع المهارات</div>
        <div class="ftabs">
            <div class="ftab active" onclick="filterCards(this,'all')">الكل ({{ $totalSkills }})</div>
            <div class="ftab" onclick="filterCards(this,'validated')">مكتسبة ({{ $validatedSkills }})</div>
            <div class="ftab" onclick="filterCards(this,'not_validated')">قيد التطوير ({{ $notValidatedSkills }})</div>
        </div>
    </div>

    {{-- Skills Grid --}}
    <div class="skills-grid" id="skillsGrid">
        @forelse($skills as $skill)
            @php
                $isValidated = $skill['validated'];
                
                if ($isValidated) {
                    $barClass    = 'bar-g';
                    $badgeClass  = 'bg-g';
                    $statusText  = 'مكتسبة';
                    $statusIcon  = '✅';
                    $btnClass    = 'btn-dark';
                    $btnText     = 'مراجعة';
                } else {
                    $barClass    = 'bar-a';
                    $badgeClass  = 'bg-a';
                    $statusText  = 'قيد التطوير';
                    $statusIcon  = '🔄';
                    $btnClass    = 'btn-teal';
                    $btnText     = 'بدء التعلم';
                }
            @endphp

            <div class="skill-card" data-status="{{ $isValidated ? 'validated' : 'not_validated' }}">
                <div class="card-top-bar {{ $barClass }}"></div>
                <div class="card-body">
                    <div class="card-head">
                        <div class="badges">
                            <span class="badge {{ $badgeClass }}">{{ $statusIcon }} {{ $statusText }}</span>
                        </div>
                    </div>
                    
                    <div class="card-title">{{ $skill['name'] }}</div>
                    <div class="card-desc">{{ Str::limit($skill['description'], 100) }}</div>
                    
                    <div class="card-footer">
                        <div class="meta">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $isValidated ? 'تم إتقان المهارة' : 'جاري تعلم المهارة' }}
                        </div>
                        <div class="actions">
                            <a href="{{ route('student.skills.show', $skill['id']) }}" class="btn btn-ghost">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                تفاصيل
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div class="empty-title">📭 لا توجد مهارات</div>
                <div class="empty-sub">لم يتم إضافة مهارات لهذه المادة بعد</div>
            </div>
        @endforelse
    </div>

</div>
</div>

<script>
function filterCards(el, status) {
    // Update active tab
    document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    
    // Filter cards
    const cards = document.querySelectorAll('.skill-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Optional: Show message if no cards visible
    const grid = document.getElementById('skillsGrid');
    const existingMsg = document.getElementById('noFilterResults');
    
    if (visibleCount === 0 && cards.length > 0) {
        if (!existingMsg) {
            const msgDiv = document.createElement('div');
            msgDiv.id = 'noFilterResults';
            msgDiv.className = 'empty-state';
            msgDiv.style.gridColumn = '1/-1';
            msgDiv.innerHTML = `
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="empty-title">لا توجد نتائج</div>
                <div class="empty-sub">لا توجد مهارات بهذه الحالة</div>
            `;
            grid.appendChild(msgDiv);
        }
    } else if (existingMsg) {
        existingMsg.remove();
    }
}

// Initialize with all cards visible
document.addEventListener('DOMContentLoaded', function() {
    const activeTab = document.querySelector('.ftab.active');
    if (activeTab) {
        filterCards(activeTab, 'all');
    }
});
</script>
@endsection