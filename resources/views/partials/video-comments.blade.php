@php
$commentsCount = $video->comments()->whereNull('parent_id')->count();
@endphp

@auth
<div class="comments-section mt-4" style="background:#0e1118; border:1px solid #1c2538; border-radius:16px; overflow:hidden;">

    {{-- ═══ Header ═══ --}}
    <div style="padding:14px 20px; border-bottom:1px solid #1c2538; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:32px; height:32px; border-radius:10px; background:rgba(25,232,160,.08); border:1px solid rgba(25,232,160,.12); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="15" height="15" fill="none" stroke="#19e8a0" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <span style="font-size:13px; font-weight:600; color:#dde4f0; letter-spacing:.01em;">التعليقات</span>
            <span class="comments-count-badge-{{ $video->id }}"
                  style="display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:500; padding:3px 9px; border-radius:99px; background:rgba(25,232,160,.07); color:#19e8a0; border:1px solid rgba(25,232,160,.12); white-space:nowrap;">
                <span style="width:5px; height:5px; border-radius:50%; background:#19e8a0; display:inline-block;"></span>
                {{ $commentsCount }} تعليق
            </span>
        </div>
        <select class="comment-sort"
                style="appearance:none; background:#0a0d14; border:1px solid #1c2538; color:#6b7a99; font-size:11px; padding:5px 28px 5px 10px; border-radius:8px; outline:none; cursor:pointer;"
                onchange="loadComments({{ $video->id }}, this.value)">
            <option value="latest">الأحدث أولاً</option>
            <option value="oldest">الأقدم أولاً</option>
        </select>
    </div>

    {{-- ═══ Compose ═══ --}}
    <div style="padding:14px 20px; border-bottom:1px solid #1c2538; display:flex; gap:12px; align-items:flex-start;">
        <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#19e8a0,#10b981); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#07090f; flex-shrink:0; margin-top:2px;">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div style="flex:1; min-width:0;">
            <textarea id="comment-input-{{ $video->id }}"
                      rows="2"
                      maxlength="2000"
                      placeholder="شارك سؤالك أو تعليقك..."
                      style="width:100%; background:#080b11; border:1px solid #1c2538; border-radius:10px; padding:10px 14px; font-size:13px; color:#dde4f0; resize:none; outline:none; line-height:1.5; transition:border-color .2s;"
                      onfocus="this.style.borderColor='rgba(25,232,160,.4)'"
                      onblur="this.style.borderColor='#1c2538'"></textarea>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-top:8px;">
                <span style="font-size:11px; color:#3d4a63;" id="char-count-{{ $video->id }}">0/2000</span>
                <button onclick="submitComment({{ $video->id }})"
                        id="submit-btn-{{ $video->id }}"
                        style="background:#19e8a0; color:#07090f; border:none; border-radius:8px; padding:6px 14px; font-size:12px; font-weight:600; cursor:pointer;">
                    نشر التعليق
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ Comments container (lazy loaded) ═══ --}}
    <div id="comments-{{ $video->id }}"
         class="comments-container"
         data-video-id="{{ $video->id }}"
         data-loaded="false"
         style="min-height:80px;">
        <div style="padding:40px 20px; text-align:center;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(25,232,160,.06); border:1px solid rgba(25,232,160,.1); display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
                <svg width="18" height="18" fill="none" stroke="rgba(25,232,160,.4)" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <p style="font-size:13px; color:#3d4a63;">اضغط لعرض التعليقات</p>
        </div>
    </div>

</div>

<style>
.comment-sort:hover { border-color: rgba(25,232,160,.25) !important; color: #dde4f0 !important; }

.comment-item {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(28,37,56,.6);
    display: flex;
    gap: 12px;
    transition: background .15s;
}
.comment-item:last-child { border-bottom: none; }
.comment-item:hover { background: rgba(25,232,160,.02); }

.comment-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    flex-shrink: 0; margin-top: 2px; color: #07090f;
}
.reply-avatar {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; flex-shrink: 0;
    background: linear-gradient(135deg, #818cf8, #6366f1); color: #fff;
}

.comment-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 5px; flex-wrap: wrap; }
.comment-name { font-size: 13px; font-weight: 600; color: #c8d3e8; }
.comment-time { font-size: 11px; color: #3d4a63; }
.comment-text { font-size: 13px; color: #8896b3; line-height: 1.6; margin-bottom: 8px; }

.comment-actions { display: flex; align-items: center; gap: 4px; }
.comment-btn {
    background: none; border: none; cursor: pointer;
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; color: #3d4a63;
    padding: 4px 8px; border-radius: 6px; transition: all .15s;
}
.comment-btn:hover { background: rgba(25,232,160,.06); color: #19e8a0; }
.comment-btn.danger:hover { background: rgba(248,113,113,.06); color: #f87171; }
.comment-sep { width: 3px; height: 3px; border-radius: 50%; background: #1c2538; }

.replies-list { margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(28,37,56,.5); display: flex; flex-direction: column; gap: 10px; }
.reply-item { display: flex; gap: 10px; align-items: flex-start; }
.reply-name { font-size: 12px; font-weight: 600; color: #c8d3e8; }
.reply-time { font-size: 10px; color: #3d4a63; }
.reply-text { font-size: 12px; color: #6b7a99; line-height: 1.55; margin-top: 2px; }

.reply-form-wrap { margin-top: 10px; display: none; gap: 8px; align-items: flex-start; }
.reply-form-wrap.open { display: flex; }
.reply-ta {
    flex: 1; background: #080b11; border: 1px solid #1c2538;
    border-radius: 8px; padding: 8px 12px; font-size: 12px;
    color: #dde4f0; resize: none; outline: none; line-height: 1.5;
    transition: border-color .2s;
}
.reply-ta:focus { border-color: rgba(25,232,160,.4); }
.reply-ta::placeholder { color: #3d4a63; }
.btn-reply-send {
    background: #19e8a0; color: #07090f; border: none;
    border-radius: 7px; padding: 7px 12px; font-size: 11px;
    font-weight: 600; cursor: pointer; flex-shrink: 0;
}
.btn-reply-cancel {
    background: none; border: 1px solid #1c2538; border-radius: 7px;
    padding: 7px 10px; font-size: 11px; color: #6b7a99; cursor: pointer;
}

.comments-spinner { display: flex; justify-content: center; align-items: center; padding: 32px; }
.spinner-ring {
    width: 28px; height: 28px;
    border: 2px solid rgba(25,232,160,.1);
    border-top-color: #19e8a0; border-radius: 50%;
    animation: cspin .6s linear infinite;
}
@keyframes cspin { to { transform: rotate(360deg); } }
.char-warn { color: #f59e0b !important; }
.char-over  { color: #f87171 !important; }
</style>

<script>
(function(){
    const videoId = {{ $video->id }};
    const COLORS  = ['#19e8a0,#10b981','#f472b6,#ec4899','#fb923c,#f97316','#a78bfa,#8b5cf6','#38bdf8,#0ea5e9'];

    // Char counter + auto-grow
    const ta = document.getElementById('comment-input-' + videoId);
    const cc = document.getElementById('char-count-' + videoId);
    if (ta && cc) {
        ta.addEventListener('input', function(){
            const len = this.value.length;
            cc.textContent = len + '/2000';
            cc.className = len > 1800 ? (len >= 2000 ? 'char-over' : 'char-warn') : '';
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 140) + 'px';
        });
    }

    function esc(s){ return String(s||'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m])); }
    function fmtDate(ds){
        const d=Math.floor((Date.now()-new Date(ds))/1000);
        if(d<60) return 'الآن';
        if(d<3600) return 'منذ '+Math.floor(d/60)+' دقيقة';
        if(d<86400) return 'منذ '+Math.floor(d/3600)+' ساعة';
        if(d<2592000) return 'منذ '+Math.floor(d/86400)+' يوم';
        return new Date(ds).toLocaleDateString('ar-SA');
    }

    function renderComment(c){
        const color   = COLORS[c.user_id % COLORS.length];
        const initial = esc((c.user?.name||'م').charAt(0));
        const isOwner = c.user_id === AUTH_ID;
        const replies = c.replies || [];
        return `
        <div class="comment-item" id="comment-${c.id}">
            <div class="comment-avatar" style="background:linear-gradient(135deg,${color})">${initial}</div>
            <div style="flex:1;min-width:0;">
                <div class="comment-meta">
                    <span class="comment-name">${esc(c.user?.name||'مجهول')}</span>
                    <span class="comment-time">${fmtDate(c.created_at)}</span>
                </div>
                <p class="comment-text">${esc(c.content)}</p>
                <div class="comment-actions">
                    <button class="comment-btn" onclick="toggleReplyForm(${c.id})">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                        رد ${replies.length ? '· '+replies.length : ''}
                    </button>
                    ${isOwner ? `
                    <span class="comment-sep"></span>
                    <button class="comment-btn danger" onclick="deleteComment(${c.id},${videoId})">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        حذف
                    </button>` : ''}
                </div>
                ${replies.length ? `
                <div class="replies-list">
                    ${replies.map(r=>`
                    <div class="reply-item">
                        <div class="reply-avatar">${esc((r.user?.name||'م').charAt(0))}</div>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px;">
                                <span class="reply-name">${esc(r.user?.name||'مجهول')}</span>
                                <span class="reply-time">${fmtDate(r.created_at)}</span>
                            </div>
                            <p class="reply-text">${esc(r.content)}</p>
                        </div>
                    </div>`).join('')}
                </div>` : ''}
                <div class="reply-form-wrap" id="reply-form-${c.id}">
                    <div class="reply-avatar">${esc(AUTH_INITIAL)}</div>
                    <textarea class="reply-ta" id="reply-input-${c.id}" rows="2" placeholder="اكتب ردك..."></textarea>
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        <button class="btn-reply-send" onclick="submitReply(${c.id},${videoId})">إرسال</button>
                        <button class="btn-reply-cancel" onclick="toggleReplyForm(${c.id})">إلغاء</button>
                    </div>
                </div>
            </div>
        </div>`;
    }

    window.toggleReplyForm = function(commentId){
        const form = document.getElementById('reply-form-'+commentId);
        if (!form) return;
        form.classList.toggle('open');
        if (form.classList.contains('open')) form.querySelector('textarea')?.focus();
        else { const i=document.getElementById('reply-input-'+commentId); if(i) i.value=''; }
    };

    window.loadComments = async function(vid, sort='latest'){
        const container = document.getElementById('comments-'+vid);
        if (!container) return;
        container.innerHTML = '<div class="comments-spinner"><div class="spinner-ring"></div></div>';
        try {
            const res  = await fetch('/comments/'+vid+'?sort='+sort);
            const data = await res.json();
            if (!data.comments || !data.comments.length) {
                container.innerHTML = `<div style="padding:40px 20px;text-align:center;"><div style="width:44px;height:44px;border-radius:12px;background:rgba(25,232,160,.06);border:1px solid rgba(25,232,160,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;"><svg width="18" height="18" fill="none" stroke="rgba(25,232,160,.4)" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg></div><p style="font-size:13px;color:#3d4a63;">لا توجد تعليقات بعد، كن أول من يعلق!</p></div>`;
                container.dataset.loaded = 'true';
                return;
            }
            container.innerHTML = data.comments.map(renderComment).join('');
            container.dataset.loaded = 'true';
        } catch(e) {
            container.innerHTML = `<div style="padding:32px 20px;text-align:center;"><p style="font-size:13px;color:#f87171;margin-bottom:8px;">حدث خطأ في تحميل التعليقات</p><button onclick="loadComments(${vid},'${sort}')" style="font-size:11px;padding:5px 12px;border-radius:7px;background:rgba(25,232,160,.08);color:#19e8a0;border:1px solid rgba(25,232,160,.15);cursor:pointer;">إعادة المحاولة</button></div>`;
        }
    };

    window.submitComment = async function(vid){
        const input = document.getElementById('comment-input-'+vid);
        const btn   = document.getElementById('submit-btn-'+vid);
        const content = input?.value?.trim();
        if (!content) { showToast('الرجاء كتابة تعليق أولاً','error'); return; }
        const orig = btn.innerHTML;
        btn.innerHTML = '<div class="spinner-ring" style="width:14px;height:14px;border-width:2px;margin:0 auto;"></div>';
        btn.disabled = true;
        try {
            const res  = await fetch(STORE_URL, {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
                body: JSON.stringify({video_id:vid, content})
            });
            const data = await res.json();
            if (data.success) {
                input.value = ''; input.style.height = 'auto';
                document.getElementById('char-count-'+vid).textContent = '0/2000';
                showToast('تم نشر تعليقك بنجاح');
                updateCommentCount(vid, data.comments_count);
                document.getElementById('comments-'+vid).dataset.loaded = 'false';
                await loadComments(vid,'latest');
            } else { showToast(data.message||'حدث خطأ','error'); }
        } catch { showToast('فشل الاتصال بالخادم','error'); }
        finally { btn.innerHTML = orig; btn.disabled = false; }
    };

    window.submitReply = async function(commentId, vid){
        const input = document.getElementById('reply-input-'+commentId);
        const content = input?.value?.trim();
        if (!content) { showToast('الرجاء كتابة الرد أولاً','error'); return; }
        try {
            const res  = await fetch('/comments/'+commentId+'/reply', {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
                body: JSON.stringify({content})
            });
            const data = await res.json();
            if (data.success) {
                toggleReplyForm(commentId);
                showToast('تم إضافة ردك بنجاح');
                document.getElementById('comments-'+vid).dataset.loaded = 'false';
                await loadComments(vid,'latest');
            } else { showToast(data.message||'حدث خطأ','error'); }
        } catch { showToast('فشل الاتصال بالخادم','error'); }
    };

    window.deleteComment = async function(commentId, vid){
        if (!confirm('هل أنت متأكد من حذف هذا التعليق؟')) return;
        try {
            const res  = await fetch('/comments/'+commentId, {
                method:'DELETE',
                headers:{'X-CSRF-TOKEN':CSRF,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
            });
            const data = await res.json();
            if (data.success) {
                showToast('تم حذف التعليق بنجاح');
                updateCommentCount(vid, data.comments_count);
                document.getElementById('comments-'+vid).dataset.loaded = 'false';
                await loadComments(vid,'latest');
            } else { showToast(data.message||'حدث خطأ','error'); }
        } catch { showToast('فشل الاتصال بالخادم','error'); }
    };

    window.updateCommentCount = function(vid, count){
        document.querySelectorAll('.comments-count-badge-'+vid).forEach(el => {
            const dot = el.querySelector('span');
            el.innerHTML = (dot ? dot.outerHTML : '') + ' ' + (count ?? '0') + ' تعليق';
        });
    };
})();
</script>
@endauth