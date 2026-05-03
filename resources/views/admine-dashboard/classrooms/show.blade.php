{{-- resources/views/admin/classrooms/show.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">📋 تفاصيل الفصل الدراسي</h1>
                        @if($classroom->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">نشط</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-full text-xs">غير نشط</span>
                        @endif
                    </div>
                    <p class="text-gray-600 text-sm mt-1">عرض معلومات الفصل الدراسي والطلاب المسجلين</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.classrooms.edit', $classroom) }}" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        تعديل
                    </a>
                    <a href="{{ route('admin.classrooms.students', $classroom) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        إدارة الطلاب
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

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
        </div>

        <!-- Main Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Classroom Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">📚 معلومات الفصل</h3>
                    <p class="text-blue-100 text-sm mt-1">البيانات الأساسية للفصل الدراسي</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">اسم الفصل (بالإنجليزية)</span>
                            <span class="font-medium text-gray-900">{{ $classroom->class_name }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">اسم الفصل (بالعربية)</span>
                            <span class="font-medium text-gray-900">{{ $classroom->class_name_ar }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">المستوى الدراسي</span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $classroom->grade_level }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">السنة الدراسية</span>
                            <span class="font-medium text-gray-900">{{ $classroom->studyYear->year_name_ar ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">المدرسة</span>
                            <span class="font-medium text-gray-900">{{ $classroom->school->name ?? 'غير معروف' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">تاريخ الإنشاء</span>
                            <span class="font-medium text-gray-900">{{ $classroom->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">آخر تحديث</span>
                            <span class="font-medium text-gray-900">{{ $classroom->updated_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teacher and Subject Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">👨‍🏫 معلومات المعلم والمادة</h3>
                    <p class="text-emerald-100 text-sm mt-1">تفاصيل المعلم والمادة الدراسية</p>
                </div>
                <div class="p-6">
                    <!-- Teacher Information -->
                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">المعلم</h4>
                                <p class="text-gray-900 font-medium">{{ $classroom->teacher->user->name ?? 'غير معروف' }}</p>
                                <p class="text-sm text-gray-500">تخصص: {{ $classroom->teacher->subject ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500">البريد الإلكتروني:</span>
                                <p class="text-gray-900">{{ $classroom->teacher->user->email ?? 'غير معروف' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">رقم الهاتف:</span>
                                <p class="text-gray-900">{{ $classroom->teacher->phone ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Subject Information -->
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">المادة الدراسية</h4>
                                <p class="text-gray-900 font-medium">{{ $classroom->subjects->name ?? 'غير معروف' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500">المجال:</span>
                                <p class="text-gray-900">{{ $classroom->subjects->fieldOfStudy->name ?? 'غير محدد' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">المستوى:</span>
                                <p class="text-gray-900">{{ $classroom->subjects->fieldOfStudy->study_level ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Card -->
        @if($classroom->description)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">📝 وصف الفصل</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 leading-relaxed">{{ $classroom->description }}</p>
            </div>
        </div>
        @endif

        <!-- Students List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">📋 قائمة الطلاب المسجلين</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $stats['total_students'] }} طالب مسجل في هذا الفصل</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            نشط: {{ $stats['active_students'] }}
                        </span>
                        <span class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded-full">
                            غير نشط: {{ $stats['inactive_students'] }}
                        </span>
                    </div>
                </div>
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
                    <a href="{{ route('admin.classrooms.students', $classroom) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        إضافة طلاب
                    </a>
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
                             </tr>
                            @endforeach
                        </tbody>
                     </table>
                </div>
                
                @if($enrolledStudents->count() > 10)
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('admin.classrooms.students', $classroom) }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1 justify-end">
                        عرض جميع الطلاب ({{ $enrolledStudents->count() }})
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                @endif
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
            <form action="{{ route('admin.classrooms.destroy', $classroom) }}" method="POST" class="inline" 
                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الفصل؟ سيتم حذف جميع بيانات الطلاب المرتبطة به.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    حذف الفصل
                </button>
            </form>
        </div>
    </div>
</div>
@endsection