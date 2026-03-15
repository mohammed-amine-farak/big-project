@extends('layouts.video_dashboard')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; }
:root {
  --brand: #E84E1B;
  --brand-dark: #C23A0F;
  --surface: #FFFFFF;
  --surface-2: #F7F6F3;
  --surface-3: #F0EEE9;
  --border: rgba(0,0,0,0.08);
  --border-strong: rgba(0,0,0,0.14);
  --text-1: #1A1917;
  --text-2: #5A5855;
  --text-3: #9A9893;
  --radius: 14px;
  --radius-sm: 8px;
  --ff: 'IBM Plex Sans Arabic', system-ui, sans-serif;
}

.vs-page { font-family: var(--ff); background: var(--surface-2); color: var(--text-1); direction: rtl; min-height: 100vh; }

/* ── TOP BAR ── */
.vs-topbar {
  background: #1A1917;
  padding: 20px 40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}
.vs-topbar-inner { max-width: 1200px; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
.vs-back-btn {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.12);
  color: rgba(255,255,255,0.75);
  font-family: var(--ff); font-size: 13px;
  padding: 8px 16px; border-radius: var(--radius-sm);
  text-decoration: none; transition: background 0.15s;
}
.vs-back-btn:hover { background: rgba(255,255,255,0.13); color: #fff; }
.vs-back-btn svg { width: 15px; height: 15px; }
.vs-views-pill {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.1);
  color: rgba(255,255,255,0.6);
  font-size: 12px; padding: 6px 14px; border-radius: 20px;
}
.vs-views-pill svg { width: 14px; height: 14px; }

/* ── VIDEO HERO ── */
.vs-hero {
  background: #1A1917;
  padding: 0 40px 36px;
}
.vs-hero-inner { max-width: 1200px; margin: 0 auto; }
.vs-video-title {
  font-size: 26px; font-weight: 700;
  color: #fff; letter-spacing: -0.4px;
  margin-bottom: 8px; line-height: 1.35;
}
.vs-video-desc { font-size: 14px; color: rgba(255,255,255,0.45); line-height: 1.6; }

/* ── MAIN ── */
.vs-main { max-width: 1200px; margin: 0 auto; padding: 32px 40px; }
.vs-layout { display: grid; grid-template-columns: 1fr 340px; gap: 28px; align-items: start; }

/* ── PLAYER ── */
.vs-player-wrap {
  background: #000;
  border-radius: var(--radius);
  overflow: hidden;
  margin-bottom: 24px;
  position: relative;
}
.vs-player-wrap video { display: block; width: 100%; aspect-ratio: 16/9; }

/* ── INFO CARDS ── */
.vs-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
  margin-bottom: 20px;
}
.vs-card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; gap: 10px;
}
.vs-card-header-icon {
  width: 32px; height: 32px;
  border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.vs-card-header-icon svg { width: 16px; height: 16px; }
.vs-card-title { font-size: 14px; font-weight: 600; color: var(--text-1); }
.vs-card-sub { font-size: 12px; color: var(--text-3); margin-top: 1px; }
.vs-card-body { padding: 20px; }

/* ── INFO ROWS ── */
.vs-info-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 10px 0;
  border-bottom: 1px solid var(--border);
  font-size: 13px;
}
.vs-info-row:last-child { border-bottom: none; padding-bottom: 0; }
.vs-info-row:first-child { padding-top: 0; }
.vs-info-label { color: var(--text-3); }
.vs-info-value { font-weight: 500; color: var(--text-1); }

/* ── STAT BLOCKS ── */
.vs-stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.vs-stat-block {
  background: var(--surface-2);
  border-radius: var(--radius-sm);
  padding: 14px;
  text-align: center;
}
.vs-stat-block .num { font-size: 22px; font-weight: 700; color: var(--text-1); line-height: 1; margin-bottom: 4px; }
.vs-stat-block .lbl { font-size: 11px; color: var(--text-3); }

/* ── COMPLETION BAR ── */
.vs-progress-wrap { margin-top: 16px; }
.vs-progress-label { display: flex; justify-content: space-between; font-size: 12px; color: var(--text-3); margin-bottom: 6px; }
.vs-progress-track { height: 6px; background: var(--surface-3); border-radius: 3px; overflow: hidden; }
.vs-progress-fill { height: 100%; background: var(--brand); border-radius: 3px; transition: width 0.6s ease; }

/* ── PRODUCTION REQUEST ── */
.vs-pr-field { margin-bottom: 14px; }
.vs-pr-field:last-child { margin-bottom: 0; }
.vs-pr-field-label { font-size: 11px; font-weight: 500; color: var(--text-3); letter-spacing: 0.4px; margin-bottom: 4px; text-transform: uppercase; }
.vs-pr-field-value { font-size: 14px; color: var(--text-1); font-weight: 500; }

/* ── STATUS BADGE ── */
.vs-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 500; padding: 4px 10px; border-radius: 20px; white-space: nowrap; }
.vs-badge-green  { background: #EDFAF4; color: #1E7F52; }
.vs-badge-yellow { background: #FEF8EC; color: #92690A; }
.vs-badge-orange { background: #FFF0EA; color: #BF4D17; }
.vs-badge-red    { background: #FEF0F0; color: #B02020; }
.vs-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

/* ── COMMENTS SECTION ── */
.vs-comments-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
}
.vs-comments-header {
  padding: 20px 24px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
}
.vs-comments-title-row { display: flex; align-items: center; gap: 12px; }
.vs-comments-icon {
  width: 36px; height: 36px;
  background: #FFF0EA; border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.vs-comments-icon svg { width: 18px; height: 18px; color: var(--brand); }
.vs-comments-heading { font-size: 16px; font-weight: 600; color: var(--text-1); }
.vs-comments-count { font-size: 12px; color: var(--text-3); margin-top: 2px; }
.vs-mark-read-btn {
  display: inline-flex; align-items: center; gap: 6px;
  background: none; border: none; cursor: pointer;
  font-family: var(--ff); font-size: 13px;
  color: var(--brand); font-weight: 500;
  padding: 6px 12px; border-radius: var(--radius-sm);
  transition: background 0.15s;
}
.vs-mark-read-btn:hover { background: #FFF0EA; }
.vs-mark-read-btn svg { width: 14px; height: 14px; }

.vs-comments-body { padding: 24px; }

/* ── COMMENT ITEM ── */
.vs-comment {
  display: flex; gap: 12px;
  padding: 16px 0;
  border-bottom: 1px solid var(--border);
}
.vs-comment:last-child { border-bottom: none; padding-bottom: 0; }
.vs-comment:first-child { padding-top: 0; }
.vs-comment-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 12px; font-weight: 700; flex-shrink: 0;
  color: #fff;
}
.vs-comment-content { flex: 1; min-width: 0; }
.vs-comment-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap; }
.vs-comment-name { font-size: 13px; font-weight: 600; color: var(--text-1); }
.vs-comment-time { font-size: 11px; color: var(--text-3); }
.vs-comment-text { font-size: 13px; color: var(--text-2); line-height: 1.6; }
.vs-comment-actions { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
.vs-comment-action-btn {
  background: none; border: none; cursor: pointer;
  font-family: var(--ff); font-size: 12px;
  color: var(--text-3); padding: 3px 8px; border-radius: 6px;
  transition: all 0.15s; display: flex; align-items: center; gap: 4px;
}
.vs-comment-action-btn:hover { background: var(--surface-3); color: var(--text-2); }
.vs-comment-action-btn.danger:hover { background: #FEF0F0; color: #B02020; }
.vs-comment-action-btn svg { width: 12px; height: 12px; }

/* ── REPLY FORM ── */
.vs-reply-form { margin-top: 12px; display: none; }
.vs-reply-form.open { display: block; }
.vs-reply-input {
  width: 100%; min-height: 70px; padding: 10px 12px;
  border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
  font-family: var(--ff); font-size: 13px; color: var(--text-1);
  background: var(--surface-2); outline: none; resize: vertical;
  transition: border-color 0.15s, box-shadow 0.15s;
  direction: rtl;
}
.vs-reply-input:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(232,78,27,0.1); background: var(--surface); }
.vs-reply-actions { display: flex; gap: 8px; margin-top: 8px; justify-content: flex-end; }
.vs-btn-reply-submit {
  height: 32px; padding: 0 16px;
  background: var(--brand); color: #fff;
  border: none; border-radius: var(--radius-sm);
  font-family: var(--ff); font-size: 12px; font-weight: 600;
  cursor: pointer; transition: background 0.15s;
}
.vs-btn-reply-submit:hover { background: var(--brand-dark); }
.vs-btn-reply-cancel {
  height: 32px; padding: 0 12px;
  background: transparent; color: var(--text-3);
  border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
  font-family: var(--ff); font-size: 12px;
  cursor: pointer; transition: background 0.15s;
}
.vs-btn-reply-cancel:hover { background: var(--surface-3); }

/* ── NESTED REPLIES ── */
.vs-replies { margin-top: 12px; padding-right: 20px; border-right: 2px solid var(--surface-3); }

/* ── EMPTY COMMENTS ── */
.vs-empty-comments { text-align: center; padding: 48px 20px; }
.vs-empty-comments-icon {
  width: 56px; height: 56px;
  background: var(--surface-3); border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 16px;
}
.vs-empty-comments-icon svg { width: 28px; height: 28px; color: var(--text-3); }
.vs-empty-comments-title { font-size: 15px; font-weight: 600; color: var(--text-1); margin-bottom: 6px; }
.vs-empty-comments-sub { font-size: 13px; color: var(--text-3); }

@media (max-width: 900px) {
  .vs-layout { grid-template-columns: 1fr; }
  .vs-topbar, .vs-hero, .vs-main { padding-right: 20px; padding-left: 20px; }
}
</style>

@php
  $statusMap = [
    'approved'          => ['cls' => 'vs-badge-green',  'label' => 'منشور'],
    'submitted'         => ['cls' => 'vs-badge-yellow', 'label' => 'قيد المراجعة'],
    'revision_required' => ['cls' => 'vs-badge-orange', 'label' => 'يحتاج تعديل'],
    'rejected'          => ['cls' => 'vs-badge-red',    'label' => 'مرفوض'],
  ];
  $status = $video->productionRequest?->status ?? '';
  $badge  = $statusMap[$status] ?? ['cls' => 'vs-badge-yellow', 'label' => $status];

  $avatarColors = ['#534AB7','#0F6E56','#C23A0F','#185FA5','#854F0B','#993556','#3B6D11'];
@endphp

<div class="vs-page">

  {{-- ══ TOP BAR ══ --}}
  <div class="vs-topbar">
    <div class="vs-topbar-inner">
      <a href="{{ route('video_creator.videos.index') }}" class="vs-back-btn">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        العودة إلى قائمة الفيديوهات
      </a>
      <div style="display:flex;align-items:center;gap:10px;">
        @if($video->productionRequest)
          <span class="vs-badge {{ $badge['cls'] }}">
            <span class="vs-badge-dot"></span>
            {{ $badge['label'] }}
          </span>
        @endif
        <span class="vs-views-pill">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
          </svg>
          {{ number_format($video->views ?? 0) }} مشاهدة
        </span>
      </div>
    </div>
  </div>

  {{-- ══ TITLE HERO ══ --}}
  <div class="vs-hero">
    <div class="vs-hero-inner">
      <h1 class="vs-video-title">{{ $video->title }}</h1>
      @if($video->description)
        <p class="vs-video-desc">{{ $video->description }}</p>
      @endif
    </div>
  </div>

  {{-- ══ MAIN LAYOUT ══ --}}
  <div class="vs-main">
    <div class="vs-layout">

      {{-- ── LEFT COLUMN: Player + Comments ── --}}
      <div>

        {{-- Video Player --}}
        <div class="vs-player-wrap">
          <video controls>
            <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
            متصفحك لا يدعم تشغيل الفيديو
          </video>
        </div>

        {{-- Comments Card --}}
        <div class="vs-comments-card">
          <div class="vs-comments-header">
            <div class="vs-comments-title-row">
              <div class="vs-comments-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
              </div>
              <div>
                <div class="vs-comments-heading">التعليقات</div>
                <div class="vs-comments-count">{{ $comments->count() }} تعليق</div>
              </div>
            </div>
            <form action="" method="POST">
              @csrf
              <button type="submit" class="vs-mark-read-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                تعيين الكل كمقروء
              </button>
            </form>
          </div>

          <div class="vs-comments-body">
            @if($comments->isEmpty())
              <div class="vs-empty-comments">
                <div class="vs-empty-comments-icon">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z"/>
                  </svg>
                </div>
                <div class="vs-empty-comments-title">لا توجد تعليقات بعد</div>
                <div class="vs-empty-comments-sub">لم يضف أحد تعليقاً على هذا الفيديو</div>
              </div>
            @else
              <div>
                @foreach($comments as $comment)
                  @include('video-dashboard.comments.partials.comment_item', ['comment' => $comment, 'depth' => 0])
                @endforeach
              </div>
            @endif
          </div>
        </div>

      </div>{{-- /left column --}}

      {{-- ── RIGHT SIDEBAR ── --}}
      <div>

        {{-- Video Info --}}
        <div class="vs-card">
          <div class="vs-card-header">
            <div class="vs-card-header-icon" style="background:#F0EEE9;">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#9A9893;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div>
              <div class="vs-card-title">معلومات الفيديو</div>
            </div>
          </div>
          <div class="vs-card-body">
            <div class="vs-info-row">
              <span class="vs-info-label">تاريخ الرفع</span>
              <span class="vs-info-value">{{ $video->created_at->format('Y/m/d') }}</span>
            </div>
            @if($video->video_format)
            <div class="vs-info-row">
              <span class="vs-info-label">الصيغة</span>
              <span class="vs-info-value">{{ strtoupper($video->video_format) }}</span>
            </div>
            @endif
            @if($video->file_size)
            <div class="vs-info-row">
              <span class="vs-info-label">الحجم</span>
              <span class="vs-info-value">{{ $video->file_size }} MB</span>
            </div>
            @endif
            @if($video->duration)
            <div class="vs-info-row">
              <span class="vs-info-label">المدة</span>
              <span class="vs-info-value">
                {{ floor($video->duration / 60) }}:{{ str_pad($video->duration % 60, 2, '0', STR_PAD_LEFT) }}
              </span>
            </div>
            @endif
          </div>
        </div>

        {{-- Statistics --}}
        <div class="vs-card">
          <div class="vs-card-header">
            <div class="vs-card-header-icon" style="background:#FFF0EA;">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#E84E1B;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
            </div>
            <div>
              <div class="vs-card-title">الإحصائيات</div>
            </div>
          </div>
          <div class="vs-card-body">
            <div class="vs-stats-grid">
              <div class="vs-stat-block">
                <div class="num">{{ number_format($video->views ?? 0) }}</div>
                <div class="lbl">المشاهدات</div>
              </div>
              <div class="vs-stat-block">
                <div class="num">{{ number_format($video->likes ?? 0) }}</div>
                <div class="lbl">الإعجابات</div>
              </div>
              <div class="vs-stat-block">
                <div class="num">{{ $comments->count() }}</div>
                <div class="lbl">التعليقات</div>
              </div>
              <div class="vs-stat-block">
                <div class="num">{{ $video->completion_rate ?? 0 }}%</div>
                <div class="lbl">نسبة الإكمال</div>
              </div>
            </div>
            @if(($video->completion_rate ?? 0) > 0)
              <div class="vs-progress-wrap">
                <div class="vs-progress-label">
                  <span>نسبة إكمال الفيديو</span>
                  <span>{{ $video->completion_rate }}%</span>
                </div>
                <div class="vs-progress-track">
                  <div class="vs-progress-fill" style="width:{{ $video->completion_rate }}%"></div>
                </div>
              </div>
            @endif
          </div>
        </div>

        {{-- Production Request --}}
        @if($video->productionRequest)
        <div class="vs-card">
          <div class="vs-card-header">
            <div class="vs-card-header-icon" style="background:#EDF4FF;">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#185FA5;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <div>
              <div class="vs-card-title">طلب الإنتاج</div>
            </div>
          </div>
          <div class="vs-card-body">
            <div class="vs-pr-field">
              <div class="vs-pr-field-label">العنوان</div>
              <div class="vs-pr-field-value">{{ $video->productionRequest->title }}</div>
            </div>
            @if($video->productionRequest->researcher)
              <div class="vs-pr-field">
                <div class="vs-pr-field-label">الباحث</div>
                <div style="display:flex;align-items:center;gap:8px;">
                  @php
                    $r = $video->productionRequest->researcher;
                    $initials = mb_substr($r->name, 0, 1, 'UTF-8');
                    $bg = $avatarColors[crc32($r->name) % count($avatarColors)];
                  @endphp
                  <div style="width:26px;height:26px;border-radius:50%;background:{{ $bg }};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;">{{ $initials }}</div>
                  <span class="vs-pr-field-value">{{ $r->name }}</span>
                </div>
              </div>
            @endif
            @if($video->productionRequest->lesson)
              <div class="vs-pr-field">
                <div class="vs-pr-field-label">الدرس</div>
                <div class="vs-pr-field-value">{{ $video->productionRequest->lesson->title }}</div>
              </div>
            @endif
            <div class="vs-pr-field" style="margin-bottom:0;">
              <div class="vs-pr-field-label">الحالة</div>
              <span class="vs-badge {{ $badge['cls'] }}">
                <span class="vs-badge-dot"></span>
                {{ $badge['label'] }}
              </span>
            </div>
          </div>
        </div>
        @endif

      </div>{{-- /sidebar --}}

    </div>{{-- /layout --}}
  </div>{{-- /main --}}

</div>{{-- /vs-page --}}

<script>
function toggleReplyForm(commentId) {
  const form = document.getElementById('reply-form-' + commentId);
  if (form) form.classList.toggle('open');
}
function deleteComment(commentId) {
  if (confirm('هل أنت متأكد من حذف هذا التعليق؟')) {
    document.getElementById('delete-form-' + commentId).submit();
  }
}
</script>
@endsection