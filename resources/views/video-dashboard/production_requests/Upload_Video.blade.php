@extends('layouts.video_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">رفع فيديو جديد</h1>
                <p class="text-sm text-gray-500 mt-1">طلب الإنتاج: {{ $production_request->title }}</p>
            </div>
            <a href="{{ route('video_creator.production_request.show', $production_request->id) }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">رفع الفيديو</h2>
            </div>
            
            <div class="p-6">
                <form id="upload-form" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Video Title -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">عنوان الفيديو *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $production_request->title) }}" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">وصف الفيديو</label>
                        <textarea id="description" name="description" rows="3" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                    </div>

                    <!-- Simple File Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ملف الفيديو *</label>
                        <input type="file" id="video_file" name="video_file" accept="video/mp4,video/mov,video/avi" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <p class="text-xs text-gray-500 mt-1">MP4, MOV, AVI - يمكن رفع ملفات حتى 10 جيجابايت</p>
                    </div>

                    <!-- Progress Bar (Simple) -->
                    <div id="progress-container" class="mb-6 hidden">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">جاري الرفع...</span>
                            <span id="progress-percent" class="text-sm text-gray-600">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div id="progress-bar" class="bg-orange-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="button" id="submit-btn" 
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-lg transition-colors font-medium">
                        رفع الفيديو
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Simple JavaScript for Chunk Upload -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('upload-form');
    const fileInput = document.getElementById('video_file');
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const submitBtn = document.getElementById('submit-btn');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressPercent = document.getElementById('progress-percent');

    submitBtn.addEventListener('click', async function() {
        // التحقق من المدخلات
        if (!titleInput.value.trim()) {
            alert('الرجاء إدخال عنوان الفيديو');
            return;
        }
        
        if (!fileInput.files || !fileInput.files[0]) {
            alert('الرجاء اختيار ملف الفيديو');
            return;
        }

        const file = fileInput.files[0];
        const chunkSize = 2 * 1024 * 1024; // 2MB لكل قطعة
        const chunks = Math.ceil(file.size / chunkSize);
        
        // إظهار شريط التقدم
        progressContainer.classList.remove('hidden');
        submitBtn.disabled = true;
        submitBtn.textContent = 'جاري الرفع...';

        // رفع القطع
        for (let i = 0; i < chunks; i++) {
            const start = i * chunkSize;
            const end = Math.min(start + chunkSize, file.size);
            const chunk = file.slice(start, end);
            
            const formData = new FormData();
            formData.append('video_file', chunk);
            formData.append('title', titleInput.value.trim());
            formData.append('description', descriptionInput.value.trim());
            formData.append('chunk_index', i);
            formData.append('total_chunks', chunks);
            formData.append('file_name', file.name);
            formData.append('file_size', file.size);
            
            try {
                const response = await fetch("{{ route('production_requests.upload.chunk', $production_request->id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.error || 'خطأ في الرفع');
                }

                // تحديث شريط التقدم
                const progress = Math.round(((i + 1) / chunks) * 100);
                progressBar.style.width = progress + '%';
                progressPercent.textContent = progress + '%';

                // إذا كانت آخر قطعة وتم الرفع بنجاح
                if (i === chunks - 1 && result.success) {
                    setTimeout(() => {
                        window.location.href = "{{ route('video_creator.production_request.show', $production_request->id) }}?success=1";
                    }, 500);
                }

            } catch (error) {
                console.error('Upload error:', error);
                alert('فشل الرفع: ' + error.message);
                
                // إعادة تعيين الأزرار
                submitBtn.disabled = false;
                submitBtn.textContent = 'رفع الفيديو';
                progressContainer.classList.add('hidden');
                break;
            }
        }
    });
});
</script>
@endsection