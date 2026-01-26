@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-900 mb-2">📝 الاختبارات</h1>
            <p class="text-gray-600 text-sm">عرض الاختبارات حسب الصف الدراسي</p>
        </div>

        <!-- Simple Filter -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-4 mb-6">
            <form method="GET" class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm text-gray-600 mb-1">الصف الدراسي</label>
                    <div class="flex gap-2">
                        <select name="classroom" class="flex-1 border border-gray-300 rounded p-2 text-sm">
                            <option value="">كل الصفوف</option>
                            @foreach($classrooms as $class)
                            <option value="{{ $class->id }}" {{ request('classroom') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                            تصفية
                        </button>
                        @if(request()->filled('classroom'))
                        <a href="{{ route('teacher.exams.list') }}" class="bg-gray-500 text-white px-4 py-2 rounded text-sm hover:bg-gray-600">
                            إعادة
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Exams Table -->
        <div class="bg-white rounded-lg shadow border border-gray-200">
            @if($exams->isEmpty())
            <div class="p-8 text-center">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-gray-600">لا توجد اختبارات</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">اسم الاختبار</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">الصف</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">المادة</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">الملف</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($exams as $exam)
                        <tr class="hover:bg-gray-50">
                            <!-- Exam Title -->
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $exam->title }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($exam->created_at)->format('Y/m/d') }}
                                </div>
                            </td>
                            
                            <!-- Classroom -->
                            <td class="px-4 py-3">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                    {{ $exam->classroom->class_name ?? 'غير معروف' }}
                                </span>
                            </td>
                            
                            <!-- Subject -->
                            <td class="px-4 py-3">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                    {{ $exam->subject->name ?? 'غير معروف' }}
                                </span>
                            </td>
                            
                            <!-- File -->
                            <td class="px-4 py-3">
                                @if($exam->file_path)
                                <a href="{{ asset($exam->file_path) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <span>📄</span>
                                    <span>فتح الملف</span>
                                </a>
                                @else
                                <span class="text-gray-400 text-sm">لا يوجد ملف</span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('teacher.exams.view', $exam->id) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                        عرض
                                    </a>
                                    <a href="{{ route('teacher.exams.print', $exam->id) }}" 
                                       target="_blank"
                                       class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                                        طباعة
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Simple Pagination -->
            @if($exams->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                <div class="flex justify-center">
                    <div class="flex gap-1">
                        @if (!$exams->onFirstPage())
                        <a href="{{ $exams->previousPageUrl() }}" 
                           class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            السابق
                        </a>
                        @endif
                        
                        @if ($exams->hasMorePages())
                        <a href="{{ $exams->nextPageUrl() }}" 
                           class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            التالي
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection