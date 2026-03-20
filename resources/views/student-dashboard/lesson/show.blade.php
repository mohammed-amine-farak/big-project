@extends('layouts.student_dashboard')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #07090f 0%, #0f1520 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- ===================================================== -->
            <!-- الشريط الجانبي الأيسر - قائمة محتوى أنيقة (3/12)   -->
            <!-- ===================================================== -->
            <div class="lg:col-span-3">
                <div class="sticky top-24 space-y-6">

                    <!-- بطاقة العودة -->
                    <div class="rounded-2xl overflow-hidden border border-[#1c2538] hover:border-[#19e8a0]/30 transition-all duration-300 group"
                         style="background: rgba(14,17,24,0.8); backdrop-filter: blur(10px);">
                        <a href="{{ route('student.lesson.index') }}"
                           class="flex items-center gap-3 px-5 py-4 hover:bg-[rgba(25,232,160,.04)] transition-all">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300"
                                 style="background: rgba(25,232,160,.1);">
                                <svg width="20" height="20" fill="none" stroke="#19e8a0" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-[#8896b3]">العودة إلى</div>
                                <div class="text-sm font-bold text-[#dde4f0] group-hover:text-[#19e8a0] transition-colors">قائمة الدروس</div>
                            </div>
                        </a>
                    </div>

                    <!-- بطاقة محتوى الدرس مع شريط التقدم -->
                    <div class="rounded-2xl overflow-hidden border border-[#1c2538]" style="background: rgba(14,17,24,0.8); backdrop-filter: blur(10px);">

                        <!-- عنوان الدرس -->
                        <div class="px-5 py-4 border-b border-[#1c2538]">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full animate-pulse" style="background: #19e8a0; box-shadow: 0 0 10px #19e8a0;"></div>
                                    <span class="text-xs font-bold tracking-wider text-[#8896b3] uppercase">{{ $lesson->subject->name ?? 'الرياضيات' }}</span>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-lg" style="background: rgba(25,232,160,.1); color: #19e8a0;">متوسط</span>
                            </div>
                            <h3 class="text-lg font-bold text-[#dde4f0] mb-3">{{ $lesson->title }}</h3>

                            <!-- شريط التقدم -->
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-[#8896b3]">تقدم التعلم</span>
                                    <span class="text-[#19e8a0]" id="progress-percentage">0%</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-[#1c2538] overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500"
                                         style="width: 0%; background: linear-gradient(90deg, #19e8a0, #10b981);"
                                         id="progress-bar"></div>
                                </div>
                            </div>
                        </div>

                        <!-- القائمة الجانبية -->
                        <div class="p-3 space-y-1" id="sidebar-links">
                            @php $globalIndex = 0; @endphp

                            <!-- فيديو الدرس الرئيسي -->
                            @if($lesson->videos && $lesson->videos->isNotEmpty())
                                @php $globalIndex++; @endphp
                                <div class="nav-item cursor-pointer rounded-xl transition-all duration-300 hover:bg-[rgba(25,232,160,.04)] group active-nav-item"
                                     data-target="video-main" data-index="0">
                                    <div class="flex items-center gap-3 px-4 py-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm transition-all duration-300 group-hover:scale-110 group-hover:bg-[rgba(248,113,113,.15)]"
                                             style="background: rgba(248,113,113,.1);">
                                            <span class="text-[#f87171] text-lg">🎥</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-[#dde4f0] group-hover:text-[#19e8a0] transition-colors">فيديو الدرس</div>
                                            <div class="flex items-center gap-2 text-xs text-[#8896b3]">
                                                <span>الدرس الرئيسي</span>
                                                <span class="w-1 h-1 rounded-full bg-[#1c2538]"></span>
                                                <span>12 دقيقة</span>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-[#1c2538] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <div class="w-2 h-2 rounded-full bg-[#19e8a0]"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @foreach($lesson->rules as $ruleIndex => $rule)
                                @php $globalIndex++; @endphp
                                <div class="nav-item cursor-pointer rounded-xl transition-all duration-300 hover:bg-[rgba(25,232,160,.04)] group mt-2"
                                     data-target="rule-{{ $rule->id }}" data-index="{{ $globalIndex - 1 }}">
                                    <div class="flex items-center gap-3 px-4 py-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold font-mono transition-all duration-300 group-hover:scale-110 group-hover:border-[#19e8a0]"
                                             style="background: #131824; border: 1px solid #1c2538;">
                                            <span style="color: #19e8a0;">{{ str_pad($ruleIndex + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-[#dde4f0] group-hover:text-[#19e8a0] transition-colors">{{ $rule->title }}</div>
                                            <div class="flex items-center gap-2 text-xs text-[#8896b3]">
                                                <span>{{ $rule->content_blocks->count() }} عناصر</span>
                                                @if($rule->content_blocks->where('type', 'video')->count() > 0)
                                                <span class="w-1 h-1 rounded-full bg-[#1c2538]"></span>
                                                <span>🎥 {{ $rule->content_blocks->where('type', 'video')->count() }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($rule->content_blocks->count() > 1)
                                <div class="sub-items pr-8 space-y-1 mb-2 hidden">
                                    @foreach($rule->content_blocks as $blockIndex => $block)
                                    <div class="sub-nav-item cursor-pointer rounded-lg transition-all hover:bg-[rgba(25,232,160,.04)] group py-2 px-3"
                                         data-target="block-{{ $block->id }}">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded flex items-center justify-center text-xs">
                                                @if($block->type == 'text') 📝
                                                @elseif($block->type == 'math') 📐
                                                @elseif($block->type == 'image') 🖼️
                                                @elseif($block->type == 'exercise') ✏️
                                                @elseif($block->type == 'video') 🎥
                                                @endif
                                            </div>
                                            <span class="text-xs text-[#8896b3] group-hover:text-[#dde4f0]">
                                                @if($block->type == 'text') نص
                                                @elseif($block->type == 'math') معادلة
                                                @elseif($block->type == 'image') صورة
                                                @elseif($block->type == 'exercise') تمرين
                                                @elseif($block->type == 'video') فيديو
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- ملخص المحتوى -->
                        <div class="px-5 py-4 border-t border-[#1c2538] mt-2">
                            <div class="flex items-center justify-between text-xs text-[#8896b3] mb-2">
                                <span>إجمالي العناصر</span>
                                <span class="font-bold text-[#19e8a0]">{{ $globalIndex }} عنصر</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-[#8896b3]">
                                <span>المتبقي</span>
                                <span class="font-bold text-[#dde4f0]" id="remaining-items">{{ $globalIndex }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- المحتوى الرئيسي (9/12)                               -->
            <!-- ===================================================== -->
            <div class="lg:col-span-9" id="content-area">

                <!-- حالة البداية -->
                <div id="empty-state" class="content-section block">
                    <div class="rounded-3xl border border-[#1c2538] p-16 text-center relative overflow-hidden group"
                         style="background: rgba(14,17,24,0.6); backdrop-filter: blur(10px);">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                            <div class="absolute top-0 -right-20 w-64 h-64 rounded-full" style="background: radial-gradient(circle, rgba(25,232,160,.05) 0%, transparent 70%);"></div>
                            <div class="absolute bottom-0 -left-20 w-64 h-64 rounded-full" style="background: radial-gradient(circle, rgba(25,232,160,.03) 0%, transparent 70%);"></div>
                        </div>
                        <div class="relative z-10">
                            <div class="w-28 h-28 mx-auto mb-6 rounded-3xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-500"
                                 style="background: rgba(25,232,160,.05);">
                                <svg width="48" height="48" fill="none" stroke="#19e8a0" viewBox="0 0 24 24" class="animate-pulse">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-[#dde4f0] mb-3">اختر عنصراً من القائمة</h2>
                            <p class="text-[#8896b3] text-lg max-w-md mx-auto mb-8">اضغط على أي عنصر في الشريط الجانبي لبدء التعلم</p>
                            <div class="flex items-center justify-center gap-8 mt-8 pt-8 border-t border-[#1c2538]">
                                <div class="text-center group/stat">
                                    <div class="text-2xl font-bold text-[#19e8a0] mb-1 transform group-hover/stat:scale-110 transition-transform">{{ $lesson->rules->count() }}</div>
                                    <div class="text-xs text-[#8896b3] flex items-center gap-1"><span>📚</span> قواعد</div>
                                </div>
                                <div class="w-px h-8" style="background: #1c2538;"></div>
                                <div class="text-center group/stat">
                                    <div class="text-2xl font-bold text-[#19e8a0] mb-1 transform group-hover/stat:scale-110 transition-transform">{{ $globalIndex }}</div>
                                    <div class="text-xs text-[#8896b3] flex items-center gap-1"><span>📋</span> عناصر</div>
                                </div>
                                <div class="w-px h-8" style="background: #1c2538;"></div>
                                <div class="text-center group/stat">
                                    <div class="text-2xl font-bold text-[#19e8a0] mb-1 transform group-hover/stat:scale-110 transition-transform">
                                        {{ $lesson->rules->sum(function($rule) { return $rule->content_blocks->where('type', 'video')->count(); }) }}
                                    </div>
                                    <div class="text-xs text-[#8896b3] flex items-center gap-1"><span>🎥</span> فيديوهات</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================================================== -->
                <!-- عرض القواعد وكتل المحتوى                             -->
                <!-- ===================================================== -->
                @foreach($lesson->rules as $rule)
                <div id="rule-{{ $rule->id }}" class="content-section hidden rounded-3xl border border-[#1c2538] overflow-hidden mb-6 transform transition-all duration-500" style="background: #0e1118;">

                    <!-- رأس القاعدة -->
                    <div class="relative px-8 py-6 border-b border-[#1c2538]" style="background: linear-gradient(135deg, rgba(25,232,160,.04), transparent);">
                        <div class="absolute right-0 top-0 bottom-0 w-1" style="background: linear-gradient(180deg, #19e8a0, transparent);"></div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <span class="w-12 h-12 rounded-xl flex items-center justify-center text-lg font-bold font-mono text-[#19e8a0] border-2 border-[rgba(25,232,160,.35)] transform hover:scale-110 transition-transform"
                                      style="background: rgba(25,232,160,.1);">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs px-2 py-1 rounded-lg" style="background: rgba(25,232,160,.1); color: #19e8a0;">قاعدة</span>
                                        <span class="text-xs text-[#8896b3]">{{ $rule->content_blocks->count() }} عناصر</span>
                                    </div>
                                    <h2 class="text-xl font-bold text-[#dde4f0]">{{ $rule->title }}</h2>
                                    @if($rule->description)
                                    <p class="text-sm text-[#8896b3] mt-1">{{ $rule->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <button class="px-4 py-2 rounded-xl text-sm font-medium transition-all hover:scale-105"
                                    style="background: rgba(25,232,160,.1); color: #19e8a0; border: 1px solid rgba(25,232,160,.2);"
                                    onclick="startRule({{ $rule->id }})">
                                بدء التعلم
                            </button>
                        </div>
                    </div>

                    <!-- محتوى القاعدة -->
                    <div class="p-8 space-y-8">
                        @foreach($rule->content_blocks as $block)
                        <div id="block-{{ $block->id }}" class="block-content group/block transform transition-all duration-300 hover:scale-[1.02]">

                            {{-- ======== نص ======== --}}
                            @if($block->type == 'text')
                            <div class="p-6 rounded-xl border border-[#1c2538] hover:border-[#19e8a0]/30 transition-all" style="background: #131824;">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(137,150,179,.1);">
                                        <svg width="16" height="16" fill="none" stroke="#8896b3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-[#8896b3] uppercase">نص تعليمي</span>
                                    <span class="text-xs text-[#19e8a0] mr-auto cursor-pointer hover:underline">قراءة لاحقاً</span>
                                </div>
                                <p class="text-[#bccae0] leading-relaxed text-lg">{{ $block->content }}</p>
                            </div>

                            {{-- ======== معادلة ======== --}}
                            @elseif($block->type == 'math')
                            <div class="relative rounded-xl border border-[#1c2538] p-8 text-center overflow-hidden group/math" style="background: #050709;">
                                <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, #19e8a0, transparent);"></div>
                                <div class="absolute inset-0 opacity-0 group-hover/math:opacity-100 transition-opacity duration-700">
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full"
                                         style="background: radial-gradient(circle, rgba(25,232,160,.03) 0%, transparent 70%);"></div>
                                </div>
                                <div class="flex items-center gap-2 mb-6 absolute top-4 right-6">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(25,232,160,.1);">
                                        <svg width="16" height="16" fill="none" stroke="#19e8a0" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12h15M12 4.5l7.5 7.5-7.5 7.5"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-[#19e8a0] uppercase">معادلة رياضية</span>
                                </div>
                                <div class="text-center mt-8" dir="ltr">
                                    <div class="math-equation text-2xl" style="color: #19e8a0;">
                                        {!! $block->content !!}
                                    </div>
                                </div>
                            </div>

                            {{-- ======== صورة ======== --}}
                            @elseif($block->type == 'image')
                            <div class="rounded-xl border border-[#1c2538] overflow-hidden group/image">
                                <div class="px-6 py-4 border-b border-[#1c2538] flex items-center gap-2" style="background: #131824;">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(74,158,255,.1);">
                                        <svg width="16" height="16" fill="none" stroke="#4a9eff" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-width="2" d="M8 12l4-4 4 4"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-[#4a9eff] uppercase">صورة توضيحية</span>
                                    <span class="text-xs text-[#8896b3] mr-auto">{{ basename($block->content) }}</span>
                                </div>
                                <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $block->content) }}')">
                                    <img src="{{ asset('storage/' . $block->content) }}" alt="صورة"
                                         class="w-full max-h-96 object-contain transition-transform duration-500 group-hover:scale-105"
                                         style="background: #131824;">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <span class="px-4 py-2 rounded-lg bg-white/10 backdrop-blur-sm text-white text-sm">اضغط للتكبير</span>
                                    </div>
                                </div>
                            </div>

                            {{-- ======== تمرين ======== --}}
                            @elseif($block->type == 'exercise')
                            <div class="relative rounded-xl p-6 overflow-hidden transform transition-all duration-300 hover:shadow-xl"
                                 style="background: linear-gradient(135deg, rgba(251,191,36,.05), rgba(251,146,60,.03)); border: 1px solid rgba(251,191,36,.18);">
                                <div class="absolute right-0 top-0 bottom-0 w-1" style="background: linear-gradient(180deg, #fbbf24, #fb923c);"></div>
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(251,191,36,.1);">
                                        <svg width="16" height="16" fill="none" stroke="#fbbf24" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-[#fbbf24] uppercase">تمرين تطبيقي</span>
                                    <span class="text-xs text-[#8896b3] mr-auto">حاول الحل بنفسك أولاً</span>
                                </div>
                                <p class="text-[#dde4f0] text-lg mb-6">{{ $block->content }}</p>
                                <div class="flex items-center gap-3">
                                    <button onclick="toggleSolution({{ $block->id }})"
                                            class="flex items-center gap-2 px-6 py-3 rounded-xl border border-[rgba(251,191,36,.28)] hover:bg-[rgba(251,191,36,.1)] text-[#fbbf24] text-sm font-medium transition-all hover:scale-105">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        عرض الحل
                                    </button>
                                    <button class="flex items-center gap-2 px-6 py-3 rounded-xl border border-[#1c2538] hover:bg-[rgba(255,255,255,.02)] text-[#8896b3] text-sm font-medium transition-all">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        تلميح
                                    </button>
                                </div>
                                <div id="solution-{{ $block->id }}" class="hidden mt-6 p-6 rounded-xl text-sm text-[#bccae0] leading-relaxed"
                                     style="background: rgba(25,232,160,.05); border: 1px solid rgba(25,232,160,.15);">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="w-6 h-6 rounded-full bg-[#19e8a0]/10 flex items-center justify-center text-[#19e8a0]">✓</span>
                                        <span class="text-[#19e8a0] font-medium">الحل النموذجي</span>
                                    </div>
                                    الحل سيظهر هنا...
                                </div>
                            </div>
                            @endif

                            {{-- ======== فيديو + قسم التعليقات ======== --}}
                            @if(isset($block->video) && $block->video)
                            <div class="rounded-xl border border-[#1c2538] overflow-hidden group/video mt-4">
                                <!-- رأس الفيديو -->
                                <div class="px-6 py-4 border-b border-[#1c2538] flex items-center gap-2" style="background: #131824;">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(248,113,113,.1);">
                                        <svg width="16" height="16" fill="none" stroke="#f87171" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold tracking-wider text-[#f87171] uppercase">فيديو توضيحي</span>
                                    <span class="text-xs text-[#8896b3] mr-auto">{{ $block->video->duration ?? '5:30' }}</span>
                                </div>

                                <!-- مشغل الفيديو -->
                                <div class="relative">
                                    <video controls class="w-full max-h-96" style="background: #000;">
                                        <source src="{{ asset('storage/' . $block->video->file_path) }}" type="video/mp4">
                                    </video>
                                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#1c2538]">
                                        <div class="h-full w-0 bg-[#f87171] transition-all duration-300" id="progress-{{ $block->id }}"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- ===================================================== -->
                            <!-- قسم التعليقات                                         -->
                            <!-- ===================================================== -->
                            <div class="rounded-2xl border border-[#1c2538] overflow-hidden mt-4" style="background: #0e1118;">

                                <!-- رأس التعليقات -->
                                <div class="px-6 py-4 border-b border-[#1c2538] flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(25,232,160,.1);">
                                            <svg width="18" height="18" fill="none" stroke="#19e8a0" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-[15px] font-bold text-[#dde4f0]">التعليقات</h4>
                                        <span class="text-xs px-3 py-1 rounded-full font-semibold" style="background: rgba(25,232,160,.1); color: #19e8a0;">
                                            {{ $block->video->comments_count ?? 0 }} تعليق
                                        </span>
                                    </div>
                                    <button class="text-xs text-[#8896b3] px-3 py-1.5 rounded-lg border border-[#1c2538] transition-all hover:border-[rgba(25,232,160,.3)] hover:text-[#19e8a0]" style="background: #131824;">
                                        ترتيب: الأحدث ▾
                                    </button>
                                </div>

                                <!-- كتابة تعليق جديد -->
                                <div class="px-6 py-4 border-b border-[#1c2538] flex gap-3 items-start">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                                         style="background: linear-gradient(135deg, #19e8a0, #10b981); color: #07090f;">
                                        {{ mb_substr(auth()->user()->name ?? 'أ', 0, 1) }}
                                    </div>
                                    <div class="comment-textarea-wrap flex-1 rounded-xl border border-[#1c2538] overflow-hidden" style="background: #131824;">
                                        <textarea
                                            rows="1"
                                            placeholder="اكتب تعليقك أو سؤالك عن الفيديو..."
                                            class="w-full bg-transparent border-none outline-none px-4 py-3 text-sm text-[#dde4f0] resize-none"
                                            style="font-family: inherit; direction: rtl;"
                                            oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px'"></textarea>
                                        <div class="flex items-center justify-between px-3 py-2 border-t border-[#1c2538]">
                                            <div class="flex gap-1">
                                                <button class="w-7 h-7 rounded-md flex items-center justify-center text-xs font-bold text-[#8896b3] hover:text-[#dde4f0] transition-all" style="font-family: Georgia, serif;">B</button>
                                                <button class="w-7 h-7 rounded-md flex items-center justify-center text-xs text-[#8896b3] hover:text-[#dde4f0] transition-all" style="font-style: italic; font-family: Georgia, serif;">I</button>
                                                <button class="w-7 h-7 rounded-md flex items-center justify-center text-[#8896b3] hover:text-[#dde4f0] transition-all">
                                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button class="flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-bold transition-all hover:opacity-90 active:scale-95"
                                                    style="background: #19e8a0; color: #07090f;">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                </svg>
                                                إرسال
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- قائمة التعليقات -->
                                <div class="px-6 pb-6 divide-y divide-[#131824]">

                                    {{-- ---- تعليق مثبت من الأستاذ ---- --}}
                                    <div class="py-5">
                                        <div class="flex gap-3">
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                                                 style="background: linear-gradient(135deg, #fbbf24, #fb923c); color: #07090f;">م</div>
                                            <div class="flex-1">
                                                <div class="flex items-center flex-wrap gap-2 mb-2">
                                                    <span class="text-sm font-bold text-[#dde4f0]">الأستاذ محمد العمري</span>
                                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold" style="background: rgba(251,191,36,.12); color: #fbbf24;">أستاذ</span>
                                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold" style="background: rgba(74,158,255,.1); color: #4a9eff;">📌 مثبت</span>
                                                    <span class="text-[11px] text-[#4a5568] mr-auto">منذ يومين</span>
                                                </div>
                                                <p class="text-sm text-[#bccae0] leading-relaxed mb-3">
                                                    مرحباً بالجميع! هذا الفيديو يشرح
                                                    <span class="px-1.5 py-0.5 rounded text-[#19e8a0] text-xs" style="background: rgba(25,232,160,.08);">القاعدة الأساسية</span>
                                                    للدرس. إذا كان لديكم أي سؤال لا تترددوا في التعليق وسأرد في أقرب وقت ✅
                                                </p>
                                                <div class="flex gap-1">
                                                    <button class="comment-like-btn flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs transition-all hover:bg-white/5" style="color: #f87171;">
                                                        <svg width="13" height="13" fill="#f87171" viewBox="0 0 24 24">
                                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                                        </svg>
                                                        47
                                                    </button>
                                                    <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-[#8896b3] hover:text-[#dde4f0] hover:bg-white/5 transition-all">
                                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                        </svg>
                                                        رد
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ---- تعليق مع ردود ---- --}}
                                    <div class="py-5">
                                        <div class="flex gap-3">
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                                                 style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff;">س</div>
                                            <div class="flex-1">
                                                <div class="flex items-center flex-wrap gap-2 mb-2">
                                                    <span class="text-sm font-bold text-[#dde4f0]">سارة الأحمدي</span>
                                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold" style="background: rgba(25,232,160,.1); color: #19e8a0;">طالبة</span>
                                                    <span class="text-[11px] text-[#4a5568] mr-auto">منذ 3 ساعات</span>
                                                </div>
                                                <p class="text-sm text-[#bccae0] leading-relaxed mb-3">جزاك الله خيراً على الشرح الرائع! سؤال: في الدقيقة 4:20 عندما تحدثت عن المعادلة، هل يمكن أن يكون المتغير x سالباً؟</p>
                                                <div class="flex gap-1 mb-4">
                                                    <button class="comment-like-btn flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-[#8896b3] hover:text-[#f87171] hover:bg-white/5 transition-all">
                                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                                        </svg>
                                                        12
                                                    </button>
                                                    <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-[#8896b3] hover:text-[#dde4f0] hover:bg-white/5 transition-all">
                                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                        </svg>
                                                        رد (2)
                                                    </button>
                                                </div>
                                                <!-- الردود -->
                                                <div class="border-r-2 border-[#1c2538] pr-4 space-y-4">
                                                    <div class="flex gap-2.5">
                                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                                             style="background: linear-gradient(135deg, #fbbf24, #fb923c); color: #07090f;">م</div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <span class="text-xs font-bold text-[#dde4f0]">الأستاذ محمد</span>
                                                                <span class="text-[9px] px-1.5 py-0.5 rounded-full" style="background: rgba(251,191,36,.12); color: #fbbf24;">أستاذ</span>
                                                                <span class="text-[10px] text-[#4a5568]">منذ 2 ساعة</span>
                                                            </div>
                                                            <p class="text-xs text-[#8896b3] leading-relaxed">نعم سارة، المتغير x يمكن أن يكون سالباً في هذه الحالة، الشرط الوحيد هو أن يكون ضمن المجال المحدد في التمرين 👍</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2.5">
                                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                                             style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: #07090f;">ع</div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <span class="text-xs font-bold text-[#dde4f0]">عمر خالد</span>
                                                                <span class="text-[10px] text-[#4a5568]">منذ ساعة</span>
                                                            </div>
                                                            <p class="text-xs text-[#8896b3]">شكراً للتوضيح، كان عندي نفس السؤال!</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ---- تعليق بسيط ---- --}}
                                    <div class="py-5">
                                        <div class="flex gap-3">
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                                                 style="background: linear-gradient(135deg, #f093fb, #f5576c); color: #fff;">ن</div>
                                            <div class="flex-1">
                                                <div class="flex items-center flex-wrap gap-2 mb-2">
                                                    <span class="text-sm font-bold text-[#dde4f0]">نورة المطيري</span>
                                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold" style="background: rgba(25,232,160,.1); color: #19e8a0;">طالبة</span>
                                                    <span class="text-[11px] text-[#4a5568] mr-auto">منذ 5 ساعات</span>
                                                </div>
                                                <p class="text-sm text-[#bccae0] leading-relaxed mb-3">الشرح واضح جداً ومرتب، أتمنى إضافة مثال تطبيقي في الحصة القادمة.</p>
                                                <div class="flex gap-1">
                                                    <button class="comment-like-btn flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-[#8896b3] hover:text-[#f87171] hover:bg-white/5 transition-all">
                                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                                        </svg>
                                                        8
                                                    </button>
                                                    <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-[#8896b3] hover:text-[#dde4f0] hover:bg-white/5 transition-all">
                                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                        </svg>
                                                        رد
                                                    </button>
                                                    <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-[#8896b3] hover:text-[#dde4f0] hover:bg-white/5 transition-all mr-auto">
                                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                                        </svg>
                                                        إبلاغ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ---- زر تحميل المزيد ---- --}}
                                    <div class="pt-5 flex justify-center">
                                        <button class="text-sm text-[#8896b3] px-6 py-2.5 rounded-xl border border-[#1c2538] hover:border-[rgba(25,232,160,.3)] hover:text-[#19e8a0] transition-all"
                                                style="background: #131824;">
                                            عرض المزيد من التعليقات
                                            <span class="text-[#19e8a0] mr-1">↓</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            {{-- ===== نهاية قسم التعليقات ===== --}}

                            @endif
                            {{-- نهاية شرط الفيديو --}}

                        </div>
                        @endforeach

                        <!-- أزرار التنقل بين القواعد -->
                        <div class="flex items-center justify-between pt-6 border-t border-[#1c2538]">
                            @if(!$loop->first)
                            <button onclick="navigateToRule({{ $lesson->rules[$loop->index - 1]->id }})"
                                    class="flex items-center gap-2 px-4 py-2 rounded-xl border border-[#1c2538] hover:border-[#19e8a0]/30 text-[#8896b3] hover:text-[#19e8a0] transition-all">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                القاعدة السابقة
                            </button>
                            @else
                            <div></div>
                            @endif

                            @if(!$loop->last)
                            <button onclick="navigateToRule({{ $lesson->rules[$loop->index + 1]->id }})"
                                    class="flex items-center gap-2 px-4 py-2 rounded-xl border border-[#1c2538] hover:border-[#19e8a0]/30 text-[#8896b3] hover:text-[#19e8a0] transition-all">
                                القاعدة التالية
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            @else
                            <div></div>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<!-- ===================================================== -->
<!-- مودال تكبير الصورة                                   -->
<!-- ===================================================== -->
<div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background: rgba(0,0,0,.95); backdrop-filter: blur(10px);">
    <div class="relative max-w-5xl max-h-[90vh] mx-4">
        <img id="modalImage" src="" alt="صورة مكبرة" class="max-w-full max-h-[90vh] object-contain rounded-xl">
        <button onclick="closeImageModal()" class="absolute -top-12 left-1/2 -translate-x-1/2 px-6 py-3 rounded-xl text-white text-sm"
                style="background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);">
            إغلاق ✕
        </button>
    </div>
</div>

<!-- Toast للقراءة -->
<div id="speechToast" class="fixed bottom-8 right-8 z-50 hidden items-center gap-3 px-5 py-3 rounded-xl"
     style="background: linear-gradient(135deg, #19e8a0, #10b981); color: #07090f; box-shadow: 0 8px 24px rgba(25,232,160,.3);">
    <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
    <span class="text-sm font-medium">جاري قراءة المعادلة...</span>
    <button onclick="stopReading()" class="mr-3 w-6 h-6 rounded-lg flex items-center justify-center hover:bg-black/10">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<!-- ===================================================== -->
<!-- JavaScript                                           -->
<!-- ===================================================== -->
<script>
let totalItems  = {{ $globalIndex }};
let viewedItems = new Set();
const toast     = document.getElementById('speechToast');
let currentUtterance = null;

/* ---------- التقدم ---------- */
function updateProgress() {
    const pct = Math.round((viewedItems.size / totalItems) * 100);
    document.getElementById('progress-percentage').textContent = pct + '%';
    document.getElementById('progress-bar').style.width = pct + '%';
    document.getElementById('remaining-items').textContent = totalItems - viewedItems.size;
}

function markAsViewed(itemId) {
    viewedItems.add(itemId);
    updateProgress();
}

/* ---------- التنقل ---------- */
function navigateToRule(ruleId) {
    document.querySelectorAll('.content-section').forEach(s => s.classList.add('hidden'));
    const target = document.getElementById('rule-' + ruleId);
    if (!target) return;
    target.classList.remove('hidden');
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('nav-active'));
    const activeNav = document.querySelector(`[data-target="rule-${ruleId}"]`);
    if (activeNav) activeNav.classList.add('nav-active');
}

function startRule(ruleId) {
    navigateToRule(ruleId);
    markAsViewed('rule-' + ruleId);
}

/* ---------- الحل ---------- */
function toggleSolution(blockId) {
    const el = document.getElementById('solution-' + blockId);
    if (!el) return;
    el.classList.toggle('hidden');
    if (!el.classList.contains('hidden')) el.style.animation = 'slideDown 0.3s ease';
}

/* ---------- الصورة ---------- */
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    const modal = document.getElementById('imageModal');
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

/* ---------- قراءة المعادلة ---------- */
function readEquation(eq) {
    if (window.speechSynthesis.speaking) window.speechSynthesis.cancel();
    toast.classList.remove('hidden');
    let clean = eq
        .replace(/\$\$/g,'').replace(/\$/g,'').replace(/\\/g,'')
        .replace(/[{}]/g,'').replace(/frac/g,' كسر ')
        .replace(/_/g,' تحت ').replace(/\^/g,' أس ')
        .replace(/sqrt/g,' جذر ').replace(/int/g,' تكامل ')
        .replace(/sum/g,' مجموع ').replace(/pi/g,' باي ')
        .replace(/sin/g,' جا ').replace(/cos/g,' جتا ')
        .replace(/tan/g,' ظا ').replace(/log/g,' لوغاريتم ')
        .replace(/ln/g,' لوغاريتم طبيعي ').replace(/times/g,' في ')
        .replace(/div/g,' على ').replace(/leq/g,' أصغر أو يساوي ')
        .replace(/geq/g,' أكبر أو يساوي ').replace(/neq/g,' لا يساوي ')
        .replace(/approx/g,' تقريباً ').replace(/infty/g,' مالانهاية ');
    currentUtterance = new SpeechSynthesisUtterance(clean);
    currentUtterance.lang = 'ar-SA';
    currentUtterance.rate = 0.9;
    currentUtterance.onend  = () => toast.classList.add('hidden');
    currentUtterance.onerror = () => toast.classList.add('hidden');
    window.speechSynthesis.speak(currentUtterance);
}
function stopReading() {
    if (window.speechSynthesis.speaking) window.speechSynthesis.cancel();
    toast.classList.add('hidden');
}

/* ---------- إعداد اللايك للتعليقات ---------- */
function initCommentLikes() {
    document.querySelectorAll('.comment-like-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const countEl = this.querySelector('svg + *') ?? this.lastChild;
            const isLiked = this.dataset.liked === '1';
            const svgEl   = this.querySelector('svg');
            if (isLiked) {
                this.dataset.liked = '0';
                svgEl.setAttribute('fill', 'none');
                svgEl.setAttribute('stroke', 'currentColor');
                this.style.color = '';
            } else {
                this.dataset.liked = '1';
                svgEl.setAttribute('fill', '#f87171');
                svgEl.removeAttribute('stroke');
                this.style.color = '#f87171';
            }
        });
    });
}

/* ---------- التشغيل عند تحميل الصفحة ---------- */
document.addEventListener('DOMContentLoaded', function () {
    const contentSections = document.querySelectorAll('.content-section');
    const navItems  = document.querySelectorAll('.nav-item');
    const emptyState = document.getElementById('empty-state');
    const subNavItems = document.querySelectorAll('.sub-nav-item');

    /* إخفاء كل شيء ما عدا الحالة الفارغة */
    contentSections.forEach(s => {
        if (s.id !== 'empty-state') s.classList.add('hidden');
    });
    if (emptyState) {
        emptyState.classList.remove('hidden');
        emptyState.classList.add('block');
    }

    /* نقر على عناصر الشريط الجانبي */
    navItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const target   = document.getElementById(targetId);
            if (!target) return;

            contentSections.forEach(s => s.classList.add('hidden'));
            if (emptyState) emptyState.classList.add('hidden');
            target.classList.remove('hidden');
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });

            navItems.forEach(n => n.classList.remove('nav-active'));
            this.classList.add('nav-active');
            markAsViewed(targetId);
        });
    });

    /* نقر على العناصر الفرعية */
    subNavItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.getElementById(this.getAttribute('data-target'));
            if (!target) return;
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            target.style.animation = 'pulse 0.5s ease';
            setTimeout(() => target.style.animation = '', 500);
            markAsViewed(this.getAttribute('data-target'));
        });
    });

    /* إغلاق المودال بـ ESC */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeImageModal();
    });

    updateProgress();
    initCommentLikes();
});
</script>

<!-- ===================================================== -->
<!-- الأنماط                                              -->
<!-- ===================================================== -->
<style>
mjx-container {
    color: #19e8a0 !important;
    font-size: 1.4rem !important;
}

/* شريط التمرير */
::-webkit-scrollbar       { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: #0e1118; }
::-webkit-scrollbar-thumb { background: #1c2538; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: #19e8a0; }

/* حالة النشاط في الشريط الجانبي */
.nav-item { cursor: pointer; transition: all 0.3s ease; }
.nav-item:hover  { background: rgba(25,232,160,.04); }
.nav-item.nav-active {
    background: rgba(25,232,160,.1) !important;
    border-right: 2px solid #19e8a0;
}

/* أنيماشن الأقسام */
.content-section { transition: opacity 0.5s ease, transform 0.5s ease; }
.content-section.hidden { display: none !important; }
.content-section:not(.hidden) { animation: fadeIn 0.5s ease; }

/* textarea داخل التعليقات */
.comment-textarea-wrap:focus-within {
    border-color: rgba(25,232,160,.4) !important;
}

/* كتل المحتوى */
.block-content { transition: all 0.3s ease; }
.math-equation mjx-container { color: #19e8a0 !important; font-size: 1.4rem !important; }

/* كيفريمز */
@keyframes fadeIn    { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
@keyframes slideDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
@keyframes pulse     { 0%,100% { transform:scale(1); } 50% { transform:scale(1.02); } }
</style>
@endsection