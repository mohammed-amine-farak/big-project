@extends('layouts.video_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header with Back Button -->
        <div class="mb-6 flex items-center justify-between">
            <a href="" 
               class="flex items-center gap-2 text-gray-600 hover:text-orange-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>العودة للقائمة</span>
            </a>
            
            <!-- Status Badge -->
            @php
                $statusColors = [
                    'pending' => 'bg-orange-100 text-orange-800',
                    'accepted' => 'bg-blue-100 text-blue-800',
                    'submitted' => 'bg-yellow-100 text-yellow-800',
                    'revision_required' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800'
                ];
                $statusTexts = [
                    'pending' => 'في الانتظار',
                    'accepted' => 'قيد التنفيذ',
                    'submitted' => 'بانتظار المراجعة',
                    'revision_required' => 'يحتاج تعديل',
                    'approved' => 'مكتمل',
                    'rejected' => 'مرفوض'
                ];
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$productionRequest->status] }}">
                {{ $statusTexts[$productionRequest->status] ?? $productionRequest->status }}
            </span>
        </div>

        <!-- Request Title Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-l from-orange-50 to-red-50 px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">{{ $productionRequest->title }}</h1>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                    <span>📋 طلب إنتاج #{{ $productionRequest->id }}</span>
                    <span>📅 {{ $productionRequest->created_at}}</span>
                </div>
            </div>
        </div>

        <!-- Main Information Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Right Column: العلاقات الأساسية -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900">العلاقات الأساسية</h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Researcher -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">researcher_id</p>
                            <p class="font-medium text-gray-900">{{ $productionRequest->researcher->user->name }}</p>
                       
                        </div>
                    </div>

                    <!-- Video Creator -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">video_creator_id</p>
                            <p class="font-medium text-gray-900">{{ $productionRequest->videoCreator->user->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>

                    <!-- Lesson -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.523 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.523 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">lesson_id</p>
                            <p class="font-medium text-gray-900">{{ $productionRequest->lesson->title }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left Column: الحقول الإضافية (rule + content_block) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900">الحقول الإضافية</h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Rule (if exists) -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">rule_id {{ $productionRequest->rule_id ? '(موجود)' : '(فارغ)' }}</p>
                            @if($productionRequest->rule)
                                <p class="font-medium text-gray-900">{{ $productionRequest->rule->title }}</p>
                            @else
                                <p class="text-gray-400 italic">لا توجد قاعدة مرتبطة</p>
                            @endif
                        </div>
                    </div>

                    <!-- Content Block (if exists) -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">content_block_id {{ $productionRequest->content_block_id ? '(موجود)' : '(فارغ)' }}</p>
                            @if($productionRequest->contentBlock)
                                <p class="font-medium text-gray-900">{{ $productionRequest->contentBlock->title ?? 'كتلة محتوى #' . $productionRequest->content_block_id }}</p>
                                <p class="text-xs text-gray-500">النوع: {{ $productionRequest->contentBlock->type ?? '' }}</p>
                            @else
                                <p class="text-gray-400 italic">لا توجد كتلة محتوى مرتبطة</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">📝 الوصف (description)</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 leading-relaxed">{{ $productionRequest->description ?: 'لا يوجد وصف' }}</p>
            </div>
        </div>

        <!-- Files Card -->
        @if($productionRequest->reference_file || $productionRequest->reference_file_path)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">📎 الملفات المرجعية</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @if($productionRequest->reference_file)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">reference_file</span>
                        <a href="{{ asset('storage/' . $productionRequest->reference_file) }}" target="_blank" 
                           class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ basename($productionRequest->reference_file) }}
                        </a>
                    </div>
                    @endif
                    
                    @if($productionRequest->reference_file_path)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">reference_file_path</span>
                        <a href="{{ asset('storage/' . $productionRequest->reference_file_path) }}" target="_blank" 
                           class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ basename($productionRequest->reference_file_path) }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Dates and Status Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">⏱️ التواريخ والحالة</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <table class="w-full text-sm">
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-gray-500">deadline</td>
                                <td class="py-2 font-medium">
                                    {{ $productionRequest->deadline ? $productionRequest->deadline->format('Y-m-d') : 'غير محدد' }}
                                    @if($productionRequest->deadline && $productionRequest->deadline->isPast() && !in_array($productionRequest->status, ['approved', 'rejected']))
                                        <span class="text-red-600 text-xs mr-2">(متأخر)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-gray-500">accepted_at</td>
                                <td class="py-2 font-medium">{{ $productionRequest->accepted_at ? $productionRequest->accepted_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-gray-500">submitted_at</td>
                                <td class="py-2 font-medium">{{ $productionRequest->submitted_at ? $productionRequest->submitted_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-gray-500">approved_at</td>
                                <td class="py-2 font-medium">{{ $productionRequest->approved_at ? $productionRequest->approved_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-500">created_at</td>
                                <td class="py-2 font-medium">{{ $productionRequest->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="w-full text-sm">
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-gray-500">الحالة</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $statusColors[$productionRequest->status] }}">
                                        {{ $statusTexts[$productionRequest->status] }}
                                    </span>
                                </td>
                            </tr>
                            @if($productionRequest->revision_details)
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-gray-500">revision_details</td>
                                <td class="py-2 text-yellow-600">{{ $productionRequest->revision_details }}</td>
                            </tr>
                            @endif
                            @if($productionRequest->notes)
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-gray-500">notes</td>
                                <td class="py-2">{{ $productionRequest->notes }}</td>
                            </tr>
                            @endif
                           
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Videos Section -->
        @if($productionRequest->videos && $productionRequest->videos->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-l from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">🎬 الفيديوهات المرفوعة</h3>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($productionRequest->videos as $video)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $video->title }}</h4>
                                <p class="text-xs text-gray-500">رفع في {{ $video->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ asset('storage/' . $video->file_path) }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-800 p-2" title="عرض الفيديو">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 justify-end mt-6 pt-6 border-t border-gray-200">
            @if($productionRequest->status == 'pending')
                <a href="{{ route('video_creator.production_requests.accept', $productionRequest->id) }}" 
   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors flex items-center gap-2"
   onclick="return confirm('هل أنت متأكد من قبول هذا الطلب؟')">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    قبول الطلب
</a>
                <button onclick="showRejectModal()" 
                   class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    رفض الطلب
                </button>
            @endif
            
            @if($productionRequest->status == 'accepted')
                <a href="{{route('video_creator.production_requests.upload', $productionRequest->id)}}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    رفع الفيديو
                </a>
            @endif
            
            @if($productionRequest->status == 'revision_required')
                <a href="" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    تعديل وإعادة الرفع
                </a>
            @endif
            
            @if(in_array($productionRequest->status, ['submitted']))
                <span class="text-gray-500 px-6 py-3 bg-gray-100 rounded-lg">بانتظار مراجعة الباحث</span>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">رفض الطلب</h3>
        <form action="" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">سبب الرفض (اختياري)</label>
                <textarea name="rejection_reason" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                          placeholder="اكتب سبب الرفض..."></textarea>
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="hideRejectModal()" 
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    إلغاء
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    تأكيد الرفض
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}
</script>
@endsection