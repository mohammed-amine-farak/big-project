{{-- resources/views/rules/content_blocks_show.blade.php --}}
@extends('layouts.reseacher_dashboard')

@section('content')

<script>
window.MathJax = {
    tex: {
        inlineMath: [['$','$'],['\\(','\\)']],
        displayMath: [['$$','$$'],['\\[','\\]']],
        processEscapes: true
    },
    svg: { fontCache: 'global' }
};
</script>
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
:root {
    --bg:       #f0f2f8;
    --surface:  #ffffff;
    --s2:       #f7f8fc;
    --border:   #e4e8f4;
    --border2:  #d0d6ec;
    --text:     #111827;
    --mid:      #4b5675;
    --dim:      #8c94b0;
    --blue:     #2563eb;
    --blue-l:   #eff4ff;
    --blue-m:   #6591f5;
    --green:    #059669;
    --green-l:  #ecfdf5;
    --teal:     #0d9488;
    --teal-l:   #f0fdfa;
    --purple:   #7c3aed;
    --purple-l: #f5f3ff;
    --orange:   #ea580c;
    --orange-l: #fff7ed;
    --red:      #dc2626;
    --red-l:    #fef2f2;
    --gold:     #d97706;
    --gold-l:   #fffbeb;
}
* { margin:0; padding:0; box-sizing:border-box; }
body { background:var(--bg); font-family:'Tajawal',sans-serif; color:var(--text); }

/* ── LAYOUT ── */
.page-wrap { max-width:1100px; margin:0 auto; padding:32px 24px 80px; }

/* ── BREADCRUMB ── */
.breadcrumb {
    display:flex; align-items:center; gap:6px;
    font-size:13px; color:var(--dim); margin-bottom:24px;
}
.breadcrumb a { color:var(--dim); text-decoration:none; transition:color .15s; }
.breadcrumb a:hover { color:var(--blue); }
.breadcrumb .sep { color:var(--border2); }
.breadcrumb .cur { color:var(--text); font-weight:600; }

/* ── HEADER CARD ── */
.header-card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:20px;
    padding:28px 32px;
    margin-bottom:20px;
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
    position:relative;
    overflow:hidden;
}
.header-card::before {
    content:'';
    position:absolute; top:0; right:0; left:0; height:3px;
    background:linear-gradient(90deg, var(--teal), var(--blue), var(--purple));
}
.hc-left { display:flex; align-items:flex-start; gap:16px; }
.hc-icon {
    width:52px; height:52px; border-radius:14px; flex-shrink:0;
    background:linear-gradient(135deg, var(--teal), var(--blue));
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 4px 16px rgba(13,148,136,.25);
}
.hc-label { font-size:11px; font-weight:700; letter-spacing:2px; color:var(--teal); text-transform:uppercase; margin-bottom:5px; }
.hc-title { font-family:'Cairo',sans-serif; font-size:22px; font-weight:900; color:var(--text); line-height:1.3; margin-bottom:4px; }
.hc-desc { font-size:14px; color:var(--dim); }
.hc-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }

/* ── BUTTONS ── */
.btn {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 18px; border-radius:10px; border:none; cursor:pointer;
    font-family:'Tajawal',sans-serif; font-size:13px; font-weight:700; transition:all .15s;
    text-decoration:none;
}
.btn-teal {
    background:linear-gradient(135deg, var(--teal), #0f766e);
    color:#fff; box-shadow:0 3px 14px rgba(13,148,136,.25);
}
.btn-teal:hover { box-shadow:0 6px 20px rgba(13,148,136,.35); transform:translateY(-1px); }
.btn-ghost {
    background:var(--surface); color:var(--mid);
    border:1px solid var(--border);
}
.btn-ghost:hover { border-color:var(--blue-m); color:var(--blue); }

/* ── LESSON CHIP ── */
.lesson-chip {
    background:var(--blue-l); border:1px solid #c7d7fd;
    border-radius:12px; padding:12px 18px;
    display:flex; align-items:center; gap:12px;
    margin-bottom:20px;
}
.lc-icon {
    width:36px; height:36px; background:#fff; border:1px solid #c7d7fd;
    border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.lc-label { font-size:10px; font-weight:700; letter-spacing:1.5px; color:var(--blue); text-transform:uppercase; margin-bottom:2px; }
.lc-name { font-size:14px; font-weight:700; color:var(--text); }

/* ── STATS ROW ── */
.stats-row { display:flex; gap:12px; margin-bottom:24px; flex-wrap:wrap; }
.stat-pill {
    background:var(--surface); border:1px solid var(--border);
    border-radius:12px; padding:12px 16px;
    display:flex; align-items:center; gap:10px;
    flex:1; min-width:110px;
}
.sp-icon {
    width:36px; height:36px; border-radius:9px;
    display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;
}
.sp-val { font-family:'Cairo',sans-serif; font-size:20px; font-weight:900; color:var(--text); }
.sp-lbl { font-size:11px; color:var(--dim); }

/* ── EMPTY STATE ── */
.empty-state {
    background:var(--surface); border:2px dashed var(--border);
    border-radius:20px; padding:64px 32px; text-align:center;
}
.empty-icon {
    width:72px; height:72px; background:var(--s2); border-radius:18px;
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 20px; font-size:32px;
}
.empty-title { font-family:'Cairo',sans-serif; font-size:20px; font-weight:700; color:var(--text); margin-bottom:8px; }
.empty-sub { font-size:14px; color:var(--dim); margin-bottom:28px; }

/* ── BLOCK CARD ── */
.block-card {
    background:var(--surface); border:1px solid var(--border);
    border-radius:18px; overflow:hidden;
    margin-bottom:16px;
    transition:all .2s;
}
.block-card:hover {
    border-color:var(--border2);
    box-shadow:0 4px 24px rgba(37,99,235,.07);
    transform:translateY(-1px);
}

/* ── BLOCK TOP BAR ── */
.block-topbar {
    padding:12px 18px;
    background:var(--s2);
    border-bottom:1px solid var(--border);
    display:flex; align-items:center; justify-content:space-between; gap:12px;
}
.bt-left { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.bt-num {
    width:30px; height:30px; border-radius:8px;
    background:linear-gradient(135deg,#334155,#1e293b);
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:700; color:#fff; flex-shrink:0;
}
.bt-order {
    font-size:11px; color:var(--dim); background:var(--border);
    padding:3px 9px; border-radius:6px; font-weight:600;
}
.type-badge {
    display:inline-flex; align-items:center; gap:5px;
    font-size:11px; font-weight:700; padding:4px 10px; border-radius:7px;
}
.type-text    { background:var(--blue-l);   color:var(--blue);   border:1px solid #c7d7fd; }
.type-math    { background:var(--purple-l); color:var(--purple); border:1px solid #ddd6fe; }
.type-image   { background:var(--green-l);  color:var(--green);  border:1px solid #a7f3d0; }
.type-exercise{ background:var(--orange-l); color:var(--orange); border:1px solid #fed7aa; }
.bt-date { font-size:11px; color:var(--dim); }

.bt-actions { display:flex; align-items:center; gap:6px; }
.act-btn {
    width:32px; height:32px; border-radius:8px;
    background:var(--surface); border:1px solid var(--border);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all .15s; color:var(--dim);
}
.act-btn:hover.edit  { background:var(--blue-l);  border-color:#c7d7fd; color:var(--blue); }
.act-btn:hover.del   { background:var(--red-l);   border-color:#fecaca; color:var(--red); }

/* ── BLOCK BODY ── */
.block-body { padding:24px 28px; }

/* TEXT */
.cb-text {
    font-size:16px; color:var(--mid); line-height:2;
    font-family:'Tajawal',sans-serif;
}

/* MATH */
.cb-math-wrap {
    background:linear-gradient(135deg,#0f172a,#1e293b);
    border-radius:14px; padding:28px 24px; text-align:center;
    border:1px solid rgba(255,255,255,.07);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.05), 0 4px 24px rgba(0,0,0,.15);
    position:relative; overflow:hidden;
}
.cb-math-wrap::before {
    content:'';
    position:absolute; top:-40px; right:-40px;
    width:140px; height:140px; border-radius:50%;
    background:radial-gradient(circle, rgba(45,212,191,.08), transparent 70%);
}
.cb-math-content {
    color:#2dd4bf; font-size:1.4rem; font-family:monospace;
    position:relative; z-index:1;
}
.math-toolbar {
    display:flex; justify-content:flex-end; margin-top:16px; position:relative; z-index:1;
}
.math-speak-btn {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(45,212,191,.12); border:1px solid rgba(45,212,191,.2);
    color:#2dd4bf; padding:6px 12px; border-radius:8px;
    font-size:12px; font-weight:600; cursor:pointer; transition:all .15s;
    font-family:'Tajawal',sans-serif;
}
.math-speak-btn:hover { background:rgba(45,212,191,.2); }

/* IMAGE */
.cb-image-wrap {
    background:var(--s2); border:1px solid var(--border);
    border-radius:12px; padding:20px; text-align:center;
}
.cb-image-wrap img {
    border-radius:10px; max-height:280px; object-fit:contain;
    display:block; margin:0 auto; box-shadow:0 4px 20px rgba(0,0,0,.08);
}
.cb-filename {
    display:inline-flex; align-items:center; gap:5px;
    margin-top:12px; font-size:11px; color:var(--dim);
    background:var(--surface); border:1px solid var(--border);
    padding:4px 10px; border-radius:6px; font-family:monospace;
}

/* EXERCISE */
.cb-exercise-wrap {
    background:linear-gradient(135deg, #fff7ed, #fffbeb);
    border:1px solid #fed7aa;
    border-right:4px solid var(--orange);
    border-radius:0 12px 12px 0;
    padding:20px 22px;
}
.ex-header { display:flex; align-items:center; gap:8px; margin-bottom:12px; }
.ex-icon-badge {
    width:32px; height:32px; background:#fff;
    border:1px solid #fed7aa; border-radius:8px;
    display:flex; align-items:center; justify-content:center; font-size:15px;
}
.ex-label-text { font-size:13px; font-weight:700; color:var(--orange); }
.ex-content { font-size:15px; color:var(--text); line-height:1.85; white-space:pre-line; }

/* VIDEO */
.video-wrapper {
    margin-top:20px; border-radius:16px; overflow:hidden;
    background:#000; box-shadow:0 8px 32px rgba(0,0,0,.2);
    border:1px solid rgba(255,255,255,.06);
}
.video-info-bar {
    background:#0f172a; border-top:1px solid rgba(255,255,255,.05);
    padding:14px 18px; display:flex; align-items:center; justify-content:space-between; gap:12px;
}
.vib-left { display:flex; align-items:center; gap:10px; }
.vib-badge {
    width:36px; height:36px; border-radius:9px;
    background:rgba(45,212,191,.12); border:1px solid rgba(45,212,191,.2);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.vib-title { font-size:13px; font-weight:600; color:#fff; font-family:'Tajawal',sans-serif; }
.vib-sub   { font-size:11px; color:#64748b; margin-top:1px; }
.vib-dur {
    background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08);
    padding:5px 10px; border-radius:7px;
    display:flex; align-items:center; gap:5px;
    font-size:11px; color:#94a3b8; font-family:monospace; flex-shrink:0;
}

/* BLOCK FOOTER */
.block-footer {
    padding:10px 18px;
    background:var(--s2); border-top:1px solid var(--border);
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:8px;
    font-size:11px; color:var(--dim);
}
.bf-item { display:flex; align-items:center; gap:5px; }

/* FAB */
.fab {
    position:fixed; bottom:28px; left:28px; z-index:50;
    width:52px; height:52px;
    background:linear-gradient(135deg, var(--teal), #0f766e);
    border-radius:14px; display:none; align-items:center; justify-content:center;
    box-shadow:0 6px 20px rgba(13,148,136,.35);
    text-decoration:none; color:#fff;
    transition:all .2s;
}
.fab:hover { transform:translateY(-2px) scale(1.05); }
@media(max-width:1024px){ .fab{ display:flex; } }

/* TOAST */
.speech-toast {
    position:fixed; bottom:28px; right:28px; z-index:100;
    background:linear-gradient(135deg,#6d28d9,#4f46e5);
    color:#fff; padding:12px 18px; border-radius:14px;
    display:none; align-items:center; gap:10px;
    box-shadow:0 8px 28px rgba(109,40,217,.3);
    font-size:13px; font-weight:600; font-family:'Tajawal',sans-serif;
}
.speech-toast.visible { display:flex; }
.toast-pulse { width:8px; height:8px; border-radius:50%; background:#a78bfa; animation:pulse 1.2s ease-in-out infinite; }
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.8)} }
.toast-close {
    width:26px; height:26px; border-radius:7px; background:rgba(255,255,255,.15);
    border:none; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;
    margin-right:4px;
}
</style>

<div class="page-wrap" dir="rtl">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="{{ route('rules.index') }}">القواعد</a>
        <span class="sep">›</span>
        <span class="cur">{{ $rule->title }}</span>
    </div>

    {{-- HEADER --}}
    <div class="header-card">
        <div class="hc-left">
            <div class="hc-icon">
                <svg width="26" height="26" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </div>
            <div>
                <div class="hc-label">محتوى القاعدة</div>
                <h1 class="hc-title">{{ $rule->title }}</h1>
                <p class="hc-desc">{{ $rule->description ?? 'عرض محتوى القاعدة' }}</p>
            </div>
        </div>
        <div class="hc-actions">
            <a href="{{ route('rules.content.create', $rule->id) }}" class="btn btn-teal">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة محتوى
            </a>
            <a href="{{ route('rules.index') }}" class="btn btn-ghost">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
        </div>
    </div>

    {{-- LESSON CHIP --}}
    <div class="lesson-chip">
        <div class="lc-icon">
            <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <div>
            <div class="lc-label">الدرس المرتبط</div>
            <div class="lc-name">{{ $rule->lesson->title ?? 'غير محدد' }}</div>
        </div>
    </div>

    {{-- STATS --}}
    @if(!$rule->content_blocks->isEmpty())
    @php
        $total   = $rule->content_blocks->count();
        $texts   = $rule->content_blocks->where('type','text')->count();
        $maths   = $rule->content_blocks->where('type','math')->count();
        $images  = $rule->content_blocks->where('type','image')->count();
        $exers   = $rule->content_blocks->where('type','exercise')->count();
    @endphp
    <div class="stats-row">
        <div class="stat-pill">
            <div class="sp-icon" style="background:var(--blue-l)">📦</div>
            <div><div class="sp-val">{{ $total }}</div><div class="sp-lbl">الإجمالي</div></div>
        </div>
        @if($texts)
        <div class="stat-pill">
            <div class="sp-icon" style="background:var(--blue-l)">📝</div>
            <div><div class="sp-val">{{ $texts }}</div><div class="sp-lbl">نصوص</div></div>
        </div>
        @endif
        @if($maths)
        <div class="stat-pill">
            <div class="sp-icon" style="background:var(--purple-l)">📐</div>
            <div><div class="sp-val">{{ $maths }}</div><div class="sp-lbl">معادلات</div></div>
        </div>
        @endif
        @if($images)
        <div class="stat-pill">
            <div class="sp-icon" style="background:var(--green-l)">🖼️</div>
            <div><div class="sp-val">{{ $images }}</div><div class="sp-lbl">صور</div></div>
        </div>
        @endif
        @if($exers)
        <div class="stat-pill">
            <div class="sp-icon" style="background:var(--orange-l)">✏️</div>
            <div><div class="sp-val">{{ $exers }}</div><div class="sp-lbl">تمارين</div></div>
        </div>
        @endif
    </div>
    @endif

    {{-- EMPTY --}}
    @if($rule->content_blocks->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <div class="empty-title">لا يوجد محتوى بعد</div>
        <p class="empty-sub">لم يتم إضافة أي محتوى لهذه القاعدة</p>
        <a href="{{ route('rules.content.create', $rule->id) }}" class="btn btn-teal">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة أول محتوى
        </a>
    </div>

    @else
    {{-- BLOCKS --}}
    <div>
        @foreach($rule->content_blocks as $index => $block)
        <div class="block-card">

            {{-- TOP BAR --}}
            <div class="block-topbar">
                <div class="bt-left">
                    <div class="bt-num">{{ $index + 1 }}</div>
                    <div class="bt-order">ترتيب {{ $block->block_order + 1 }}</div>
                    <div class="type-badge
                        @if($block->type=='text')     type-text
                        @elseif($block->type=='math') type-math
                        @elseif($block->type=='image') type-image
                        @else                         type-exercise
                        @endif">
                        @if($block->type=='text')     📝 نص
                        @elseif($block->type=='math') 📐 معادلة
                        @elseif($block->type=='image') 🖼️ صورة
                        @else                         ✏️ تمرين
                        @endif
                    </div>
                    <span class="bt-date">{{ $block->created_at->format('Y-m-d') }}</span>
                </div>
                <div class="bt-actions">
                    <a href="{{ route('rules.content.edit', [$rule->id, $block->id]) }}"
                       class="act-btn edit" title="تعديل">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form action="{{ route('rules.content.destroy', [$rule->id, $block->id]) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('هل أنت متأكد من حذف هذا المحتوى؟');"
                                class="act-btn del" title="حذف">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- BODY --}}
            <div class="block-body">

                @if($block->type == 'math')
                <div class="cb-math-wrap">
                    <div class="cb-math-content math-eq" dir="ltr">{!! $block->content !!}</div>
                    <div class="math-toolbar">
                        <button class="math-speak-btn" onclick="readEquation('{{ addslashes($block->content) }}')">
                            <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
                            </svg>
                            استمع للمعادلة
                        </button>
                    </div>
                </div>

                @elseif($block->type == 'image')
                <div class="cb-image-wrap">
                    <img src="{{ asset('storage/' . $block->content) }}" alt="صورة">
                    <div class="cb-filename">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ basename($block->content) }}
                    </div>
                </div>

                @elseif($block->type == 'exercise')
                <div class="cb-exercise-wrap">
                    <div class="ex-header">
                        <div class="ex-icon-badge">✏️</div>
                        <span class="ex-label-text">تمرين تطبيقي</span>
                    </div>
                    <div class="ex-content">{{ $block->content }}</div>
                </div>

                @elseif($block->type == 'text')
                <div class="cb-text">{{ $block->content }}</div>

                @endif

                {{-- VIDEO --}}
                @if(isset($block->video) && $block->video)
                <div class="video-wrapper" x-data="{
                    playing:false, progress:0, currentTime:'0:00', duration:'0:00',
                    volume:1, muted:false, fullscreen:false, showControls:true, ct:null,
                    fmt(s){ if(isNaN(s))return'0:00'; const m=Math.floor(s/60),sec=Math.floor(s%60); return m+':'+(sec<10?'0':'')+sec; },
                    init(){
                        const v=this.$refs.vid;
                        v.addEventListener('loadedmetadata',()=>this.duration=this.fmt(v.duration));
                        v.addEventListener('timeupdate',()=>{ this.progress=(v.currentTime/v.duration)*100||0; this.currentTime=this.fmt(v.currentTime); });
                        v.addEventListener('ended',()=>this.playing=false);
                    },
                    play(){ const v=this.$refs.vid; v.paused?(v.play(),this.playing=true):(v.pause(),this.playing=false); },
                    seek(e){ const v=this.$refs.vid,r=e.currentTarget.getBoundingClientRect(); v.currentTime=((e.clientX-r.left)/r.width)*v.duration; },
                    vol(e){ const v=this.$refs.vid; v.volume=e.target.value; this.volume=e.target.value; this.muted=v.volume===0; },
                    mute(){ const v=this.$refs.vid; v.muted=!v.muted; this.muted=v.muted; },
                    fs(){ const el=this.$refs.wrap; !document.fullscreenElement?(el.requestFullscreen(),this.fullscreen=true):(document.exitFullscreen(),this.fullscreen=false); },
                    rst(){ clearTimeout(this.ct); this.showControls=true; this.ct=setTimeout(()=>{ if(this.playing)this.showControls=false; },2500); }
                }" x-init="init()" x-ref="wrap">

                    <div class="relative bg-black cursor-pointer select-none"
                         @click="play();rst();" @mousemove="rst()" @mouseleave="if(playing)showControls=false">
                        <video x-ref="vid" class="w-full block" style="max-height:440px;object-fit:contain;background:#000;" preload="metadata">
                            <source src="{{ asset('storage/' . $block->video->file_path) }}" type="video/mp4">
                        </video>
                        {{-- Play overlay --}}
                        <div x-show="!playing" x-transition class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div style="width:72px;height:72px;border-radius:50%;background:rgba(0,0,0,.55);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;">
                                <svg width="30" height="30" fill="white" viewBox="0 0 24 24" style="transform:translateX(2px)">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        {{-- Controls --}}
                        <div x-show="showControls||!playing" x-transition
                             style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(0,0,0,.9),transparent);padding:36px 16px 12px;"
                             @click.stop>
                            {{-- Progress --}}
                            <div style="height:4px;background:rgba(255,255,255,.2);border-radius:2px;margin-bottom:12px;cursor:pointer;position:relative;" @click="seek($event)">
                                <div style="position:absolute;inset-y:0;left:0;background:#2dd4bf;border-radius:2px;transition:width .1s;" :style="`width:${progress}%`"></div>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <button @click="play()" style="background:none;border:none;color:#fff;cursor:pointer;padding:3px;">
                                        <svg x-show="!playing" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        <svg x-show="playing"  width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                    </button>
                                    <button @click="mute()" style="background:none;border:none;color:rgba(255,255,255,.7);cursor:pointer;padding:3px;">
                                        <svg x-show="!muted" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <svg x-show="muted"  width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
                                    </button>
                                    <input type="range" min="0" max="1" step="0.05" :value="muted?0:volume" @input="vol($event)" style="width:60px;accent-color:#2dd4bf;cursor:pointer;">
                                    <span style="font-size:11px;color:rgba(255,255,255,.6);font-family:monospace;" x-text="currentTime+' / '+duration"></span>
                                </div>
                                <button @click="fs()" style="background:none;border:none;color:rgba(255,255,255,.7);cursor:pointer;padding:3px;">
                                    <svg x-show="!fullscreen" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
                                    <svg x-show="fullscreen"  width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="vib-left" style="padding:14px 18px;background:#0f172a;border-top:1px solid rgba(255,255,255,.04);display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="vib-badge">
                                <svg width="16" height="16" fill="#2dd4bf" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                            <div>
                                @if($block->video->title)
                                <div class="vib-title">{{ $block->video->title }}</div>
                                @endif
                                <div class="vib-sub">فيديو تعليمي · مرتبط بهذا المحتوى</div>
                            </div>
                        </div>
                        <div class="vib-dur">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="duration" style="font-family:monospace;font-size:11px;color:#94a3b8;"></span>
                        </div>
                    </div>
                </div>
                @endif

            </div>{{-- end block-body --}}

            {{-- FOOTER --}}
            <div class="block-footer">
                <div class="bf-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    أُضيف: {{ $block->created_at->format('Y-m-d H:i') }}
                </div>
                @if($block->updated_at != $block->created_at)
                <div class="bf-item">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    آخر تحديث: {{ $block->updated_at->format('Y-m-d H:i') }}
                </div>
                @endif
            </div>

        </div>{{-- end block-card --}}
        @endforeach
    </div>
    @endif

</div>

{{-- FAB --}}
<a href="{{ route('rules.content.create', $rule->id) }}" class="fab" title="إضافة محتوى">
    <svg width="22" height="22" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
</a>

{{-- SPEECH TOAST --}}
<div id="speechToast" class="speech-toast">
    <div class="toast-pulse"></div>
    <span>جاري قراءة المعادلة...</span>
    <button class="toast-close" onclick="stopReading()">✕</button>
</div>

<script>
const toast = document.getElementById('speechToast');
let currentUtterance = null;

function readEquation(eq) {
    if (speechSynthesis.speaking) speechSynthesis.cancel();
    toast.classList.add('visible');
    let clean = eq
        .replace(/\$\$/g,'').replace(/\$/g,'').replace(/\\/g,'').replace(/[{}]/g,'')
        .replace(/frac/g,' كسر ').replace(/_/g,' تحت ').replace(/\^/g,' أس ')
        .replace(/sqrt/g,' جذر ').replace(/int/g,' تكامل ').replace(/sum/g,' مجموع ')
        .replace(/pi/g,' باي ').replace(/sin/g,' جا ').replace(/cos/g,' جتا ')
        .replace(/tan/g,' ظا ').replace(/log/g,' لوغاريتم ').replace(/ln/g,' لوغاريتم طبيعي ')
        .replace(/times/g,' في ').replace(/div/g,' على ')
        .replace(/leq/g,' أصغر أو يساوي ').replace(/geq/g,' أكبر أو يساوي ')
        .replace(/neq/g,' لا يساوي ').replace(/approx/g,' تقريباً ').replace(/infty/g,' مالانهاية ');
    currentUtterance = new SpeechSynthesisUtterance(clean);
    currentUtterance.lang = 'ar-SA';
    currentUtterance.rate = 0.9;
    currentUtterance.onend = currentUtterance.onerror = () => toast.classList.remove('visible');
    speechSynthesis.speak(currentUtterance);
}

function stopReading() {
    if (speechSynthesis.speaking) speechSynthesis.cancel();
    toast.classList.remove('visible');
}

window.addEventListener('beforeunload', () => { if(speechSynthesis.speaking) speechSynthesis.cancel(); });

document.addEventListener('DOMContentLoaded', () => {
    if (window.MathJax) MathJax.typesetPromise().catch(e => console.log(e));
});
</script>

@endsection