@extends('layouts.student_dashboard')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl shadow-xl p-6 text-white">
                <h1 class="text-3xl font-bold mb-1">📚 الدروس</h1>
                <p class="text-emerald-100">تصفح جميع الدروس وتابع تقدمك</p>
            </div>
        </div>

        <!-- Subject Selection Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('student.lesson.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        اختر المادة <span class="text-red-500">*</span>
                    </label>
                    <select name="subject_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- اختر المادة --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-medium transition-colors">
                    عرض الدروس
                </button>
            </form>
        </div>

        @if($selectedSubjectId)
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">إجمالي الدروس</p>
                    <p class="text-3xl font-bold">{{ $totalLessons }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">مكتمل</p>
                    <p class="text-3xl font-bold text-green-600">{{ $completedLessons }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">قيد التعلم</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $inProgressLessons }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">لم يبدأ</p>
                    <p class="text-3xl font-bold text-gray-400">{{ $notStartedLessons }}</p>
                </div>
            </div>

            <!-- Continue Learning -->
            @if($lastLessonProgress && $lastLessonProgress->lesson)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">⏯️ استئناف التعلم</h2>
                <div class="bg-gradient-to-l from-emerald-50 to-green-50 p-6 rounded-xl border border-emerald-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $lastLessonProgress->lesson->title }}</h3>
                                <p class="text-gray-600">آخر نشاط: {{ $lastLessonProgress->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-48">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">التقدم</span>
                                    <span class="font-medium text-emerald-600">{{ $lastLessonProgress->progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $lastLessonProgress->progress }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('student.lessons.show', $lastLessonProgress->lesson_id) }}" 
                               class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                                متابعة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Lessons Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($lessonsWithProgress as $item)
                    @php
                        if ($item['status'] == 'completed') {
                            $statusColor = 'bg-green-500';
                            $statusBadge = 'bg-green-100 text-green-700';
                            $statusText = 'مكتمل';
                            $icon = '✅';
                            $buttonText = 'مراجعة';
                            $buttonClass = 'bg-gray-600 hover:bg-gray-700';
                        } elseif ($item['status'] == 'in_progress') {
                            $statusColor = 'bg-emerald-500';
                            $statusBadge = 'bg-emerald-100 text-emerald-700';
                            $statusText = 'قيد التعلم';
                            $icon = '🔄';
                            $buttonText = 'متابعة';
                            $buttonClass = 'bg-emerald-600 hover:bg-emerald-700';
                        } else {
                            $statusColor = 'bg-gray-300';
                            $statusBadge = 'bg-gray-100 text-gray-500';
                            $statusText = 'لم يبدأ';
                            $icon = '📘';
                            $buttonText = 'بدء';
                            $buttonClass = 'bg-emerald-600 hover:bg-emerald-700';
                        }
                    @endphp

                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all">
                        <div class="h-2 {{ $statusColor }}"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-medium {{ $statusBadge }} px-3 py-1 rounded-full">
                                            {{ $icon }} {{ $statusText }}
                                        </span>
                                        @if($item['subject'])
                                        <span class="text-xs font-medium bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                            {{ $item['subject']->name }}
                                        </span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $item['title'] }}</h3>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $item['description'] ?? 'شرح مفصل للدرس...' }}</p>
                            
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-500">التقدم</span>
                                    <span class="font-medium text-emerald-600">{{ $item['progress'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $item['progress'] }}%"></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $item['created_at']->diffForHumans() }}</span>
                                </div>
                                
                                <a href="{{ route('student.lessons.show', $item['id']) }}" 
                                   class="{{ $buttonClass }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    {{ $buttonText }}
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">لا توجد دروس</h3>
                        <p class="text-gray-500">لم يتم إضافة دروس لهذه المادة بعد</p>
                    </div>
                @endforelse
            </div>
        @else
            <!-- لم يختر مادة بعد -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-16 text-center">
                <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 9l4-4 4 4m0 8l-4 4-4-4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">اختر مادة للبدء</h3>
                <p class="text-gray-500 text-lg">الرجاء اختيار مادة من القائمة أعلاه لعرض الدروس</p>
            </div>
        @endif
    </div>
</div>
@endsection