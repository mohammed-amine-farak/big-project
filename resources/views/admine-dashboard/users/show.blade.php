{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.admin_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تفاصيل المستخدم</h1>
                <p class="text-sm text-gray-500 mt-1">رقم المستخدم: #{{ $user->id }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @if($user->account_status === 'approved')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    حساب مقبول
                </span>
            @elseif($user->account_status === 'pending')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    قيد المراجعة
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    حساب مرفوض
                </span>
            @endif
        </div>

        <!-- Main Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- User Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">المستخدم</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $user->name }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">البريد الإلكتروني:</span>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">نوع الحساب:</span>
                        <span class="font-medium">
                            @if($user->user_type == 'teacher') 👨‍🏫 معلم
                            @elseif($user->user_type == 'student') 🎓 طالب
                            @elseif($user->user_type == 'researcher') 🔬 باحث
                            @elseif($user->user_type == 'video_creator') 🎥 منشئ فيديو
                            @else 👑 مدير
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Account Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">معلومات الحساب</h3>
                        <p class="text-sm text-gray-500">تفاصيل التسجيل</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">تاريخ التسجيل:</span>
                        <span class="font-medium">{{ $user->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                    @if($user->approved_at)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">تاريخ المراجعة:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($user->approved_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    @endif
                    @if($user->approved_by)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">تمت المراجعة بواسطة:</span>
                        <span class="font-medium">{{ $user->approver->name ?? 'غير معروف' }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stats Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">إحصائيات</h3>
                        <p class="text-sm text-gray-500">نظرة عامة</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">آخر نشاط:</span>
                        <span class="font-medium">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejection Reason (if rejected) -->
        @if($user->account_status == 'rejected' && $user->rejection_reason)
        <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-red-800 mb-1">سبب رفض الحساب</h4>
                    <p class="text-red-700">{{ $user->rejection_reason }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Teacher Specific Information -->
        @if($user->user_type == 'teacher' && $additionalData)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">👨‍🏫 معلومات المعلم</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">المرحلة التعليمية:</span>
                        <span class="font-medium">{{ $additionalData->school_level ?? 'غير محدد' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">المدرسة:</span>
                        <span class="font-medium">{{ $additionalData->school ?? 'غير محدد' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">المادة:</span>
                        <span class="font-medium">{{ $additionalData->subject ?? 'غير محدد' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Student Specific Information -->
        @if($user->user_type == 'student' && $additionalData)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">🎓 معلومات الطالب</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">المرحلة الدراسية:</span>
                        <span class="font-medium">{{ $additionalData->school_level ?? 'غير محدد' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">المجال الدراسي:</span>
                        <span class="font-medium">{{ $additionalData->fieldStudy->name ?? 'غير محدد' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">تاريخ الميلاد:</span>
                        <span class="font-medium">{{ $additionalData->birth_date ? \Carbon\Carbon::parse($additionalData->birth_date)->format('Y/m/d') : 'غير محدد' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Researcher Specific Information -->
        @if($user->user_type == 'researcher' && $additionalData)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">🔬 معلومات الباحث</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">مجال الدراسة:</span>
                            <span class="font-medium">{{ $additionalData->field_of_study ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">المؤسسة:</span>
                            <span class="font-medium">{{ $additionalData->institution ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">الدولة:</span>
                            <span class="font-medium">{{ $additionalData->country ?? 'غير محدد' }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">المدينة:</span>
                            <span class="font-medium">{{ $additionalData->city ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">الدرجة العلمية:</span>
                            <span class="font-medium">{{ $additionalData->degree ?? 'غير محدد' }}</span>
                        </div>
                        @if($additionalData->certificate_path)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">الشهادة:</span>
                            <a href="{{ Storage::url($additionalData->certificate_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">
                                عرض الشهادة 📄
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Video Creator Specific Information -->
        @if($user->user_type == 'video_creator' && $additionalData)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">🎥 معلومات منشئ الفيديو</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">التخصص:</span>
                            <span class="font-medium">{{ $additionalData->specialization ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">البرامج المفضلة:</span>
                            <span class="font-medium">{{ $additionalData->preferred_software ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">رابط المعرض:</span>
                            @if($additionalData->portfolio_url)
                            <a href="{{ $additionalData->portfolio_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">
                                فتح الرابط 🔗
                            </a>
                            @else
                            <span class="text-gray-400">غير محدد</span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">المهارات:</span>
                            <div class="flex flex-wrap gap-1">
                                @php
                                    $skills = is_array($additionalData->skills) ? $additionalData->skills : json_decode($additionalData->skills, true);
                                @endphp
                                @if(is_array($skills) && count($skills) > 0)
                                    @foreach($skills as $skill)
                                        <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $skill }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400">غير محدد</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">الحالة:</span>
                            <span class="font-medium">{{ $additionalData->status ?? 'غير محدد' }}</span>
                        </div>
                    </div>
                </div>
                <!-- Video Creator Stats -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">مقاطع مكتملة</p>
                                <p class="text-lg font-bold text-gray-800">{{ $additionalData->completed_videos ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">متوسط التقييم</p>
                                <p class="text-lg font-bold text-gray-800">{{ $additionalData->average_rating ?? 0 }} / 5</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">إجمالي التقييمات</p>
                                <p class="text-lg font-bold text-gray-800">{{ $additionalData->total_ratings ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        @if($user->account_status == 'pending')
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
            <button onclick="showRejectModal({{ $user->id }})" 
                    class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                رفض الحساب
            </button>
            
            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" 
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-150 flex items-center gap-2"
                        onclick="return confirm('هل تريد قبول هذا المستخدم؟')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    قبول الحساب
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 16px; padding: 2rem; max-width: 500px; width: 90%; margin: 0 auto;">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 1rem;">رفض حساب المستخدم</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 8px;">سبب الرفض</label>
                <textarea name="rejection_reason" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" placeholder="اكتب سبب رفض الحساب..." required></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeRejectModal()" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 8px; background: #fff; cursor: pointer;">إلغاء</button>
                <button type="submit" style="padding: 8px 16px; border: none; border-radius: 8px; background: #DC2626; color: #fff; cursor: pointer;">رفض</button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(userId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/users/${userId}/reject`;
    modal.style.display = 'flex';
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'none';
}
</script>

@endsection