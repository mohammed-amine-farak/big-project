@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Lesson Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex-1 text-right">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ $lesson->title }}</h1>
                        <div class="flex items-center gap-4 text-sm text-gray-600 justify-end">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $lesson->created_at->format('Y-m-d') }}</span>
                            </div>
                            @if($lesson->subject)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span>{{ $lesson->subject->name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-600">إعداد وتقديم</p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ $lesson->researcher->name_ar ?? $lesson->researcher->name ?? 'لم يتم تحديد خبير' }}
                            </p>
                            @if($lesson->researcher->researcherProfile->field_of_study ?? false)
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $lesson->researcher->researcherProfile->field_of_study }}
                            </p>
                            @endif
                        </div>
                        <img src="{{ $lesson->researcher->image_url ?? 'https://placehold.co/80x80/3b82f6/ffffff?text=خبير' }}" 
                             alt="{{ $lesson->researcher->name_ar ?? 'صورة الأستاذ' }}" 
                             class="rounded-full w-16 h-16 lg:w-20 lg:h-20 border-4 border-blue-500 object-cover shadow-lg">
                    </div>
                </div>
            </div>
        </div>

        <!-- Lesson Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">محتوى الدرس</h2>
                        <p class="text-sm text-gray-600">المادة التعليمية الأساسية</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="prose prose-lg max-w-none text-right text-gray-700 leading-relaxed">
                    {!! nl2br(e($lesson->content)) !!}
                </div>
            </div>
        </div>

        <!-- Rules Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">القواعد والمفاهيم</h2>
                            <p class="text-sm text-gray-600">
                                {{ $lesson->rules->count() }} قاعدة مع الأمثلة التوضيحية
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if($lesson->rules->count() > 0)
                    <div class="space-y-8">
                        @foreach($lesson->rules as $rule)
                            <!-- Rule Card -->
                            <div class="bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                            قاعدة {{ $loop->iteration }}
                                        </span>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $rule->title }}</h3>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $rule->examples->count() }} مثال
                                    </div>
                                </div>

                                <!-- Rule Description -->
                                <div class="mb-6">
                                    <p class="text-gray-700 leading-relaxed text-right bg-white p-4 rounded-lg border border-gray-200">
                                        {!! nl2br(e($rule->description)) !!}
                                    </p>
                                </div>

                                <!-- Examples -->
                                @if($rule->examples->count() > 0)
                                    <div class="space-y-4">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2 border-gray-200 text-right">
                                            أمثلة توضيحية
                                        </h4>
                                        @foreach($rule->examples as $example)
                                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                                <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                                                    <h5 class="text-md font-bold text-blue-800 text-right">
                                                        {{ $example->example_title }}
                                                    </h5>
                                                </div>
                                                <div class="p-4">
                                                    @if($example->example_description)
                                                    <p class="text-gray-700 mb-4 text-right leading-relaxed">
                                                        {!! nl2br(e($example->example_description)) !!}
                                                    </p>
                                                    @endif

                                                    @if($example->example_text)
                                                    <div class="bg-gray-900 rounded-lg p-4 mb-4 overflow-x-auto">
                                                        <code class="text-green-400 text-sm whitespace-pre-wrap font-mono">
                                                            {!! nl2br(e($example->example_text)) !!}
                                                        </code>
                                                    </div>
                                                    @endif

                                                    @if($example->example_explanation)
                                                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                                        <p class="text-amber-800 text-sm text-right leading-relaxed">
                                                            {!! nl2br(e($example->example_explanation)) !!}
                                                        </p>
                                                    </div>
                                                    @endif

                                                    @if($example->image_url)
                                                    <div class="mt-4">
                                                        <div class="flex justify-center">
                                                            <img src="{{ asset('storage/' . $example->image_url) }}" 
                                                                 alt="{{ $example->image_alt_ar }}" 
                                                                 class="rounded-lg shadow-md max-w-full h-auto max-h-64 object-contain">
                                                        </div>
                                                        @if($example->image_caption_ar)
                                                        <p class="text-sm text-gray-600 text-center mt-2">
                                                            {{ $example->image_caption_ar }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                        <p class="mt-2 text-sm">لا توجد أمثلة لهذه القاعدة بعد</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State for Rules -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد قواعد</h3>
                        <p class="text-gray-500 text-sm mb-6">لم يتم إضافة أي قواعد لهذا الدرس بعد</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
            <a href="{{ route('lessons.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة للدروس
            </a>
            <a href="{{ route('rules.create', ['lesson_id' => $lesson->id]) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200 text-center flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة قاعدة جديدة
            </a>
        </div>
    </div>
</div>

<style>
.prose {
    max-width: none;
}
.prose p {
    margin-bottom: 1rem;
    line-height: 1.8;
}
.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}
</style>
@endsection