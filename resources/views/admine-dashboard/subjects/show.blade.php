{{-- resources/views/admin/subjects/show.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📖 تفاصيل المادة</h1>
            <p class="text-gray-600 text-sm mt-1">عرض معلومات المادة الدراسية</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">معلومات المادة</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">اسم المادة</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $subject->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">مجال الدراسة</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $subject->fieldOfStudy->name ?? 'غير محدد' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">المستوى الدراسي</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $subject->fieldOfStudy->study_level ?? 'غير محدد' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">تاريخ الإضافة</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $subject->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['lessons_count'] }}</p>
                <p class="text-sm text-gray-500">الدروس</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['exams_count'] }}</p>
                <p class="text-sm text-gray-500">الامتحانات</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['classrooms_count'] }}</p>
                <p class="text-sm text-gray-500">الصفوف</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                العودة
            </a>
            <a href="{{ route('admin.subjects.edit', $subject) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                تعديل
            </a>
        </div>
    </div>
</div>
@endsection