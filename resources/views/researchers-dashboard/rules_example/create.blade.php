@extends('layouts.reseacher_dashboard')

@section('content')
<div class="mx-auto mt-12 px-6" style="max-width: 80%;">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">
            ➕ إضافة مثال جديد للقاعدة: <span class="text-blue-700">{{ $rule->title }}</span>
        </h1>
        <a href="{{ route('Example.index', $rule->id) }}" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
            العودة إلى أمثلة القاعدة
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">عذراً!</strong>
            <span class="block sm:inline">كان هناك بعض المشاكل مع إدخالك.</span>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form action="{{ route('Example.store', $rule->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="example_title" class="block text-gray-700 text-lg font-bold mb-2">عنوان المثال:</label>
                <input type="text" name="example_title" id="example_title"
                       class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       value="{{ old('example_title') }}" required>
                @error('example_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="example_text" class="block text-gray-700 text-lg font-bold mb-2">نص المثال مع المعادلات الرياضية:</label>
                
                <!-- Quick Equation Buttons -->
                <div class="bg-gray-50 p-3 rounded-t-lg border border-gray-300 flex flex-wrap gap-2 mb-2">
                    <span class="text-sm text-gray-600 ml-2">معادلات سريعة:</span>
                    <button type="button" onclick="insertEquation('x^2 + y^2 = z^2')" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded text-sm">$x^2 + y^2 = z^2$</button>
                    <button type="button" onclick="insertEquation('\\frac{a}{b}')" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded text-sm">$\frac{a}{b}$</button>
                    <button type="button" onclick="insertEquation('\\sqrt{x}')" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded text-sm">$\sqrt{x}$</button>
                    <button type="button" onclick="insertEquation('\\int_{a}^{b} f(x) dx')" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded text-sm">$\int_{a}^{b} f(x) dx$</button>
                    <button type="button" onclick="insertEquation('\\sum_{i=1}^{n} i^2')" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded text-sm">$\sum_{i=1}^{n} i^2$</button>
                </div>
                
                <!-- Textarea for writing equations with LaTeX -->
                <textarea name="example_text" id="example_text" rows="6"
                          class="shadow border rounded-t-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline font-mono text-lg"
                          placeholder="اكتب المعادلات بصيغة LaTeX... 
مثال: $x^2 + y^2 = z^2$ أو $$\int_{0}^{\infty} e^{-x^2} dx = \frac{\sqrt{\pi}}{2}$$"
                          style="direction: ltr; text-align: left;"
                          required>{{ old('example_text') }}</textarea>
                
                <!-- Live Preview Area -->
                <div class="mt-4 p-4 border rounded-lg bg-gray-50">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-sm font-bold text-gray-700">📐 معاينة المعادلات:</p>
                        <span class="text-xs text-gray-500">يتم تحديث المعاينة تلقائياً</span>
                    </div>
                    <div id="equation-preview" class="prose max-w-none p-4 bg-white rounded border min-h-[100px]" 
                         style="direction: ltr; text-align: left;">
                        {{ old('example_text') }}
                    </div>
                </div>
                
                <!-- Help Text -->
                <p class="text-sm text-blue-600 mt-2">
                    💡 استخدم $...$ للمعادلات داخل السطر، و $$...$$ للمعادلات المنفصلة
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    أمثلة: $\alpha$, $\beta$, $\gamma$, $\infty$, $\pi$, $\theta$
                </p>
                
                @error('example_text')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="example_description" class="block text-gray-700 text-lg font-bold mb-2">وصف المثال (اختياري):</label>
                <textarea name="example_description" id="example_description" rows="3"
                          class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          style="direction: rtl; text-align: right;">{{ old('example_description') }}</textarea>
                @error('example_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image_url" class="block text-gray-700 text-lg font-bold mb-2">صورة المثال (اختياري):</label>
                <input type="file" name="image_url" id="image_url"
                       class="block w-full text-lg text-gray-700
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image_alt_ar" class="block text-gray-700 text-lg font-bold mb-2">وصف الصورة (للوصول وتحسين محركات البحث) (اختياري):</label>
                <input type="text" name="image_alt_ar" id="image_alt_ar"
                       class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       style="direction: rtl; text-align: right;"
                       value="{{ old('image_alt_ar') }}">
                @error('image_alt_ar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image_caption_ar" class="block text-gray-700 text-lg font-bold mb-2">تعليق الصورة (اختياري):</label>
                <input type="text" name="image_caption_ar" id="image_caption_ar"
                       class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       style="direction: rtl; text-align: right;"
                       value="{{ old('image_caption_ar') }}">
                @error('image_caption_ar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300 focus:outline-none focus:shadow-outline">
                    حفظ المثال
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MathJax for rendering equations -->
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

<!-- JavaScript for Live Preview and Equation Insertion -->
<script>
    // Function to insert equation templates
    function insertEquation(equation) {
        const textarea = document.getElementById('example_text');
        const cursorPos = textarea.selectionStart;
        const textBefore = textarea.value.substring(0, cursorPos);
        const textAfter = textarea.value.substring(cursorPos);
        
        // Wrap equation in $ if it's not already wrapped
        const newEquation = equation.startsWith('$') ? equation : '$' + equation + '$';
        
        textarea.value = textBefore + newEquation + textAfter;
        textarea.focus();
        
        // Update preview
        updatePreview();
    }
    
    // Function to update preview
    function updatePreview() {
        const preview = document.getElementById('equation-preview');
        const equationText = document.getElementById('example_text').value;
        
        preview.innerHTML = equationText;
        
        // Rerender MathJax
        if (window.MathJax) {
            MathJax.typesetPromise([preview]).catch(function(err) {
                console.log('MathJax error:', err);
            });
        }
    }
    
    // Live preview on input
    document.getElementById('example_text').addEventListener('input', updatePreview);
    
    // Initial preview on page load
    document.addEventListener('DOMContentLoaded', function() {
        updatePreview();
    });
</script>

<style>
    /* تنسيق المعادلات */
    .MathJax {
        font-size: 1.2em !important;
        direction: ltr !important;
    }
    
    /* تنسيق معاينة المعادلات */
    #equation-preview {
        line-height: 2;
        unicode-bidi: embed;
    }
    
    /* تنسيق النص العربي */
    .prose {
        max-width: 100%;
    }
    
    /* تنسيق حقل المعادلات */
    #example_text {
        font-family: 'Courier New', monospace;
    }
    
    /* تنسيق الحقول العربية */
    input[type="text"], textarea {
        unicode-bidi: plaintext;
    }
</style>

@endsection