{{-- resources/views/admin/fields_of_study/show.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">📖 تفاصيل مجال الدراسة</h1>
                    <p class="text-gray-600 text-sm mt-1">عرض معلومات مجال الدراسة</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.fields-of-study.edit', $field) }}" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        تعديل
                    </a>
                    <a href="{{ route('admin.fields-of-study.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">{{ $field->name }}</h3>
                <p class="text-blue-100 text-sm mt-1">معلومات أساسية عن مجال الدراسة</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">اسم المجال</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $field->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">المستوى الدراسي</p>
                        @php
                            $levelTexts = [
                                'Common Core' => 'السنة الأولى إعدادي',
                                'First Baccalaureate' => 'الأولى باكالوريا',
                                'Second Baccalaureate' => 'الثانية باكالوريا'
                            ];
                        @endphp
                        <p class="text-lg font-semibold text-gray-900">{{ $levelTexts[$field->study_level] ?? $field->study_level }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">تاريخ الإضافة</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $field->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
                @if($field->description)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500 mb-1">الوصف</p>
                    <p class="text-gray-700">{{ $field->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['subjects_count'] }}</p>
                <p class="text-sm text-gray-500">المواد الدراسية</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['students_count'] }}</p>
                <p class="text-sm text-gray-500">الطلاب المسجلين</p>
            </div>
            
           
        </div>

        <!-- Subjects List -->
        @if($subjects->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">📚 المواد الدراسية التابعة لهذا المجال</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">اسم المادة</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">عدد الدروس</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">عدد الامتحانات</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">تاريخ الإضافة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($subjects as $subject)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-blue-100 rounded flex items-center justify-center">
                                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-900">{{ $subject->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                    {{ $subject->lessons_count }} دروس
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs">
                                    {{ $subject->exams_count }} امتحانات
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-500">
                                {{ $subject->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Recent Students -->
        @if($recentStudents->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">🎓 أحدث الطلاب المسجلين في هذا المجال</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">اسم الطالب</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">البريد الإلكتروني</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">تاريخ التسجيل</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentStudents as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-emerald-600">{{ substr($student->user->name ?? '?', 0, 1) }}</span>
                                    </div>
                                    <span class="text-gray-900">{{ $student->user->name ?? 'غير معروف' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">
                                {{ $student->user->email ?? 'غير معروف' }}
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-500">
                                {{ $student->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection