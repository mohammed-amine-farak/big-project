{{-- resources/views/partials/video-modal.blade.php --}}

<div id="videoModal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background: rgba(194, 63, 63, 0.85); backdrop-filter: blur(8px);">

    <div id="videoModalContent"
         class="w-full max-w-4xl rounded-2xl overflow-hidden border border-[#1c2538]"
         style="background: #0a0d14; box-shadow: 0 32px 80px rgba(0,0,0,0.6); transform: scale(0.96); opacity: 0; transition: transform .25s cubic-bezier(.4,0,.2,1), opacity .25s ease;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-[#1c2538]">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: rgba(248,113,113,.1); border: 1px solid rgba(248,113,113,.2);">
                    <svg width="16" height="16" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h3 id="videoModalTitle"
                        class="text-sm font-semibold text-[#dde4f0] truncate">فيديو الدرس</h3>
                    <div class="flex items-center gap-3 mt-0.5">
                        <span id="videoDuration"
                              class="text-xs text-[#8896b3]">--:--</span>
                        <span class="text-[#1c2538]">·</span>
                        <span id="videoQuality"
                              class="text-xs text-[#8896b3]">جاري التحميل...</span>
                    </div>
                </div>
            </div>

            <button onclick="closeVideoModal()"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-[#8896b3] hover:text-[#dde4f0] transition-all hover:bg-[#1c2538] flex-shrink-0 ml-4">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Player --}}
        <div style="background: #000; position: relative;">
            <video id="videoPlayer"
                   controls
                   class="w-full"
                   style="max-height: 62vh; display: block;">
                <source id="videoSource" src="" type="video/mp4">
                متصفحك لا يدعم تشغيل الفيديو
            </video>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-5 py-3 border-t border-[#1c2538]"
             style="background: #080b11;">

            {{-- Keyboard hints --}}
            <div class="flex items-center gap-4">
                @foreach(['Space' => 'تشغيل/إيقاف', '← →' => 'تقديم 10 ث', 'F' => 'ملء الشاشة', 'Esc' => 'إغلاق'] as $key => $label)
                <div class="hidden sm:flex items-center gap-1.5">
                    <kbd class="text-[10px] px-1.5 py-0.5 rounded font-mono text-[#8896b3]"
                         style="background: #131824; border: 1px solid #1c2538;">{{ $key }}</kbd>
                    <span class="text-[11px] text-[#4a5568]">{{ $label }}</span>
                </div>
                @endforeach
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2">
                <a id="downloadVideoBtn"
                   href="#"
                   download
                   class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-medium transition-all hover:scale-105"
                   style="background: rgba(25,232,160,.08); color: #19e8a0; border: 1px solid rgba(25,232,160,.2);">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    تحميل
                </a>

                <button onclick="closeVideoModal()"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-medium text-[#8896b3] hover:text-[#dde4f0] transition-all"
                        style="background: #131824; border: 1px solid #1c2538;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const modal   = document.getElementById('videoModal');
    const content = document.getElementById('videoModalContent');
    const player  = document.getElementById('videoPlayer');
    const source  = document.getElementById('videoSource');

    // ── Open ──────────────────────────────────────────────
    window.playVideo = function (videoUrl, videoTitle) {
        source.src = videoUrl;
        player.load();

        document.getElementById('videoModalTitle').textContent = videoTitle || 'مشاهدة الفيديو';
        document.getElementById('downloadVideoBtn').href = videoUrl;
        document.getElementById('videoDuration').textContent  = '--:--';
        document.getElementById('videoQuality').textContent   = 'جاري التحميل...';

        player.onloadedmetadata = function () {
            const m = Math.floor(player.duration / 60);
            const s = Math.floor(player.duration % 60);
            document.getElementById('videoDuration').textContent =
                m + ':' + String(s).padStart(2, '0');

            const w = player.videoWidth;
            document.getElementById('videoQuality').textContent =
                w >= 1920 ? 'Full HD 1080p' :
                w >= 1280 ? 'HD 720p'       :
                w >= 854  ? 'SD 480p'       : 'SD';
        };

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        // Animate in — rAF ensures transition runs after display:flex
        requestAnimationFrame(() => requestAnimationFrame(() => {
            content.style.transform = 'scale(1)';
            content.style.opacity   = '1';
        }));
    };

    // ── Close ─────────────────────────────────────────────
    window.closeVideoModal = function () {
        content.style.transform = 'scale(0.96)';
        content.style.opacity   = '0';

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            player.pause();
            player.currentTime = 0;
            document.body.style.overflow = '';
        }, 250);
    };

    // ── Backdrop click ────────────────────────────────────
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeVideoModal();
    });

    // ── Keyboard shortcuts (single listener) ─────────────
    document.addEventListener('keydown', function (e) {
        if (!modal || modal.classList.contains('hidden')) return;

        switch (e.key) {
            case 'Escape':
                closeVideoModal();
                break;
            case ' ':
            case 'Space':
                e.preventDefault();
                player.paused ? player.play() : player.pause();
                break;
            case 'ArrowLeft':
                e.preventDefault();
                player.currentTime = Math.max(0, player.currentTime - 10);
                break;
            case 'ArrowRight':
                e.preventDefault();
                player.currentTime = Math.min(player.duration, player.currentTime + 10);
                break;
            case 'f':
            case 'F':
                e.preventDefault();
                (player.requestFullscreen || player.webkitRequestFullscreen || (() => {})).call(player);
                break;
        }
    });
})();
</script>