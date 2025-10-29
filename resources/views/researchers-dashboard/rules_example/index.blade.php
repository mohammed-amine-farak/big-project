@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">تفاصيل القاعدة</h1>
                    <p class="text-gray-600 text-sm">عرض كامل المعلومات والأمثلة الخاصة بالقاعدة</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('rules.index') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للقواعد
                    </a>
                </div>
            </div>
        </div>

        <!-- Rule Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $rule->title }}</h2>
                        <p class="text-sm text-gray-600">
                            {{ $rule->lesson->title ?? 'غير محدد الدرس' }}
                            • {{ $rule->examples->count() }} مثال
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">وصف القاعدة</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-right">
                            {{ $rule->description }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">تاريخ الإنشاء</p>
                            <p class="text-gray-900 font-medium">{{ $rule->created_at?->format('Y-m-d') ?? 'غير محدد' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">عدد الأمثلة</p>
                            <p class="text-gray-900 font-medium">{{ $rule->examples->count() }} مثال</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">الدرس المرتبط</p>
                            <p class="text-gray-900 font-medium">{{ $rule->lesson->title ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('rules.edit', $rule->id) }}" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        تعديل القاعدة
                    </a>
                    
                    <form action="{{ route('rules.destroy', $rule->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('هل أنت متأكد من حذف هذه القاعدة؟ سيتم حذف جميع الأمثلة المرتبطة بها.');"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            حذف القاعدة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Examples Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">الأمثلة التوضيحية</h2>
                            <p class="text-sm text-gray-600">عرض وتعديل أمثلة القاعدة</p>
                        </div>
                    </div>
                    <a href="{{ route('Example.create', $rule->id) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إضافة مثال
                    </a>
                </div>
            </div>

            <div class="p-6">
                @if($rule->examples->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد أمثلة</h3>
                        <p class="text-gray-500 text-sm mb-6">لم يتم إضافة أي أمثلة لهذه القاعدة بعد</p>
                        <a href="{{ route('Example.create', $rule->id) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 inline-flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة أول مثال
                        </a>
                    </div>
                @else
                    <!-- Examples Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($rule->examples as $example)
                            <div class="bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-6 hover:border-gray-400 transition duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                        مثال {{ $loop->iteration }}
                                    </span>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('Example.edit', ['rule' => $rule->id, 'example' => $example->id]) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1 transition duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('Example.destroy', ['rule' => $rule->id, 'example' => $example->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا المثال؟');"
                                                    class="text-red-600 hover:text-red-800 p-1 transition duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-3 text-right">
                                    {{ $example->example_title }}
                                </h3>

                                @if($example->example_description)
                                <p class="text-gray-700 text-sm mb-4 leading-relaxed text-right">
                                    {{ Str::limit($example->example_description, 120) }}
                                </p>
                                @endif

                                @if($example->example_text)
                                <div class="bg-gray-900 rounded-lg p-3 mb-4 overflow-x-auto">
                                    <code class="text-green-400 text-xs whitespace-pre-wrap font-mono">
                                        {{ Str::limit($example->example_text, 100) }}
                                    </code>
                                </div>
                                @endif

                                @if($example->image_url)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $example->image_url) }}" 
                                         alt="{{ $example->image_alt_ar ?? 'صورة توضيحية' }}" 
                                         class="w-full h-32 object-cover rounded-lg shadow-sm">
                                    @if($example->image_caption_ar)
                                    <p class="text-xs text-gray-600 mt-2 text-center">
                                        {{ Str::limit($example->image_caption_ar, 50) }}
                                    </p>
                                    @endif
                                </div>
                                @endif

                                <div class="flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-gray-200">
                                    <span>آخر تحديث</span>
                                    <span>{{ $example->updated_at?->format('Y-m-d') ?? 'غير محدد' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}
</style>
@endsection