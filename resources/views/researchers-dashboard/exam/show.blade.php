@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">تفاصيل الاختبار</h1>
                    <p class="text-gray-600 text-sm">عرض كامل المعلومات والتفاصيل الخاصة بالاختبار</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('exam.index') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>

        <!-- Exam Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $exam->title }}</h2>
                        <p class="text-sm text-gray-600">معلومات أساسية عن الاختبار</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $exam->status === 'active' ? 'bg-green-100 text-green-800' : ($exam->status === 'upcoming' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $exam->status === 'active' ? 'نشط' : ($exam->status === 'upcoming' ? 'قادم' : 'منتهي') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">الدرس المرتبط</p>
                                <p class="text-gray-900">{{ $exam->lesson->title ?? 'غير محدد' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">تاريخ الإنشاء</p>
                                <p class="text-gray-900">{{ $exam->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Time Info -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">وقت البدء</p>
                                <p class="text-gray-900">{{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d H:i') : 'غير محدد' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">وقت الانتهاء</p>
                                <p class="text-gray-900">{{ $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d H:i') : 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('exam.edit', $exam->id) }}" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        تعديل الاختبار
                    </a>
                    
                    <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('هل أنت متأكد من حذف هذا الاختبار؟ سيتم حذف جميع الأسئلة المرتبطة به.');"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            حذف الاختبار
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">أسئلة الاختبار</h2>
                            <p class="text-sm text-gray-600">
                                {{ $exam->questions->count() }} 
                                سؤال ({{ $exam->questions->sum(fn($q) => $q->choices->count()) }} خيار)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if ($exam->questions->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.5 20.5l-.5-.5a7.5 7.5 0 100-11l.5.5M14.5 3.5l.5.5a7.5 7.5 0 100 11l-.5-.5"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">لا يوجد أسئلة</h3>
                        <p class="text-gray-500 text-sm mb-6">لم يتم إضافة أي أسئلة لهذا الاختبار بعد</p>
                        <a href="{{ route('exam.edit', $exam->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 inline-flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة أسئلة
                        </a>
                    </div>
                @else
                    <!-- Questions List -->
                    <div class="space-y-6">
                        @foreach ($exam->questions as $index => $question)
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                            سؤال {{ $index + 1 }}
                                        </span>
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                            {{ $question->type ?? 'اختيار متعدد' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $question->choices->count() }} خيارات
                                    </div>
                                </div>

                                <!-- Question Text -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">نص السؤال:</h3>
                                    <p class="text-gray-700 bg-white p-4 rounded-lg border border-gray-200">{{ $question->question_text }}</p>
                                </div>

                                <!-- Choices -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 mb-3">خيارات الإجابة:</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach ($question->choices as $choiceIndex => $choice)
                                            <div class="bg-white rounded-lg border-2 p-4 transition-all duration-200 {{ $choice->is_correct ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex items-center gap-2 flex-1">
                                                        <span class="bg-gray-100 text-gray-600 w-6 h-6 rounded-full flex items-center justify-center text-sm font-medium">
                                                            {{ $choiceLetters[$choiceIndex] ?? $choiceIndex + 1 }}
                                                        </span>
                                                        <span class="text-gray-700 {{ $choice->is_correct ? 'font-medium' : '' }}">
                                                            {{ $choice->choice_text }}
                                                        </span>
                                                    </div>
                                                    @if ($choice->is_correct)
                                                        <div class="flex items-center gap-1 text-green-600">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                            <span class="text-xs font-medium">صحيحة</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}
</style>
@endsection