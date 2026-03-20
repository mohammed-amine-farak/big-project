@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-4 md:p-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto">
        <!-- Header with decorative element -->
        <div class="flex items-center justify-between mb-8">
            <div class="relative">
                <h1 class="text-3xl font-bold text-gray-900">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                        ➕ طلب إنتاج فيديو جديد
                    </span>
                </h1>
                <p class="text-gray-600 mt-2 text-lg">أنشئ طلباً متكاملاً لفيديو تعليمي بكل التفاصيل</p>
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute -bottom-8 -left-6 w-24 h-24 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            </div>
            <a href="" class="group flex items-center gap-2 bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-white hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="font-medium">العودة للقائمة</span>
            </a>
        </div>

        <!-- Enhanced Error Messages -->
        @if($errors->any())
        <div class="bg-red-50 border-r-4 border-red-500 rounded-xl p-5 mb-8 shadow-sm animate-slideDown">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-base font-semibold text-red-800">يوجد {{ $errors->count() }} خطأ {{ $errors->count() > 1 ? 'في النموذج' : '' }}</h4>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <div class="bg-gradient-to-l from-blue-600 to-indigo-600 px-8 py-5">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    معلومات الطلب الأساسية
                </h2>
            </div>
            
            <div class="p-8">
                <form action="{{route('researcher.production_requests.store')}}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title with icon -->
                    <div class="group">
                        <label for="title" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </span>
                            عنوان الطلب <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300"
                               placeholder="مثال: شرح قاعدة النحو للمبتدئين">
                        @error('title')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="group">
                        <label for="description" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </span>
                            وصف الطلب <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4" required
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300"
                                  placeholder="اشرح بالتفصيل محتوى الفيديو المطلوب، العناصر الرئيسية، أي متطلبات خاصة...">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            اذكر التفاصيل المهمة: نوع الفيديو، العناصر المطلوبة، أي تعليمات خاصة
                        </p>
                        @error('description')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Grid: Lesson & Rule -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Lesson -->
                        <div class="group">
                            <label for="lesson_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </span>
                                الدرس المرتبط <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="lesson_id" name="lesson_id" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 group-hover:border-gray-300">
                                    <option value="" disabled selected>اختر الدرس...</option>
                                    @foreach($lessons as $lesson)
                                        <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                            {{ $lesson->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('lesson_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rule (dynamic) -->
                        <div class="group relative">
                            <label for="rule_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                القاعدة المرتبطة (اختياري)
                            </label>
                            <div class="relative">
                                <select id="rule_id" name="rule_id" disabled
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-gray-50 transition-all duration-200">
                                    <option value="">اختر الدرس أولاً...</option>
                                </select>
                                <input type="hidden" id="rule_id_hidden" name="rule_id" value="{{ old('rule_id') }}">
                                <div id="rules_loading" class="hidden absolute left-3 top-1/2 transform -translate-y-1/2">
                                    <div class="w-5 h-5 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                                </div>
                            </div>
                            @error('rule_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Content Block -->
                    <div class="group">
                        <label for="content_block_id" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                </svg>
                            </span>
                            كتلة المحتوى (اختياري)
                        </label>
                        <div class="relative">
                            <select id="content_block_id" name="content_block_id" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-gray-50 transition-all duration-200">
                                <option value="">اختر القاعدة أولاً...</option>
                            </select>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            إذا كان الطلب خاصاً بكتلة محتوى معينة داخل القاعدة
                        </p>
                        @error('content_block_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Video Creator Selection - Modern Cards -->
                    <div class="mb-8">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-4">
                            <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            اختر منشئ الفيديو <span class="text-red-500">*</span>
                        </label>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            @foreach($videoCreators as $creator)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="video_creator_id" value="{{ $creator->id }}" 
                                       class="hidden peer" {{ old('video_creator_id') == $creator->id ? 'checked' : '' }} required>
                                
                                <div class="relative h-full p-5 bg-white border-2 border-gray-200 rounded-xl 
                                            peer-checked:border-blue-500 peer-checked:bg-blue-50/50
                                            group-hover:border-blue-300 group-hover:shadow-lg
                                            transition-all duration-300 overflow-hidden">
                                    
                                    <!-- Background gradient effect on hover -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="relative flex items-start gap-4 z-10">
                                        <!-- Avatar with gradient -->
                                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 
                                                    flex items-center justify-center text-white font-bold text-2xl shadow-md
                                                    transform group-hover:scale-105 transition-transform duration-300">
                                            {{ substr($creator->user->name, 0, 2) }}
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 text-lg truncate">{{ $creator->user->name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $creator->specialization }}</p>
                                            
                                            <!-- Badges -->
                                            <div class="flex items-center gap-2 mt-3 flex-wrap">
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $creator->completed_videos ?? 0 }} فيديو
                                                </span>
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    {{ number_format($creator->average_rating ?? 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Radio indicator with animation -->
                                        <div class="relative w-6 h-6 rounded-full border-2 border-gray-300 
                                                    peer-checked:border-blue-500 peer-checked:border-4
                                                    transition-all duration-200
                                                    after:content-[''] after:absolute after:inset-1 after:rounded-full after:bg-blue-500 
                                                    after:scale-0 peer-checked:after:scale-100 after:transition-transform after:duration-200">
                                        </div>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reference File Upload -->
                    <div class="group">
                        <label for="reference_file" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                            </span>
                            ملف مرجعي (PDF, Word)
                        </label>
                        <div class="relative">
                            <input type="file" id="reference_file" name="reference_file" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200">
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            يمكنك رفع ملف PDF أو Word يحتوي على شرح إضافي (اختياري)
                        </p>
                        @error('reference_file')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deadline & Priority Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Deadline -->
                        <div class="group">
                            <label for="deadline" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                تاريخ التسليم المطلوب
                            </label>
                            <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}"
                                   min="{{ date('Y-m-d') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300">
                            <p class="text-xs text-gray-500 mt-2">اختياري - إذا لم تحدد، سيتفق معك منشئ الفيديو على الموعد</p>
                            @error('deadline')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div class="group">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
                                <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                الأولوية
                            </label>
                            <div class="flex flex-wrap gap-3">
                                <label class="flex items-center gap-2 px-4 py-2 border-2 border-gray-200 rounded-xl has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition-all duration-200 cursor-pointer">
                                    <input type="radio" name="priority" value="low" class="w-4 h-4 text-blue-600" {{ old('priority', 'medium') == 'low' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">منخفضة</span>
                                </label>
                                <label class="flex items-center gap-2 px-4 py-2 border-2 border-gray-200 rounded-xl has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition-all duration-200 cursor-pointer">
                                    <input type="radio" name="priority" value="medium" class="w-4 h-4 text-blue-600" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">متوسطة</span>
                                </label>
                                <label class="flex items-center gap-2 px-4 py-2 border-2 border-gray-200 rounded-xl has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition-all duration-200 cursor-pointer">
                                    <input type="radio" name="priority" value="high" class="w-4 h-4 text-blue-600" {{ old('priority') == 'high' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">عالية</span>
                                </label>
                                <label class="flex items-center gap-2 px-4 py-2 border-2 border-gray-200 rounded-xl has-[:checked]:border-red-500 has-[:checked]:bg-red-50 transition-all duration-200 cursor-pointer">
                                    <input type="radio" name="priority" value="urgent" class="w-4 h-4 text-red-600" {{ old('priority') == 'urgent' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">عاجل</span>
                                </label>
                            </div>
                            @error('priority')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="group">
                        <label for="notes" class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </span>
                            ملاحظات إضافية
                        </label>
                        <textarea id="notes" name="notes" rows="3" 
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300"
                                  placeholder="أي ملاحظات إضافية لمنشئ الفيديو...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-8 border-t border-gray-200">
                        <a href="" 
                           class="px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium text-center">
                            إلغاء
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 flex items-center justify-center gap-2 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إنشاء الطلب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript remains the same but with minor enhancements -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lessonSelect = document.getElementById('lesson_id');
    const ruleSelect = document.getElementById('rule_id');
    const ruleHidden = document.getElementById('rule_id_hidden');
    const contentBlockSelect = document.getElementById('content_block_id');
    const rulesLoading = document.getElementById('rules_loading');

    // Load rules when lesson changes
    lessonSelect.addEventListener('change', async function() {
        const lessonId = this.value;
        
        // Reset selects
        ruleSelect.innerHTML = '<option value="">اختر القاعدة...</option>';
        ruleSelect.disabled = true;
        ruleSelect.classList.add('bg-gray-50');
        contentBlockSelect.innerHTML = '<option value="">اختر القاعدة أولاً...</option>';
        contentBlockSelect.disabled = true;
        contentBlockSelect.classList.add('bg-gray-50');
        
        if (!lessonId) return;

        // Show loading
        rulesLoading.classList.remove('hidden');
        
        try {
            const response = await fetch(`/ajax/get-lesson-rules/${lessonId}`);
            const data = await response.json();
            
            if (data.success && data.rules.length > 0) {
                ruleSelect.disabled = false;
                ruleSelect.classList.remove('bg-gray-50');
                
                data.rules.forEach(rule => {
                    const option = document.createElement('option');
                    option.value = rule.id;
                    option.textContent = rule.title;
                    ruleSelect.appendChild(option);
                });

                // Restore old value if exists
                if (ruleHidden.value) {
                    ruleSelect.value = ruleHidden.value;
                    ruleSelect.dispatchEvent(new Event('change'));
                }
            } else {
                ruleSelect.innerHTML = '<option value="">لا توجد قواعد لهذا الدرس</option>';
            }
        } catch (error) {
            console.error('Error loading rules:', error);
            ruleSelect.innerHTML = '<option value="">حدث خطأ في التحميل</option>';
        } finally {
            rulesLoading.classList.add('hidden');
        }
    });

    // Load content blocks when rule changes
    ruleSelect.addEventListener('change', async function() {
        const ruleId = this.value;
        ruleHidden.value = ruleId;
        
        // Reset content blocks select
        contentBlockSelect.innerHTML = '<option value="">اختر كتلة المحتوى...</option>';
        contentBlockSelect.disabled = true;
        contentBlockSelect.classList.add('bg-gray-50');
        
        if (!ruleId) return;

        // Show loading
        rulesLoading.classList.remove('hidden');
        
        try {
            const response = await fetch(`/ajax/get-rule-content-blocks/${ruleId}`);
            const data = await response.json();
            
            if (data.success && data.contentBlocks.length > 0) {
                contentBlockSelect.disabled = false;
                contentBlockSelect.classList.remove('bg-gray-50');
                
                // Add empty option
                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = 'بدون كتلة محددة';
                contentBlockSelect.appendChild(emptyOption);
                
                data.contentBlocks.forEach(block => {
                    const option = document.createElement('option');
                    option.value = block.id;
                    option.textContent = `${block.type} - ${block.content.substring(0, 50)}...`;
                    contentBlockSelect.appendChild(option);
                });
            } else {
                contentBlockSelect.innerHTML = '<option value="">لا توجد كتل محتوى لهذه القاعدة</option>';
            }
        } catch (error) {
            console.error('Error loading content blocks:', error);
            contentBlockSelect.innerHTML = '<option value="">حدث خطأ في التحميل</option>';
        } finally {
            rulesLoading.classList.add('hidden');
        }
    });

    // Trigger change if old values exist
    if (lessonSelect.value) {
        lessonSelect.dispatchEvent(new Event('change'));
    }
});
</script>

<!-- Add some custom animations -->
<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slideDown {
    animation: slideDown 0.3s ease-out;
}
</style>
@endsection