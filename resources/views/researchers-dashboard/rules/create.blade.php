@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('rules.index') }}" 
                           class="text-gray-500 hover:text-gray-700 transition duration-200 flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة للقواعد
                        </a>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">📚 إضافة قاعدة جديدة</h1>
                    <p class="text-gray-600 text-sm">إنشاء قاعدة تعليمية جديدة مع إمكانية إضافة محتوى متنوع</p>
                </div>
            </div>
        </div>

        @if($lessons->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">لا يوجد دروس</h3>
                    <p class="text-gray-600 mb-4">تحتاج إلى إنشاء درس أولاً قبل إضافة القواعد.</p>
                    <a href="{{ route('lessons.create') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200">
                        إنشاء درس جديد
                    </a>
                </div>
            </div>
        @else
            @if ($errors->any())
                <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="fill-current h-5 w-5 text-red-500 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 1 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm mb-1">حدثت الأخطاء التالية:</p>
                            <ul class="list-disc list-inside text-xs space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Create Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('rules.store') }}" method="POST" class="p-5">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                            <span class="text-blue-600">1.</span> المعلومات الأساسية
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Title Field -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    عنوان القاعدة <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}"
                                       required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       placeholder="أدخل عنوان القاعدة...">
                            </div>
                            
                            <!-- Description Field -->
                           
                            
                            <!-- Lesson Selection -->
                            <div>
                                <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    الدرس المرتبط <span class="text-red-500">*</span>
                                </label>
                               <select name="lessons_id" id="lesson_id" required class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Choose a Lesson --</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }} ({{ $lesson->grade_level }})</option>
                    @endforeach
                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    سيتم إضافة القاعدة إلى هذا الدرس
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Content Preview Info -->
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('rules.index') }}" 
                           class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg transition duration-200 text-center">
                            إلغاء والعودة
                        </a>
                        
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                حفظ القاعدة
                            </button>
                            
                           
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
    // Auto-resize textareas
    document.addEventListener('DOMContentLoaded', function() {
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }
        
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                autoResize(this);
            });
            // Initial resize
            setTimeout(() => autoResize(textarea), 100);
        });
    });
</script>

<style>
    textarea {
        resize: none;
        min-height: 100px;
    }
    
    @media (max-width: 640px) {
        .grid-cols-5 {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endsection