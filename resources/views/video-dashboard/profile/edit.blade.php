@extends('layouts.video_dashboard')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">تعديل الملف الشخصي</h1>
                <p class="text-gray-600 mt-1">قم بتحديث معلوماتك الشخصية والمهنية</p>
            </div>
            <a href="{{ route('video_creator.profile.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="font-medium">يوجد {{ $errors->count() }} أخطاء</p>
            </div>
            <ul class="list-disc list-inside mr-8 space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-l from-orange-50 to-red-50 px-8 py-5 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">المعلومات الأساسية</h2>
            </div>

            <form action="{{ route('video_creator.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <!-- Profile Image -->
<div>
    <label class="block text-lg font-semibold text-gray-700 mb-4 text-right">
        الصورة الشخصية
    </label>
    <div class="flex items-center gap-6">
        <div class="relative">
            <div class="w-32 h-32 rounded-2xl border-4 border-gray-200 overflow-hidden bg-gray-50">
                @if($videoCreator->profile_image) {{-- ✅ الصحيح --}}
                    <img src="{{ asset('storage/' . $videoCreator->profile_image) }}" 
                         alt="{{ $user->name }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <span class="text-4xl font-bold text-gray-400">
                            {{ substr($user->name, 0, 1) }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="absolute -bottom-2 -left-2">
                <label for="profile_image" class="cursor-pointer">
                    <div class="bg-orange-600 hover:bg-orange-700 text-white p-2 rounded-lg shadow-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden">
                </label>
            </div>
        </div>
        <div class="flex-1">
            <p class="text-sm text-gray-500 mb-2">الصيغ المسموحة: JPG, PNG, GIF</p>
            <p class="text-sm text-gray-500">الحد الأقصى: 2 ميجابايت</p>
        </div>
    </div>
</div>

                    <!-- Name and Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2 text-right">
                                الاسم الكامل <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2 text-right">
                                البريد الإلكتروني <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        </div>
                    </div>

                    <!-- Specialization -->
                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2 text-right">
                            التخصص <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="specialization" 
                               name="specialization" 
                               value="{{ old('specialization', $videoCreator->specialization) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                               placeholder="مثال: رياضيات، فيزياء، كيمياء">
                        <p class="text-xs text-gray-500 mt-2">التخصص الذي تنتج فيه الفيديوهات</p>
                    </div>

                    <!-- Skills -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3 text-right">
                            المهارات <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @php
                                $selectedSkills = old('skills', $skills ?? []);
                            @endphp
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="مونتاج" {{ in_array('مونتاج', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">🎬 مونتاج</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="رسوم متحركة" {{ in_array('رسوم متحركة', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">✨ رسوم متحركة</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="تعليق صوتي" {{ in_array('تعليق صوتي', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">🎙️ تعليق صوتي</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="مؤثرات بصرية" {{ in_array('مؤثرات بصرية', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">✨ مؤثرات بصرية</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="كتابة سيناريو" {{ in_array('كتابة سيناريو', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">📝 كتابة سيناريو</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="تصوير" {{ in_array('تصوير', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">📹 تصوير</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="إضاءة" {{ in_array('إضاءة', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">💡 إضاءة</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors">
                                <input type="checkbox" name="skills[]" value="تلوين" {{ in_array('تلوين', $selectedSkills) ? 'checked' : '' }} class="rounded text-orange-600 focus:ring-orange-500">
                                <span class="text-sm">🎨 تلوين</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">اختر مهارة واحدة على الأقل</p>
                    </div>

                    <!-- Preferred Software -->
                    <div>
                        <label for="preferred_software" class="block text-sm font-medium text-gray-700 mb-2 text-right">
                            البرامج المفضلة
                        </label>
                        <input type="text" 
                               id="preferred_software" 
                               name="preferred_software" 
                               value="{{ old('preferred_software', $videoCreator->preferred_software) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                               placeholder="مثال: Adobe Premiere, After Effects, DaVinci Resolve">
                    </div>

                    <!-- Portfolio URL -->
                    <div>
                        <label for="portfolio_url" class="block text-sm font-medium text-gray-700 mb-2 text-right">
                            رابط معرض الأعمال
                        </label>
                        <input type="url" 
                               id="portfolio_url" 
                               name="portfolio_url" 
                               value="{{ old('portfolio_url', $videoCreator->portfolio_url) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                               placeholder="https://youtube.com/... أو https://portfolio.com/...">
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2 text-right">
                            نبذة عني
                        </label>
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="5" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                  placeholder="اكتب نبذة مختصرة عن خبراتك ومهاراتك...">{{ old('bio', $videoCreator->bio) }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">أقصى طول 1000 حرف</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white py-4 px-6 rounded-xl font-semibold text-lg transition-colors shadow-lg">
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection