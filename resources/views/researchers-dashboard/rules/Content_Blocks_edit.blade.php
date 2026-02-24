{{-- resources/views/rules/content/edit.blade.php --}}
@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">تعديل المحتوى التعليمي</h1>
            <a href="{{ route('content_block.show', $rule->id) }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Rule Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">معلومات القاعدة</h2>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $rule->title }}</h3>
                      
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">تعديل بيانات المحتوى</h2>
            </div>
            
            <form action="{{ route('rules.content.update', [$rule->id, $contentBlock->id]) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="p-6">
                @csrf
                @method('PUT')
                
                <!-- Content Type Display (Read-only) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        نوع المحتوى
                    </label>
                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-gray-100 rounded-lg">
                        @if($contentBlock->type == 'text')
                            <span class="text-2xl">📝</span>
                            <span class="font-medium text-gray-700">نص</span>
                        @elseif($contentBlock->type == 'math')
                            <span class="text-2xl">📐</span>
                            <span class="font-medium text-gray-700">معادلة</span>
                        @elseif($contentBlock->type == 'image')
                            <span class="text-2xl">🖼️</span>
                            <span class="font-medium text-gray-700">صورة</span>
                        @elseif($contentBlock->type == 'video')
                            <span class="text-2xl">🎥</span>
                            <span class="font-medium text-gray-700">فيديو</span>
                        @else
                            <span class="text-2xl">✏️</span>
                            <span class="font-medium text-gray-700">تمرين</span>
                        @endif
                    </div>
                    <input type="hidden" name="type" value="{{ $contentBlock->type }}">
                </div>

                <!-- Content Fields Based on Type -->
                @if($contentBlock->type == 'text')
                    <!-- Text Content -->
                    <div class="mb-6">
                        <label for="content_text" class="block text-sm font-medium text-gray-700 mb-2">
                            المحتوى النصي *
                        </label>
                        <textarea id="content_text" name="content" rows="8" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 font-arabic"
                                  placeholder="اكتب المحتوى النصي هنا..." required>{{ old('content', $contentBlock->content) }}</textarea>
                    </div>

                @elseif($contentBlock->type == 'math')
                    <!-- Math Content -->
                    <div class="mb-6">
                        <label for="content_math" class="block text-sm font-medium text-gray-700 mb-2">
                            معادلة LaTeX *
                        </label>
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2 border-b border-gray-300">
                                <span class="text-xs text-gray-600">صيغة LaTeX</span>
                            </div>
                            <textarea id="content_math" name="content" rows="5" 
                                      class="w-full px-3 py-2.5 font-mono text-left focus:ring-2 focus:ring-purple-500 focus:border-purple-500 border-0"
                                      placeholder="$$ E = mc^2 $$" required>{{ old('content', $contentBlock->content) }}</textarea>
                        </div>
                        
                        <!-- Math Preview -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                معاينة المعادلة
                            </label>
                            <div id="math_preview" class="bg-gray-900 rounded-lg p-6 text-center overflow-x-auto">
                                <span class="text-green-400 text-xl" id="preview_text">{{ $contentBlock->content }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-purple-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-purple-800 font-medium">مساعدة في كتابة المعادلات</p>
                                    <p class="text-sm text-purple-700 mt-1">
                                        استخدم صيغة LaTeX: $$ E = mc^2 $$, $$ \frac{a}{b} $$, $$ \sqrt{x} $$
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($contentBlock->type == 'image')
                    <!-- Image Content -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            الصورة الحالية
                        </label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mb-4">
                            <img src="{{ asset('storage/' . $contentBlock->content) }}" 
                                 alt="الصورة الحالية" 
                                 class="max-h-48 mx-auto rounded-lg">
                            <p class="text-center text-sm text-gray-600 mt-2">
                                {{ basename($contentBlock->content) }}
                            </p>
                        </div>

                        <label for="content_image" class="block text-sm font-medium text-gray-700 mb-2">
                            تغيير الصورة (اختياري)
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition duration-200 cursor-pointer" id="image_upload_area">
                            <input type="file" id="content_image" name="content" accept="image/*" class="hidden">
                            <div id="image_upload_placeholder">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">انقر لاختيار صورة جديدة أو اسحبها وأفلتها هنا</p>
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF (الحد الأقصى 10MB)</p>
                            </div>
                            <div id="image_preview" class="hidden">
                                <img src="" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                                <p class="mt-2 text-sm text-gray-600" id="image_name"></p>
                            </div>
                        </div>
                        
                        <!-- Image Alt Text -->
                        <div class="mt-4">
                            <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-2">
                                نص بديل للصورة
                            </label>
                            <input type="text" id="image_alt" name="image_alt" 
                                   value="{{ old('image_alt', json_decode($contentBlock->metadata, true)['alt'] ?? '') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150"
                                   placeholder="وصف مختصر للصورة">
                        </div>
                    </div>

                @elseif($contentBlock->type == 'video')
                    <!-- Video Content -->
                    <div class="mb-6">
                        <label for="content_video" class="block text-sm font-medium text-gray-700 mb-2">
                            رابط الفيديو *
                        </label>
                        <input type="url" id="content_video" name="content" 
                               value="{{ old('content', $contentBlock->content) }}"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150"
                               placeholder="https://www.youtube.com/watch?v=..." required>
                        
                        <!-- Video Platform Help -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm font-medium text-red-800 mb-1">YouTube</p>
                                <p class="text-xs text-red-600">https://www.youtube.com/watch?v=VIDEO_ID</p>
                            </div>
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm font-medium text-blue-800 mb-1">Vimeo</p>
                                <p class="text-xs text-blue-600">https://vimeo.com/VIDEO_ID</p>
                            </div>
                        </div>
                        
                        <!-- Video Preview -->
                        <div id="video_preview_container" class="mt-4 {{ $contentBlock->content ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                معاينة الفيديو
                            </label>
                            <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg overflow-hidden">
                                <iframe id="video_preview" 
                                        src="{{ $contentBlock->content }}" 
                                        frameborder="0" 
                                        allowfullscreen 
                                        class="w-full h-48"></iframe>
                            </div>
                        </div>
                    </div>

                @elseif($contentBlock->type == 'exercise')
                    <!-- Exercise Content -->
                    <div class="mb-6">
                        <label for="content_exercise" class="block text-sm font-medium text-gray-700 mb-2">
                            نص التمرين *
                        </label>
                        <textarea id="content_exercise" name="content" rows="8" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150"
                                  placeholder="اكتب نص التمرين هنا..." required>{{ old('content', $contentBlock->content) }}</textarea>
                        
                        <!-- Exercise Tips -->
                        <div class="mt-4 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-orange-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-orange-800 font-medium">نصائح للتمرين</p>
                                    <ul class="text-sm text-orange-700 mt-1 list-disc list-inside">
                                        <li>اكتب التمرين بشكل واضح ومفهوم</li>
                                        <li>يمكنك إضافة خطوات الحل إذا لزم الأمر</li>
                                        <li>يمكنك تضمين معادلات باستخدام LaTeX بين علامات $$</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Content Order -->
                <div class="mt-6">
                    <label for="block_order" class="block text-sm font-medium text-gray-700 mb-2">
                        ترتيب المحتوى
                    </label>
                    <input type="number" name="block_order" id="block_order" 
                           value="{{ old('block_order', $contentBlock->block_order) }}"
                           min="0" 
                           class="w-32 px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    <p class="mt-2 text-sm text-gray-500">
                        رقم ترتيب هذا المحتوى (الأصغر يظهر أولاً)
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('content_block.show', $rule->id) }}" 
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                        إلغاء
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        تحديث المحتوى
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Section -->
       
    </div>
</div>

<!-- JavaScript for Dynamic Features -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Math Preview
        const mathTextarea = document.getElementById('content_math');
        const previewText = document.getElementById('preview_text');
        
        if (mathTextarea && previewText) {
            function updateMathPreview() {
                const latex = mathTextarea.value;
                previewText.innerHTML = latex || '$$ ... $$';
                if (window.MathJax) {
                    MathJax.typesetPromise([previewText]).catch(err => {
                        console.log('MathJax error:', err);
                    });
                }
            }
            
            mathTextarea.addEventListener('input', updateMathPreview);
            updateMathPreview();
        }

        // Image Upload
        const imageUploadArea = document.getElementById('image_upload_area');
        const imageInput = document.getElementById('content_image');
        const imagePlaceholder = document.getElementById('image_upload_placeholder');
        const imagePreview = document.getElementById('image_preview');
        const imagePreviewImg = imagePreview?.querySelector('img');
        const imageNameSpan = document.getElementById('image_name');

        if (imageUploadArea && imageInput) {
            imageUploadArea.addEventListener('click', () => imageInput.click());
            
            imageUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                imageUploadArea.classList.add('border-green-500', 'bg-green-50');
            });
            
            imageUploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                imageUploadArea.classList.remove('border-green-500', 'bg-green-50');
            });
            
            imageUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                imageUploadArea.classList.remove('border-green-500', 'bg-green-50');
                
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    imageInput.files = e.dataTransfer.files;
                    handleImagePreview(file);
                }
            });
            
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handleImagePreview(this.files[0]);
                }
            });
        }

        function handleImagePreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (imagePreviewImg) imagePreviewImg.src = e.target.result;
                if (imageNameSpan) imageNameSpan.textContent = file.name;
                if (imagePlaceholder) imagePlaceholder.classList.add('hidden');
                if (imagePreview) imagePreview.classList.remove('hidden');
                imageUploadArea.classList.add('border-green-500', 'bg-green-50');
            };
            reader.readAsDataURL(file);
        }

        // Video Preview
        const videoInput = document.getElementById('content_video');
        const videoPreviewContainer = document.getElementById('video_preview_container');
        const videoPreview = document.getElementById('video_preview');

        if (videoInput && videoPreviewContainer && videoPreview) {
            videoInput.addEventListener('input', function() {
                const url = this.value;
                
                let embedUrl = null;
                
                if (url.includes('youtube.com/watch')) {
                    const videoId = new URL(url).searchParams.get('v');
                    if (videoId) embedUrl = `https://www.youtube.com/embed/${videoId}`;
                } else if (url.includes('youtu.be/')) {
                    const videoId = url.split('youtu.be/')[1]?.split('?')[0];
                    if (videoId) embedUrl = `https://www.youtube.com/embed/${videoId}`;
                } else if (url.includes('vimeo.com/')) {
                    const videoId = url.split('vimeo.com/')[1]?.split('?')[0];
                    if (videoId) embedUrl = `https://player.vimeo.com/video/${videoId}`;
                }
                
                if (embedUrl) {
                    videoPreview.src = embedUrl;
                    videoPreviewContainer.classList.remove('hidden');
                } else {
                    videoPreviewContainer.classList.add('hidden');
                }
            });
        }
    });
</script>

<style>
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%;
    }
    
    .aspect-w-16 iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .font-arabic {
        font-family: 'Tajawal', 'Cairo', sans-serif;
        line-height: 1.8;
    }
    
    [dir="rtl"] .text-left {
        text-align: right;
    }
    
    [dir="rtl"] .font-mono {
        direction: ltr;
        text-align: left;
    }
</style>
@endsection