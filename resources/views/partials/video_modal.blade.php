<!-- Video Modal - Modern Design -->
<div id="videoModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden shadow-2xl border border-gray-700/50 transform transition-all duration-300 scale-95 modal-enter">
        <!-- Modal Header -->
        <div class="relative px-6 py-4 flex items-center justify-between border-b border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 id="videoModalTitle" class="text-lg font-semibold text-white truncate max-w-md">عنوان الفيديو</h3>
                    <p class="text-xs text-gray-400">مشغل وسائط متطور</p>
                </div>
            </div>
            <button onclick="closeVideoModal()" class="text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 p-2 rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 transform group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Video Player Area -->
        <div class="p-4 bg-gradient-to-br from-gray-950 to-gray-900">
            <div class="relative rounded-xl overflow-hidden shadow-2xl border border-gray-700/50">
                <video id="videoPlayer" controls class="w-full max-h-[65vh] mx-auto" controlsList="nodownload">
                    <source id="videoSource" src="" type="video/mp4">
                    متصفحك لا يدعم تشغيل الفيديو
                </video>
                
                <!-- Video Overlay -->
                <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-gradient-to-br from-gray-800 to-gray-900 border-t border-gray-700">
            <div class="flex items-center justify-between">
                <!-- Video Info -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span id="videoQuality" class="text-sm">HD 1080p</span>
                    </div>
                    <div class="w-1 h-1 bg-gray-600 rounded-full"></div>
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span id="videoDuration" class="text-sm">00:00</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <a id="downloadVideoBtn" href="#" download 
                       class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2 shadow-lg shadow-green-600/20 transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        تحميل
                    </a>
                    
                    <button onclick="closeVideoModal()" 
                            class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2 shadow-lg transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS for animations -->
<style>
    #videoModal.modal-enter {
        animation: modalEnter 0.3s ease-out forwards;
    }
    
    @keyframes modalEnter {
        0% {
            opacity: 0;
            transform: scale(0.95);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* Custom video player styling */
    video::-webkit-media-controls-panel {
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    }
    
    video::-webkit-media-controls-play-button {
        background-color: rgba(255,255,255,0.2);
        border-radius: 50%;
        transition: all 0.2s;
    }
    
    video::-webkit-media-controls-play-button:hover {
        background-color: rgba(255,255,255,0.3);
        transform: scale(1.1);
    }
    
    video::-webkit-media-controls-timeline {
        border-radius: 10px;
        height: 6px;
    }
</style>

<!-- JavaScript for Video Modal -->
<script>
function playVideo(videoUrl, videoTitle) {
    const modal = document.getElementById('videoModal');
    const modalContent = modal.querySelector('.bg-gradient-to-br');
    const videoPlayer = document.getElementById('videoPlayer');
    const videoSource = document.getElementById('videoSource');
    const modalTitle = document.getElementById('videoModalTitle');
    const downloadBtn = document.getElementById('downloadVideoBtn');
    const videoQuality = document.getElementById('videoQuality');
    const videoDuration = document.getElementById('videoDuration');
    
    // تحديث مصدر الفيديو
    videoSource.src = videoUrl;
    videoPlayer.load();
    
    // تحديث العنوان وزر التحميل
    modalTitle.textContent = videoTitle || 'مشاهدة الفيديو';
    downloadBtn.href = videoUrl;
    
    // استخراج معلومات الفيديو
    videoPlayer.onloadedmetadata = function() {
        // حساب المدة
        const minutes = Math.floor(videoPlayer.duration / 60);
        const seconds = Math.floor(videoPlayer.duration % 60);
        videoDuration.textContent = minutes + ':' + (seconds < 10 ? '0' + seconds : seconds);
        
        // تقدير الجودة
        const videoWidth = videoPlayer.videoWidth;
        if (videoWidth >= 1920) {
            videoQuality.textContent = 'Full HD 1080p';
        } else if (videoWidth >= 1280) {
            videoQuality.textContent = 'HD 720p';
        } else if (videoWidth >= 854) {
            videoQuality.textContent = 'HD 480p';
        } else {
            videoQuality.textContent = 'SD';
        }
    };
    
    // عرض المودال مع تأثير
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modalContent.classList.add('modal-enter');
    
    // منع التمرير في الخلفية
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const modalContent = modal.querySelector('.bg-gradient-to-br');
    const videoPlayer = document.getElementById('videoPlayer');
    
    // تأثير الإخفاء
    modalContent.classList.remove('modal-enter');
    modal.classList.add('opacity-0');
    
    setTimeout(() => {
        // إخفاء المودال
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'opacity-0');
        
        // إيقاف الفيديو
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
        
        // إعادة التمرير
        document.body.style.overflow = 'auto';
    }, 200);
}

// إغلاق المودال بالضغط على ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal();
    }
});

// إغلاق المودال بالنقر على الخلفية
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeVideoModal();
            }
        });
    }
});
</script>