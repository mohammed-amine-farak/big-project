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

        <!-- Messages -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Request Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-blue-900 mb-1">تفاصيل الطلب</h3>
                    <p class="text-sm text-blue-800">
                        <span class="font-medium">الدرس:</span> {{ $production_request->lesson->title }} • 
                        <span class="font-medium">الباحث:</span> {{ $production_request->researcher->user->name }}
                    </p>
                    @if($production_request->rule)
                    <p class="text-sm text-blue-700 mt-1">
                        <span class="font-medium">القاعدة:</span> {{ $production_request->rule->title }}
                    </p>
                    @endif
                    @if($production_request->deadline)
                    <p class="text-sm text-blue-700 mt-1">
                        <span class="font-medium">تاريخ التسليم:</span> {{ $production_request->deadline->format('Y-m-d') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upload Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">بيانات الفيديو</h2>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data" id="uploadForm" class="p-6">
                @csrf
                
                <!-- Video Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        عنوان الفيديو *
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $production_request->title) }}" required
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150"
                           placeholder="أدخل عنوان الفيديو...">
                    @error('title')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Description -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                وصف الفيديو
                            </label>
                            <p class="text-sm text-gray-500">وصف مختصر لمحتوى الفيديو</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span id="character_count" class="text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full">
                                0 حرف
                            </span>
                        </div>
                    </div>
                    
                    <!-- Description Textarea -->
                    <div>
                        <textarea id="description" name="description" rows="4" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150" 
                                  placeholder="وصف مختصر لمحتوى الفيديو...">{{ old('description') }}</textarea>
                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-gray-500">اختياري - يمكنك ترك هذا الحقل فارغاً</p>
                            <p class="text-xs text-gray-500">الحد الأقصى: 500 حرف</p>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Video File Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ملف الفيديو *
                    </label>
                    
                    <!-- File Upload Area -->
                    <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-orange-500 transition-colors cursor-pointer bg-gray-50">
                        <input type="file" id="video_file" name="video_file" accept="video/mp4,video/mov,video/avi" class="hidden" required>
                        
                        <div id="upload_placeholder" class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium">اضغط لرفع الفيديو أو اسحبه وأفلته هنا</p>
                                <p class="text-sm text-gray-500 mt-1">MP4, MOV, AVI (بحد أقصى 500MB)</p>
                            </div>
                        </div>
                        
                        <div id="file_info" class="hidden flex flex-col items-center gap-2">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p id="file_name" class="text-gray-700 font-medium"></p>
                                <p id="file_size" class="text-sm text-gray-500 mt-1"></p>
                            </div>
                            <button type="button" id="change_file" class="text-orange-600 hover:text-orange-800 text-sm font-medium mt-2">
                                تغيير الملف
                            </button>
                        </div>
                    </div>
                    
                    <!-- Video Requirements -->
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>الصيغ المدعومة: MP4, MOV, AVI</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>الحد الأقصى للحجم: 500 ميجابايت</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>الدقة الموصى بها: 1080p أو أعلى</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>المدة الموصى بها: 5-15 دقيقة</span>
                        </div>
                    </div>
                    
                    @error('video_file')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Notes (Optional) -->
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        ملاحظات إضافية (اختياري)
                    </label>
                    <textarea id="notes" name="notes" rows="2" 
                              class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150" 
                              placeholder="أي ملاحظات إضافية للباحث...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('video_creator.production_request.show', $production_request->id) }}" 
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150">
                        إلغاء
                    </a>
                    <button type="submit" id="submitBtn"
                            class="px-5 py-2.5 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-150 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <span id="submit_text">رفع الفيديو</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const dropzone = document.getElementById('dropzone');
        const videoFile = document.getElementById('video_file');
        const uploadPlaceholder = document.getElementById('upload_placeholder');
        const fileInfo = document.getElementById('file_info');
        const fileName = document.getElementById('file_name');
        const fileSize = document.getElementById('file_size');
        const changeFile = document.getElementById('change_file');
        const description = document.getElementById('description');
        const characterCount = document.getElementById('character_count');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submit_text');
        const uploadForm = document.getElementById('uploadForm');

        // Character Counter
        if (description) {
            description.addEventListener('input', function() {
                const count = this.value.length;
                characterCount.textContent = `${count} حرف`;
                
                // Update count badge color
                if (count === 0) {
                    characterCount.className = 'text-sm text-gray-600 px-3 py-1 bg-gray-100 rounded-full';
                } else if (count <= 200) {
                    characterCount.className = 'text-sm text-green-600 px-3 py-1 bg-green-100 rounded-full';
                } else if (count <= 400) {
                    characterCount.className = 'text-sm text-blue-600 px-3 py-1 bg-blue-100 rounded-full';
                } else {
                    characterCount.className = 'text-sm text-yellow-600 px-3 py-1 bg-yellow-100 rounded-full';
                }
                
                // Show warning if approaching limit
                if (count > 450) {
                    characterCount.className = 'text-sm text-red-600 px-3 py-1 bg-red-100 rounded-full';
                }
            });
        }

        // Initialize character count
        if (description) {
            description.dispatchEvent(new Event('input'));
        }

        // File Upload Handling
        dropzone.addEventListener('click', function() {
            videoFile.click();
        });

        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropzone.classList.add('border-orange-500', 'bg-orange-50');
        });

        dropzone.addEventListener('dragleave', function() {
            dropzone.classList.remove('border-orange-500', 'bg-orange-50');
        });

        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropzone.classList.remove('border-orange-500', 'bg-orange-50');
            
            if (e.dataTransfer.files.length) {
                videoFile.files = e.dataTransfer.files;
                updateFileInfo(e.dataTransfer.files[0]);
            }
        });

        videoFile.addEventListener('change', function() {
            if (this.files.length) {
                updateFileInfo(this.files[0]);
            }
        });

        changeFile.addEventListener('click', function(e) {
            e.stopPropagation();
            videoFile.value = '';
            uploadPlaceholder.classList.remove('hidden');
            fileInfo.classList.add('hidden');
        });

        function updateFileInfo(file) {
            // Check file size (max 500MB)
            const maxSize = 500 * 1024 * 1024; // 500MB in bytes
            if (file.size > maxSize) {
                alert('حجم الملف كبير جداً. الحد الأقصى هو 500 ميجابايت');
                videoFile.value = '';
                return;
            }

            // Check file type
            const allowedTypes = ['video/mp4', 'video/quicktime', 'video/x-msvideo'];
            if (!allowedTypes.includes(file.type)) {
                alert('نوع الملف غير مدعوم. الصيغ المدعومة: MP4, MOV, AVI');
                videoFile.value = '';
                return;
            }

            uploadPlaceholder.classList.add('hidden');
            fileInfo.classList.remove('hidden');
            
            fileName.textContent = file.name;
            
            // Format file size
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            fileSize.textContent = `الحجم: ${sizeInMB} MB`;
        }

        // Form Validation
        uploadForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const file = videoFile.files[0];
            
            // Validate title
            if (!title) {
                e.preventDefault();
                alert('يرجى إدخال عنوان الفيديو');
                document.getElementById('title').focus();
                return false;
            }
            
            // Validate file
            if (!file) {
                e.preventDefault();
                alert('يرجى اختيار ملف الفيديو');
                return false;
            }
            
            // Validate description length
            const descLength = description.value.length;
            if (descLength > 500) {
                e.preventDefault();
                alert('وصف الفيديو يجب أن لا يتجاوز 500 حرف');
                description.focus();
                return false;
            }
            
            // Add loading state to submit button
            submitBtn.disabled = true;
            submitText.innerHTML = `
                <div class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></div>
                جاري الرفع...
            `;
        });
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
    
    #dropzone {
        transition: all 0.3s ease;
    }
    
    input:focus, select:focus, textarea:focus {
        outline: none;
        ring-width: 2px;
    }
    
    /* Loading animation */
    .btn-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }
</style>

@endsection