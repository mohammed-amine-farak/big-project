@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- MathJax Configuration - MUST be before any content -->
        <script>
            window.MathJax = {
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']],
                    displayMath: [['$$', '$$'], ['\\[', '\\]']],
                    processEscapes: true,
                    processEnvironments: true
                },
                options: {
                    skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre'],
                    ignoreHtmlClass: 'tex2jax_ignore',
                    processHtmlClass: 'tex2jax_process'
                },
                svg: {
                    fontCache: 'global'
                },
                startup: {
                    ready: () => {
                        console.log('MathJax is ready!');
                        MathJax.startup.defaultReady();
                    }
                }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" id="MathJax-script" async></script>

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إنشاء محتوى تعليمي جديد</h1>
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
                        @if($rule->description)
                            <p class="text-gray-600 text-sm mt-1">{{ $rule->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">بيانات المحتوى</h2>
            </div>
            
            <form action="{{ route('rules.content.store', $rule->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- Content Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        نوع المحتوى *
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <!-- Text Type -->
                        <label class="relative">
                            <input type="radio" name="type" value="text" class="peer sr-only" checked>
                            <div class="w-full p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 text-center">
                                <span class="text-2xl mb-2 block">📝</span>
                                <span class="text-sm font-medium text-gray-700">نص</span>
                            </div>
                        </label>
                        
                        <!-- Math Type -->
                        <label class="relative">
                            <input type="radio" name="type" value="math" class="peer sr-only">
                            <div class="w-full p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50 text-center">
                                <span class="text-2xl mb-2 block">📐</span>
                                <span class="text-sm font-medium text-gray-700">معادلة</span>
                            </div>
                        </label>
                        
                        <!-- Image Type -->
                        <label class="relative">
                            <input type="radio" name="type" value="image" class="peer sr-only">
                            <div class="w-full p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50 text-center">
                                <span class="text-2xl mb-2 block">🖼️</span>
                                <span class="text-sm font-medium text-gray-700">صورة</span>
                            </div>
                        </label>
                        
                        <!-- Video Type -->
                        <label class="relative">
                            <input type="radio" name="type" value="video" class="peer sr-only">
                            <div class="w-full p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-gray-50 text-center">
                                <span class="text-2xl mb-2 block">🎥</span>
                                <span class="text-sm font-medium text-gray-700">فيديو</span>
                            </div>
                        </label>
                        
                        <!-- Exercise Type -->
                        <label class="relative">
                            <input type="radio" name="type" value="exercise" class="peer sr-only">
                            <div class="w-full p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:bg-gray-50 text-center">
                                <span class="text-2xl mb-2 block">✏️</span>
                                <span class="text-sm font-medium text-gray-700">تمرين</span>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dynamic Content Fields -->
                <div class="space-y-6">
                    <!-- Text Content (Default) -->
                    <div id="text_content" class="content-field">
                        <label for="content_text" class="block text-sm font-medium text-gray-700 mb-2">
                            المحتوى النصي *
                        </label>
                        <textarea id="content_text" name="content" rows="8" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 font-arabic"
                                  placeholder="اكتب المحتوى النصي هنا..."></textarea>
                        <p class="mt-2 text-sm text-gray-500">
                            يمكنك كتابة النصوص التعليمية، الشروحات، أو أي محتوى نصي آخر.
                        </p>
                    </div>

                    <!-- Math Content -->
                    <div id="math_content" class="content-field hidden">
                        <label for="content_math" class="block text-sm font-medium text-gray-700 mb-2">
                            معادلة LaTeX *
                        </label>
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2 border-b border-gray-300">
                                <span class="text-xs text-gray-600">صيغة LaTeX</span>
                            </div>
                            <textarea id="content_math" name="content" rows="5" 
                                      class="w-full px-3 py-2.5 font-mono text-left focus:ring-2 focus:ring-purple-500 focus:border-purple-500 border-0 tex2jax_process"
                                      placeholder="$$ E = mc^2 $$" disabled></textarea>
                        </div>
                        
                        <!-- Math Preview with proper class for MathJax -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                معاينة المعادلة
                            </label>
                            <div id="math_preview" class="bg-gray-900 rounded-lg p-6 text-center overflow-x-auto">
                                <div class="text-green-400 text-xl tex2jax_process" id="preview_text">
                                    $$ ... $$
                                </div>
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

                    <!-- Image Content -->
                    <div id="image_content" class="content-field hidden">
                        <label for="content_image" class="block text-sm font-medium text-gray-700 mb-2">
                            رفع الصورة *
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition duration-200 cursor-pointer" id="image_upload_area">
                            <input type="file" id="content_image" name="content" accept="image/*" class="hidden" disabled>
                            <div id="image_upload_placeholder">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">انقر لرفع صورة أو اسحبها وأفلتها هنا</p>
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF يصل حجمها إلى 10MB</p>
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
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150"
                                   placeholder="وصف مختصر للصورة" disabled>
                        </div>
                    </div>

                    <!-- Video Content -->
                    <div id="video_content" class="content-field hidden">
                        <label for="content_video" class="block text-sm font-medium text-gray-700 mb-2">
                            رابط الفيديو *
                        </label>
                        <input type="url" id="content_video" name="content" 
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150"
                               placeholder="https://www.youtube.com/watch?v=..." disabled>
                        
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
                        <div id="video_preview_container" class="mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                معاينة الفيديو
                            </label>
                            <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg overflow-hidden">
                                <iframe id="video_preview" src="" frameborder="0" allowfullscreen class="w-full h-48"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Exercise Content -->
                    <div id="exercise_content" class="content-field hidden">
                        <label for="content_exercise" class="block text-sm font-medium text-gray-700 mb-2">
                            نص التمرين *
                        </label>
                        <textarea id="content_exercise" name="content" rows="8" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150"
                                  placeholder="اكتب نص التمرين هنا..." disabled></textarea>
                        
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
                </div>

                <!-- Content Order -->
                <div class="mt-6">
                    <label for="block_order" class="block text-sm font-medium text-gray-700 mb-2">
                        ترتيب المحتوى
                    </label>
                    <input type="number" name="block_order" id="block_order" 
                           value="{{ $nextOrder ?? 0 }}"
                           min="0" 
                           class="w-32 px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    <p class="mt-2 text-sm text-gray-500">
                        رقم ترتيب هذا المحتوى بالنسبة لباقي محتويات القاعدة (الأصغر يظهر أولاً)
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        حفظ المحتوى
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Dynamic Content -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const contentFields = {
            text: document.getElementById('text_content'),
            math: document.getElementById('math_content'),
            image: document.getElementById('image_content'),
            video: document.getElementById('video_content'),
            exercise: document.getElementById('exercise_content')
        };
        
        const contentInputs = {
            text: document.getElementById('content_text'),
            math: document.getElementById('content_math'),
            image: document.getElementById('content_image'),
            video: document.getElementById('content_video'),
            exercise: document.getElementById('content_exercise')
        };
        
        // Additional elements
        const imageUploadArea = document.getElementById('image_upload_area');
        const imagePlaceholder = document.getElementById('image_upload_placeholder');
        const imagePreview = document.getElementById('image_preview');
        const imagePreviewImg = imagePreview?.querySelector('img');
        const imageNameSpan = document.getElementById('image_name');
        const imageAltInput = document.getElementById('image_alt');
        
        const mathTextarea = document.getElementById('content_math');
        const previewText = document.getElementById('preview_text');
        
        const videoInput = document.getElementById('content_video');
        const videoPreviewContainer = document.getElementById('video_preview_container');
        const videoPreview = document.getElementById('video_preview');
        
        // MathJax rendering function
        function renderMath() {
            if (window.MathJax) {
                MathJax.typesetPromise([previewText]).then(() => {
                    console.log('MathJax rendered successfully');
                }).catch((err) => {
                    console.log('MathJax error:', err);
                });
            }
        }
        
        // Update math preview
        function updateMathPreview() {
            const latex = mathTextarea.value;
            if (latex.trim() === '') {
                previewText.innerHTML = '$$\\text{  }$$';
            } else {
                previewText.innerHTML = latex;
            }
            
            // Render with MathJax
            setTimeout(renderMath, 50);
        }
        
        // Math input event
        if (mathTextarea) {
            mathTextarea.addEventListener('input', updateMathPreview);
        }
        
        // Switch content type
        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const type = this.value;
                
                // Hide all fields and disable inputs
                Object.keys(contentFields).forEach(key => {
                    if (contentFields[key]) {
                        contentFields[key].classList.add('hidden');
                    }
                    if (contentInputs[key]) {
                        contentInputs[key].disabled = true;
                    }
                });
                
                // Show selected field and enable input
                if (contentFields[type]) {
                    contentFields[type].classList.remove('hidden');
                    if (contentInputs[type]) {
                        contentInputs[type].disabled = false;
                        
                        // Special handling for different types
                        if (type === 'math') {
                            setTimeout(() => {
                                updateMathPreview();
                            }, 100);
                        } else if (type === 'image') {
                            if (imageAltInput) imageAltInput.disabled = false;
                        } else if (type === 'video') {
                            if (videoPreviewContainer) videoPreviewContainer.classList.add('hidden');
                            if (videoPreview) videoPreview.src = '';
                        }
                    }
                }
            });
        });
        
        // Image Upload Handling
        if (imageUploadArea) {
            imageUploadArea.addEventListener('click', function() {
                document.getElementById('content_image')?.click();
            });
            
            imageUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-green-500', 'bg-green-50');
            });
            
            imageUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-green-500', 'bg-green-50');
            });
            
            imageUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-green-500', 'bg-green-50');
                
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    const input = document.getElementById('content_image');
                    if (input) {
                        input.files = e.dataTransfer.files;
                        handleImagePreview(file);
                    }
                }
            });
            
            const imageInput = document.getElementById('content_image');
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        handleImagePreview(this.files[0]);
                    }
                });
            }
        }
        
        function handleImagePreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (imagePreviewImg) imagePreviewImg.src = e.target.result;
                if (imageNameSpan) imageNameSpan.textContent = file.name;
                if (imagePlaceholder) imagePlaceholder.classList.add('hidden');
                if (imagePreview) imagePreview.classList.remove('hidden');
                if (imageUploadArea) {
                    imageUploadArea.classList.add('border-green-500', 'bg-green-50');
                }
            };
            reader.readAsDataURL(file);
        }
        
        // Video URL Preview
        if (videoInput) {
            videoInput.addEventListener('input', function() {
                const url = this.value;
                
                // Extract YouTube or Vimeo video ID
                let embedUrl = null;
                
                try {
                    // YouTube
                    if (url.includes('youtube.com/watch')) {
                        const videoId = new URL(url).searchParams.get('v');
                        if (videoId) {
                            embedUrl = `https://www.youtube.com/embed/${videoId}`;
                        }
                    } else if (url.includes('youtu.be/')) {
                        const videoId = url.split('youtu.be/')[1]?.split('?')[0];
                        if (videoId) {
                            embedUrl = `https://www.youtube.com/embed/${videoId}`;
                        }
                    }
                    // Vimeo
                    else if (url.includes('vimeo.com/')) {
                        const videoId = url.split('vimeo.com/')[1]?.split('?')[0];
                        if (videoId) {
                            embedUrl = `https://player.vimeo.com/video/${videoId}`;
                        }
                    }
                } catch (e) {
                    console.log('Invalid URL');
                }
                
                if (embedUrl && videoPreview && videoPreviewContainer) {
                    videoPreview.src = embedUrl;
                    videoPreviewContainer.classList.remove('hidden');
                } else if (videoPreviewContainer) {
                    videoPreviewContainer.classList.add('hidden');
                }
            });
        }
        
        // Form validation
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const selectedType = document.querySelector('input[name="type"]:checked')?.value;
            if (!selectedType) return;
            
            const contentInput = contentInputs[selectedType];
            
            if (!contentInput || !contentInput.value.trim()) {
                e.preventDefault();
                alert('يرجى إدخال المحتوى');
                if (contentInput) contentInput.focus();
                return false;
            }
            
            // Additional validation for image
            if (selectedType === 'image') {
                const imageInput = document.getElementById('content_image');
                if (imageInput && imageInput.files.length === 0) {
                    e.preventDefault();
                    alert('يرجى اختيار صورة');
                    return false;
                }
            }
            
            // Add loading state to submit button
            const submitBtn = e.target.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <div class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent ml-2"></div>
                    جاري الحفظ...
                `;
            }
        });

        // Initial render if math is selected
        if (document.querySelector('input[name="type"]:checked')?.value === 'math') {
            setTimeout(updateMathPreview, 200);
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
    
    .content-field {
        transition: all 0.3s ease;
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
    
    input[type="radio"]:checked + div {
        transform: scale(1.02);
    }
    
    .font-arabic {
        font-family: 'Tajawal', 'Cairo', sans-serif;
        line-height: 1.8;
    }
    
    /* MathJax styles */
    .tex2jax_process {
        direction: ltr;
        text-align: center;
    }
    
    #preview_text mjx-container {
        color: #4ade80 !important;
        font-size: 1.2rem;
    }
    
    /* RTL adjustments */
    [dir="rtl"] .text-left {
        text-align: right;
    }
    
    [dir="rtl"] .font-mono {
        direction: ltr;
        text-align: left;
    }
</style>
@endsection