@php
$commentsCount = $video->comments()->whereNull('parent_id')->count();
@endphp

@auth
<div class="rounded-2xl border border-[#1c2538] overflow-hidden mt-4" style="background: #0e1118;">

    <!-- رأس التعليقات -->
    <div class="px-6 py-4 border-b border-[#1c2538] flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(25,232,160,.1);">
                <svg width="18" height="18" fill="none" stroke="#19e8a0" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <h4 class="text-[15px] font-bold text-[#dde4f0]">التعليقات</h4>
            <span class="comments-count-badge-{{ $video->id }} text-xs px-3 py-1 rounded-full font-semibold"
                  style="background: rgba(25,232,160,.1); color: #19e8a0;">
                {{ $commentsCount }} تعليق
            </span>
        </div>
        <select class="comment-sort text-xs text-[#8896b3] px-3 py-1.5 rounded-lg border border-[#1c2538] outline-none cursor-pointer"
                style="background: #131824;"
                onchange="loadComments({{ $video->id }}, this.value)">
            <option value="latest">الأحدث أولاً</option>
            <option value="oldest">الأقدم أولاً</option>
        </select>
    </div>

    <!-- حقل كتابة تعليق -->
    <div class="px-6 py-4 border-b border-[#1c2538] flex gap-3 items-start">
        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
             style="background: linear-gradient(135deg, #19e8a0, #10b981); color: #07090f;">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="flex-1">
            <textarea id="comment-input-{{ $video->id }}"
                      rows="1"
                      maxlength="2000"
                      placeholder="اكتب تعليقك أو سؤالك..."
                      class="w-full px-4 py-3 rounded-xl border border-[#1c2538] bg-[#0e1118] text-[#dde4f0] placeholder-[#8896b3] focus:border-[#19e8a0] focus:ring-1 focus:ring-[#19e8a0] transition-all resize-none"></textarea>
            <div class="flex justify-end mt-2">
                <button onclick="submitComment({{ $video->id }})"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-all hover:scale-105"
                        style="background: #19e8a0; color: #07090f;">
                    نشر التعليق
                </button>
            </div>
        </div>
    </div>

    {{--
        LAZY LOADING FIX:
        - data-video-id   → used by JS to know which video to load
        - data-loaded     → flag so we only fetch once per reveal
        - No DOMContentLoaded here — loading is triggered by the
          section-reveal logic in the main page JS.
    --}}
    <div id="comments-{{ $video->id }}"
         class="comments-container px-6 py-4"
         data-video-id="{{ $video->id }}"
         data-loaded="false">
        <!-- Placeholder shown until JS triggers loadComments() -->
        <div class="text-center py-8 text-[#8896b3] text-sm comments-placeholder">
            <div class="text-3xl mb-2 opacity-20">💬</div>
            اضغط لعرض التعليقات
        </div>
    </div>

</div>
@endauth