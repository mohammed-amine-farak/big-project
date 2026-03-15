<div class="comment-item" style="margin-right: {{ $depth * 40 }}px;">
    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-all {{ !$comment->read_at && $depth == 0 ? 'border-r-4 border-orange-500' : '' }}">
        <div class="flex items-start gap-3">
            <!-- User Avatar -->
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-base shadow-md flex-shrink-0">
                {{ substr($comment->user->name ?? 'مستخدم', 0, 1) }}
            </div>
            
            <div class="flex-1">
                <!-- User Info -->
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $comment->user->name ?? 'مستخدم' }}</h4>
                        <p class="text-xs text-gray-500">
                            {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>
                    
                    @if(!$comment->read_at && $depth == 0)
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full text-xs font-medium">
                            جديد
                        </span>
                    @endif
                </div>

                <!-- Comment Content -->
                <p class="text-gray-700 mb-3">{{ $comment->content }}</p>

                <!-- Action Buttons (only for video creator) -->
                <div class="flex items-center gap-4">
                    <!-- Reply Button -->
                    <button onclick="toggleReplyForm({{ $comment->id }})" 
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        رد
                    </button>
                    
                    <!-- Mark as Read Button (only for parent comments) -->
                    @if(!$comment->read_at && $depth == 0)
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
                    
                    <!-- Delete Button -->
                    <form id="delete-form-{{ $comment->id }}" action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deleteComment({{ $comment->id }})" 
                                class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            حذف
                        </button>
                    </form>
                </div>

                <!-- Reply Form -->
                <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden">
                    <form action="{{ route('comments.reply', $comment) }}" method="POST">
                        @csrf
                        <div class="flex gap-3">
                            <input type="text" name="content" placeholder="اكتب ردك هنا..." required
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <button type="submit" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                رد
                            </button>
                            <button type="button" onclick="toggleReplyForm({{ $comment->id }})"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                إلغاء
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Replies -->
                @if($comment->replies->count() > 0)
                    <div class="mt-4 space-y-4">
                        @foreach($comment->replies as $reply)
                            @include('video-dashboard.comments.partials.comment_item', ['comment' => $reply, 'depth' => $depth + 1])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>