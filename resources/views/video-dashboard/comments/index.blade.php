@extends('layouts.video_dashboard')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header with Statistics -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold mb-1">التعليقات على فيديوهاتي</h1>
                            <p class="text-orange-100">جميع التعليقات والملاحظات على المحتوى الذي أنتجته</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 backdrop-blur-lg rounded-xl px-5 py-3">
                            <p class="text-xs opacity-90">إجمالي التعليقات</p>
                            <p class="text-2xl font-bold">{{ $totalComments ?? 0 }}</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-lg rounded-xl px-5 py-3">
                            <p class="text-xs opacity-90">غير مقروءة</p>
                            <p class="text-2xl font-bold text-yellow-300">{{ $unreadComments ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">تصفية التعليقات</h3>
            </div>

            <form action="{{ route('video_creator.comments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">حالة القراءة</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">الكل</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>غير مقروء</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>مقروء</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">من تاريخ</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">إلى تاريخ</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Actions -->
                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2.5 rounded-xl font-medium transition-colors">
                        تطبيق
                    </button>
                    <a href="{{ route('video_creator.comments.index') }}" 
                       class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                        إعادة تعيين
                    </a>
                </div>
            </form>
        </div>

        <!-- Comments List -->
        @if($comments->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-16 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">لا توجد تعليقات</h3>
                <p class="text-gray-500 text-lg mb-8">لم يضف أحد تعليقات على فيديوهاتك بعد</p>
                <a href="" 
                   class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    عرض فيديوهاتي
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($comments as $comment)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all {{ !$comment->read_at ? 'border-r-4 border-orange-500' : '' }}">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <!-- User Avatar -->
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md flex-shrink-0">
                                    {{ substr($comment->user->name ?? 'مستخدم', 0, 1) }}
                                </div>
                                
                                <div class="flex-1">
                                    <!-- User Info -->
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $comment->user->name ?? 'مستخدم' }}</h4>
                                            <p class="text-xs text-gray-500">
                                                {{ $comment->created_at->format('Y/m/d H:i') }}
                                                @if($comment->created_at != $comment->updated_at)
                                                    <span class="mr-2">(معدل)</span>
                                                @endif
                                            </p>
                                        </div>
                                        
                                        @if(!$comment->read_at)
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">
                                                جديد
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Comment Content -->
                                    <p class="text-gray-700 leading-relaxed mb-4">{{ $comment->content }}</p>

                                    <!-- Video Info -->
                                    @if($comment->commentable)
                                        <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-xl p-4 mb-4 border border-red-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $comment->commentable->title ?? 'فيديو' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        تم النشر في {{ $comment->commentable->created_at->format('Y/m/d') }}
                                                    </p>
                                                </div>
                                                <a href="{{ route('video_creator.videos.show', $comment->commentable_id) }}" 
                                                   class="mr-auto text-sm text-red-600 hover:text-red-800 font-medium flex items-center gap-1">
                                                    <span>عرض الفيديو</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-4">
                                        <!-- Reply Button -->
                                        <button onclick="toggleReplyForm({{ $comment->id }})" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                            </svg>
                                            رد
                                        </button>
                                        
                                        <!-- Mark as Read Button -->
                                        @if(!$comment->read_at)
                                            <form action="{{ route('comments.mark-read', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    تحديد كمقروء
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <!-- Delete Button (for video creator) -->
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا التعليق؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                حذف
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Reply Form (hidden by default) -->
                                    <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden">
                                        <form action="{{ route('comments.reply', $comment) }}" method="POST">
                                            @csrf
                                            <div class="flex gap-3">
                                                <input type="text" name="content" placeholder="اكتب ردك هنا..." required
                                                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500">
                                                <button type="submit" 
                                                        class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2.5 rounded-xl font-medium transition-colors">
                                                    رد
                                                </button>
                                                <button type="button" onclick="toggleReplyForm({{ $comment->id }})"
                                                        class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                                    إلغاء
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Replies -->
                                    @if($comment->replies->count() > 0)
                                        <div class="mt-4 mr-8 space-y-4">
                                            @foreach($comment->replies as $reply)
                                                <div class="bg-gray-50 rounded-xl p-4 border-r-4 border-orange-500">
                                                    <div class="flex items-start gap-3">
                                                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                            {{ substr($reply->user->name ?? 'منشئ', 0, 1) }}
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center justify-between mb-1">
                                                                <span class="font-medium text-gray-900">{{ $reply->user->name ?? 'منشئ الفيديو' }}</span>
                                                                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="text-gray-700">{{ $reply->content }}</p>
                                                            
                                                            <!-- Delete reply button -->
                                                            <div class="mt-2">
                                                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline"
                                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الرد؟')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium flex items-center gap-1">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                        حذف
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $comments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    form.classList.toggle('hidden');
}

// Auto-refresh for new comments (every 60 seconds)
setTimeout(function() {
    location.reload();
}, 60000);
</script>

<style>
/* Custom animation for new comments */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.comment-item {
    animation: fadeIn 0.3s ease-out;
}

/* RTL specific */
[dir="rtl"] .border-r-4 {
    border-right-width: 4px;
}

[dir="rtl"] .mr-8 {
    margin-right: 2rem;
}
</style>
@endsection