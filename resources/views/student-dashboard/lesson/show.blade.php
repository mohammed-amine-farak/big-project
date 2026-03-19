@extends('layouts.student_dashboard')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #07090f 0%, #0f1520 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- ===================================================== -->
            <!-- الشريط الجانبي الأيسر - قائمة محتوى أنيقة (3/12) -->
            <!-- ===================================================== -->
            <div class="lg:col-span-3">
                <div class="sticky top-24 space-y-6">
                    <!-- بطاقة العودة -->
                    <div class="rounded-2xl overflow-hidden border border-[#1c2538]" style="background: rgba(14,17,24,0.8); backdrop-filter: blur(10px);">
                        <a href="{{ route('student.lesson.index') }}" 
                           class="flex items-center gap-3 px-5 py-4 hover:bg-[rgba(25,232,160,.04)] transition-all group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(25,232,160,.1);">
                                <svg width="20" height="20" fill="none" stroke="#19e8a0" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-[#8896b3]">العودة إلى</div>
                                <div class="text-sm font-bold text-[#dde4f0] group-hover:text-[#19e8a0]">قائمة الدروس</div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- بطاقة محتوى الدرس -->
                    <div class="rounded-2xl overflow-hidden border border-[#1c2538]" style="background: rgba(14,17,24,0.8); backdrop-filter: blur(10px);">
                        <!-- عنوان الدرس -->
                        <div class="px-5 py-4 border-b border-[#1c2538]">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-2 h-2 rounded-full" style="background: #19e8a0; box-shadow: 0 0 10px #19e8a0;"></div>
                                <span class="text-xs font-bold tracking-wider text-[#8896b3] uppercase">{{ $lesson->subject->name ?? 'الرياضيات' }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-[#dde4f0]">{{ $lesson->title }}</h3>
                        </div>
                        
                        <!-- القائمة الرئيسية -->
                        <div class="p-3 space-y-1" id="sidebar-links">
                            @php $globalIndex = 0; @endphp
                            
                            <!-- فيديو الدرس الرئيسي -->
                            @if($lesson->videos && $lesson->videos->isNotEmpty())
                                @php $globalIndex++; @endphp
                                <div class="nav-item cursor-pointer rounded-xl transition-all hover:bg-[rgba(25,232,160,.04)] group"
                                     data-target="video-main">
                                    <div class="flex items-center gap-3 px-4 py-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background: rgba(248,113,113,.1);">
                                            <span class="text-[#f87171]">🎥</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-[#dde4f0] group-hover:text-[#19e8a0]">فيديو الدرس</div>
                                            <div class="text-xs text-[#8896b3]">{{ $globalIndex }} · 12 دقيقة</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @foreach($lesson->rules as $ruleIndex => $rule)
                                <!-- القاعدة -->
                                @php $globalIndex++; @endphp
                                <div class="nav-item cursor-pointer rounded-xl transition-all hover:bg-[rgba(25,232,160,.04)] group mt-2"
                                     data-target="rule-{{ $rule->id }}">
                                    <div class="flex items-center gap-3 px-4 py-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold font-mono border border-[#1c2538]" style="background: #131824;">
                                            <span style="color: #19e8a0;">{{ str_pad($ruleIndex + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-[#dde4f0] group-hover:text-[#19e8a0]">{{ $rule->title }}</div>
                                            <div class="text-xs text-[#8896b3]">{{ $rule->content_blocks->count() }} عناصر</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- عناصر القاعدة -->
                                
                            @endforeach
                        </div>
                        
                        <!-- ملخص المحتوى -->
                        <div class="px-5 py-4 border-t border-[#1c2538] mt-2">
                            <div class="flex items-center justify-between text-xs text-[#8896b3]">
                                <span>إجمالي العناصر</span>
                                <span class="font-bold text-[#19e8a0]">{{ $globalIndex }} عنصر</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================================================== -->
            <!-- المحتوى الرئيسي (9/12) - عرض أنيق للمحتوى -->
            <!-- ===================================================== -->
            <div class="lg:col-span-9" id="content-area">
                <!-- حالة البداية - اختيار عنصر -->
                <div id="empty-state" class="content-section block">
                    <div class="rounded-3xl border border-[#1c2538] p-16 text-center" style="background: rgba(14,17,24,0.6); backdrop-filter: blur(10px);">
                        <div class="w-28 h-28 mx-auto mb-6 rounded-3xl flex items-center justify-center" style="background: rgba(25,232,160,.05);">
                            <svg width="48" height="48" fill="none" stroke="#19e8a0" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-[#dde4f0] mb-3">اختر عنصراً من القائمة</h2>
                        <p class="text-[#8896b3] text-lg max-w-md mx-auto">اضغط على أي عنصر في الشريط الجانبي لبدء التعلم</p>
                        
                        <!-- إحصائيات سريعة -->
                        <div class="flex items-center justify-center gap-6 mt-8 pt-8 border-t border-[#1c2538]">
                            <div>
                                <div class="text-2xl font-bold text-[#19e8a0]">{{ $lesson->rules->count() }}</div>
                                <div class="text-xs text-[#8896b3]">قواعد</div>
                            </div>
                            <div class="w-px h-8" style="background: #1c2538;"></div>
                            <div>
                                <div class="text-2xl font-bold text-[#19e8a0]">{{ $globalIndex }}</div>
                                <div class="text-xs text-[#8896b3]">عناصر</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- فيديو الدرس الرئيسي -->
                @if($lesson->videos && $lesson->videos->isNotEmpty())
                <div id="video-main" class="content-section hidden rounded-3xl overflow-hidden border border-[#1c2538] mb-6" style="background: #0e1118;">
                    <div class="relative">
                        <video controls class="w-full aspect-video" style="background: #000;">
                            <source src="{{ asset('storage/' . $lesson->videos->first()->file_path) }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="px-6 py-4 border-t border-[#1c2538] flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full animate-pulse" style="background: #f87171;"></div>
                            <span class="text-sm text-[#8896b3]">فيديو الدرس</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- عرض القواعد وكتل المحتوى -->
                @foreach($lesson->rules as $rule)
                <div id="rule-{{ $rule->id }}" class="content-section hidden rounded-3xl border border-[#1c2538] overflow-hidden mb-6" style="background: #0e1118;">
                    <!-- رأس القاعدة -->
                    <div class="relative px-8 py-6 border-b border-[#1c2538]" style="background: linear-gradient(135deg, rgba(25,232,160,.04), transparent);">
                        <div class="absolute right-0 top-0 bottom-0 w-1" style="background: linear-gradient(180deg, #19e8a0, transparent);"></div>
                        <div class="flex items-center gap-4">
                            <span class="w-12 h-12 rounded-xl flex items-center justify-center text-lg font-bold font-mono text-[#19e8a0] border-2 border-[rgba(25,232,160,.35)]" style="background: rgba(25,232,160,.1);">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div>
                                <h2 class="text-xl font-bold text-[#dde4f0]">{{ $rule->title }}</h2>
                                @if($rule->description)
                                <p class="text-sm text-[#8896b3] mt-1">{{ $rule->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- محتوى القاعدة -->
                    <div class="p-8 space-y-6">
                        @foreach($rule->content_blocks as $block)
                            <div id="block-{{ $block->id }}" class="block-content">
                                @if($block->type == 'text')
                                    <div class="p-6 rounded-xl border border-[#1c2538]" style="background: #131824;">
                                        <div class="flex items-center gap-2 mb-4">
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background: rgba(137,150,179,.1);">
                                                <svg width="14" height="14" fill="none" stroke="#8896b3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                            </div>
                                            <span class="text-xs font-bold tracking-wider text-[#8896b3] uppercase">نص</span>
                                        </div>
                                        <p class="text-[#bccae0] leading-relaxed text-lg">{{ $block->content }}</p>
                                    </div>

                                @elseif($block->type == 'math')
                                    <div class="relative rounded-xl border border-[#1c2538] p-8 text-center overflow-hidden" style="background: #050709;">
                                        <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, #19e8a0, transparent);"></div>
                                        <div class="flex items-center gap-2 mb-6 absolute top-4 right-6">
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background: rgba(25,232,160,.1);">
                                                <svg width="14" height="14" fill="none" stroke="#19e8a0" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12h15M12 4.5l7.5 7.5-7.5 7.5"/></svg>
                                            </div>
                                            <span class="text-xs font-bold tracking-wider text-[#19e8a0] uppercase">معادلة</span>
                                        </div>
                                        <div class="text-center mt-8" dir="ltr">
                                            {!! $block->content !!}
                                        </div>
                                    </div>

                                @elseif($block->type == 'image')
                                    <div class="rounded-xl border border-[#1c2538] overflow-hidden">
                                        <div class="px-6 py-4 border-b border-[#1c2538] flex items-center gap-2" style="background: #131824;">
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background: rgba(74,158,255,.1);">
                                                <svg width="14" height="14" fill="none" stroke="#4a9eff" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M8 12l4-4 4 4"/></svg>
                                            </div>
                                            <span class="text-xs font-bold tracking-wider text-[#4a9eff] uppercase">صورة توضيحية</span>
                                        </div>
                                        <img src="{{ asset('storage/' . $block->content) }}" alt="صورة" class="w-full max-h-96 object-contain" style="background: #131824;">
                                    </div>

                                @elseif($block->type == 'exercise')
                                    <div class="relative rounded-xl p-6 overflow-hidden" style="background: linear-gradient(135deg, rgba(251,191,36,.05), rgba(251,146,60,.03)); border: 1px solid rgba(251,191,36,.18);">
                                        <div class="absolute right-0 top-0 bottom-0 w-1" style="background: linear-gradient(180deg, #fbbf24, #fb923c);"></div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background: rgba(251,191,36,.1);">
                                                <svg width="14" height="14" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </div>
                                            <span class="text-xs font-bold tracking-wider text-[#fbbf24] uppercase">تمرين تطبيقي</span>
                                        </div>
                                        <p class="text-[#dde4f0] text-lg mb-6">{{ $block->content }}</p>
                                        <button onclick="toggleSolution({{ $block->id }})" 
                                                class="flex items-center gap-2 px-6 py-3 rounded-xl border border-[rgba(251,191,36,.28)] hover:bg-[rgba(251,191,36,.1)] text-[#fbbf24] text-sm font-medium transition-all">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            عرض الحل
                                        </button>
                                        <div id="solution-{{ $block->id }}" class="hidden mt-6 p-6 rounded-xl text-sm text-[#bccae0] leading-relaxed" style="background: rgba(25,232,160,.05); border: 1px solid rgba(25,232,160,.15);">
                                            الحل سيظهر هنا...
                                        </div>
                                    </div>

                                @elseif($block->type == 'video' && $block->video)
                                    <div class="rounded-xl border border-[#1c2538] overflow-hidden">
                                        <div class="px-6 py-4 border-b border-[#1c2538] flex items-center gap-2" style="background: #131824;">
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background: rgba(248,113,113,.1);">
                                                <svg width="14" height="14" fill="none" stroke="#f87171" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <span class="text-xs font-bold tracking-wider text-[#f87171] uppercase">فيديو توضيحي</span>
                                        </div>
                                        <video controls class="w-full max-h-96" style="background: #000;">
                                            <source src="{{ asset('storage/' . $block->video->file_path) }}" type="video/mp4">
                                        </video>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
function toggleSolution(blockId) {
    const solution = document.getElementById('solution-' + blockId);
    if (solution) {
        solution.classList.toggle('hidden');
    }
}

// نظام التنقل بين المحتوى - يعمل 100%
document.addEventListener('DOMContentLoaded', function() {
    // الحصول على جميع العناصر
    const contentSections = document.querySelectorAll('.content-section');
    const navItems = document.querySelectorAll('.nav-item');
    const emptyState = document.getElementById('empty-state');
    
    // إخفاء كل المحتوى في البداية (باستثناء الحالة الفارغة)
    contentSections.forEach(section => {
        if (section.id !== 'empty-state') {
            section.classList.add('hidden');
        }
    });
    
    // التأكد أن الحالة الفارغة ظاهرة
    if (emptyState) {
        emptyState.classList.remove('hidden');
        emptyState.classList.add('block');
    }
    
    // إضافة حدث النقر لكل عنصر في القائمة
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                // إخفاء جميع أقسام المحتوى
                contentSections.forEach(section => {
                    section.classList.add('hidden');
                });
                
                // إخفاء الحالة الفارغة
                if (emptyState) {
                    emptyState.classList.add('hidden');
                }
                
                // إظهار القسم المطلوب
                targetElement.classList.remove('hidden');
                
                // تمرير الصفحة إلى العنصر
                targetElement.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
                
                // تغيير لون الخلفية للعنصر المحدد
                navItems.forEach(nav => {
                    nav.classList.remove('bg-[rgba(25,232,160,.1)]');
                });
                this.classList.add('bg-[rgba(25,232,160,.1)]');
            }
        });
    });
});
</script>

<style>
.nav-item {
    cursor: pointer;
    transition: all 0.2s ease;
}

.nav-item:hover {
    background: rgba(25,232,160,.04);
}

.nav-item.bg-\[rgba\(25\,232\,160\,\.1\)\] {
    background: rgba(25,232,160,.1);
}

.content-section {
    transition: opacity 0.3s ease;
}

.hidden {
    display: none !important;
}

.block {
    display: block !important;
}

/* تلميحات MathJax */
mjx-container {
    color: #19e8a0 !important;
    font-size: 1.2rem !important;
}
</style>
@endsection