@extends('layouts.student_dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('student.lessons.show', $lesson ?? $exam->lesson) }}" 
               class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                العودة إلى الدرس
            </a>
        </div>

        <!-- Result Card -->
        <div class="rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 overflow-hidden">
            <div class="p-8 text-center border-b border-white/10">
                <div class="w-24 h-24 mx-auto mb-4 rounded-full flex items-center justify-center
                    {{ $passed ? 'bg-emerald-500/20' : 'bg-red-500/20' }}">
                    @if($passed)
                    <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @else
                    <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @endif
                </div>
                
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $exam->title }}</h1>
                <p class="text-slate-400 mb-4">{{ $exam->subject ?? 'نتيجة الاختبار' }}</p>
                
                <div class="inline-block px-6 py-3 rounded-xl text-3xl font-bold
                    {{ $passed ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                    {{ round($scorePercentage, 1) }}%
                </div>
                
                <div class="mt-4 text-slate-400">
                    <span class="text-white font-bold">{{ $correctAnswers }}</span> من <span class="text-white font-bold">{{ $totalQuestions }}</span> إجابة صحيحة
                </div>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="text-center p-4 rounded-xl bg-white/5">
                        <div class="text-2xl font-bold text-emerald-400">{{ round($scorePercentage, 1) }}%</div>
                        <div class="text-xs text-slate-400">نسبة النجاح</div>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-white/5">
                        <div class="text-2xl font-bold text-purple-400">{{ $totalQuestions - $correctAnswers }}</div>
                        <div class="text-xs text-slate-400">إجابات خاطئة</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-white mb-4">تفاصيل الإجابات</h3>
                    
                    @foreach($answers as $index => $answer)
                    <div class="rounded-xl border {{ $answer->is_correct ? 'border-emerald-500/30 bg-emerald-500/5' : 'border-red-500/30 bg-red-500/5' }} p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                @if($answer->is_correct)
                                <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                @else
                                <div class="w-6 h-6 rounded-full bg-red-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-bold text-slate-400">السؤال {{ $index + 1 }}</span>
                                </div>
                                <p class="text-white mb-3">{{ $answer->question->question_text }}</p>
                                <div class="text-sm">
                                    <div class="mb-1">
                                        <span class="text-slate-400">إجابتك: </span>
                                        <span class="{{ $answer->is_correct ? 'text-emerald-400' : 'text-red-400' }}">
                                            {{ $answer->choice->choice_text }}
                                        </span>
                                    </div>
                                    @if(!$answer->is_correct)
                                    <div class="text-emerald-400">
                                        <span class="text-slate-400">الإجابة الصحيحة: </span>
                                        {{ $answer->question->choices->where('is_correct', true)->first()->choice_text }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection