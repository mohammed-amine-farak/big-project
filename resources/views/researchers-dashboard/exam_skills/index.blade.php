@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-8xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        📊 تقارير ربط المهارات بالاختبارات
                    </h1>
                    <p class="text-gray-600 text-lg">
                        نظرة شاملة على جميع الاختبارات الأسبوعية والمهارات المرتبطة بها
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('Exam_skill.create') }}"
                       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        ربط جديد
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3 animate-fade-in">
            <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-emerald-800 font-medium">{{ session('success') }}</div>
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">الاختبارات المرتبطة</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $results->total() }}</p>
                        @if(request()->anyFilled(['subject_id', 'exam_title', 'skills_count', 'skill_id']))
                            <p class="text-xs text-gray-500 mt-1">بعد التصفية</p>
                        @endif
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">إجمالي المهارات</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $results->sum('weekly_skills_count') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">متوسط المهارات</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $results->count() > 0 ? round($results->sum('weekly_skills_count') / $results->count(), 1) : 0 }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">الصفحة الحالية</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $results->currentPage() }} / {{ $results->lastPage() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">تصفية النتائج</h2>
                        <p class="text-gray-500 text-sm">تصفية الاختبارات المرتبطة بالمهارات حسب المادة والاختبار والمهارات</p>
                    </div>
                </div>
            </div>

            <form method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <!-- Exam Title Filter -->
                <div>
                    <label for="exam_title" class="block text-sm font-semibold text-gray-700 mb-2">
                        اسم الاختبار
                    </label>
                    <div class="relative">
                        <input type="text" name="exam_title" id="exam_title" value="{{ request('exam_title') }}"
                               placeholder="ابحث باسم الاختبار..."
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Subject Filter -->
                <div>
                    <label for="subject_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        المادة الدراسية
                    </label>
                    <div class="relative">
                        <select name="subject_id" id="subject_id"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white appearance-none">
                            <option value="">جميع المواد</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Skills Count Filter -->
                <div>
                    <label for="skills_count" class="block text-sm font-semibold text-gray-700 mb-2">
                        عدد المهارات
                    </label>
                    <div class="relative">
                        <select name="skills_count" id="skills_count"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white appearance-none">
                            <option value="">أي عدد</option>
                            <option value="1" {{ request('skills_count') == '1' ? 'selected' : '' }}>مهارة واحدة</option>
                            <option value="2" {{ request('skills_count') == '2' ? 'selected' : '' }}>مهارتان</option>
                            <option value="3+" {{ request('skills_count') == '3+' ? 'selected' : '' }}>3 مهارات أو أكثر</option>
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Specific Skill Filter -->
                <div>
                    <label for="skill_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        مهارة محددة
                    </label>
                    <div class="relative">
                        <select name="skill_id" id="skill_id"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white appearance-none">
                            <option value="">جميع المهارات</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ request('skill_id') == $skill->id ? 'selected' : '' }}>
                                    {{ $skill->name }} - {{ $skill->subject->name ?? 'غير محدد' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="lg:col-span-4 flex items-end gap-3">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        تطبيق التصفية
                    </button>
                    
                    <a href="{{ route('Exam_skill.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        إعادة التعيين
                    </a>
                </div>
            </form>

            <!-- Active Filters -->
            <div class="mt-6 pt-6 border-t border-gray-200 {{ request()->anyFilled(['subject_id', 'exam_title', 'skills_count', 'skill_id']) ? '' : 'hidden' }}" id="activeFilters">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-700">التصفيات المطبقة:</h3>
                    <span class="text-sm text-gray-500">({{ $results->total() }} نتيجة)</span>
                </div>
                <div class="flex flex-wrap gap-2" id="filtersContainer">
                    @if(request('exam_title'))
                        <span class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-2 rounded-lg text-sm flex items-center gap-2 font-medium">
                            الاختبار: "{{ request('exam_title') }}"
                            <a href="{{ request()->fullUrlWithQuery(['exam_title' => null]) }}" class="text-blue-500 hover:text-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    @endif

                    @if(request('subject_id'))
                        @php
                            $selectedSubject = $subjects->firstWhere('id', request('subject_id'));
                        @endphp
                        @if($selectedSubject)
                            <span class="bg-purple-50 text-purple-700 border border-purple-200 px-3 py-2 rounded-lg text-sm flex items-center gap-2 font-medium">
                                المادة: {{ $selectedSubject->name }}
                                <a href="{{ request()->fullUrlWithQuery(['subject_id' => null]) }}" class="text-purple-500 hover:text-purple-700 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </span>
                        @endif
                    @endif

                    @if(request('skills_count'))
                        @php
                            $skillsCountText = [
                                '1' => 'مهارة واحدة',
                                '2' => 'مهارتان', 
                                '3+' => '3 مهارات أو أكثر'
                            ][request('skills_count')] ?? request('skills_count');
                        @endphp
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-2 rounded-lg text-sm flex items-center gap-2 font-medium">
                            {{ $skillsCountText }}
                            <a href="{{ request()->fullUrlWithQuery(['skills_count' => null]) }}" class="text-emerald-500 hover:text-emerald-700 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    @endif

                    @if(request('skill_id'))
                        @php
                            $selectedSkill = $skills->firstWhere('id', request('skill_id'));
                        @endphp
                        @if($selectedSkill)
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 px-3 py-2 rounded-lg text-sm flex items-center gap-2 font-medium">
                                المهارة: {{ $selectedSkill->name }}
                                <a href="{{ request()->fullUrlWithQuery(['skill_id' => null]) }}" class="text-amber-500 hover:text-amber-700 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">الاختبارات المرتبطة بالمهارات</h3>
                        <p class="text-gray-500 text-sm">قائمة بجميع الاختبارات التي تحتوي على مهارات مرتبطة</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        عرض <span class="font-semibold text-gray-700">{{ $results->count() }}</span> من أصل <span class="font-semibold text-gray-700">{{ $results->total() }}</span> اختبار
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                الاختبار الأسبوعي
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                عدد المهارات
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                المهارات المرتبطة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($results as $exam)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-semibold text-gray-900">{{ $exam->title }}</div>
                                            @if($exam->subject)
                                                <div class="text-sm text-gray-500">{{ $exam->subject->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium border border-emerald-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        {{ $exam->weekly_skills_count }} مهارة
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1 justify-center">
                                        @foreach($exam->weeklySkills->take(3) as $weeklySkill)
                                            @if($weeklySkill->levelSkill && $weeklySkill->levelSkill->skill)
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                    {{ $weeklySkill->levelSkill->skill->name }}
                                                    @if($weeklySkill->levelSkill->level)
                                                        (مستوى {{ $weeklySkill->levelSkill->level }})
                                                    @endif
                                                </span>
                                            @endif
                                        @endforeach
                                        @if($exam->weekly_skills_count > 3)
                                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-medium">
                                                +{{ $exam->weekly_skills_count - 3 }} أخرى
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('exam-skills.show', $exam->id) }}" 
                                           class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            التفاصيل
                                        </a>
                                        
                                        <form action="{{ route('exam-skills.delete', $exam->id) }}" method="POST" 
                                              onsubmit="return confirm('هل أنت متأكد من حذف جميع مهارات هذا الاختبار؟')">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 bg-red-50 text-red-600 hover:bg-red-100 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                حذف الكل
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                        <div class="text-lg font-medium text-gray-500">لا توجد اختبارات مرتبطة</div>
                                        <p class="text-sm">لم يتم العثور على أي اختبارات تحتوي على مهارات مرتبطة</p>
                                        <a href="{{ route('Exam_skill.create') }}" 
                                           class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 inline-flex items-center gap-2 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            إنشاء ربط جديد
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($results->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Showing results info -->
                    <div class="text-sm text-gray-700">
                        عرض 
                        <span class="font-semibold">{{ $results->firstItem() ?? 0 }}</span>
                        إلى
                        <span class="font-semibold">{{ $results->lastItem() ?? 0 }}</span>
                        من أصل
                        <span class="font-semibold">{{ $results->total() }}</span>
                        نتيجة
                    </div>

                    <!-- Pagination Links -->
                    <nav class="flex items-center space-x-2 space-x-reverse">
                        <!-- Previous Page Link -->
                        @if($results->onFirstPage())
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-default">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                السابق
                            </span>
                        @else
                            <a href="{{ $results->previousPageUrl() }}" 
                               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                السابق
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        <div class="hidden md:flex space-x-1 space-x-reverse">
                            @foreach($results->getUrlRange(1, $results->lastPage()) as $page => $url)
                                @if($page == $results->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-600 rounded-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        <!-- Mobile Page Info -->
                        <div class="md:hidden text-sm text-gray-700 font-medium">
                            {{ $results->currentPage() }} / {{ $results->lastPage() }}
                        </div>

                        <!-- Next Page Link -->
                        @if($results->hasMorePages())
                            <a href="{{ $results->nextPageUrl() }}" 
                               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                التالي
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-default">
                                التالي
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const examTitleInput = document.getElementById('exam_title');
    const subjectSelect = document.getElementById('subject_id');
    const skillsCountSelect = document.getElementById('skills_count');
    const skillSelect = document.getElementById('skill_id');

    // Real-time search for exam title
    let searchTimeout;
    examTitleInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });

    // Auto-submit on select changes
    [subjectSelect, skillsCountSelect, skillSelect].forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out;
}

select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: left 0.75rem center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
    padding-right: 2.5rem;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}
</style>
@endsection