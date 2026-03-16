@extends('layouts.video_dashboard')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">الملف الشخصي</h1>
            <p class="text-gray-600 mt-1">عرض وإدارة معلوماتك الشخصية والمهنية</p>
        </div>

        <!-- Profile Header Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 h-32"></div>
            <div class="px-8 pb-8">
                <div class="flex flex-col md:flex-row md:items-end -mt-16 gap-6">
                    <!-- Profile Image -->
                    <div class="relative">
                        <div class="w-32 h-32 rounded-2xl border-4 border-white shadow-xl overflow-hidden bg-white">
                            @if($videoCreator->profile_image)
                                <img src="{{ asset('storage/' . $videoCreator->profile_image) }}" 
                                     alt="{{ $videoCreator->user->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <span class="text-4xl font-bold text-gray-400">
                                        {{ substr($videoCreator->user->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="absolute bottom-2 left-2">
                            @if($videoCreator->status == 'active')
                                <span class="w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
                            @elseif($videoCreator->status == 'busy')
                                <span class="w-4 h-4 bg-yellow-500 rounded-full border-2 border-white"></span>
                            @else
                                <span class="w-4 h-4 bg-gray-500 rounded-full border-2 border-white"></span>
                            @endif
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 md:pb-4">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">{{ $videoCreator->user->name }}</h2>
                                <p class="text-gray-600 text-lg">{{ $videoCreator->specialization }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="flex items-center gap-1 text-sm text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $videoCreator->user->email }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Edit Button -->
                            <a href="{{ route('video_creator.profile.edit') }}" 
                               class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-medium flex items-center gap-2 transition-colors shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                تعديل الملف الشخصي
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">إجمالي الفيديوهات</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalVideos }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">إجمالي المشاهدات</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalViews) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">مشاريع مكتملة</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $completedRequests }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">التقييم</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($videoCreator->average_rating, 1) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Right Column - Profile Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About Section -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">نبذة عني</h3>
                    </div>
                    <div class="p-6">
                        @if($videoCreator->bio)
                            <p class="text-gray-700 leading-relaxed">{{ $videoCreator->bio }}</p>
                        @else
                            <p class="text-gray-400 text-center py-8">لم تقم بإضافة نبذة تعريفية بعد</p>
                        @endif
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">المهارات</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $skills = is_string($videoCreator->skills) 
                                ? json_decode($videoCreator->skills, true) 
                                : $videoCreator->skills;
                        @endphp
                        
                        @if(!empty($skills))
                            <div class="flex flex-wrap gap-2">
                                @foreach($skills as $skill)
                                    <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-medium">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-center py-8">لم تقم بإضافة مهارات بعد</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Videos -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-gray-50 to-white px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">أحدث الفيديوهات</h3>
                        <a href="{{ route('video_creator.videos.index') }}" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                            عرض الكل
                        </a>
                    </div>
                    <div class="p-6">
                        @if($recentVideos->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentVideos as $video)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $video->title }}</p>
                                                <p class="text-xs text-gray-500">{{ $video->created_at->format('Y/m/d') }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-600">{{ number_format($video->views) }} مشاهدة</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-center py-8">لا توجد فيديوهات بعد</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Left Column - Sidebar Info -->
            <div class="space-y-8">
                <!-- Professional Info -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">معلومات مهنية</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">التخصص</p>
                                <p class="font-medium text-gray-900">{{ $videoCreator->specialization }}</p>
                            </div>
                        </div>

                        @if($videoCreator->preferred_software)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">البرامج المفضلة</p>
                                <p class="font-medium text-gray-900">{{ $videoCreator->preferred_software }}</p>
                            </div>
                        </div>
                        @endif

                        @if($videoCreator->portfolio_url)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">معرض الأعمال</p>
                                <a href="{{ $videoCreator->portfolio_url }}" target="_blank" 
                                   class="font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $videoCreator->portfolio_url }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">عضو منذ</p>
                                <p class="font-medium text-gray-900">{{ $videoCreator->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">حالة التوفر</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-gray-700">الحالة الحالية</span>
                            @if($videoCreator->status == 'active')
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
                                    متاح
                                </span>
                            @elseif($videoCreator->status == 'busy')
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium">
                                    مشغول
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium">
                                    غير متاح
                                </span>
                            @endif
                        </div>
                        
                        <!-- Status Update Buttons -->
                        <div class="grid grid-cols-3 gap-2">
                            <button onclick="updateStatus('active')" 
                                    class="px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-sm font-medium transition-colors">
                                متاح
                            </button>
                            <button onclick="updateStatus('busy')" 
                                    class="px-3 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg text-sm font-medium transition-colors">
                                مشغول
                            </button>
                            <button onclick="updateStatus('inactive')" 
                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                غير متاح
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-l from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">معلومات الحساب</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">البريد الإلكتروني</span>
                            <span class="font-medium text-gray-900">{{ $videoCreator->user->email }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">تاريخ التسجيل</span>
                            <span class="font-medium text-gray-900">{{ $videoCreator->user->created_at->format('Y/m/d') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500">آخر تحديث</span>
                            <span class="font-medium text-gray-900">{{ $videoCreator->updated_at->format('Y/m/d') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Status Update -->
<script>
function updateStatus(status) {
    fetch('{{ route("video_creator.profile.update-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection