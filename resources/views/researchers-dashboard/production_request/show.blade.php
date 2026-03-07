@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">📋 تفاصيل طلب الإنتاج</h1>
                <p class="text-sm text-gray-500 mt-1">طلب #{{ $production_request->id }}: {{ $production_request->title }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('researcher.production_requests.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
                
                @if($production_request->status == 'pending')
                <a href="{{ route('researcher.production_requests.edit', $production_request->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل
                </a>
                @endif
            </div>
        </div>

        <!-- Status Badge & Priority -->
        <div class="flex flex-wrap gap-3 mb-6">
            @php
                $statusColors = [
                    'pending' => 'bg-gray-100 text-gray-800 border-gray-300',
                    'accepted' => 'bg-blue-100 text-blue-800 border-blue-300',
                    'submitted' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                    'revision_required' => 'bg-orange-100 text-orange-800 border-orange-300',
                    'approved' => 'bg-green-100 text-green-800 border-green-300',
                    'rejected' => 'bg-red-100 text-red-800 border-red-300'
                ];
                $statusTexts = [
                    'pending' => 'في الانتظار',
                    'accepted' => 'قيد التنفيذ',
                    'submitted' => 'بانتظار المراجعة',
                    'revision_required' => 'يحتاج تعديل',
                    'approved' => 'مكتمل',
                    'rejected' => 'مرفوض'
                ];
                
                $priorityColors = [
                    'low' => 'bg-gray-50 text-gray-600',
                    'medium' => 'bg-blue-50 text-blue-600',
                    'high' => 'bg-orange-50 text-orange-600',
                    'urgent' => 'bg-red-50 text-red-600'
                ];
            @endphp
            
            <span class="px-3 py-1.5 rounded-full text-sm font-medium border {{ $statusColors[$production_request->status] }}">
                {{ $statusTexts[$production_request->status] }}
            </span>
            
            @if($production_request->priority)
            <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $priorityColors[$production_request->priority] ?? 'bg-gray-50' }}">
                @if($production_request->priority == 'low') 🔹 منخفضة
                @elseif($production_request->priority == 'medium') 🔸 متوسطة
                @elseif($production_request->priority == 'high') 🔺 عالية
                @elseif($production_request->priority == 'urgent') ⚡ عاجل
                @endif
            </span>
            @endif
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Right Column (Main Info) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Request Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-900">تفاصيل الطلب</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Title -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">عنوان الطلب</p>
                            <p class="text-lg font-medium text-gray-900">{{ $production_request->title }}</p>
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">الوصف</p>
                            <p class="text-gray-700 bg-gray-50 p-4 rounded-lg leading-relaxed">{{ $production_request->description }}</p>
                        </div>
                        
                        <!-- Dates Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ الإنشاء</p>
                                <p class="text-sm font-medium">{{ $production_request->created_at->format('Y-m-d') }}</p>
                                <p class="text-xs text-gray-400">{{ $production_request->created_at->format('H:i') }}</p>
                            </div>
                            
                            @if($production_request->deadline)
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ التسليم</p>
                                <p class="text-sm font-medium">{{ $production_request->deadline->format('Y-m-d') }}</p>
                                @php
                                    $daysLeft = now()->diffInDays($production_request->deadline, false);
                                @endphp
                                @if($daysLeft > 0 && $production_request->status != 'approved')
                                    <p class="text-xs {{ $daysLeft <= 3 ? 'text-orange-500' : 'text-green-500' }}">
                                        {{ $daysLeft }} يوم متبقي
                                    </p>
                                @elseif($daysLeft < 0 && $production_request->status != 'approved')
                                    <p class="text-xs text-red-500">متأخر {{ abs($daysLeft) }} يوم</p>
                                @endif
                            </div>
                            @endif
                            
                            @if($production_request->accepted_at)
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ القبول</p>
                                <p class="text-sm font-medium">{{ $production_request->accepted_at->format('Y-m-d') }}</p>
                            </div>
                            @endif
                            
                            @if($production_request->submitted_at)
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ التسليم</p>
                                <p class="text-sm font-medium">{{ $production_request->submitted_at->format('Y-m-d') }}</p>
                            </div>
                            @endif
                            
                            @if($production_request->approved_at)
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ الموافقة</p>
                                <p class="text-sm font-medium">{{ $production_request->approved_at->format('Y-m-d') }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Notes (if exists) -->
                        @if($production_request->notes)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500 mb-2">ملاحظات إضافية</p>
                            <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-700">
                                {{ $production_request->notes }}
                            </div>
                        </div>
                        @endif
                        
                        <!-- Revision Details (if exists) -->
                        @if($production_request->revision_details)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-yellow-600 mb-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                التعديلات المطلوبة
                            </p>
                            <div class="bg-yellow-50 p-3 rounded-lg text-sm text-yellow-800 border border-yellow-200">
                                {{ $production_request->revision_details }}
                            </div>
                        </div>
                        @endif
                        
                        <!-- Reference File -->
                        @if($production_request->reference_file_path)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500 mb-2">الملف المرجعي</p>
                            <a href="{{ asset('storage/' . $production_request->reference_file_path) }}" target="_blank"
                               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span>تحميل الملف المرجعي</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Videos Section -->
                @if($production_request->videos && $production_request->videos->count() > 0)
                <div id="videos" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <h2 class="text-lg font-semibold text-gray-900">الفيديوهات المرفوعة</h2>
                            </div>
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $production_request->videos->count() }} فيديو
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($production_request->videos as $video)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $video->title }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $video->created_at->format('Y-m-d H:i') }}
                                                </span>
                                                @if($video->file_size)
                                                <span class="inline-flex items-center gap-1 mr-3">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    {{ $video->file_size }} MB
                                                </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($video->status ?? 'approved')
                                            @php
                                                $videoStatusColors = [
                                                    'under_review' => 'bg-yellow-100 text-yellow-800',
                                                    'approved' => 'bg-green-100 text-green-800',
                                                    'revision' => 'bg-orange-100 text-orange-800'
                                                ];
                                                $videoStatusTexts = [
                                                    'under_review' => 'بانتظار المراجعة',
                                                    'approved' => 'مقبول',
                                                    'revision' => 'مطلوب تعديل'
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $videoStatusColors[$video->status] ?? 'bg-gray-100' }}">
                                                {{ $videoStatusTexts[$video->status] ?? $video->status }}
                                            </span>
                                        @endif
                                        <button onclick="playVideo('{{ asset('storage/' . $video->file_path) }}', '{{ $video->title }}')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm flex items-center gap-1 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            </svg>
                                            مشاهدة
                                        </button>
                                        @if($production_request->status == 'submitted')
                                        <div class="flex items-center gap-1">
                                            <form action="{{ route('researcher.production_requests.approve', $production_request->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-green-600 hover:text-green-800 p-1" 
                                                        title="موافقة"
                                                        onclick="return confirm('هل أنت متأكد من الموافقة على هذا الفيديو؟')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <button onclick="showRevisionModal({{ $production_request->id }})"
                                                    class="text-orange-600 hover:text-orange-800 p-1"
                                                    title="طلب تعديل">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <form action="{{ route('researcher.production_requests.reject', $production_request->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 p-1" 
                                                        title="رفض"
                                                        onclick="return confirm('هل أنت متأكد من رفض هذا الفيديو؟')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @if($video->description)
                                <p class="mt-2 text-sm text-gray-600 bg-gray-50 p-2 rounded">{{ $video->description }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                
            </div>

            <!-- Left Column (Sidebar) -->
            <div class="space-y-6">
                <!-- Video Creator Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-orange-50 to-red-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">منشئ الفيديو</h2>
                    </div>
                    <div class="p-6">
                        @if($production_request->videoCreator)
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                                {{ substr($production_request->videoCreator->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $production_request->videoCreator->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $production_request->videoCreator->specialization ?? 'منشئ فيديو' }}</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-500">الحالة</span>
                                <span class="text-green-600 font-medium">نشط</span>
                            </div>
                           
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">لم يتم تعيين منشئ فيديو بعد</p>
                        @endif
                    </div>
                </div>

                <!-- Related Content Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">المحتوى المرتبط</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Lesson -->
                        <div>
                            <p class="text-xs text-gray-500 mb-1">الدرس</p>
                            <a href="{{ route('lessons.show', $production_request->lesson_id) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                {{ $production_request->lesson->title }}
                            </a>
                        </div>
                        
                        <!-- Rule (if exists) -->
                        @if($production_request->rule)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">القاعدة</p>
                            <p class="text-gray-900">{{ $production_request->rule->title }}</p>
                        </div>
                        @endif
                        
                        <!-- Content Block (if exists) -->
                        @if($production_request->contentBlock)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">كتلة المحتوى</p>
                            <p class="text-sm text-gray-700">نوع: {{ $production_request->contentBlock->type }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">إجراءات سريعة</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($production_request->status == 'pending')
                        <a href="{{ route('researcher.production_requests.edit', $production_request->id) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            تعديل الطلب
                        </a>
                        @endif
                        
                        @if($production_request->status == 'submitted')
                        <form action="{{ route('researcher.production_requests.approve', $production_request->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center gap-2 transition-colors"
                                    onclick="return confirm('هل أنت متأكد من الموافقة على هذا الفيديو؟')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                موافقة على الفيديو
                            </button>
                        </form>
                        
                        <button onclick="showRevisionModal({{ $production_request->id }})"
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            طلب تعديلات
                        </button>
                        
                        <form action="{{ route('researcher.production_requests.reject', $production_request->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center gap-2 transition-colors"
                                    onclick="return confirm('هل أنت متأكد من رفض هذا الفيديو؟')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                رفض الفيديو
                            </button>
                        </form>
                        @endif
                        
                        @if($production_request->status == 'approved' && $production_request->videos->count() > 0)
                        <a href="{{ asset('storage/' . $production_request->videos->last()->file_path) }}" download
                           class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            تحميل الفيديو
                        </a>
                        @endif
                        
                        @if($production_request->status == 'pending')
                        <form action="{{route('researcher.production_requests.destroy', $production_request->id)}}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center gap-2 transition-colors border border-red-200"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟ لا يمكن التراجع عن هذا الإجراء.')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                حذف الطلب
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revision Modal -->
<div id="revisionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-md w-full">
        <div class="bg-orange-600 text-white px-6 py-4 rounded-t-xl">
            <h3 class="text-lg font-bold">✏️ طلب تعديلات على الفيديو</h3>
        </div>
        <form id="revisionForm" method="POST">
            @csrf
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        تفاصيل التعديلات المطلوبة <span class="text-red-500">*</span>
                    </label>
                    <textarea name="revision_details" rows="5" required
                              class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="اذكر بالتفصيل التعديلات المطلوبة على الفيديو..."></textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeRevisionModal()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        إلغاء
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors">
                        إرسال طلب التعديل
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include Video Modal -->
@include('partials.video_modal')

<script>
function showRevisionModal(requestId) {
    const modal = document.getElementById('revisionModal');
    const form = document.getElementById('revisionForm');
   
      form.action = "{{ route('researcher.production_requests.revision', ':id') }}".replace(':id', requestId);
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeRevisionModal() {
    const modal = document.getElementById('revisionModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modal on ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRevisionModal();
    }
});

// Close modal on outside click
document.getElementById('revisionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRevisionModal();
    }
});
</script>
@endsection