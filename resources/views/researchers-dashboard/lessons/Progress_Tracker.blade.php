@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">تتبع التقدم في الدروس</h1>
                    <p class="text-gray-600 text-sm">مراقبة ومتابعة تقدمك في جميع الدروس</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="#" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للرئيسية
                    </a>
                </div>
            </div>
        </div>

        <!-- Progress Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">إجمالي الدروس</p>
                        <p class="text-lg font-bold text-gray-900">{{ $lessons->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">مكتمل</p>
                        <p class="text-lg font-bold text-gray-900">{{ $lessons->where('status', 'completed')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">قيد التقدم</p>
                        <p class="text-lg font-bold text-gray-900">{{ $lessons->where('status', 'in_progress')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">لم يبدأ</p>
                        <p class="text-lg font-bold text-gray-900">{{ $lessons->where('status', 'not_started')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">تقدم الدروس</h2>
                        <p class="text-sm text-gray-600">تحديث حالة التقدم لكل درس</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                الدرس
                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                المادة
                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                الحالة
                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                تاريخ الإكمال
                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($lessons as $lesson)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-50 rounded flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900 truncate max-w-[200px]">
                                            {{ $lesson->title }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $lesson->created_at }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                    {{ $lesson->subject->name ?? 'غير محدد' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <form action="{{ route('lessons.updateStatus', $lesson->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" 
                                            class="form-select block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 {{ 
                                                $lesson->status == 'completed' ? 'bg-green-50 text-green-700 border-green-200' : 
                                                ($lesson->status == 'in_progress' ? 'bg-amber-50 text-amber-700 border-amber-200' : 
                                                'bg-gray-50 text-gray-700 border-gray-200') 
                                            }}">
                                        <option value="not_started" {{ $lesson->status == 'not_started' ? 'selected' : '' }} class="bg-white text-gray-700">لم يبدأ</option>
                                        <option value="in_progress" {{ $lesson->status == 'in_progress' ? 'selected' : '' }} class="bg-white text-gray-700">قيد التقدم</option>
                                        <option value="completed" {{ $lesson->status == 'completed' ? 'selected' : '' }} class="bg-white text-gray-700">مكتمل</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                @if($lesson->completed_at)
                                    <div class="flex items-center justify-center gap-1 text-green-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $lesson->completed_at}}
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('lessons.show', $lesson->id) }}" 
                                       class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1 rounded text-xs font-medium transition-colors duration-200">
                                        عرض
                                    </a>
                                    <a href="{{ route('lessons.update', $lesson->id) }}" 
                                       class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-3 py-1 rounded text-xs font-medium transition-colors duration-200">
                                        تعديل
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer - Removed pagination since it's a collection -->
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                <div class="text-sm text-gray-700 text-center">
                    عرض 
                    <span class="font-medium">{{ $lessons->count() }}</span>
                    درس
                </div>
            </div>
        </div>

        <!-- Progress Summary -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Progress Chart Placeholder -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ملخص التقدم</h3>
                <div class="space-y-4">
                    @php
                        $total = $lessons->count();
                        $completed = $lessons->where('status', 'completed')->count();
                        $inProgress = $lessons->where('status', 'in_progress')->count();
                        $notStarted = $lessons->where('status', 'not_started')->count();
                        
                        $completedPercent = $total > 0 ? ($completed / $total) * 100 : 0;
                        $inProgressPercent = $total > 0 ? ($inProgress / $total) * 100 : 0;
                        $notStartedPercent = $total > 0 ? ($notStarted / $total) * 100 : 0;
                    @endphp
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-green-600 font-medium">مكتمل</span>
                            <span class="text-gray-600">{{ $completed }} ({{ round($completedPercent) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $completedPercent }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-amber-600 font-medium">قيد التقدم</span>
                            <span class="text-gray-600">{{ $inProgress }} ({{ round($inProgressPercent) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $inProgressPercent }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600 font-medium">لم يبدأ</span>
                            <span class="text-gray-600">{{ $notStarted }} ({{ round($notStartedPercent) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-400 h-2 rounded-full" style="width: {{ $notStartedPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">إجراءات سريعة</h3>
                <div class="space-y-3">
                    <a href="{{ route('lessons.create') }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إنشاء درس جديد
                    </a>
                    <a href="{{ route('lessons.index') }}" 
                       class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        عرض جميع الدروس
                    </a>
                </div>
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