{{-- resources/views/rules/content_blocks_show.blade.php --}}
@extends('layouts.reseacher_dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 py-8" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- MathJax -->
        <script>
            window.MathJax = {
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']],
                    displayMath: [['$$', '$$'], ['\\[', '\\]']],
                    processEscapes: true
                },
                svg: { fontCache: 'global' }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>

        <!-- ═══ HEADER ═══ -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <!-- Top accent line -->
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-emerald-400 via-teal-500 to-emerald-400"></div>

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mt-1">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-md flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest mb-0.5">محتوى القاعدة</p>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">{{ $rule->title }}</h1>
                            @if($rule->description)
                                <p class="text-gray-500 text-sm mt-1">{{ $rule->description }}</p>
                            @else
                                <p class="text-gray-400 text-sm mt-1">عرض محتوى القاعدة</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0">
                        <a href="{{ route('rules.content.create', $rule->id) }}"
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl shadow-md shadow-emerald-100 hover:shadow-lg hover:shadow-emerald-200 transition-all duration-200 font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة محتوى جديد
                        </a>
                        <a href="{{ route('rules.index') }}"
                           class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-600 hover:text-gray-800 px-5 py-2.5 rounded-xl transition-all duration-200 font-medium text-sm shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ LESSON INFO ═══ -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 via-indigo-50/60 to-blue-50 border-b border-blue-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider">الدرس المرتبط</p>
                        <p class="font-bold text-gray-800 mt-0.5">{{ $rule->lesson->title ?? 'غير محدد' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ STATS ═══ -->
        @if(!$rule->content_blocks->isEmpty())
        @php
            $textCount     = $rule->content_blocks->where('type', 'text')->count();
            $mathCount     = $rule->content_blocks->where('type', 'math')->count();
            $imageCount    = $rule->content_blocks->where('type', 'image')->count();
            $videoCount    = $rule->content_blocks->where('type', 'video')->count();
            $exerciseCount = $rule->content_blocks->where('type', 'exercise')->count();
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-1">الإجمالي</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $rule->content_blocks->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                </div>
            </div>

            @if($textCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:border-blue-100 p-4 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-1">نصوص</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $textCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-lg">📝</div>
                </div>
            </div>
            @endif

            @if($mathCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:border-purple-100 p-4 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-1">معادلات</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $mathCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-lg">📐</div>
                </div>
            </div>
            @endif

            @if($imageCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:border-green-100 p-4 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-1">صور</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $imageCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-lg">🖼️</div>
                </div>
            </div>
            @endif

            @if($exerciseCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:border-orange-100 p-4 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-1">تمارين</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $exerciseCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-lg">✏️</div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- ═══ CONTENT BLOCKS ═══ -->
        @if($rule->content_blocks->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-dashed border-gray-200 p-16 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">لا يوجد محتوى</h3>
                <p class="text-gray-400 mb-7">لم يتم إضافة أي محتوى لهذه القاعدة بعد</p>
                <a href="{{ route('rules.content.create', $rule->id) }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-7 py-3 rounded-xl shadow-md shadow-emerald-100 transition-all duration-200 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة أول محتوى
                </a>
            </div>

        @else
            <div class="space-y-5">
                @foreach($rule->content_blocks as $index => $block)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:border-gray-200 transition-all duration-300 hover:-translate-y-0.5">

                    <!-- Block Header -->
                    <div class="px-5 py-3.5 bg-gradient-to-r from-gray-50/80 to-white border-b border-gray-100 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-900 text-white rounded-lg flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full font-medium">
                                ترتيب {{ $block->block_order + 1 }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full flex items-center gap-1.5
                                @if($block->type == 'text')      bg-blue-50   text-blue-600   ring-1 ring-blue-100
                                @elseif($block->type == 'math')  bg-purple-50 text-purple-600 ring-1 ring-purple-100
                                @elseif($block->type == 'image') bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100
                                @else                            bg-orange-50 text-orange-600 ring-1 ring-orange-100
                                @endif">
                                @if($block->type == 'text')     <span>📝</span> نص
                                @elseif($block->type == 'math') <span>📐</span> معادلة
                                @elseif($block->type == 'image') <span>🖼️</span> صورة
                                @else                            <span>✏️</span> تمرين
                                @endif
                            </span>
                            <span class="text-xs text-gray-300 hidden sm:inline">{{ $block->created_at->format('Y-m-d') }}</span>
                        </div>

                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <a href="{{ route('rules.content.edit', [$rule->id, $block->id]) }}"
                               class="p-2 bg-white hover:bg-blue-50 text-gray-400 hover:text-blue-600 rounded-lg border border-gray-100 hover:border-blue-200 transition-all duration-200"
                               title="تعديل">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('rules.content.destroy', [$rule->id, $block->id]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('هل أنت متأكد من حذف هذا المحتوى؟');"
                                        class="p-2 bg-white hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-lg border border-gray-100 hover:border-red-200 transition-all duration-200"
                                        title="حذف">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Block Content -->
                    <div class="p-6 lg:p-8">
                        @if($block->type == 'math')
                            <div class="bg-gradient-to-br from-gray-950 to-gray-900 rounded-xl p-8 overflow-x-auto border border-gray-800 shadow-inner">
                                <div class="text-center text-emerald-400 text-xl font-mono math-equation" dir="ltr">
                                    {!! $block->content !!}
                                </div>
                            </div>

                        @elseif($block->type == 'image')
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                                <img src="{{ asset('storage/' . $block->content) }}"
                                     alt="صورة"
                                     class="rounded-xl max-h-72 mx-auto object-contain shadow-sm block">
                                <p class="text-center text-xs text-gray-400 mt-4 font-mono bg-white py-1.5 px-4 rounded-full border border-gray-100" style="display:table;margin:1rem auto 0;">
                                    {{ basename($block->content) }}
                                </p>
                            </div>

                        @elseif($block->type == 'exercise')
                            <div class="bg-gradient-to-br from-orange-50 to-amber-50/60 rounded-xl p-6 border border-orange-100 border-r-4 border-r-orange-400">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <span class="text-base">✏️</span>
                                    </div>
                                    <span class="font-bold text-orange-700 text-sm">تمرين</span>
                                </div>
                                <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base">
                                    {{ $block->content }}
                                </div>
                            </div>

                        @elseif($block->type == 'text')
                            <div class="prose prose-gray max-w-none">
                                <div class="text-gray-700 leading-relaxed whitespace-pre-line text-5xl" style="font-family:'Tajawal',sans-serif; line-height:1.9;">
                                    {{ $block->content }}
                                </div>
                            </div>
                           @if($block->video)
<div class="mt-6 rounded-2xl overflow-hidden bg-gray-950 shadow-xl shadow-black/20 border border-gray-800/60" x-data="{
    playing: false,
    progress: 0,
    currentTime: '0:00',
    duration: '0:00',
    volume: 1,
    muted: false,
    fullscreen: false,
    showControls: true,
    controlsTimer: null,
    formatTime(s) {
        if (isNaN(s)) return '0:00';
        const m = Math.floor(s / 60);
        const sec = Math.floor(s % 60);
        return m + ':' + (sec < 10 ? '0' : '') + sec;
    },
    initVideo() {
        const v = this.$refs.video;
        v.addEventListener('loadedmetadata', () => { this.duration = this.formatTime(v.duration); });
        v.addEventListener('timeupdate', () => {
            this.progress = (v.currentTime / v.duration) * 100 || 0;
            this.currentTime = this.formatTime(v.currentTime);
        });
        v.addEventListener('ended', () => { this.playing = false; });
    },
    togglePlay() {
        const v = this.$refs.video;
        if (v.paused) { v.play(); this.playing = true; }
        else { v.pause(); this.playing = false; }
    },
    seek(e) {
        const v = this.$refs.video;
        const rect = e.currentTarget.getBoundingClientRect();
        const pct = (e.clientX - rect.left) / rect.width;
        v.currentTime = pct * v.duration;
    },
    setVolume(e) {
        const v = this.$refs.video;
        v.volume = e.target.value;
        this.volume = e.target.value;
        this.muted = v.volume === 0;
    },
    toggleMute() {
        const v = this.$refs.video;
        v.muted = !v.muted;
        this.muted = v.muted;
    },
    toggleFullscreen() {
        const el = this.$refs.wrapper;
        if (!document.fullscreenElement) { el.requestFullscreen(); this.fullscreen = true; }
        else { document.exitFullscreen(); this.fullscreen = false; }
    },
    resetTimer() {
        clearTimeout(this.controlsTimer);
        this.showControls = true;
        this.controlsTimer = setTimeout(() => { if (this.playing) this.showControls = false; }, 2500);
    }
}" x-init="initVideo()" x-ref="wrapper">

    <!-- ── Video Element ── -->
    <div class="relative bg-black group cursor-pointer"
         @click="togglePlay(); resetTimer();"
         @mousemove="resetTimer()"
         @mouseleave="if(playing) showControls = false">

        <video x-ref="video"
               class="w-full block max-h-[480px] object-contain bg-black"
               preload="metadata">
            <source src="{{ asset('storage/' . $block->video->file_path) }}" type="video/mp4">
            متصفحك لا يدعم تشغيل الفيديو
        </video>

        <!-- Big play button overlay (shown when paused) -->
        <div x-show="!playing"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="w-20 h-20 rounded-full bg-black/50 backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-2xl">
                <svg class="w-9 h-9 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
        </div>

        <!-- Controls Bar -->
        <div x-show="showControls || !playing"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent pt-10 pb-3 px-4"
             @click.stop>

            <!-- Progress Bar -->
            <div class="relative h-1 bg-white/20 rounded-full mb-3 cursor-pointer group/bar"
                 @click="seek($event)">
                <!-- Buffered (decorative) -->
                <div class="absolute inset-y-0 left-0 bg-white/30 rounded-full" :style="`width: ${progress * 0.9}%`"></div>
                <!-- Played -->
                <div class="absolute inset-y-0 left-0 bg-teal-400 rounded-full transition-all duration-100"
                     :style="`width: ${progress}%`"></div>
                <!-- Thumb -->
                <div class="absolute top-1/2 -translate-y-1/2 w-3.5 h-3.5 bg-teal-400 rounded-full shadow-md opacity-0 group-hover/bar:opacity-100 transition-opacity -translate-x-1/2"
                     :style="`left: ${progress}%`"></div>
                <!-- Hover expand -->
                <div class="absolute inset-0 -top-1 -bottom-1 rounded-full group-hover/bar:bg-transparent"></div>
            </div>

            <!-- Controls Row -->
            <div class="flex items-center justify-between gap-3">
                <!-- Left: Play + Volume + Time -->
                <div class="flex items-center gap-3">
                    <!-- Play/Pause -->
                    <button @click="togglePlay()" class="text-white hover:text-teal-400 transition-colors p-1">
                        <svg x-show="!playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                    </button>

                    <!-- Volume -->
                    <div class="flex items-center gap-2">
                        <button @click="toggleMute()" class="text-white/70 hover:text-white transition-colors p-1">
                            <svg x-show="!muted && volume > 0" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                            </svg>
                            <svg x-show="muted || volume == 0" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
                            </svg>
                        </button>
                        <input type="range" min="0" max="1" step="0.05"
                               :value="muted ? 0 : volume"
                               @input="setVolume($event)"
                               class="w-16 h-1 accent-teal-400 cursor-pointer">
                    </div>

                    <!-- Time -->
                    <span class="text-white/60 text-xs font-mono tabular-nums">
                        <span x-text="currentTime"></span> / <span x-text="duration"></span>
                    </span>
                </div>

                <!-- Right: Fullscreen -->
                <button @click="toggleFullscreen()" class="text-white/70 hover:text-white transition-colors p-1">
                    <svg x-show="!fullscreen" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                    </svg>
                    <svg x-show="fullscreen" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ── Info Panel (Khan Academy style) ── -->
    <div class="bg-gray-950 border-t border-white/5 px-5 py-4">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-3 min-w-0">
                <!-- Teal play icon badge -->
                <div class="w-9 h-9 rounded-lg bg-teal-500/15 border border-teal-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-teal-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    @if($block->video->title)
                        <p class="text-white font-semibold text-sm leading-snug truncate" style="font-family:'Tajawal',sans-serif;">
                            {{ $block->video->title }}
                        </p>
                    @endif
                    <p class="text-gray-500 text-xs mt-1" style="font-family:'Tajawal',sans-serif;">فيديو تعليمي · مرتبط بهذا المحتوى</p>
                </div>
            </div>
            <!-- Duration chip -->
            <div class="flex-shrink-0 bg-white/5 border border-white/10 rounded-lg px-2.5 py-1.5 flex items-center gap-1.5">
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-text="duration" class="text-gray-300 text-xs font-mono tabular-nums"></span>
            </div>
        </div>
    </div>
</div>
@endif
                        @endif
                    </div>

                    <!-- Block Footer -->
                    <div class="px-5 py-2.5 bg-gray-50/60 border-t border-gray-100 flex items-center justify-between flex-wrap gap-2 text-xs text-gray-400">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            تاريخ الإضافة: {{ $block->created_at->format('Y-m-d H:i') }}
                        </div>
                        @if($block->updated_at != $block->created_at)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            آخر تحديث: {{ $block->updated_at->format('Y-m-d H:i') }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Mobile FAB -->
            <div class="fixed bottom-6 left-6 lg:hidden z-50">
                <a href="{{ route('rules.content.create', $rule->id) }}"
                   class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg shadow-emerald-200 flex items-center justify-center text-white hover:scale-105 active:scale-95 transition-transform duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Audio Toast -->
<div id="audioStatus" class="fixed bottom-6 right-6 hidden z-50">
    <div class="bg-gradient-to-r from-violet-600 to-indigo-600 text-white px-5 py-3.5 rounded-2xl shadow-xl shadow-violet-200/50 flex items-center gap-3">
        <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
            </svg>
        </div>
        <span class="font-medium text-sm">جاري قراءة المعادلة...</span>
        <button onclick="stopReading()" class="mr-2 hover:bg-white/20 w-7 h-7 rounded-lg flex items-center justify-center transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script>
    let speechSynthesis = window.speechSynthesis;
    let currentUtterance = null;
    const audioStatus = document.getElementById('audioStatus');

    function readEquation(equation) {
        if (speechSynthesis.speaking) speechSynthesis.cancel();
        audioStatus.classList.remove('hidden');
        let cleanEquation = equation
            .replace(/\$\$/g, '').replace(/\$/g, '').replace(/\\/g, '').replace(/\{|\}/g, '')
            .replace(/\\frac/g, ' كسر ').replace(/_/g, ' تحت ').replace(/\^/g, ' أس ')
            .replace(/\\sqrt/g, ' جذر ').replace(/\\int/g, ' تكامل ').replace(/\\sum/g, ' مجموع ')
            .replace(/\\lim/g, ' نهاية ').replace(/\\alpha/g, ' ألفا ').replace(/\\beta/g, ' بيتا ')
            .replace(/\\gamma/g, ' جاما ').replace(/\\pi/g, ' باي ').replace(/\\sin/g, ' جا ')
            .replace(/\\cos/g, ' جتا ').replace(/\\tan/g, ' ظا ').replace(/\\log/g, ' لوغاريتم ')
            .replace(/\\ln/g, ' لوغاريتم طبيعي ').replace(/\\pm/g, ' موجب أو سالب ')
            .replace(/\\times/g, ' في ').replace(/\\div/g, ' على ')
            .replace(/\\leq/g, ' أصغر من أو يساوي ').replace(/\\geq/g, ' أكبر من أو يساوي ')
            .replace(/\\neq/g, ' لا يساوي ').replace(/\\approx/g, ' تقريباً ')
            .replace(/\\infty/g, ' مالانهاية ');
        currentUtterance = new SpeechSynthesisUtterance(cleanEquation);
        currentUtterance.lang = 'ar-SA';
        currentUtterance.rate = 0.9;
        currentUtterance.pitch = 1;
        currentUtterance.onend  = () => audioStatus.classList.add('hidden');
        currentUtterance.onerror = () => audioStatus.classList.add('hidden');
        speechSynthesis.speak(currentUtterance);
    }

    function stopReading() {
        if (speechSynthesis.speaking) {
            speechSynthesis.cancel();
            audioStatus.classList.add('hidden');
        }
    }

    window.addEventListener('beforeunload', () => {
        if (speechSynthesis.speaking) speechSynthesis.cancel();
    });

    document.addEventListener('DOMContentLoaded', () => {
        if (window.MathJax) {
            MathJax.typesetPromise().catch(err => console.log('MathJax error:', err));
        }
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

    body { font-family: 'Tajawal', sans-serif; }

    .math-equation mjx-container {
        color: #34d399 !important;
        font-size: 1.3rem !important;
    }

    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
    .animate-pulse { animation: pulse 2s ease-in-out infinite; }
</style>

@endsection