@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">تفاصيل المهارة</h1>
                    <p class="text-gray-600 text-sm">عرض كامل المعلومات ومستويات المهارة الخاصة بـ {{ $result->name }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('skills.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        العودة للمهارات
                    </a>
                </div>
            </div>
        </div>

        <!-- Skill Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1v-3h-6z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $result->name }}</h2>
                        <p class="text-sm text-gray-600">
                            {{ $result->subject->name ?? 'غير محدد المادة' }}
                            • {{ $result->levelSkills->count() }} مستوى
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">وصف المهارة</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-right">
                            {{ $result->description }}
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
                            <p class="text-gray-900 font-medium">{{ $result->created_at?->format('Y-m-d') ?? 'غير محدد' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">الموضوع المرتبط</p>
                            <p class="text-gray-900 font-medium">{{ $result->subject->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-1.5 2.5a.5.5 0 00.5.5h-5.5a.5.5 0 00-.5.5v5.5a.5.5 0 00.5.5H15a.5.5 0 00.5-.5V15z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21v-3.5"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">مجال الدراسة</p>
                            <p class="text-gray-900 font-medium">{{ $result->subject->fieldOfStudy->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('skills.edit', $result->id) }}" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        تعديل المهارة
                    </a>
                    
                    <form action="{{ route('skills.destroy', $result->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('هل أنت متأكد من حذف هذه المهارة؟ سيتم حذف جميع المستويات المرتبطة بها.');"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            حذف المهارة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Skill Levels Section -->
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
                            <h2 class="text-lg font-semibold text-gray-900">مستويات المهارة</h2>
                            <p class="text-sm text-gray-600">عرض وتعديل مستويات مهارة {{ $result->name }}</p>
                        </div>
                    </div>
                    @if($result->levelSkills->count() < 3)
                    <a href="{{ route('create_level.create', $result->id) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إضافة مستوى جديد
                    </a>
                    @else
                    <button class="bg-gray-400 text-white font-medium px-4 py-2 rounded-lg flex items-center gap-2 text-sm cursor-not-allowed" disabled>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        الحد الأقصى للمستويات
                    </button>
                    @endif
                </div>
            </div>

            <div class="p-6">
                @if($result->levelSkills->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد مستويات</h3>
                        <p class="text-gray-500 text-sm mb-6">لم يتم إضافة أي مستويات لهذه المهارة بعد</p>
                        <a href="{{ route('create_level.create', $result->id) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 inline-flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة أول مستوى
                        </a>
                    </div>
                @else
                    <!-- Levels Progress -->
                    <div class="mb-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <h3 class="text-sm font-medium text-blue-900 mb-3">تقدم المستويات</h3>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-blue-700">المستويات المضافة:</span>
                            <span class="font-medium text-blue-900">{{ $result->levelSkills->count() }} من 3</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($result->levelSkills->count() / 3) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Levels Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($result->levelSkills->sortBy('level') as $levelSkill)
                            <div class="bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-6 hover:border-gray-400 transition duration-200 hover-lift">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                        @if($levelSkill->level == 'level_1')
                                            المستوى الأول
                                        @elseif($levelSkill->level == 'level_2')
                                            المستوى الثاني
                                        @elseif($levelSkill->level == 'level_3')
                                            المستوى الثالث
                                        @endif
                                    </span>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('level.edit', $levelSkill->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1 transition duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('level.destroy', $levelSkill->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا المستوى؟');"
                                                    class="text-red-600 hover:text-red-800 p-1 transition duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-3 text-right">
                                    {{ $levelSkill->level_name }}
                                </h3>

                                @if($levelSkill->level_description)
                                <p class="text-gray-700 text-sm mb-4 leading-relaxed text-right whitespace-pre-line">
                                    {{ $levelSkill->level_description }}
                                </p>
                                @else
                                <p class="text-gray-400 text-sm mb-4 text-right">لا يوجد وصف للمستوى</p>
                                @endif

                                <div class="flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-gray-200">
                                    <span>آخر تحديث</span>
                                    <span>{{ $levelSkill->updated_at?->format('Y-m-d') ?? 'غير محدد' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Levels Summary -->
                    @if($result->levelSkills->count() < 3)
                    <div class="mt-6 bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="text-yellow-800 text-sm font-medium">يمكنك إضافة {{ 3 - $result->levelSkills->count() }} مستوى إضافي</p>
                                <p class="text-yellow-700 text-xs">الحد الأقصى للمستويات هو 3 مستويات لكل مهارة</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}
.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
}

</style>
@endsection