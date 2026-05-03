{{-- resources/views/admin/classrooms/students.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">👥 إدارة طلاب الفصل</h1>
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="text-gray-600 text-sm">{{ $classroom->class_name_ar }} ({{ $classroom->class_name }})</p>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $classroom->grade_level }}</span>
                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">{{ $classroom->subjects->name ?? 'غير محدد' }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.classrooms.export-students', $classroom) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        تصدير CSV
                    </a>
                    <a href="{{ route('admin.classrooms.index') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">إجمالي الطلاب</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">السعة القصوى</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['max_students'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">المقاعد المتاحة</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['available_seats'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">نسبة الإشغال</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $stats['occupancy_percentage'] }}%</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">طلاب نشطون</p>
                        <p class="text-2xl font-bold text-emerald-600">{{ $stats['active_students'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-600">طلاب غير نشطين</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['inactive_students'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Student Section -->
        @if($stats['available_seats'] > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">➕ إضافة طالب جديد</h3>
                <p class="text-blue-100 text-sm mt-1">أضف طالباً إلى هذا الفصل الدراسي</p>
            </div>
            
            <form action="{{ route('admin.classrooms.add-student', $classroom) }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="student_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            اختر الطالب <span class="text-red-500">*</span>
                        </label>
                        <select name="student_id" 
                                id="student_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">-- اختر الطالب --</option>
                            @foreach($availableStudents as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->user->name ?? 'غير معروف' }} ({{ $student->user->email ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @if($availableStudents->isEmpty())
                            <p class="text-yellow-600 text-xs mt-2">⚠ لا يوجد طلاب متاحين للإضافة</p>
                        @endif
                    </div>
                    
                    <div>
                        <label for="enrollment_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            تاريخ التسجيل
                        </label>
                        <input type="date" 
                               name="enrollment_date" 
                               id="enrollment_date" 
                               value="{{ old('enrollment_date', date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center gap-2"
                            {{ $availableStudents->isEmpty() ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إضافة الطالب
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-yellow-50 border-r-4 border-yellow-500 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="text-yellow-700 font-medium">الفصل مكتمل. لا يمكن إضافة المزيد من الطلاب.</p>
            </div>
        </div>
        @endif

        <!-- Students List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">📋 قائمة الطلاب المسجلين</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $stats['total_students'] }} طالب مسجل في هذا الفصل</p>
            </div>

            @if($enrolledStudents->isEmpty())
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">لا يوجد طلاب</h3>
                    <p class="text-gray-500 mb-4">لم يتم إضافة أي طلاب إلى هذا الفصل بعد</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسم الطالب</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">البريد الإلكتروني</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ التسجيل</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الانضمام</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($enrolledStudents as $index => $studentClassroom)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr($studentClassroom->student->user->name ?? 'ط', 0, 1) }}</span>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $studentClassroom->student->user->name ?? 'غير معروف' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $studentClassroom->student->user->email ?? 'غير معروف' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-600">
                                    {{ $studentClassroom->enrollment_date ? \Carbon\Carbon::parse($studentClassroom->enrollment_date)->format('Y-m-d') : 'غير محدد' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ $studentClassroom->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    @if($studentClassroom->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">نشط</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">غير نشط</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($studentClassroom->is_active)
                                        <form action="{{ route('admin.classrooms.update-student-status', [$classroom, $studentClassroom->student_id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_active" value="0">
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-800 transition" title="تعطيل">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.classrooms.update-student-status', [$classroom, $studentClassroom->student_id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_active" value="1">
                                            <button type="submit" class="text-green-600 hover:text-green-800 transition" title="تفعيل">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.classrooms.remove-student', [$classroom, $studentClassroom->student_id]) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب من الفصل؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition" title="حذف">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
        <div class="mt-4">
            {{-- Pagination if needed --}}
        </div>
    </div>
</div>
@endsection