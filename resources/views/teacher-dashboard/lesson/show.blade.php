@extends('layouts.teacher_dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-6" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
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
                },
                chtml: {
                    scale: 1.2
                }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js" id="MathJax-script" async></script>

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                        <a href="" class="hover:text-emerald-600 transition">الرئيسية</a>
                        <span>/</span>
                        <a href="" class="hover:text-emerald-600 transition">الدروس</a>
                        <span>/</span>
                        <span class="text-slate-800">عرض الدرس</span>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-800">{{ $lesson->title }}</h1>
                    @if($lesson->subtitle)
                        <p class="text-slate-500 mt-2">{{ $lesson->subtitle }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    
                    <a href="" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column: Lesson Content -->
            <div class="space-y-8">
                <!-- Lesson Content Card -->
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="border-b border-slate-100 bg-gradient-to-l from-emerald-50 via-teal-50 to-cyan-50 px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">محتوى الدرس</h2>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="prose prose-lg max-w-none text-right text-slate-700 leading-relaxed lesson-content">
                            {!! $lesson->content !!}
                        </div>
                    </div>
                </div>

                <!-- Lesson Info Card -->
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <span class="text-slate-500 text-sm">المادة</span>
                            <p class="font-bold text-slate-800 mt-1">{{ $lesson->subject ?? 'غير محدد' }}</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <span class="text-slate-500 text-sm">تاريخ الإنشاء</span>
                            <p class="font-bold text-slate-800 mt-1">{{ $lesson->created_at->format('Y/m/d') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Rules with Examples -->
            <div class="space-y-8">
                @if($lesson->rules->count() > 0)
                    @foreach($lesson->rules as $ruleIndex => $rule)
                        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                            <!-- Rule Header -->
                            <div class="border-b border-slate-100 bg-gradient-to-l from-purple-50 via-pink-50 to-rose-50 px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-purple-200">
                                        {{ $ruleIndex + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-800">{{ $rule->title }}</h3>
                                        @if($rule->description)
                                            <p class="text-slate-500 text-sm mt-1">{{ $rule->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Rule Examples -->
                            @if($rule->examples->count() > 0)
                                <div class="p-6 space-y-6">
                                    @foreach($rule->examples as $exampleIndex => $example)
                                        <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md transition-all">
                                            <!-- Example Header -->
                                            <div class="px-6 py-4 bg-white border-b border-slate-100">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-medium text-slate-500">مثال {{ $ruleIndex + 1 }}.{{ $exampleIndex + 1 }}</span>
                                                    <h4 class="font-bold text-slate-800">{{ $example->example_title }}</h4>
                                                </div>
                                                @if($example->example_description)
                                                    <p class="text-sm text-slate-600 mt-2">{{ $example->example_description }}</p>
                                                @endif
                                            </div>

                                            <!-- Example Content -->
                                            <div class="p-6 space-y-6">
                                                <!-- Equation Display -->
                                                @if($example->example_text)
                                                <div class="equation-container">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="text-xs font-medium px-3 py-1 bg-purple-100 text-purple-700 rounded-full">المعادلة</span>
                                                    </div>
                                                    <div class="equation-display math-equation text-center py-6 px-4" style="direction: ltr;">
                                                        {!! $example->example_text !!}
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Explanation -->
                                                @if($example->example_explanation)
                                                <div class="explanation-container">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="text-xs font-medium px-3 py-1 bg-blue-100 text-blue-700 rounded-full">الشرح</span>
                                                    </div>
                                                    <div class="bg-blue-50 border-r-4 border-blue-500 p-4 rounded-xl">
                                                        <p class="text-blue-900">{{ $example->example_explanation }}</p>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Image -->
                                                @if($example->image_url)
                                                <div class="image-container">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="text-xs font-medium px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full">صورة توضيحية</span>
                                                    </div>
                                                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                                                        <img src="{{ asset('storage/' . $example->image_url) }}" 
                                                             alt="{{ $example->image_alt_ar ?? 'صورة توضيحية' }}" 
                                                             class="rounded-lg max-h-64 mx-auto object-contain">
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <!-- No Rules Placeholder -->
                    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden p-12 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">لا توجد قواعد</h3>
                        <p class="text-slate-500">لم يتم إضافة أي قواعد أو أمثلة لهذا الدرس بعد</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- MathJax Rendering Script -->
<script>
    function renderEquations() {
        if (window.MathJax) {
            MathJax.typesetPromise().then(() => {
                console.log('✅ MathJax: Equations rendered successfully');
                
                // Add visual feedback for rendered equations
                document.querySelectorAll('.equation-display').forEach(eq => {
                    eq.classList.add('equation-rendered');
                });
            }).catch((err) => {
                console.log('❌ MathJax error:', err);
                
                // Fallback display for equations if MathJax fails
                document.querySelectorAll('.equation-display').forEach(eq => {
                    eq.classList.add('equation-fallback');
                });
            });
        }
    }

    // Initial render
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(renderEquations, 100); // Small delay to ensure DOM is ready
    });

    // Re-render if content changes dynamically
    document.addEventListener('math-update', function() {
        renderEquations();
    });

    // Handle dark equations in light mode
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
            .equation-display {
                background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            .equation-display:hover {
                border-color: #94a3b8;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            }
            .equation-rendered {
                border-color: #10b981;
            }
            .equation-fallback {
                background: #1e293b;
                color: #4ade80;
                font-family: 'Courier New', monospace;
                padding: 1.5rem;
                border-radius: 1rem;
                direction: ltr;
            }
            .explanation-container,
            .equation-container,
            .image-container {
                animation: slideIn 0.5s ease-out;
            }
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>

<style>
/* Custom styles for lesson content */
.lesson-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.lesson-content h1,
.lesson-content h2,
.lesson-content h3 {
    color: #1e293b;
    font-weight: 700;
    margin-top: 1.5em;
    margin-bottom: 0.75em;
}

.lesson-content p {
    margin-bottom: 1.25em;
    color: #334155;
}

.lesson-content ul,
.lesson-content ol {
    margin-bottom: 1.25em;
    padding-right: 1.5em;
}

.lesson-content li {
    margin-bottom: 0.5em;
    color: #334155;
}

/* Equation display styles */
.equation-display {
    background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    direction: ltr;
    transition: all 0.3s ease;
}

.equation-display .MathJax {
    font-size: 1.3rem !important;
    color: #0f172a;
}

/* RTL adjustments */
[dir="rtl"] .equation-display {
    text-align: center;
}

/* Hover effects */
.bg-white.rounded-3xl {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.bg-white.rounded-3xl:hover {
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .equation-display .MathJax {
        font-size: 1rem !important;
    }
    
    .px-8 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

/* Print styles */
@media print {
    .bg-gradient-to-br {
        background: white;
    }
    
    .shadow-xl {
        box-shadow: none;
        border: 1px solid #e2e8f0;
    }
    
    .no-print {
        display: none;
    }
}
</style>
@endsection