@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- MathJax Configuration -->
        <script>
            window.MathJax = {
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']],
                    displayMath: [['$$', '$$'], ['\\[', '\\]']],
                    processEscapes: true,
                    processEnvironments: true
                },
                options: {
                    skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre'],
                    ignoreHtmlClass: 'tex2jax_ignore',
                    processHtmlClass: 'tex2jax_process'
                },
                svg: {
                    fontCache: 'global'
                }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>

        <!-- Header with Back Button -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('lessons.index') }}" 
                           class="text-gray-500 hover:text-gray-700 transition duration-200 flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة للدروس
                        </a>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">📖 عرض الدرس</h1>
                    <p class="text-gray-600 text-sm">{{ $lesson->title }}</p>
                </div>
                
                
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1">
                        <svg class="fill-current h-5 w-5 text-green-500 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Lesson Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Lesson Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">معلومات الدرس</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xl font-bold text-gray-900 truncate">{{ $lesson->title }}</h4>
                                @if($lesson->subtitle)
                                    <p class="text-gray-600 text-sm">{{ $lesson->subtitle }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">المادة</p>
                                <p class="font-medium text-gray-900">{{ $lesson->subject->name ?? 'غير محدد' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ الإنشاء</p>
                                <p class="font-medium text-gray-900">{{ $lesson->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                        
                        @if($lesson->researcher)
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-2">إعداد وتقديم</p>
                            <div class="flex items-center gap-3">
                                <img src="{{ $lesson->researcher->image_url ?? 'https://placehold.co/40x40/3b82f6/ffffff?text=خبير' }}" 
                                     alt="{{ $lesson->researcher->name_ar ?? 'صورة الخبير' }}" 
                                     class="rounded-full w-10 h-10 border-2 border-blue-500 object-cover">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $lesson->researcher->name_ar ?? $lesson->researcher->name ?? 'خبير' }}</p>
                                    @if($lesson->researcher->researcherProfile && $lesson->researcher->researcherProfile->field_of_study)
                                        <p class="text-xs text-gray-500">{{ $lesson->researcher->researcherProfile->field_of_study }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">إحصائيات الدرس</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">عدد القواعد</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $lesson->rules->count() }}
                            </span>
                        </div>
                        
                        @php
                            $totalBlocks = $lesson->rules->sum(function($rule) {
                                return $rule->content_blocks->count();
                            });
                        @endphp
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">إجمالي العناصر التعليمية</span>
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $totalBlocks }}
                            </span>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-2">آخر تحديث</p>
                            <p class="text-sm text-gray-900">{{ $lesson->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Lesson Content and Rules -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Lesson Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">محتوى الدرس</h3>
                    
                    <div class="prose max-w-none text-gray-700 leading-relaxed lesson-content">
                        {!! $lesson->content !!}
                    </div>
                </div>

                <!-- Rules and Content Blocks -->
                @if($lesson->rules->count() > 0)
                    @foreach($lesson->rules as $ruleIndex => $rule)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                            <!-- Rule Header -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-purple-600 font-bold">{{ $ruleIndex + 1 }}</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $rule->title }}</h3>
                                    @if($rule->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $rule->description }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Content Blocks -->
                            @if($rule->content_blocks && $rule->content_blocks->count() > 0)
                                <div class="space-y-4 mt-4">
                                    @foreach($rule->content_blocks as $blockIndex => $block)
                                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                            <!-- Block Header -->
                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="text-xs text-gray-500">عنصر {{ $ruleIndex + 1 }}.{{ $blockIndex + 1 }}</span>
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                                    @if($block->type == 'text') bg-blue-100 text-blue-700
                                                    @elseif($block->type == 'math') bg-purple-100 text-purple-700
                                                    @elseif($block->type == 'image') bg-green-100 text-green-700
                                                    @elseif($block->type == 'video') bg-red-100 text-red-700
                                                    @else bg-orange-100 text-orange-700
                                                    @endif">
                                                    @if($block->type == 'text') 📝 نص
                                                    @elseif($block->type == 'math') 📐 معادلة
                                                    @elseif($block->type == 'image') 🖼️ صورة
                                                    @elseif($block->type == 'video') 🎥 فيديو
                                                    @else ✏️ تمرين
                                                    @endif
                                                </span>
                                            </div>

                                            <!-- Block Content -->
                                            @if($block->type == 'math')
                                                <div class="equation-display math-equation text-center py-4 px-2 bg-gray-900 rounded-lg" style="direction: ltr;">
                                                    <span class="text-green-400">{!! $block->content !!}</span>
                                                </div>
                                                
                                                @if($block->metadata)
                                                    @php $metadata = json_decode($block->metadata, true); @endphp
                                                    @if(isset($metadata['note']))
                                                        <p class="mt-2 text-xs text-gray-500 text-center">{{ $metadata['note'] }}</p>
                                                    @endif
                                                @endif
                                                
                                            @elseif($block->type == 'image')
                                                <div class="text-center">
                                                    <img src="{{ asset('storage/' . $block->content) }}" 
                                                         alt="صورة توضيحية" 
                                                         class="rounded-lg max-h-64 mx-auto object-contain">
                                                    @if($block->metadata)
                                                        @php $metadata = json_decode($block->metadata, true); @endphp
                                                        @if(isset($metadata['alt']))
                                                            <p class="mt-2 text-sm text-gray-600">{{ $metadata['alt'] }}</p>
                                                        @endif
                                                    @endif
                                                </div>
                                                
                                            @elseif($block->type == 'video')
                                                <div>
                                                    <div class="aspect-w-16 aspect-h-9 bg-gray-800 rounded-lg overflow-hidden">
                                                        <iframe src="{{ $block->content }}" 
                                                                frameborder="0" 
                                                                allowfullscreen
                                                                class="w-full h-48"></iframe>
                                                    </div>
                                                    <a href="{{ $block->content }}" target="_blank" 
                                                       class="mt-2 inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                        </svg>
                                                        فتح الرابط
                                                    </a>
                                                </div>
                                                
                                            @elseif($block->type == 'exercise')
                                                <div class="bg-orange-50 border-r-4 border-orange-500 p-4 rounded-lg">
                                                    <p class="text-orange-900 whitespace-pre-line leading-relaxed">{{ $block->content }}</p>
                                                </div>
                                                
                                            @else
                                                <div class="prose max-w-none">
                                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $block->content }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                    <p class="mt-2 text-gray-500">لا يوجد محتوى لهذه القاعدة</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <!-- No Rules -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">لا توجد قواعد</h3>
                        <p class="text-gray-600">لم يتم إضافة أي قواعد لهذا الدرس بعد</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Print Function -->
<script>
  

    // MathJax rendering
    document.addEventListener('DOMContentLoaded', function() {
        if (window.MathJax) {
            MathJax.typesetPromise().catch(err => console.log('MathJax error:', err));
        }
    });
</script>

<style>
/* Lesson content styling */
.lesson-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.lesson-content p {
    margin-bottom: 1.25rem;
}

/* Equation display */
.equation-display {
    font-family: 'Courier New', monospace;
    overflow-x: auto;
}

.equation-display .MathJax {
    font-size: 1.2rem !important;
}

/* Aspect ratio for videos */
.aspect-w-16 {
    position: relative;
    padding-bottom: 56.25%;
}

.aspect-w-16 iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Print styles */


/* RTL adjustments */
[dir="rtl"] .equation-display {
    text-align: center;
}
</style>
@endsection