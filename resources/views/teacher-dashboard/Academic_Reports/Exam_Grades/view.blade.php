@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $exam->title }}</h1>
                <div class="flex gap-4 mt-2 text-sm text-gray-600">
                    <span>الصف: {{ $exam->classroom->class_name ?? '' }}</span>
                    <span>المادة: {{ $exam->subject->name ?? '' }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                    🖨️ طباعة
                </button>
                <a href="{{ route('teacher.exams.list') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded text-sm">
                    ↩ رجوع
                </a>
            </div>
        </div>

        <!-- Exam Content -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <!-- If exam has file -->
            @if($exam->file_path)
            <div class="text-center py-8">
                <div class="text-5xl mb-4">📄</div>
                <p class="text-gray-600 mb-4">الاختبار متوفر كملف</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ asset($exam->file_path) }}" 
                       target="_blank"
                       class="bg-green-600 text-white px-4 py-2 rounded text-sm">
                        فتح الملف
                    </a>
                    <a href="{{ asset($exam->file_path) }}" 
                       download
                       class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                        تحميل الملف
                    </a>
                </div>
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-5xl mb-4">📝</div>
                <p class="text-gray-600">لا يوجد ملف للاختبار</p>
                <p class="text-gray-500 text-sm mt-2">يمكنك طباعة هذه الصفحة</p>
            </div>
            @endif

            <!-- Exam Details -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="font-medium text-gray-900 mb-4">تفاصيل الاختبار:</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">الباحث:</p>
                        <p class="font-medium">{{ $exam->researcher->name ?? 'غير معروف' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">تاريخ الإنشاء:</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($exam->created_at)->format('Y/m/d') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    header, aside, .flex.justify-between, a, button {
        display: none !important;
    }
    body {
        padding: 20px !important;
    }
    .bg-white {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }
}
</style>
@endsection