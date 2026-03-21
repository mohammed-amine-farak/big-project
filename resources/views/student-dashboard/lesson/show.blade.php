@extends('layouts.student_dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @php
            $totalItems = 0;
            if ($lesson->videos && $lesson->videos->isNotEmpty()) $totalItems++;
            $totalItems += $lesson->rules->count();
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- ===================================================== -->
            <!-- الشريط الجانبي الأيسر (3/12) - Modern Udemy Style     -->
            <!-- ===================================================== -->
            <div class="lg:col-span-3">
                <div class="sticky top-24 space-y-6">

                    <!-- بطاقة العودة - Modern -->
                    <div class="rounded-2xl overflow-hidden bg-white/5 backdrop-blur-sm border border-white/10 hover:border-emerald-500/30 transition-all duration-300 group">
                        <a href="{{ route('student.lesson.index') }}"
                           class="flex items-center gap-3 px-5 py-4 hover:bg-white/5 transition-all">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 bg-emerald-500/10">
                                <svg width="20" height="20" fill="none" stroke="#10b981" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-400">العودة إلى</div>
                                <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">قائمة الدروس</div>
                            </div>
                        </a>
                    </div>

                    <!-- بطاقة محتوى الدرس - Modern Course Sidebar -->
                    <div class="rounded-2xl overflow-hidden bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="px-5 py-4 border-b border-white/10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-lg shadow-emerald-500/50"></div>
                                    <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">{{ $lesson->subject->name ?? 'الرياضيات' }}</span>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 font-medium">متوسط</span>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ $lesson->title }}</h3>
                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $totalItems }} محتوى تعليمي</span>
                            </div>
                        </div>

                        <div class="p-3 space-y-1" id="sidebar-links">
                            @if($lesson->videos && $lesson->videos->isNotEmpty())
                                <div class="nav-item cursor-pointer rounded-xl transition-all duration-300 group hover:bg-white/5"
                                     data-target="video-main" data-index="0">
                                    <div class="flex items-center gap-3 px-4 py-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-500/10 group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-white group-hover:text-emerald-400 transition-colors">فيديو الدرس</div>
                                            <div class="text-xs text-slate-400">الدرس الرئيسي</div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @foreach($lesson->rules as $ruleIndex => $rule)
                                <div class="nav-item cursor-pointer rounded-xl transition-all duration-300 group hover:bg-white/5 mt-1"
                                     data-target="rule-{{ $rule->id }}" data-index="{{ $ruleIndex + 1 }}">
                                    <div class="flex items-center gap-3 px-4 py-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold font-mono bg-slate-800 border border-white/10">
                                            <span class="text-emerald-400">{{ str_pad($ruleIndex + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-white group-hover:text-emerald-400 transition-colors">{{ $rule->title }}</div>
                                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                                <span>{{ $rule->content_blocks->count() }} عناصر</span>
                                                @if($rule->content_blocks->where('type','video')->count() > 0)
                                                <span>• 🎥 {{ $rule->content_blocks->where('type','video')->count() }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="px-5 py-4 border-t border-white/10 mt-2">
                            <div class="flex items-center justify-between text-xs text-slate-400">
                                <span>إجمالي العناصر</span>
                                <span class="font-bold text-emerald-400">{{ $totalItems }} عنصر</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- المحتوى الرئيسي (9/12) - Modern Udemy Player Style    -->
            <!-- ===================================================== -->
            <div class="lg:col-span-9" id="content-area">

                <!-- حالة البداية - Modern Welcome Screen -->
                <div id="empty-state" class="content-section block">
                    <div class="rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 p-16 text-center relative overflow-hidden group">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                            <div class="absolute top-0 -right-20 w-64 h-64 rounded-full bg-emerald-500/5 blur-3xl"></div>
                            <div class="absolute bottom-0 -left-20 w-64 h-64 rounded-full bg-emerald-500/3 blur-3xl"></div>
                        </div>
                        <div class="relative z-10">
                            <div class="w-28 h-28 mx-auto mb-6 rounded-3xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-500 bg-emerald-500/10">
                                <svg width="48" height="48" fill="none" stroke="#10b981" viewBox="0 0 24 24" class="animate-pulse">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-3">اختر عنصراً من القائمة</h2>
                            <p class="text-slate-400 text-lg max-w-md mx-auto">اضغط على أي عنصر في الشريط الجانبي لبدء التعلم</p>
                            <div class="flex items-center justify-center gap-8 mt-8 pt-8 border-t border-white/10">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-emerald-400 mb-1">{{ $lesson->rules->count() }}</div>
                                    <div class="text-xs text-slate-400">📚 قواعد</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- فيديو الدرس الرئيسي - Modern Video Player -->
                @if($lesson->videos && $lesson->videos->isNotEmpty())
                @php $mainVideo = $lesson->videos->first(); @endphp
                <div id="video-main" class="content-section hidden rounded-3xl overflow-hidden border border-white/10 mb-6 bg-black/30 backdrop-blur-sm">
                    <div class="relative group/video">
                        <video controls class="w-full aspect-video" style="background: #000;">
                            <source src="{{ asset('storage/' . $mainVideo->file_path) }}" type="video/mp4">
                        </video>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-4 opacity-0 group-hover/video:opacity-100 transition-opacity duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-white">فيديو الدرس الرئيسي</div>
                                        <div class="text-xs text-slate-400">{{ $lesson->title }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('partials.video-comments', ['video' => $mainVideo])
                </div>
                @endif

                <!-- القواعد وكتل المحتوى - Modern Content Blocks -->
                @foreach($lesson->rules as $rule)
                <div id="rule-{{ $rule->id }}" class="content-section hidden rounded-3xl border border-white/10 overflow-hidden mb-6 bg-white/5 backdrop-blur-sm">
                    <div class="relative px-8 py-6 border-b border-white/10 bg-gradient-to-r from-emerald-500/5 to-transparent">
                        <div class="absolute right-0 top-0 bottom-0 w-1 bg-gradient-to-b from-emerald-500 to-transparent"></div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg font-bold font-mono text-emerald-400 border-2 border-emerald-500/30 bg-emerald-500/10">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs px-2 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 font-medium">قاعدة</span>
                                        <span class="text-xs text-slate-400">{{ $rule->content_blocks->count() }} عناصر</span>
                                    </div>
                                    <h2 class="text-xl font-bold text-white">{{ $rule->title }}</h2>
                                    @if($rule->description)
                                    <p class="text-sm text-slate-400 mt-1">{{ $rule->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <button class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all hover:scale-105 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20"
                                    onclick="showSection('rule-{{ $rule->id }}')">
                                بدء التعلم
                            </button>
                        </div>
                    </div>

                    <!-- كتل المحتوى - Modern Styling -->
                    <div class="p-8 space-y-8">
                        @foreach($rule->content_blocks as $block)
                        <div id="block-{{ $block->id }}" class="block-content transform transition-all duration-300 hover:translate-x-1">

                            {{-- نص --}}
                            @if($block->type == 'text')
                            <div class="p-6 rounded-xl border border-white/10 hover:border-emerald-500/30 transition-all bg-white/5">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-400/10">
                                        <svg width="16" height="16" fill="none" stroke="#94a3b8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-slate-400 uppercase">نص تعليمي</span>
                                </div>
                                <p class="text-slate-300 leading-relaxed text-lg">{{ $block->content }}</p>
                            </div>

                            {{-- معادلة --}}
                            @elseif($block->type == 'math')
                            <div class="relative rounded-xl border border-white/10 p-8 text-center overflow-hidden bg-black/30">
                                <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-emerald-500 to-transparent"></div>
                                <div class="flex items-center gap-2 absolute top-4 right-6">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-emerald-500/10">
                                        <svg width="16" height="16" fill="none" stroke="#10b981" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12h15M12 4.5l7.5 7.5-7.5 7.5"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-emerald-400 uppercase">معادلة رياضية</span>
                                </div>
                                <div class="text-center mt-8" dir="ltr">
                                    <div class="math-equation text-2xl text-emerald-400 font-mono">{!! $block->content !!}</div>
                                </div>
                                <button onclick="readEquation('{{ addslashes($block->content) }}')"
                                        class="mt-6 flex items-center gap-2 px-4 py-2 rounded-lg mx-auto text-xs transition-all hover:scale-105 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
                                    </svg>
                                    استمع للمعادلة
                                </button>
                            </div>

                            {{-- صورة --}}
                            @elseif($block->type == 'image')
                            <div class="rounded-xl border border-white/10 overflow-hidden">
                                <div class="px-6 py-4 border-b border-white/10 flex items-center gap-2 bg-white/5">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-500/10">
                                        <svg width="16" height="16" fill="none" stroke="#3b82f6" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-width="2" d="M8 12l4-4 4 4"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-blue-400 uppercase">صورة توضيحية</span>
                                    <span class="text-xs text-slate-400 mr-auto">{{ basename($block->content) }}</span>
                                </div>
                                <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $block->content) }}')">
                                    <img src="{{ asset('storage/' . $block->content) }}" alt="صورة"
                                         class="w-full max-h-96 object-contain transition-transform duration-500 group-hover:scale-105 bg-black/30">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <span class="px-4 py-2 rounded-lg bg-white/10 text-white text-sm backdrop-blur-sm">اضغط للتكبير</span>
                                    </div>
                                </div>
                            </div>

                            {{-- تمرين --}}
                            @elseif($block->type == 'exercise')
                            <div class="relative rounded-xl p-6 overflow-hidden bg-gradient-to-r from-amber-500/5 to-orange-500/3 border border-amber-500/20">
                                <div class="absolute right-0 top-0 bottom-0 w-1 bg-gradient-to-b from-amber-500 to-orange-500"></div>
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-500/10">
                                        <svg width="16" height="16" fill="none" stroke="#fbbf24" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-amber-400 uppercase">تمرين تطبيقي</span>
                                    <span class="text-xs text-slate-400 mr-auto">حاول الحل بنفسك أولاً</span>
                                </div>
                                <p class="text-white text-lg mb-6">{{ $block->content }}</p>
                                <button onclick="toggleSolution({{ $block->id }})"
                                        class="flex items-center gap-2 px-6 py-3 rounded-xl border border-amber-500/30 hover:bg-amber-500/10 text-amber-400 text-sm font-medium transition-all hover:scale-105">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    عرض الحل
                                </button>
                                <div id="solution-{{ $block->id }}" class="hidden mt-6 p-6 rounded-xl text-sm text-slate-300 leading-relaxed bg-emerald-500/5 border border-emerald-500/20">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-emerald-400 bg-emerald-500/10">✓</span>
                                        <span class="text-emerald-400 font-medium">الحل النموذجي</span>
                                    </div>
                                    الحل سيظهر هنا...
                                </div>
                            </div>
                            @endif

                            {{-- فيديو + تعليقات --}}
                            @if(isset($block->video) && $block->video)
                            @php $video = $block->video; @endphp
                            <div class="rounded-xl border border-white/10 overflow-hidden mt-4">
                                <div class="px-6 py-4 border-b border-white/10 flex items-center gap-2 bg-white/5">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-500/10">
                                        <svg width="16" height="16" fill="none" stroke="#f87171" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-rose-400 uppercase">فيديو توضيحي</span>
                                    <span class="text-xs text-slate-400 mr-auto">{{ $video->duration ?? '' }}</span>
                                </div>
                                <div class="relative">
                                    <video controls class="w-full max-h-96 bg-black">
                                        <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                            @include('partials.video-comments', ['video' => $video])
                            @endif

                        </div>
                        @endforeach

                        <!-- أزرار التنقل بين القواعد - Modern Navigation -->
                        <div class="flex items-center justify-between pt-6 border-t border-white/10">
                            @if(!$loop->first)
                            <button onclick="navigateToRule({{ $lesson->rules[$loop->index - 1]->id }})"
                                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl border border-white/10 hover:border-emerald-500/30 text-slate-400 hover:text-emerald-400 transition-all hover:bg-white/5">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                القاعدة السابقة
                            </button>
                            @else<div></div>
                            @endif
                            @if(!$loop->last)
                            <button onclick="navigateToRule({{ $lesson->rules[$loop->index + 1]->id }})"
                                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl border border-white/10 hover:border-emerald-500/30 text-slate-400 hover:text-emerald-400 transition-all hover:bg-white/5">
                                القاعدة التالية
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            @else<div></div>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<!-- مودال الصورة - Modern -->
<div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/95 backdrop-blur-lg">
    <div class="relative max-w-5xl max-h-[90vh] mx-4">
        <img id="modalImage" src="" alt="صورة مكبرة" class="max-w-full max-h-[90vh] object-contain rounded-2xl shadow-2xl">
        <button onclick="closeImageModal()" class="absolute -top-12 left-1/2 -translate-x-1/2 px-6 py-3 rounded-xl text-white text-sm bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 transition-all">
            إغلاق ✕
        </button>
    </div>
</div>

<!-- Toast - Modern -->
<div id="appToast" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 hidden items-center gap-3 px-5 py-3 rounded-xl transition-all bg-slate-800/90 backdrop-blur-sm border border-white/10 text-white shadow-2xl min-w-64">
    <span id="toastIcon" class="text-base">✓</span>
    <span id="toastMsg" class="text-sm font-medium"></span>
</div>

<script>
// =============================================
// المتغيرات العامة
// =============================================
const CSRF       = '{{ csrf_token() }}';
const STORE_URL  = '{{ route("comments.store") }}';
const AUTH_ID    = {{ auth()->id() }};
const AUTH_NAME  = '{{ auth()->user()->name }}';
const AUTH_INITIAL = '{{ substr(auth()->user()->name, 0, 1) }}';

let totalItems = {{ $totalItems }};
let viewedItems = new Set();

// =============================================
// التقدم
// =============================================


function markAsViewed(id) {
    viewedItems.add(id);
   
}

// =============================================
// FIX #1 + #2: Central section-reveal function
// Lazy-loads comments the FIRST time a section is shown.
// Used by sidebar clicks, navigateToRule, and startRule.
// =============================================
function showSection(targetId) {
    const sections  = document.querySelectorAll('.content-section');
    const emptyState = document.getElementById('empty-state');
    const target    = document.getElementById(targetId);

    if (!target) return;

    // Hide all sections
    sections.forEach(s => s.classList.add('hidden'));
    if (emptyState) emptyState.classList.add('hidden');

    // Show the requested section
    target.classList.remove('hidden');
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });

    // Update sidebar active state
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('nav-active'));
    const activeNav = document.querySelector(`[data-target="${targetId}"]`);
    if (activeNav) activeNav.classList.add('nav-active');

    // Mark as viewed
    markAsViewed(targetId);

    // FIX #2: Lazy-load comments — only fetch when section becomes visible,
    // and only once per container (data-loaded flag prevents duplicate fetches).
    target.querySelectorAll('.comments-container').forEach(container => {
        const videoId = container.dataset.videoId;
        if (container.dataset.loaded === 'false') {
            container.dataset.loaded = 'true';
            // Get current sort value from the sibling select
            const sortEl = container.closest('.rounded-2xl')?.querySelector('.comment-sort');
            const sort   = sortEl ? sortEl.value : 'latest';
            loadComments(videoId, sort);
        }
    });
}

// =============================================
// التنقل بين القواعد
// =============================================
function navigateToRule(ruleId) {
    showSection('rule-' + ruleId);
}

function startRule(ruleId) {
    showSection('rule-' + ruleId);
}

// =============================================
// حل التمرين
// =============================================
function toggleSolution(blockId) {
    const solution = document.getElementById('solution-' + blockId);
    if (solution) solution.classList.toggle('hidden');
}

// =============================================
// الصورة
// =============================================
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    document.getElementById('modalImage').src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// =============================================
// قراءة المعادلة
// =============================================
let currentUtterance = null;
const speechToast = document.createElement('div');
speechToast.className = 'fixed bottom-24 right-8 z-50 hidden items-center gap-3 px-4 py-3 rounded-xl';
speechToast.style.cssText = 'background:#19e8a0;color:#07090f;';
speechToast.innerHTML = '<div class="w-2 h-2 rounded-full bg-white animate-pulse"></div><span class="text-sm font-medium">جاري قراءة المعادلة...</span><button onclick="stopReading()" class="mr-3 w-6 h-6 rounded-lg flex items-center justify-center hover:bg-black/10">✕</button>';
document.body.appendChild(speechToast);

function readEquation(eq) {
    if (window.speechSynthesis.speaking) window.speechSynthesis.cancel();
    speechToast.classList.remove('hidden');
    speechToast.classList.add('flex');

    let clean = eq
        .replace(/\$\$/g,'').replace(/\$/g,'').replace(/\\/g,'')
        .replace(/[{}]/g,'').replace(/frac/g,' كسر ')
        .replace(/_/g,' تحت ').replace(/\^/g,' أس ')
        .replace(/sqrt/g,' جذر ').replace(/int/g,' تكامل ')
        .replace(/sum/g,' مجموع ').replace(/pi/g,' باي ')
        .replace(/sin/g,' جا ').replace(/cos/g,' جتا ')
        .replace(/tan/g,' ظا ').replace(/log/g,' لوغاريتم ')
        .replace(/ln/g,' لوغاريتم طبيعي ');

    currentUtterance = new SpeechSynthesisUtterance(clean);
    currentUtterance.lang  = 'ar-SA';
    currentUtterance.rate  = 0.9;
    currentUtterance.onend  = () => { speechToast.classList.add('hidden'); speechToast.classList.remove('flex'); };
    currentUtterance.onerror = () => { speechToast.classList.add('hidden'); speechToast.classList.remove('flex'); };
    window.speechSynthesis.speak(currentUtterance);
}

function stopReading() {
    if (window.speechSynthesis.speaking) window.speechSynthesis.cancel();
    speechToast.classList.add('hidden');
    speechToast.classList.remove('flex');
}

// =============================================
// Toast
// =============================================
let toastTimer;
function showToast(msg, type = 'success') {
    const toast = document.getElementById('appToast');
    document.getElementById('toastMsg').textContent = msg;
    const icon = document.getElementById('toastIcon');
    icon.textContent  = type === 'success' ? '✓' : '✕';
    icon.style.color  = type === 'success' ? '#19e8a0' : '#f87171';
    toast.classList.remove('hidden');
    toast.classList.add('flex');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove('flex');
    }, 3000);
}

// =============================================
// دوال التعليقات
// =============================================
async function loadComments(videoId, sort = 'latest') {
    const container = document.getElementById(`comments-${videoId}`);
    if (!container) return;

    container.innerHTML = `
        <div class="text-center py-8">
            <svg class="animate-spin mx-auto mb-3" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="#1c2538" stroke-width="3"/>
                <path d="M12 2a10 10 0 0 1 10 10" stroke="#19e8a0" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <p class="text-sm text-[#8896b3]">جاري تحميل التعليقات...</p>
        </div>`;

    try {
        const res  = await fetch(`/api/comments/${videoId}?sort=${sort}`);
        const data = await res.json();

        if (!data.comments || data.comments.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <div class="text-4xl mb-2 opacity-30">💬</div>
                    <p class="text-sm text-[#8896b3]">لا توجد تعليقات بعد، كن أول من يعلق!</p>
                </div>`;
            return;
        }

        let html = '';
        data.comments.forEach(comment => {
            const initial  = escapeHtml(comment.user?.name?.charAt(0) || 'م');
            const isOwner  = comment.user_id === AUTH_ID;
            const replies  = comment.replies || [];

            html += `
            <div class="border-b border-[#1c2538] pb-4 mb-4 last:border-0" id="comment-${comment.id}">
                <div class="flex gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                         style="background: linear-gradient(135deg, #19e8a0, #10b981); color: #07090f;">
                        ${initial}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <span class="text-sm font-bold text-[#dde4f0]">${escapeHtml(comment.user?.name || 'مجهول')}</span>
                            <span class="text-xs text-[#8896b3]">${formatDate(comment.created_at)}</span>
                        </div>
                        <p class="text-sm text-[#bccae0] mb-3">${escapeHtml(comment.content)}</p>
                        <div class="flex items-center gap-3">
                            <button onclick="showReplyForm(${comment.id}, ${videoId})"
                                    class="flex items-center gap-1 text-xs text-[#8896b3] hover:text-[#19e8a0] transition-colors">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                رد ${replies.length ? `(${replies.length})` : ''}
                            </button>
                            ${isOwner ? `
                            <button onclick="deleteComment(${comment.id}, ${videoId})"
                                    class="flex items-center gap-1 text-xs text-[#8896b3] hover:text-[#f87171] transition-colors">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                حذف
                            </button>` : ''}
                        </div>
                        <div id="reply-form-${comment.id}" class="hidden mt-3">
                            <div class="flex gap-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                     style="background: linear-gradient(135deg, #19e8a0, #10b981); color: #07090f;">
                                    ${AUTH_INITIAL}
                                </div>
                                <div class="flex-1">
                                    <textarea id="reply-input-${comment.id}" rows="2"
                                              placeholder="اكتب ردك..."
                                              class="w-full px-3 py-2 rounded-lg border border-[#1c2538] bg-[#0e1118] text-[#dde4f0] text-sm"
                                              maxlength="2000"></textarea>
                                    <div class="flex justify-end gap-2 mt-2">
                                        <button onclick="hideReplyForm(${comment.id})"
                                                class="px-3 py-1 text-xs text-[#8896b3]">إلغاء</button>
                                        <button onclick="submitReply(${comment.id}, ${videoId})"
                                                class="px-4 py-1 rounded-lg text-xs font-medium"
                                                style="background: #19e8a0; color: #07090f;">إرسال</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ${replies.length ? `
                        <div class="mt-3 mr-8 space-y-2">
                            ${replies.map(reply => `
                            <div class="flex gap-2">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                     style="background: linear-gradient(135deg, #fbbf24, #fb923c); color: #07090f;">
                                    ${escapeHtml(reply.user?.name?.charAt(0) || 'م')}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-[#dde4f0]">${escapeHtml(reply.user?.name || 'مجهول')}</span>
                                        <span class="text-[10px] text-[#8896b3]">${formatDate(reply.created_at)}</span>
                                    </div>
                                    <p class="text-xs text-[#bccae0]">${escapeHtml(reply.content)}</p>
                                </div>
                            </div>`).join('')}
                        </div>` : ''}
                    </div>
                </div>
            </div>`;
        });

        container.innerHTML = html;

    } catch (error) {
        console.error('Error loading comments:', error);
        container.innerHTML = '<div class="text-center py-8 text-[#f87171] text-sm">حدث خطأ في تحميل التعليقات</div>';
    }
}

async function submitComment(videoId) {
    const input   = document.getElementById(`comment-input-${videoId}`);
    const content = input?.value?.trim();
    if (!content) { showToast('الرجاء كتابة تعليق أولاً', 'error'); return; }

    try {
        const res = await fetch(STORE_URL, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest' // ✅ makes $request->ajax() return true
    },
    body: JSON.stringify({ video_id: videoId, content })
});
        const data = await res.json();
              
        if (data.success) {
            input.value = '';
            showToast('تم إضافة تعليقك بنجاح');
            // FIX: force reload regardless of loaded flag
            await loadComments(videoId, 'latest');

               
        } else {
            showToast(data.message || 'حدث خطأ', 'error');
        }
    } catch { showToast('فشل الاتصال بالخادم', 'error'); }
}
function updateCommentCount(videoId, count) {
    document.querySelectorAll(`.comments-count-badge-${videoId}`).forEach(el => {
        el.textContent = count + ' تعليق'; // ✅ updates this span
    });
}
async function submitReply(commentId, videoId) {
    const input   = document.getElementById(`reply-input-${commentId}`);
    const content = input?.value?.trim();

    if (!content) { showToast('الرجاء كتابة الرد أولاً', 'error'); return; }

    try {
       const res = await fetch(`/comments/${commentId}/reply`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest' // ✅
    },
    body: JSON.stringify({ content })
});
        const data = await res.json();

        if (data.success) {
            input.value = '';
            hideReplyForm(commentId);
            showToast('تم إضافة ردك بنجاح');
            loadComments(videoId, 'latest');
        } else {
            showToast(data.message || 'حدث خطأ', 'error');
        }
    } catch { showToast('فشل الاتصال بالخادم', 'error'); }
}

async function deleteComment(commentId, videoId) {
    if (!confirm('هل أنت متأكد من حذف هذا التعليق؟')) return;

    try {
       const res = await fetch(`/comments/${commentId}`, {
    method: 'DELETE',
    headers: {
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest' // ✅
    }
});
        const data = await res.json();

        if (data.success) {
            showToast('تم حذف التعليق بنجاح');
            loadComments(videoId, 'latest');
            document.querySelectorAll(`.comments-count-badge-${videoId}`).forEach(el => {
                const n = parseInt(el.textContent) - 1;
                el.textContent = Math.max(0, n) + ' تعليق';
            });
        } else {
            showToast(data.message || 'حدث خطأ', 'error');
        }
    } catch { showToast('فشل الاتصال بالخادم', 'error'); }
}

function showReplyForm(commentId) {
    document.getElementById(`reply-form-${commentId}`)?.classList.remove('hidden');
}

function hideReplyForm(commentId) {
    document.getElementById(`reply-form-${commentId}`)?.classList.add('hidden');
    const input = document.getElementById(`reply-input-${commentId}`);
    if (input) input.value = '';
}

// =============================================
// FIX #6: Complete escapeHtml (adds " and ')
// =============================================
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    }[m]));
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const diff = Math.floor((Date.now() - date) / 1000);
    if (diff < 60)      return 'الآن';
    if (diff < 3600)    return `منذ ${Math.floor(diff / 60)} دقيقة`;
    if (diff < 86400)   return `منذ ${Math.floor(diff / 3600)} ساعة`;
    if (diff < 2592000) return `منذ ${Math.floor(diff / 86400)} يوم`;
    return date.toLocaleDateString('ar-SA');
}

// =============================================
// تهيئة الصفحة — single DOMContentLoaded
// =============================================
document.addEventListener('DOMContentLoaded', function () {
    const sections   = document.querySelectorAll('.content-section');
    const emptyState = document.getElementById('empty-state');

    // Make sure only empty-state is visible at start
    sections.forEach(s => {
        if (s.id !== 'empty-state') s.classList.add('hidden');
    });
    if (emptyState) {
        emptyState.classList.remove('hidden');
        emptyState.classList.add('block');
    }

    // Sidebar nav clicks → use showSection (which also lazy-loads comments)
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            if (targetId) showSection(targetId);
        });
    });

    updateProgress();
});

// =============================================
// Styles
// =============================================
const style = document.createElement('style');
style.textContent = `
    .nav-item { cursor: pointer; transition: all 0.3s ease; }
    .nav-item:hover { background: rgba(25,232,160,.04); }
    .nav-item.nav-active { background: rgba(25,232,160,.1) !important; border-right: 2px solid #19e8a0; }
    .content-section { transition: opacity 0.5s ease, transform 0.5s ease; }
    .content-section.hidden { display: none !important; }
    .content-section:not(.hidden) { animation: fadeIn 0.5s ease; }
    .block-content { transition: all 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
`;
document.head.appendChild(style);
</script>


@endsection