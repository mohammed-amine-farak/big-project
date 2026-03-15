@extends('layouts.video_dashboard')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; }
:root {
  --brand: #E84E1B;
  --brand-dark: #C23A0F;
  --brand-light: #FFF0EA;
  --surface: #FFFFFF;
  --surface-2: #F7F6F3;
  --surface-3: #F0EEE9;
  --border: rgba(0,0,0,0.07);
  --border-strong: rgba(0,0,0,0.13);
  --text-1: #1A1917;
  --text-2: #5A5855;
  --text-3: #9A9893;
  --radius: 14px;
  --radius-sm: 8px;
  --ff: 'IBM Plex Sans Arabic', system-ui, sans-serif;
}

.db-page { font-family: var(--ff); background: var(--surface-2); color: var(--text-1); direction: rtl; min-height: 100vh; }

/* ══ HERO ══ */
.db-hero {
  background: #1A1917;
  padding: 40px 40px 0;
  position: relative; overflow: hidden;
}
.db-hero::before {
  content: '';
  position: absolute; top: -100px; left: -100px;
  width: 420px; height: 420px; border-radius: 50%;
  background: radial-gradient(circle, rgba(232,78,27,0.16) 0%, transparent 65%);
  pointer-events: none;
}
.db-hero::after {
  content: '';
  position: absolute; bottom: 0; right: 0;
  width: 500px; height: 250px;
  background: linear-gradient(135deg, rgba(232,78,27,0.05) 0%, transparent 60%);
  pointer-events: none;
}
.db-hero-inner {
  max-width: 1280px; margin: 0 auto;
  display: flex; align-items: flex-end; justify-content: space-between;
  gap: 32px; position: relative; z-index: 1;
}
.db-hero-left { padding-bottom: 36px; }
.db-hero-greeting {
  font-size: 13px; font-weight: 500;
  color: rgba(255,255,255,0.4); letter-spacing: 0.6px;
  text-transform: uppercase; margin-bottom: 8px;
}
.db-hero-name { font-size: 30px; font-weight: 700; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.db-hero-sub { font-size: 13px; color: rgba(255,255,255,0.4); }

/* Date card */
.db-date-card {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 12px 12px 0 0;
  padding: 20px 28px; text-align: center;
  min-width: 160px;
}
.db-date-day { font-size: 11px; color: rgba(255,255,255,0.4); margin-bottom: 4px; letter-spacing: 0.4px; }
.db-date-num { font-size: 26px; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 2px; }
.db-date-month { font-size: 12px; color: rgba(255,255,255,0.45); }

/* ══ MAIN ══ */
.db-main { max-width: 1280px; margin: 0 auto; padding: 32px 40px; }

/* ══ KPI GRID ══ */
.db-kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
.db-kpi {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 20px 22px;
  display: flex; flex-direction: column; justify-content: space-between;
  transition: box-shadow 0.2s;
}
.db-kpi:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.07); }
.db-kpi-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 16px; }
.db-kpi-icon {
  width: 40px; height: 40px; border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.db-kpi-icon svg { width: 18px; height: 18px; }
.db-kpi-label { font-size: 11px; color: var(--text-3); margin-bottom: 6px; letter-spacing: 0.3px; }
.db-kpi-value { font-size: 28px; font-weight: 700; color: var(--text-1); letter-spacing: -0.5px; line-height: 1; }
.db-kpi-footer { display: flex; align-items: center; justify-content: space-between; font-size: 12px; }
.db-kpi-sub { color: var(--text-3); }
.db-kpi-delta { font-weight: 600; }
.db-kpi-delta.up { color: #1E7F52; }
.db-kpi-delta.neutral { color: var(--brand); }

/* Progress bar in KPI */
.db-kpi-bar { height: 4px; background: var(--surface-3); border-radius: 2px; margin-top: 10px; overflow: hidden; }
.db-kpi-bar-fill { height: 100%; border-radius: 2px; background: var(--brand); }

/* ══ CHARTS ROW ══ */
.db-charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }

/* ══ MID ROW ══ */
.db-mid-row { display: grid; grid-template-columns: 1fr 320px; gap: 20px; margin-bottom: 28px; }

/* ══ BOTTOM ROW ══ */
.db-bottom-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }

/* ══ CARD ══ */
.db-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
}
.db-card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
}
.db-card-title { font-size: 14px; font-weight: 600; color: var(--text-1); }
.db-card-link { font-size: 12px; color: var(--brand); font-weight: 500; text-decoration: none; transition: opacity 0.15s; }
.db-card-link:hover { opacity: 0.75; }
.db-card-body { padding: 20px; }
.db-chart-wrap { padding: 16px 20px 20px; position: relative; }

/* ══ STATUS GRID ══ */
.db-status-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.db-status-block {
  background: var(--surface-2);
  border-radius: var(--radius-sm);
  padding: 14px 12px; text-align: center;
  transition: background 0.15s;
}
.db-status-block:hover { background: var(--surface-3); }
.db-status-num { font-size: 22px; font-weight: 700; color: var(--text-1); line-height: 1; margin-bottom: 4px; }
.db-status-lbl { font-size: 11px; color: var(--text-3); }
.db-status-block.blue  .db-status-num { color: #185FA5; }
.db-status-block.amber .db-status-num { color: #92690A; }
.db-status-block.orange .db-status-num { color: var(--brand); }
.db-status-block.green  .db-status-num { color: #1E7F52; }
.db-status-block.red    .db-status-num { color: #B02020; }

/* ══ QUICK ACTIONS ══ */
.db-quick-action {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 16px;
  border-radius: var(--radius-sm);
  text-decoration: none;
  background: var(--surface-2);
  transition: background 0.15s;
  margin-bottom: 8px;
}
.db-quick-action:last-child { margin-bottom: 0; }
.db-quick-action:hover { background: var(--surface-3); }
.db-quick-action-left { display: flex; align-items: center; gap: 12px; }
.db-quick-action-icon {
  width: 36px; height: 36px; border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.db-quick-action-icon svg { width: 17px; height: 17px; }
.db-quick-action-label { font-size: 13px; font-weight: 500; color: var(--text-1); }
.db-quick-action-arrow { color: var(--text-3); transition: transform 0.15s; }
.db-quick-action:hover .db-quick-action-arrow { transform: translateX(-3px); }
.db-quick-action-arrow svg { width: 16px; height: 16px; }
.db-unread-badge {
  background: #E84E1B; color: #fff;
  font-size: 11px; font-weight: 600;
  padding: 2px 8px; border-radius: 10px;
}

/* ══ ACTIVITY LIST ══ */
.db-activity-item {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid var(--border);
}
.db-activity-item:last-child { border-bottom: none; padding-bottom: 0; }
.db-activity-item:first-child { padding-top: 0; }
.db-activity-thumb {
  width: 36px; height: 36px; border-radius: var(--radius-sm);
  background: #1A1917; display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.db-activity-thumb svg { width: 17px; height: 17px; color: rgba(255,255,255,0.5); }
.db-activity-info { flex: 1; min-width: 0; }
.db-activity-title { font-size: 13px; font-weight: 500; color: var(--text-1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; }
.db-activity-time { font-size: 11px; color: var(--text-3); }
.db-activity-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.db-activity-views { font-size: 11px; color: var(--text-3); white-space: nowrap; }
.db-activity-link { color: var(--brand); text-decoration: none; display: flex; }
.db-activity-link svg { width: 16px; height: 16px; }

/* ══ COMMENT ITEM ══ */
.db-comment-item { padding: 12px 0; border-bottom: 1px solid var(--border); }
.db-comment-item:last-child { border-bottom: none; padding-bottom: 0; }
.db-comment-item:first-child { padding-top: 0; }
.db-comment-top { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
.db-comment-avatar {
  width: 30px; height: 30px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0;
}
.db-comment-name { font-size: 13px; font-weight: 500; color: var(--text-1); }
.db-comment-time { font-size: 11px; color: var(--text-3); margin-right: auto; }
.db-comment-text { font-size: 12px; color: var(--text-2); line-height: 1.6; padding-right: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.db-comment-on { font-size: 11px; color: var(--text-3); padding-right: 40px; margin-top: 3px; }

/* ══ ACTIVE REQUESTS ══ */
.db-req-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border); }
.db-req-item:last-child { border-bottom: none; padding-bottom: 0; }
.db-req-item:first-child { padding-top: 0; }
.db-req-info { flex: 1; min-width: 0; }
.db-req-title { font-size: 13px; font-weight: 500; color: var(--text-1); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.db-req-meta { display: flex; align-items: center; gap: 12px; font-size: 11px; color: var(--text-3); }
.db-req-link { color: var(--brand); text-decoration: none; flex-shrink: 0; margin-right: 12px; }
.db-req-link svg { width: 16px; height: 16px; }

/* ══ BADGES ══ */
.db-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 500; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
.db-badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.db-badge-blue   { background: #EDF4FF; color: #185FA5; }
.db-badge-yellow { background: #FEF8EC; color: #92690A; }
.db-badge-orange { background: var(--brand-light); color: var(--brand); }
.db-badge-green  { background: #EDFAF4; color: #1E7F52; }

.db-empty { text-align: center; padding: 28px 16px; color: var(--text-3); font-size: 13px; }

@media (max-width: 1024px) {
  .db-kpi-grid { grid-template-columns: repeat(2,1fr); }
  .db-charts-row, .db-mid-row, .db-bottom-row { grid-template-columns: 1fr; }
  .db-hero, .db-main { padding-right: 20px; padding-left: 20px; }
}
</style>

@php
  $completionRate = $totalRequests > 0 ? round(($approvedRequests / $totalRequests) * 100) : 0;
  $avatarColors   = ['#534AB7','#0F6E56','#C23A0F','#185FA5','#854F0B','#993556','#3B6D11'];
  $activeStatusMap = [
    'accepted'          => ['cls' => 'db-badge-blue',   'label' => 'قيد التنفيذ'],
    'submitted'         => ['cls' => 'db-badge-yellow', 'label' => 'بانتظار المراجعة'],
    'revision_required' => ['cls' => 'db-badge-orange', 'label' => 'يحتاج تعديل'],
  ];
@endphp

<div class="db-page">

  {{-- ══ HERO ══ --}}
  <header class="db-hero">
    <div class="db-hero-inner">
      <div class="db-hero-left">
        <div class="db-hero-greeting">لوحة تحكم منشئ الفيديو</div>
        <div class="db-hero-name">مرحباً 👋</div>
        <div class="db-hero-sub">إدارة وإنتاج الفيديوهات التعليمية</div>
      </div>
      <div class="db-date-card">
        <div class="db-date-day">{{ now()->translatedFormat('l') }}</div>
        <div class="db-date-num">{{ now()->format('d') }}</div>
        <div class="db-date-month">{{ now()->translatedFormat('F Y') }}</div>
      </div>
    </div>
  </header>

  {{-- ══ MAIN ══ --}}
  <div class="db-main">

    {{-- ── KPI CARDS ── --}}
    <div class="db-kpi-grid">

      {{-- Videos --}}
      <div class="db-kpi">
        <div class="db-kpi-top">
          <div>
            <div class="db-kpi-label">إجمالي الفيديوهات</div>
            <div class="db-kpi-value">{{ $totalVideos }}</div>
          </div>
          <div class="db-kpi-icon" style="background:#EDF4FF;">
            <svg fill="none" stroke="#185FA5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
          </div>
        </div>
        <div class="db-kpi-footer">
          <span class="db-kpi-sub">هذا الشهر</span>
          <span class="db-kpi-delta up">+{{ $monthlyVideos }}</span>
        </div>
      </div>

      {{-- Views --}}
      <div class="db-kpi">
        <div class="db-kpi-top">
          <div>
            <div class="db-kpi-label">إجمالي المشاهدات</div>
            <div class="db-kpi-value">{{ number_format($totalViews) }}</div>
          </div>
          <div class="db-kpi-icon" style="background:#EDFAF4;">
            <svg fill="none" stroke="#1E7F52" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </div>
        </div>
        <div class="db-kpi-footer">
          <span class="db-kpi-sub">هذا الشهر</span>
          <span class="db-kpi-delta up">+{{ number_format($monthlyViews) }}</span>
        </div>
      </div>

      {{-- Comments --}}
      <div class="db-kpi">
        <div class="db-kpi-top">
          <div>
            <div class="db-kpi-label">التعليقات</div>
            <div class="db-kpi-value">{{ $totalComments }}</div>
          </div>
          <div class="db-kpi-icon" style="background:#F4EFFE;">
            <svg fill="none" stroke="#6D3AB5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
          </div>
        </div>
        <div class="db-kpi-footer">
          <span class="db-kpi-sub">غير مقروءة</span>
          <span class="db-kpi-delta neutral">{{ $unreadComments }}</span>
        </div>
      </div>

      {{-- Completion --}}
      <div class="db-kpi">
        <div class="db-kpi-top">
          <div>
            <div class="db-kpi-label">معدل الإكمال</div>
            <div class="db-kpi-value">{{ $completionRate }}%</div>
          </div>
          <div class="db-kpi-icon" style="background:var(--brand-light);">
            <svg fill="none" stroke="var(--brand)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
        </div>
        <div class="db-kpi-bar">
          <div class="db-kpi-bar-fill" style="width:{{ $completionRate }}%"></div>
        </div>
        <div class="db-kpi-footer" style="margin-top:8px;">
          <span class="db-kpi-sub">{{ $approvedRequests }} من {{ $totalRequests }} طلب</span>
        </div>
      </div>

    </div>{{-- /kpi-grid --}}

    {{-- ── CHARTS ROW ── --}}
    <div class="db-charts-row">

      {{-- Line Chart: Views Over Time --}}
      <div class="db-card">
        <div class="db-card-header">
          <span class="db-card-title">المشاهدات خلال الأشهر الستة الأخيرة</span>
        </div>
        <div class="db-chart-wrap" style="height:240px;">
          <canvas id="chart-views"></canvas>
        </div>
      </div>

      {{-- Doughnut: Request Status --}}
      <div class="db-card">
        <div class="db-card-header">
          <span class="db-card-title">توزيع حالات الطلبات</span>
        </div>
        <div class="db-chart-wrap" style="height:240px;display:flex;align-items:center;justify-content:center;gap:24px;">
          <canvas id="chart-status" style="max-width:180px;max-height:180px;"></canvas>
          <div id="chart-status-legend" style="display:flex;flex-direction:column;gap:8px;font-size:12px;color:var(--text-2);"></div>
        </div>
      </div>

    </div>{{-- /charts-row --}}

    {{-- ── MID ROW: Status + Quick Actions ── --}}
    <div class="db-mid-row">

      {{-- Status breakdown --}}
      <div class="db-card">
        <div class="db-card-header">
          <span class="db-card-title">حالة طلبات الإنتاج</span>
          <a href="{{ route('video_creator.production_request') }}" class="db-card-link">عرض الكل</a>
        </div>
        <div class="db-card-body">
          <div class="db-status-grid">
            <div class="db-status-block">
              <div class="db-status-num">{{ $pendingRequests }}</div>
              <div class="db-status-lbl">في الانتظار</div>
            </div>
            <div class="db-status-block blue">
              <div class="db-status-num">{{ $acceptedRequests }}</div>
              <div class="db-status-lbl">قيد التنفيذ</div>
            </div>
            <div class="db-status-block amber">
              <div class="db-status-num">{{ $submittedRequests }}</div>
              <div class="db-status-lbl">بانتظار المراجعة</div>
            </div>
            <div class="db-status-block orange">
              <div class="db-status-num">{{ $revisionRequests }}</div>
              <div class="db-status-lbl">يحتاج تعديل</div>
            </div>
            <div class="db-status-block green">
              <div class="db-status-num">{{ $approvedRequests }}</div>
              <div class="db-status-lbl">مكتملة</div>
            </div>
            <div class="db-status-block red">
              <div class="db-status-num">{{ $rejectedRequests }}</div>
              <div class="db-status-lbl">مرفوضة</div>
            </div>
          </div>

          {{-- Bar chart inside status card --}}
          <div style="margin-top:20px;height:90px;">
            <canvas id="chart-bar-status"></canvas>
          </div>
        </div>
      </div>

      {{-- Quick actions --}}
      <div class="db-card">
        <div class="db-card-header">
          <span class="db-card-title">إجراءات سريعة</span>
        </div>
        <div class="db-card-body">
          <a href="{{ route('video_creator.production_request') }}" class="db-quick-action">
            <div class="db-quick-action-left">
              <div class="db-quick-action-icon" style="background:var(--brand-light);">
                <svg fill="none" stroke="var(--brand)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
              </div>
              <span class="db-quick-action-label">طلبات الإنتاج</span>
            </div>
            <span class="db-quick-action-arrow"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
          </a>
          <a href="{{ route('video_creator.videos.index') }}" class="db-quick-action">
            <div class="db-quick-action-left">
              <div class="db-quick-action-icon" style="background:#FEF0F0;">
                <svg fill="none" stroke="#B02020" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
              </div>
              <span class="db-quick-action-label">فيديوهاتي</span>
            </div>
            <span class="db-quick-action-arrow"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
          </a>
          <a href="{{ route('video_creator.comments.index') }}" class="db-quick-action">
            <div class="db-quick-action-left">
              <div class="db-quick-action-icon" style="background:#F4EFFE;">
                <svg fill="none" stroke="#6D3AB5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
              </div>
              <span class="db-quick-action-label">التعليقات</span>
            </div>
            @if($unreadComments > 0)
              <span class="db-unread-badge">{{ $unreadComments }}</span>
            @else
              <span class="db-quick-action-arrow"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
            @endif
          </a>
        </div>
      </div>

    </div>{{-- /mid-row --}}

    {{-- ── BOTTOM ROW: Recent Videos + Recent Comments ── --}}
    <div class="db-bottom-row">

      {{-- Recent Videos --}}
      <div class="db-card">
        <div class="db-card-header">
          <span class="db-card-title">أحدث الفيديوهات</span>
          <a href="{{ route('video_creator.videos.index') }}" class="db-card-link">عرض الكل</a>
        </div>
        <div class="db-card-body">
          @forelse($recentVideos as $video)
            <div class="db-activity-item">
              <div class="db-activity-thumb">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
              </div>
              <div class="db-activity-info">
                <div class="db-activity-title">{{ $video->title }}</div>
                <div class="db-activity-time">{{ $video->created_at->diffForHumans() }}</div>
              </div>
              <div class="db-activity-right">
                <span class="db-activity-views">{{ number_format($video->views ?? 0) }} مشاهدة</span>
                <a href="{{ route('video_creator.videos.show', $video) }}" class="db-activity-link">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
              </div>
            </div>
          @empty
            <div class="db-empty">لا توجد فيديوهات بعد</div>
          @endforelse
        </div>
      </div>

      {{-- Recent Comments --}}
      <div class="db-card">
        <div class="db-card-header">
          <span class="db-card-title">أحدث التعليقات</span>
          <a href="{{ route('video_creator.comments.index') }}" class="db-card-link">عرض الكل</a>
        </div>
        <div class="db-card-body">
          @forelse($recentComments as $comment)
            @php
              $uName = $comment->user->name ?? 'مستخدم';
              $uInitial = mb_substr($uName, 0, 1, 'UTF-8');
              $uBg = $avatarColors[crc32($uName) % count($avatarColors)];
            @endphp
            <div class="db-comment-item">
              <div class="db-comment-top">
                <div class="db-comment-avatar" style="background:{{ $uBg }}">{{ $uInitial }}</div>
                <span class="db-comment-name">{{ $uName }}</span>
                <span class="db-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
              </div>
              <div class="db-comment-text">{{ $comment->content }}</div>
              @if($comment->commentable)
                <div class="db-comment-on">على: {{ $comment->commentable->title ?? 'فيديو' }}</div>
              @endif
            </div>
          @empty
            <div class="db-empty">لا توجد تعليقات بعد</div>
          @endforelse
        </div>
      </div>

    </div>{{-- /bottom-row --}}

    {{-- ── ACTIVE REQUESTS ── --}}
    <div class="db-card">
      <div class="db-card-header">
        <span class="db-card-title">طلبات الإنتاج النشطة</span>
        <a href="{{ route('video_creator.production_request') }}" class="db-card-link">عرض الكل</a>
      </div>
      <div class="db-card-body">
        @forelse($activeRequests as $request)
          @php
            $ab = $activeStatusMap[$request->status] ?? ['cls' => 'db-badge-orange', 'label' => $request->status];
          @endphp
          <div class="db-req-item">
            <div class="db-req-info">
              <div class="db-req-title">{{ $request->title }}</div>
              <div class="db-req-meta">
                <span>{{ $request->researcher->name ?? 'غير محدد' }}</span>
                @if($request->deadline)
                  <span>التسليم: {{ $request->deadline->format('Y/m/d') }}</span>
                @endif
                <span class="db-badge {{ $ab['cls'] }}">
                  <span class="db-badge-dot"></span>{{ $ab['label'] }}
                </span>
              </div>
            </div>
            <a href="{{ route('video_creator.production_requests.show', $request) }}" class="db-req-link">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
          </div>
        @empty
          <div class="db-empty">لا توجد طلبات إنتاج نشطة</div>
        @endforelse
      </div>
    </div>

  </div>{{-- /db-main --}}
</div>{{-- /db-page --}}

{{-- ══ CHART.JS ══ --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// ── shared defaults ──
Chart.defaults.font.family = "'IBM Plex Sans Arabic', system-ui, sans-serif";
Chart.defaults.color = '#9A9893';

const brand   = '#E84E1B';
const blue    = '#185FA5';
const green   = '#1E7F52';
const amber   = '#92690A';
const orange  = '#BF4D17';
const red     = '#B02020';
const gray    = '#9A9893';
const surface = '#F0EEE9';

// ── 1. Line chart: views over 6 months ──
(function() {
  // months array (last 6, most-recent last)
 // Last 6 months labels
$chartMonths = collect(range(5, 0))
    ->map(fn($i) => now()->subMonths($i)->translatedFormat('M'))
    ->values();

// Last 6 months views
$chartViews = collect(range(5, 0))
    ->map(fn($i) => \App\Models\Video::whereYear('created_at', now()->subMonths($i)->year)
        ->whereMonth('created_at', now()->subMonths($i)->month)
        ->sum('views') ?? 0
    )
    ->values();

  const ctx = document.getElementById('chart-views').getContext('2d');
  const grad = ctx.createLinearGradient(0, 0, 0, 200);
  grad.addColorStop(0, 'rgba(232,78,27,0.18)');
  grad.addColorStop(1, 'rgba(232,78,27,0)');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'المشاهدات',
        data: viewsData,
        borderColor: brand,
        backgroundColor: grad,
        borderWidth: 2,
        pointBackgroundColor: brand,
        pointRadius: 4,
        pointHoverRadius: 6,
        tension: 0.4,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1A1917',
          titleColor: '#fff',
          bodyColor: 'rgba(255,255,255,0.7)',
          padding: 10,
          cornerRadius: 8,
          callbacks: {
            label: ctx => ' ' + ctx.parsed.y.toLocaleString('ar') + ' مشاهدة'
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          border: { display: false },
          ticks: { font: { size: 11 } }
        },
        y: {
          grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
          border: { display: false },
          ticks: { font: { size: 11 }, maxTicksLimit: 5 }
        }
      }
    }
  });
})();

// ── 2. Doughnut chart: request status distribution ──
(function() {
  const labels = ['في الانتظار','قيد التنفيذ','بانتظار المراجعة','يحتاج تعديل','مكتملة','مرفوضة'];
  const values = [
    {{ $pendingRequests }},
    {{ $acceptedRequests }},
    {{ $submittedRequests }},
    {{ $revisionRequests }},
    {{ $approvedRequests }},
    {{ $rejectedRequests }}
  ];
  const colors = [gray, blue, amber, orange, green, red];

  const ctx = document.getElementById('chart-status').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels,
      datasets: [{
        data: values,
        backgroundColor: colors.map(c => c + 'CC'),
        borderColor: colors,
        borderWidth: 1.5,
        hoverOffset: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '68%',
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1A1917',
          titleColor: '#fff',
          bodyColor: 'rgba(255,255,255,0.7)',
          padding: 10,
          cornerRadius: 8,
        }
      }
    }
  });

  // custom legend
  const legend = document.getElementById('chart-status-legend');
  labels.forEach((lbl, i) => {
    if (values[i] === 0) return;
    const el = document.createElement('div');
    el.style.cssText = 'display:flex;align-items:center;gap:6px;';
    el.innerHTML = `<span style="width:8px;height:8px;border-radius:50%;background:${colors[i]};flex-shrink:0;"></span>
                    <span style="color:var(--text-2)">${lbl}</span>
                    <span style="font-weight:600;color:var(--text-1);margin-right:auto;">${values[i]}</span>`;
    legend.appendChild(el);
  });
})();

// ── 3. Bar chart inside status card ──
(function() {
  const labels = ['انتظار','تنفيذ','مراجعة','تعديل','مكتملة','مرفوضة'];
  const values = [
    {{ $pendingRequests }},
    {{ $acceptedRequests }},
    {{ $submittedRequests }},
    {{ $revisionRequests }},
    {{ $approvedRequests }},
    {{ $rejectedRequests }}
  ];
  const bColors = [
    gray + 'BB', blue + 'CC', amber + 'CC',
    orange + 'CC', green + 'CC', red + 'CC'
  ];

  const ctx = document.getElementById('chart-bar-status').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        data: values,
        backgroundColor: bColors,
        borderRadius: 4,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1A1917',
          titleColor: '#fff',
          bodyColor: 'rgba(255,255,255,0.7)',
          padding: 8,
          cornerRadius: 8,
        }
      },
      scales: {
        x: {
          grid: { display: false },
          border: { display: false },
          ticks: { font: { size: 10 } }
        },
        y: {
          display: false,
        }
      }
    }
  });
})();
</script>
@endsection