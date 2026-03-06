@extends('layouts.video_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">✏️ تعديل الفيديو</h1>
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

        <!-- Revision Details Card -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-yellow-800 mb-2">التعديلات المطلوبة من الباحث</h3>
                    <div class="bg-white p-4 rounded-lg border border-yellow-200">
                        <p class="text-gray-700 leading-relaxed">{{ $production_request->revision_details ?: 'لم يحدد الباحث تفاصيل التعديلات' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Previous Video Card (if exists) -->
        @if($production_request->videos && $production_request->videos->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">الفيديو السابق</h3>
            </div>
            <div class="p-6">
                @php $lastVideo = $production_request->videos->last(); @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $lastVideo->title }}</h4>
                            <p class="text-sm text-gray-500">رفع في {{ $lastVideo->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $lastVideo->file_path) }}" target="_blank"
                       class="text-blue-600 hover:text-blue-800 px-4 py-2 rounded-lg border border-blue-200 hover:bg-blue-50 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        مشاهدة
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Upload Revised Version Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">رفع النسخة المعدلة</h2>
            </div>
            
            <div class="p-6">
                <form id="revise-form" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Revision Notes -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظاتك على التعديلات</label>
                        <textarea id="revision_notes" name="revision_notes" rows="4" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                  placeholder="اكتب ملاحظاتك عن التعديلات التي قمت بها..."></textarea>
                    </div>

                    <!-- File Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ملف الفيديو المعدل *</label>
                        <input type="file" id="video_file" name="video_file" accept="video/mp4,video/mov,video/avi" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <p class="text-xs text-gray-500 mt-1">MP4, MOV, AVI - يمكن رفع ملفات حتى 10 جيجابايت</p>
                    </div>

                    <!-- Progress Bar -->
                    <div id="progress-container" class="mb-6 hidden">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">جاري رفع النسخة المعدلة...</span>
                            <span id="progress-percent" class="text-sm text-gray-600">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div id="progress-bar" class="bg-orange-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="button" id="submit-btn" 
                                class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-lg transition-colors font-medium flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            رفع النسخة المعدلة
                        </button>
                        <a href="{{ route('video_creator.production_request.show', $production_request->id) }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Simple JavaScript for Chunk Upload (Same as upload page) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('video_file');
    const revisionNotes = document.getElementById('revision_notes');
    const submitBtn = document.getElementById('submit-btn');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressPercent = document.getElementById('progress-percent');

    submitBtn.addEventListener('click', async function() {
        if (!fileInput.files || !fileInput.files[0]) {
            alert('الرجاء اختيار ملف الفيديو المعدل');
            return;
        }

        const file = fileInput.files[0];
        const chunkSize = 2 * 1024 * 1024; // 2MB per chunk
        const chunks = Math.ceil(file.size / chunkSize);
        
        // Show progress bar
        progressContainer.classList.remove('hidden');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'جاري الرفع...';

        // Upload chunks
        for (let i = 0; i < chunks; i++) {
            const start = i * chunkSize;
            const end = Math.min(start + chunkSize, file.size);
            const chunk = file.slice(start, end);
            
            const formData = new FormData();
            formData.append('video_file', chunk);
            formData.append('revision_notes', revisionNotes.value.trim());
            formData.append('chunk_index', i);
            formData.append('total_chunks', chunks);
            formData.append('file_name', file.name);
            formData.append('file_size', file.size);
            
            try {
                const response = await fetch("{{ route('video_creator.production_requests.revise.chunk', $production_request->id) }}", {
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

                // Update progress bar
                const progress = Math.round(((i + 1) / chunks) * 100);
                progressBar.style.width = progress + '%';
                progressPercent.textContent = progress + '%';

                // If last chunk and successful
                if (i === chunks - 1 && result.success) {
                    setTimeout(() => {
                        window.location.href = "{{ route('video_creator.production_request.show', $production_request->id) }}?success=1";
                    }, 500);
                }

            } catch (error) {
                console.error('Upload error:', error);
                alert('فشل الرفع: ' + error.message);
                
                // Reset buttons
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'رفع النسخة المعدلة';
                progressContainer.classList.add('hidden');
                break;
            }
        }
    });
});
</script>
@endsection