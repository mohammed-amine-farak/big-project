@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex-1 text-right">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">تفاصيل التقرير الإداري</h1>
                    <p class="text-gray-600">عرض كامل المعلومات حول التقرير الإداري المرسل</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="" 
                       class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Report Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-900">معلومات التقرير</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">عنوان التقرير</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $adminReport->title }}</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">وصف التقرير</label>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $adminReport->description }}</p>
                                </div>
                            </div>

                            <!-- Related Documents -->
                            @if($adminReport->related_documents)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">المستندات المرفقة</label>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    @foreach(json_decode($adminReport->related_documents, true) as $document)
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                            <span class="text-sm text-gray-700">{{ $document['name'] ?? 'مستند' }}</span>
                                            <a href="{{ $document['path'] ?? '#' }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                تحميل
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Researcher Response Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-900">رد الباحث</h2>
                    </div>
                    <div class="p-6">
                        @if($adminReport->researcher_response)
                            <!-- Existing Response -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">الرد الحالي</label>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $adminReport->researcher_response }}</p>
                                    @if($adminReport->resolved_at)
                                        <div class="mt-3 pt-3 border-t border-blue-200">
                                            <p class="text-sm text-blue-600">
                                                تم الحل في: {{ $adminReport->resolved_at }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- No Response Yet -->
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                <p class="text-gray-500 text-lg mb-4">لا يوجد رد حتى الآن</p>
                                <p class="text-gray-400 text-sm">يمكنك إضافة رد باستخدام النموذج أدناه</p>
                            </div>
                        @endif

                        <!-- Response Form -->
                        <form action="{{route('admin-reports.update-response', $adminReport->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-4">
                                <!-- Response Textarea -->
                                <div>
                                    <label for="researcher_response" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $adminReport->researcher_response ? 'تعديل الرد' : 'إضافة رد' }}
                                    </label>
                                    <textarea 
                                        id="researcher_response" 
                                        name="researcher_response" 
                                        rows="6" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="اكتب ردك هنا...">{{ old('researcher_response', $adminReport->researcher_response) }}</textarea>
                                    @error('researcher_response')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                

                                <!-- Submit Button -->
                                <div class="flex justify-end gap-3 pt-4">
                                    <a href="" 
                                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                        إلغاء
                                    </a>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                        {{ $adminReport->researcher_response ? 'تحديث الرد' : 'إرسال الرد' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">حالة التقرير</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <!-- Current Status -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">الحالة الحالية:</span>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'under_review' => 'bg-orange-100 text-orange-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'resolved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'closed' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $statusNames = [
                                        'pending' => 'قيد الانتظار',
                                        'under_review' => 'قيد المراجعة',
                                        'in_progress' => 'قيد المعالجة',
                                        'resolved' => 'تم الحل',
                                        'rejected' => 'مرفوض',
                                        'closed' => 'مغلق'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$adminReport->status] }}">
                                    {{ $statusNames[$adminReport->status] }}
                                </span>
                            </div>

                            <!-- Priority -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">الأولوية:</span>
                                @php
                                    $priorityColors = [
                                        'low' => 'bg-green-100 text-green-800',
                                        'medium' => 'bg-blue-100 text-blue-800',
                                        'high' => 'bg-orange-100 text-orange-800',
                                        'critical' => 'bg-red-100 text-red-800'
                                    ];
                                    $priorityNames = [
                                        'low' => 'منخفضة',
                                        'medium' => 'متوسطة',
                                        'high' => 'عالية',
                                        'critical' => 'حرجة'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $priorityColors[$adminReport->priority] }}">
                                    {{ $priorityNames[$adminReport->priority] }}
                                </span>
                            </div>

                            <!-- Report Type -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">نوع التقرير:</span>
                                @php
                                    $typeColors = [
                                        'financial' => 'bg-green-100 text-green-800',
                                        'administrative' => 'bg-blue-100 text-blue-800',
                                        'technical' => 'bg-purple-100 text-purple-800',
                                        'human_resources' => 'bg-pink-100 text-pink-800',
                                        'infrastructure' => 'bg-indigo-100 text-indigo-800',
                                        'academic' => 'bg-cyan-100 text-cyan-800',
                                        'research' => 'bg-orange-100 text-orange-800',
                                        'security' => 'bg-red-100 text-red-800',
                                        'other' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $typeNames = [
                                        'financial' => 'مالي',
                                        'administrative' => 'إداري',
                                        'technical' => 'تقني',
                                        'human_resources' => 'موارد بشرية',
                                        'infrastructure' => 'بنية تحتية',
                                        'academic' => 'أكاديمي',
                                        'research' => 'بحثي',
                                        'security' => 'أمني',
                                        'other' => 'أخرى'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $typeColors[$adminReport->report_type] }}">
                                    {{ $typeNames[$adminReport->report_type] }}
                                </span>
                            </div>

                            <!-- Dates -->
                            <div class="pt-3 border-t border-gray-200 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">تاريخ الإرسال:</span>
                                    <span class="text-xs text-gray-700">{{ $adminReport->created_at }}</span>
                                </div>
                                @if($adminReport->deadline)
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">الموعد النهائي:</span>
                                    <span class="text-xs text-gray-700">{{ $adminReport->deadline}}</span>
                                </div>
                                @endif
                                @if($adminReport->resolved_at)
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">تاريخ الحل:</span>
                                    <span class="text-xs text-gray-700">{{ $adminReport->resolved_at}}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">معلومات ذات صلة</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <!-- Admin Info -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">المرسل (المسؤول)</h4>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">{{ $adminReport->admin->user->name ?? 'غير محدد' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $adminReport->admin->user->email ?? '' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $adminReport->admin->position ?? 'مسؤول' }}</p>
                            </div>
                        </div>

                        <!-- Researcher Info -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">الباحث المسؤول</h4>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">{{ $adminReport->researcher->user->name ?? 'غير محدد' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $adminReport->researcher->user->email ?? '' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $adminReport->researcher->specialization ?? 'باحث' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection