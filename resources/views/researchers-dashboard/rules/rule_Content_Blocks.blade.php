{{-- resources/views/rules/content_blocks_show.blade.php --}}
@extends('layouts.reseacher_dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- MathJax Configuration -->
        <script>
            window.MathJax = {
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']],
                    displayMath: [['$$', '$$'], ['\\[', '\\]']],
                    processEscapes: true
                },
                svg: {
                    fontCache: 'global'
                }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>

        <!-- Modern Header with Gradient -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <!-- Left side: Title and breadcrumb -->
                    <div>
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl shadow-lg flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $rule->title }}</h1>
                                <p class="text-gray-600 mt-1">{{ $rule->description ?? 'عرض محتوى القاعدة' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right side: Action buttons -->
                    <div class="flex items-center gap-3">
                        <!-- Create Button -->
                        <a href="{{ route('rules.content.create', $rule->id) }}" 
                           class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-emerald-200 transition-all duration-200 flex items-center gap-2 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة محتوى جديد
                        </a>
                        
                        <!-- Back Button -->
                        <a href="{{ route('rules.index') }}" 
                           class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-xl transition-all duration-200 flex items-center gap-2 font-medium shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lesson Info Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gradient-to-l from-blue-50 to-indigo-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">الدرس المرتبط</p>
                        <p class="font-bold text-gray-900">{{ $rule->lesson->title ?? 'غير محدد' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Stats -->
        @if(!$rule->content_blocks->isEmpty())
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">الإجمالي</p>
                        <p class="text-xl font-bold text-gray-900">{{ $rule->content_blocks->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            @php
                $textCount = $rule->content_blocks->where('type', 'text')->count();
                $mathCount = $rule->content_blocks->where('type', 'math')->count();
                $imageCount = $rule->content_blocks->where('type', 'image')->count();
                $videoCount = $rule->content_blocks->where('type', 'video')->count();
                $exerciseCount = $rule->content_blocks->where('type', 'exercise')->count();
            @endphp
            
            @if($textCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">نصوص</p>
                        <p class="text-xl font-bold text-gray-900">{{ $textCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-blue-600 text-lg">📝</span>
                    </div>
                </div>
            </div>
            @endif
            
            @if($mathCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">معادلات</p>
                        <p class="text-xl font-bold text-gray-900">{{ $mathCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <span class="text-purple-600 text-lg">📐</span>
                    </div>
                </div>
            </div>
            @endif
            
            @if($imageCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">صور</p>
                        <p class="text-xl font-bold text-gray-900">{{ $imageCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-green-600 text-lg">🖼️</span>
                    </div>
                </div>
            </div>
            @endif
            
            @if($videoCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">فيديوهات</p>
                        <p class="text-xl font-bold text-gray-900">{{ $videoCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <span class="text-red-600 text-lg">🎥</span>
                    </div>
                </div>
            </div>
            @endif
            
            @if($exerciseCount > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">تمارين</p>
                        <p class="text-xl font-bold text-gray-900">{{ $exerciseCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <span class="text-orange-600 text-lg">✏️</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Content Blocks -->
        @if($rule->content_blocks->isEmpty())
            <!-- Modern Empty State -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">لا يوجد محتوى</h3>
                <p class="text-gray-500 text-lg mb-8">لم يتم إضافة أي محتوى لهذه القاعدة بعد</p>
                <a href="{{ route('rules.content.create', $rule->id) }}" 
                   class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-8 py-4 rounded-xl shadow-lg shadow-emerald-200 transition-all duration-200 font-medium text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة أول محتوى
                </a>
            </div>
        @else
            <!-- Content Blocks Timeline -->
            <div class="space-y-6">
                @foreach($rule->content_blocks as $index => $block)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Block Header with Gradient -->
                        <div class="px-6 py-4 bg-gradient-to-l from-gray-50 to-white border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <!-- Modern Number Badge -->
                                <div class="flex items-center gap-2">
                                    <span class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 text-white rounded-xl flex items-center justify-center text-sm font-bold shadow-md">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                        ترتيب {{ $block->block_order + 1 }}
                                    </span>
                                </div>
                                
                                <!-- Modern Type Badge -->
                                <span class="px-4 py-1.5 text-sm font-medium rounded-full flex items-center gap-2
                                    @if($block->type == 'text') bg-blue-100 text-blue-700
                                    @elseif($block->type == 'math') bg-purple-100 text-purple-700
                                    @elseif($block->type == 'image') bg-green-100 text-green-700
                                    @elseif($block->type == 'video') bg-red-100 text-red-700
                                    @else bg-orange-100 text-orange-700
                                    @endif">
                                    @if($block->type == 'text') 
                                        <span>📝</span> نص
                                    @elseif($block->type == 'math') 
                                        <span>📐</span> معادلة
                                    @elseif($block->type == 'image') 
                                        <span>🖼️</span> صورة
                                    @elseif($block->type == 'video') 
                                        <span>🎥</span> فيديو
                                    @else 
                                        <span>✏️</span> تمرين
                                    @endif
                                </span>

                                <!-- Date Badge -->
                                <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1.5 rounded-full">
                                    {{ $block->created_at }}
                                </span>
                            </div>

                            <!-- Modern Action Buttons -->
                            <div class="flex items-center gap-2">
                              
                                
                                <a href="{{ route('rules.content.edit', [$rule->id, $block->id]) }}" 
                                   class="p-2.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-xl transition-all duration-200 group"
                                   title="تعديل">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('rules.content.destroy', [$rule->id, $block->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المحتوى؟');"
                                            class="p-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-all duration-200 group"
                                            title="حذف">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Block Content -->
                        <div class="p-8">
                            @if($block->type == 'math')
                                <!-- Math Equation with Modern Styling -->
                                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-8 overflow-x-auto border border-gray-700">
                                    <div class="text-center text-emerald-400 text-xl font-mono math-equation" dir="ltr">
                                        {!! $block->content !!}
                                    </div>
                                </div>
                            @elseif($block->type == 'image')
                                <!-- Image with Modern Frame -->
                                <div class="bg-gray-50 rounded-2xl p-6 border-2 border-dashed border-gray-200">
                                    <img src="{{ asset('storage/' . $block->content) }}" 
                                         alt="صورة" 
                                         class="rounded-xl max-h-64 mx-auto object-contain shadow-lg">
                                    <p class="text-center text-sm text-gray-500 mt-4 font-mono bg-gray-100 py-2 px-4 rounded-full inline-block mx-auto">
                                        {{ basename($block->content) }}
                                    </p>
                                </div>
                            @elseif($block->type == 'video')
                                <!-- Video Link -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-blue-800">رابط الفيديو</span>
                                    </div>
                                    <a href="{{ $block->content }}" target="_blank" 
                                       class="text-blue-600 break-all hover:text-blue-800 underline decoration-blue-300">
                                        {{ $block->content }}
                                    </a>
                                </div>
                            @elseif($block->type == 'exercise')
                                <!-- Exercise with Modern Styling -->
                                <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 border-r-4 border-orange-500">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                            <span class="text-orange-600 text-lg">✏️</span>
                                        </div>
                                        <span class="font-bold text-orange-800">تمرين</span>
                                    </div>
                                    <div class="text-gray-800 leading-relaxed whitespace-pre-line text-lg">
                                        {{ $block->content }}
                                    </div>
                                </div>
                            @else
                                <!-- Text Content with Modern Typography -->
                                <div class="prose prose-lg max-w-none">
                                    <div class="text-gray-800 leading-relaxed whitespace-pre-line text-lg" style="font-family: 'Tajawal', sans-serif;">
                                        {{ $block->content }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Block Footer -->
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-500">تاريخ الإضافة: {{ $block->created_at }}</span>
                            </div>
                            @if($block->updated_at != $block->created_at)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="text-gray-500">آخر تحديث: {{ $block->updated_at}}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Floating Create Button for Mobile -->
            <div class="fixed bottom-6 left-6 lg:hidden">
                <a href="{{ route('rules.content.create', $rule->id) }}" 
                   class="w-14 h-14 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-full shadow-lg flex items-center justify-center text-white hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Audio Status Indicator - Modern Toast -->
<div id="audioStatus" class="fixed bottom-6 right-6 hidden z-50">
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 transform transition-all duration-300 scale-100">
        <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
            </svg>
        </div>
        <span class="font-medium">جاري قراءة المعادلة...</span>
        <button onclick="stopReading()" class="mr-4 hover:bg-white/20 p-2 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<!-- Speech Synthesis -->
<script>
    // Speech Synthesis
    let speechSynthesis = window.speechSynthesis;
    let currentUtterance = null;
    let audioStatus = document.getElementById('audioStatus');

    function readEquation(equation) {
        // Stop any current reading
        if (speechSynthesis.speaking) {
            speechSynthesis.cancel();
        }
        
        // Show audio status
        audioStatus.classList.remove('hidden');
        
        // Clean the equation for speech
        let cleanEquation = equation
            .replace(/\$\$/g, '')
            .replace(/\$/g, '')
            .replace(/\\/g, '')
            .replace(/\{|\}/g, '')
            .replace(/\\frac/g, ' كسر ')
            .replace(/_/g, ' تحت ')
            .replace(/\^/g, ' أس ')
            .replace(/\\sqrt/g, ' جذر ')
            .replace(/\\int/g, ' تكامل ')
            .replace(/\\sum/g, ' مجموع ')
            .replace(/\\lim/g, ' نهاية ')
            .replace(/\\alpha/g, ' ألفا ')
            .replace(/\\beta/g, ' بيتا ')
            .replace(/\\gamma/g, ' جاما ')
            .replace(/\\pi/g, ' باي ')
            .replace(/\\sin/g, ' جا ')
            .replace(/\\cos/g, ' جتا ')
            .replace(/\\tan/g, ' ظا ')
            .replace(/\\log/g, ' لوغاريتم ')
            .replace(/\\ln/g, ' لوغاريتم طبيعي ')
            .replace(/\\pm/g, ' موجب أو سالب ')
            .replace(/\\times/g, ' في ')
            .replace(/\\div/g, ' على ')
            .replace(/\\leq/g, ' أصغر من أو يساوي ')
            .replace(/\\geq/g, ' أكبر من أو يساوي ')
            .replace(/\\neq/g, ' لا يساوي ')
            .replace(/\\approx/g, ' تقريباً ')
            .replace(/\\infty/g, ' مالانهاية ');
        
        // Create utterance
        currentUtterance = new SpeechSynthesisUtterance(cleanEquation);
        
        // Set language to Arabic
        currentUtterance.lang = 'ar-SA';
        
        // Set rate (speed)
        currentUtterance.rate = 0.9;
        
        // Set pitch
        currentUtterance.pitch = 1;
        
        // On end
        currentUtterance.onend = function() {
            audioStatus.classList.add('hidden');
        };
        
        // On error
        currentUtterance.onerror = function() {
            audioStatus.classList.add('hidden');
            console.log('Error reading equation');
        };
        
        // Speak
        speechSynthesis.speak(currentUtterance);
    }

    function stopReading() {
        if (speechSynthesis.speaking) {
            speechSynthesis.cancel();
            audioStatus.classList.add('hidden');
        }
    }

    // Stop reading on page navigation
    window.addEventListener('beforeunload', function() {
        if (speechSynthesis.speaking) {
            speechSynthesis.cancel();
        }
    });

    // Render MathJax after content loads
    document.addEventListener('DOMContentLoaded', function() {
        if (window.MathJax) {
            MathJax.typesetPromise().then(() => {
                console.log('MathJax rendered successfully');
            }).catch((err) => {
                console.log('MathJax error:', err);
            });
        }
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
    
    body {
        font-family: 'Tajawal', sans-serif;
    }
    
    .prose {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
    }
    
    .bg-gradient-to-l {
        background-size: 200% 200%;
    }
    
    /* Math equation styling */
    .math-equation mjx-container {
        color: #4ade80 !important;
        font-size: 1.3rem !important;
    }
    
    /* RTL adjustments */
    [dir="rtl"] .text-left {
        text-align: right;
    }
    
    [dir="rtl"] .font-mono {
        direction: ltr;
        text-align: center;
    }
    
    /* Modern scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection