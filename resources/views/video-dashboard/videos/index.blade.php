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

.vc-page { font-family: var(--ff); background: var(--surface-2); color: var(--text-1); direction: rtl; }

/* ── HERO ── */
.vc-hero {
  background: #1A1917;
  padding: 36px 40px 0;
  position: relative;
  overflow: hidden;
}
.vc-hero::before {
  content: '';
  position: absolute;
  top: -60px; left: -60px;
  width: 320px; height: 320px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(232,78,27,0.18) 0%, transparent 70%);
  pointer-events: none;
}
.vc-hero-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 32px;
  position: relative;
  z-index: 1;
}
.vc-hero-title-row {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 10px;
}
.vc-hero-icon {
  width: 48px; height: 48px;
  background: var(--brand);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.vc-hero-icon svg { width: 24px; height: 24px; color: #fff; }
.vc-hero-heading { font-size: 28px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }
.vc-hero-sub { font-size: 13px; color: rgba(255,255,255,0.45); margin-top: 2px; }
.vc-hero-stats { display: flex; gap: 2px; }
.vc-stat-pill {
  padding: 18px 28px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 12px 12px 0 0;
  text-align: center;
  min-width: 110px;
}
.vc-stat-pill .num { font-size: 24px; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 5px; }
.vc-stat-pill .lbl { font-size: 11px; color: rgba(255,255,255,0.42); }

/* ── MAIN ── */
.vc-main { max-width: 1200px; margin: 0 auto; padding: 32px 40px; }

/* ── FILTER BAR ── */
.vc-filter-bar {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 20px 24px;
  margin-bottom: 28px;
  display: flex;
  gap: 12px;
  align-items: flex-end;
  flex-wrap: wrap;
}
.vc-filter-group { display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 130px; }
.vc-filter-group.wide { flex: 2; min-width: 200px; }
.vc-filter-label { font-size: 11px; font-weight: 500; color: var(--text-3); letter-spacing: 0.5px; text-transform: uppercase; }
.vc-filter-input {
  height: 38px;
  padding: 0 12px;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-sm);
  font-family: var(--ff);
  font-size: 13px;
  color: var(--text-1);
  background: var(--surface-2);
  outline: none;
  transition: border-color 0.15s, box-shadow 0.15s;
  direction: rtl;
  width: 100%;
}
.vc-filter-input:focus {
  border-color: var(--brand);
  box-shadow: 0 0 0 3px rgba(232,78,27,0.1);
  background: var(--surface);
}
.vc-search-wrap { position: relative; }
.vc-search-wrap .vc-search-icon {
  position: absolute;
  left: 10px; top: 50%;
  transform: translateY(-50%);
  color: var(--text-3);
  pointer-events: none;
  display: flex;
}
.vc-search-wrap .vc-filter-input { padding-left: 34px; }
.vc-filter-actions { display: flex; gap: 8px; align-items: flex-end; flex-shrink: 0; padding-top: 20px; }
.vc-btn-apply {
  height: 38px; padding: 0 20px;
  background: var(--brand); color: #fff;
  border: none; border-radius: var(--radius-sm);
  font-family: var(--ff); font-size: 13px; font-weight: 600;
  cursor: pointer; transition: background 0.15s;
  white-space: nowrap; display: flex; align-items: center; gap: 6px;
}
.vc-btn-apply:hover { background: var(--brand-dark); }
.vc-btn-reset {
  height: 38px; padding: 0 16px;
  background: transparent; color: var(--text-2);
  border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
  font-family: var(--ff); font-size: 13px; cursor: pointer;
  transition: background 0.15s; white-space: nowrap; text-decoration: none;
  display: flex; align-items: center;
}
.vc-btn-reset:hover { background: var(--surface-3); }

/* ── GRID HEADER ── */
.vc-grid-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.vc-grid-title { font-size: 16px; font-weight: 600; color: var(--text-1); }
.vc-grid-count { font-size: 12px; color: var(--text-3); background: var(--surface-3); padding: 3px 10px; border-radius: 20px; margin-right: 10px; }
.vc-sort-select {
  height: 34px; padding: 0 10px;
  border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
  font-family: var(--ff); font-size: 12px; color: var(--text-2);
  background: var(--surface); cursor: pointer; outline: none;
  -webkit-appearance: none; appearance: none;
}
.vc-sort-select:focus { border-color: var(--brand); }

/* ── VIDEOS GRID ── */
.vc-videos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
  gap: 20px;
}

/* ── VIDEO CARD ── */
.vc-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
}
.vc-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.1);
  border-color: var(--border-strong);
}
.vc-card:hover .vc-thumb-overlay { opacity: 1; }
.vc-card:hover .vc-thumb-img { transform: scale(1.04); }

.vc-thumb { position: relative; height: 170px; overflow: hidden; background: #1A1917; }
.vc-thumb-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
.vc-thumb-placeholder {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg, #1f1e1c 0%, #2d2b28 100%);
}
.vc-thumb-placeholder svg { width: 48px; height: 48px; opacity: 0.2; color: #fff; }
.vc-thumb-overlay {
  position: absolute; inset: 0;
  background: rgba(0,0,0,0.45);
  opacity: 0; transition: opacity 0.2s;
  display: flex; align-items: center; justify-content: center;
  text-decoration: none;
}
.vc-play-btn {
  width: 52px; height: 52px;
  background: rgba(255,255,255,0.95);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
}
.vc-play-btn svg { width: 22px; height: 22px; color: var(--brand); margin-right: -3px; }
.vc-duration {
  position: absolute; bottom: 10px; left: 10px;
  background: rgba(0,0,0,0.72); color: #fff;
  font-size: 11px; font-weight: 500;
  padding: 3px 8px; border-radius: 5px;
  letter-spacing: 0.5px;
}
.vc-card-body { padding: 16px; }
.vc-card-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
.vc-avatar {
  width: 28px; height: 28px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 10px; font-weight: 700;
  flex-shrink: 0; color: #fff;
}
.vc-researcher-name { font-size: 12px; color: var(--text-3); }
.vc-card-title {
  font-size: 14px; font-weight: 600; color: var(--text-1);
  line-height: 1.45; margin-bottom: 12px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.vc-card-divider { height: 1px; background: var(--border); margin: 12px 0; }
.vc-card-footer { display: flex; align-items: center; justify-content: space-between; }
.vc-card-stats { display: flex; gap: 12px; }
.vc-stat-item { display: flex; align-items: center; gap: 4px; font-size: 12px; color: var(--text-3); }
.vc-stat-item svg { width: 13px; height: 13px; }

/* ── STATUS BADGES ── */
.vc-badge { font-size: 11px; font-weight: 500; padding: 4px 10px; border-radius: 20px; white-space: nowrap; }
.vc-badge-green  { background: #EDFAF4; color: #1E7F52; }
.vc-badge-yellow { background: #FEF8EC; color: #92690A; }
.vc-badge-orange { background: #FFF0EA; color: #BF4D17; }
.vc-badge-red    { background: #FEF0F0; color: #B02020; }

/* ── EMPTY STATE ── */
.vc-empty {
  text-align: center; padding: 80px 40px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
}
.vc-empty-icon {
  width: 72px; height: 72px;
  background: var(--surface-3); border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
}
.vc-empty-icon svg { width: 36px; height: 36px; color: var(--text-3); }
.vc-empty-title { font-size: 18px; font-weight: 600; color: var(--text-1); margin-bottom: 8px; }
.vc-empty-sub { font-size: 14px; color: var(--text-3); margin-bottom: 24px; }
.vc-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--brand); color: #fff;
  font-family: var(--ff); font-size: 14px; font-weight: 600;
  padding: 10px 24px; border: none; border-radius: var(--radius-sm);
  cursor: pointer; text-decoration: none; transition: background 0.15s;
}
.vc-btn-primary:hover { background: var(--brand-dark); }

/* ── PAGINATION ── */
.vc-pagination { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 40px; }
.vc-page-btn {
  min-width: 36px; height: 36px; padding: 0 8px;
  border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
  background: var(--surface); color: var(--text-2);
  font-family: var(--ff); font-size: 13px;
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  transition: all 0.15s; text-decoration: none;
}
.vc-page-btn:hover { background: var(--surface-3); }
.vc-page-btn.active { background: var(--brand); color: #fff; border-color: var(--brand); }
</style>

<div class="vc-page">

    {{-- ══ HERO HEADER ══ --}}
    <header class="vc-hero">
        <div class="vc-hero-inner">
            <div>
                <div class="vc-hero-title-row">
                    <div class="vc-hero-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="vc-hero-heading">فيديوهاتي</h1>
                        <p class="vc-hero-sub">جميع الفيديوهات التي أنتجتها</p>
                    </div>
                </div>
            </div>
            <div class="vc-hero-stats">
                <div class="vc-stat-pill">
                    <div class="num">{{ $totalVideos }}</div>
                    <div class="lbl">إجمالي الفيديوهات</div>
                </div>
                <div class="vc-stat-pill">
                    <div class="num">{{ number_format($totalViews) }}</div>
                    <div class="lbl">إجمالي المشاهدات</div>
                </div>
                <div class="vc-stat-pill">
                    <div class="num">{{ $totalComments }}</div>
                    <div class="lbl">التعليقات</div>
                </div>
            </div>
        </div>
    </header>

    {{-- ══ MAIN CONTENT ══ --}}
    <div class="vc-main">

        {{-- ── FILTER BAR ── --}}
        <form action="{{ route('video_creator.videos.index') }}" method="GET" class="vc-filter-bar">
            <div class="vc-filter-group wide">
                <span class="vc-filter-label">بحث</span>
                <div class="vc-search-wrap">
                    <span class="vc-search-icon">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="ابحث باسم الفيديو..." class="vc-filter-input">
                </div>
            </div>

            <div class="vc-filter-group">
                <span class="vc-filter-label">الحالة</span>
                <select name="status" class="vc-filter-input">
                    <option value="">الكل</option>
                    <option value="approved"          {{ request('status') == 'approved'          ? 'selected' : '' }}>منشور</option>
                    <option value="submitted"         {{ request('status') == 'submitted'         ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="revision_required" {{ request('status') == 'revision_required' ? 'selected' : '' }}>يحتاج تعديل</option>
                    <option value="rejected"          {{ request('status') == 'rejected'          ? 'selected' : '' }}>مرفوض</option>
                </select>
            </div>

            <div class="vc-filter-group">
                <span class="vc-filter-label">من تاريخ</span>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="vc-filter-input">
            </div>

            <div class="vc-filter-group">
                <span class="vc-filter-label">إلى تاريخ</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="vc-filter-input">
            </div>

            <div class="vc-filter-actions">
                <button type="submit" class="vc-btn-apply">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    تطبيق
                </button>
                <a href="{{ route('video_creator.videos.index') }}" class="vc-btn-reset">إعادة تعيين</a>
            </div>
        </form>

        {{-- ── GRID HEADER ── --}}
        <div class="vc-grid-header">
            <div style="display:flex;align-items:center;">
                <span class="vc-grid-title">النتائج</span>
                <span class="vc-grid-count">{{ $videos->total() }} فيديو</span>
            </div>
            <select class="vc-sort-select" name="sort" onchange="this.form && this.form.submit()">
                <option>الأحدث أولاً</option>
                <option>الأكثر مشاهدة</option>
                <option>الأكثر تعليقاً</option>
            </select>
        </div>

        {{-- ── VIDEOS GRID / EMPTY STATE ── --}}
        @if($videos->isEmpty())
            <div class="vc-empty">
                <div class="vc-empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="vc-empty-title">لا توجد فيديوهات</h3>
                <p class="vc-empty-sub">لم تقم بإنتاج أي فيديو بعد</p>
                <a href="{{ route('video_creator.production_requests.index') }}" class="vc-btn-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    عرض طلبات الإنتاج
                </a>
            </div>
        @else
            <div class="vc-videos-grid">
                @foreach($videos as $video)
                    @php
                        $statusMap = [
                            'approved'          => ['cls' => 'vc-badge-green',  'label' => 'منشور'],
                            'submitted'         => ['cls' => 'vc-badge-yellow', 'label' => 'قيد المراجعة'],
                            'revision_required' => ['cls' => 'vc-badge-orange', 'label' => 'يحتاج تعديل'],
                            'rejected'          => ['cls' => 'vc-badge-red',    'label' => 'مرفوض'],
                        ];
                        $status = $video->productionRequest?->status ?? '';
                        $badge  = $statusMap[$status] ?? ['cls' => 'vc-badge-yellow', 'label' => $status];

                        $commentCount = \App\Models\Comment::where('commentable_id', $video->id)
                            ->where('commentable_type', 'App\\Models\\Video')
                            ->count();

                        $researcher = $video->productionRequest?->researcher;
                        $initials   = $researcher
                            ? mb_substr($researcher->name, 0, 1, 'UTF-8')
                            : '؟';

                        $avatarColors = ['#534AB7','#0F6E56','#C23A0F','#185FA5','#854F0B','#993556','#3B6D11'];
                        $avatarBg = $avatarColors[crc32($researcher?->name ?? '') % count($avatarColors)];
                    @endphp

                    <div class="vc-card">
                        {{-- Thumbnail --}}
                        <div class="vc-thumb">
                            @if($video->thumbnail)
                                <img src="{{ asset('storage/' . $video->thumbnail) }}"
                                     alt="{{ $video->title }}"
                                     class="vc-thumb-img">
                            @else
                                <div class="vc-thumb-placeholder">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <a href="{{ route('video_creator.videos.show', $video) }}" class="vc-thumb-overlay">
                                <div class="vc-play-btn">
                                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </a>
                            @if($video->duration)
                                <span class="vc-duration">
                                    {{ floor($video->duration / 60) }}:{{ str_pad($video->duration % 60, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="vc-card-body">
                            @if($researcher)
                                <div class="vc-card-meta">
                                    <div class="vc-avatar" style="background:{{ $avatarBg }}">{{ $initials }}</div>
                                    <span class="vc-researcher-name">{{ $researcher->name }}</span>
                                </div>
                            @endif

                            <div class="vc-card-title" title="{{ $video->title }}">{{ $video->title }}</div>

                            <div class="vc-card-divider"></div>

                            <div class="vc-card-footer">
                                <div class="vc-card-stats">
                                    <span class="vc-stat-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ number_format($video->views ?? 0) }}
                                    </span>
                                    <span class="vc-stat-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        {{ $commentCount }}
                                    </span>
                                    <span class="vc-stat-item" style="font-size:11px;">
                                        {{ $video->created_at->format('Y/m/d') }}
                                    </span>
                                </div>
                                @if($video->productionRequest)
                                    <span class="vc-badge {{ $badge['cls'] }}">{{ $badge['label'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ── PAGINATION ── --}}
            <div class="vc-pagination">
                {{-- Previous --}}
                @if($videos->onFirstPage())
                    <span class="vc-page-btn" style="opacity:.35;pointer-events:none;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @else
                    <a href="{{ $videos->previousPageUrl() }}" class="vc-page-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach($videos->getUrlRange(1, $videos->lastPage()) as $page => $url)
                    @if($page == $videos->currentPage())
                        <span class="vc-page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="vc-page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($videos->hasMorePages())
                    <a href="{{ $videos->nextPageUrl() }}" class="vc-page-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @else
                    <span class="vc-page-btn" style="opacity:.35;pointer-events:none;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                @endif
            </div>
        @endif

    </div>{{-- /vc-main --}}
</div>{{-- /vc-page --}}
@endsection