@extends('layouts.teacher_dashboard') {{-- أو التخطيط المناسب --}}

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="" 
                           class="text-gray-500 hover:text-gray-700 transition duration-200 flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            العودة للردود
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">📋 تفاصيل رد الإدارة على التقرير النفسي</h1>
                    <p class="text-gray-600">تفاصيل الرد الإداري على التقرير النفسي للطالب</p>
                </div>
                
                <div class="flex items-center gap-3 flex-shrink-0">
                    
                    
                    <button onclick="printResponse()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        طباعة
                    </button>
                </div>
            </div>
            
            <!-- Status Alert -->
            @php
                $statusColors = [
                    'مقبول' => 'bg-green-100 border-green-500 text-green-700',
                    'مرفوض' => 'bg-red-100 border-red-500 text-red-700',
                    'تحت_المراجعة' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
                    'مكتمل' => 'bg-blue-100 border-blue-500 text-blue-700',
                    'بحاجة_لمزيد_من_المعلومات' => 'bg-orange-100 border-orange-500 text-orange-700',
                    'تم_المعالجة' => 'bg-purple-100 border-purple-500 text-purple-700',
                ];
            @endphp
            <div class="{{ $statusColors[$response->status] ?? 'bg-gray-100 border-gray-500 text-gray-700' }} border-r-4 p-4 rounded-lg shadow-sm mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                            @switch($response->status)
                                @case('مقبول')
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @break
                                @case('مرفوض')
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                            @endswitch
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">حالة الرد: <span class="font-black">{{ $response->status }}</span></h3>
                            <p class="text-sm opacity-90">
                                @switch($response->status)
                                    @case('مقبول')
                                        تم قبول التقرير النفسي واتخاذ الإجراءات المناسبة
                                        @break
                                    @case('مرفوض')
                                        تم رفض التقرير النفسي للأسباب المذكورة أدناه
                                        @break
                                    @case('تحت_المراجعة')
                                        التقرير قيد المراجعة من قبل الإدارة
                                        @break
                                    @case('مكتمل')
                                        تم اكتمال معالجة التقرير
                                        @break
                                    @case('بحاجة_لمزيد_من_المعلومات')
                                        يحتاج التقرير إلى معلومات إضافية
                                        @break
                                    @case('تم_المعالجة')
                                        تمت معالجة التقرير بنجاح
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                    
                    @if($response->is_urgent)
                    <div class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        عاجل
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Left Column: Basic Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Student Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">📝 معلومات التقرير الأصلي</h3>
                    
                    <div class="space-y-4">
                        <!-- Original Report Info -->
                        <div>
                            <p class="text-xs text-gray-500 mb-1">التقرير النفسي المرجعي</p>
                            <p class="font-medium text-gray-900 text-sm">
                                #{{ $response->student_psychology_id }} - {{ optional($response->student_psychologies)->created_at?? 'غير محدد' }}
                            </p>
                        </div>
                        
                        <!-- Student Info -->
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">الطالب</p>
                            <p class="font-medium text-gray-900">
                                {{ optional(optional($response->student_psychologies)->student)->user->name ?? 'غير محدد' }}
                            </p>
                        </div>
                        
                        <!-- Teacher Info -->
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">المعلم</p>
                            <p class="font-medium text-gray-900">
                                {{ optional($response->teacher)->user->name ?? 'غير محدد' }}
                            </p>
                        </div>
                        
                        <!-- Admin Info -->
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">المسؤول</p>
                            <p class="font-medium text-gray-900">
                                {{ optional($response->admin)->user->name ?? 'لم يتم التعيين' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Priority & Urgency -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">🚨 الأولوية والأهمية</h3>
                    
                    <div class="space-y-4">
                        <!-- Priority -->
                        <div>
                            <p class="text-sm text-gray-600 mb-2">مستوى الأولوية</p>
                            @php
                                $priorityColors = [
                                    'منخفض' => 'bg-gray-100 text-gray-800',
                                    'متوسط' => 'bg-blue-100 text-blue-800',
                                    'مرتفع' => 'bg-orange-100 text-orange-800',
                                    'عاجل' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $priorityColors[$response->priority] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $response->priority }}
                            </span>
                        </div>
                        
                        <!-- Urgency -->
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-sm text-gray-600 mb-2">مستوى الأهمية</p>
                            <div class="flex items-center gap-2">
                                @if($response->is_urgent)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                        حالة عاجلة
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        غير عاجل
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Response Type -->
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-sm text-gray-600 mb-2">نوع الرد</p>
                            <span class="inline-block px-3 py-1 rounded-lg bg-purple-50 text-purple-700 text-sm font-medium">
                                {{ $response->response_type }}
                            </span>
                        </div>
                        
                        <!-- Dates -->
                        <div class="pt-3 border-t border-gray-100 space-y-2">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">تاريخ الإنشاء</p>
                                <p class="text-sm text-gray-900">{{ $response->created_at }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">آخر تحديث</p>
                                <p class="text-sm text-gray-900">{{ $response->updated_at}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Follow-up Info -->
                @if($response->requires_follow_up)
                <div class="bg-white rounded-xl shadow-sm border border-yellow-200 p-5 border-l-4 border-l-yellow-500">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-yellow-200">📅 متابعة</h3>
                    
                    <div class="space-y-4">
                        <div class="bg-yellow-50 p-3 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium text-yellow-800">مطلوب متابعة</span>
                            </div>
                            
                            @if($response->follow_up_date)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">تاريخ المتابعة:</p>
                                <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($response->follow_up_date) }}</p>
                            </div>
                            @endif
                            
                            @if($response->follow_up_notes)
                            <div class="mt-3 pt-3 border-t border-yellow-200">
                                <p class="text-sm text-gray-600 mb-1">ملاحظات المتابعة:</p>
                                <p class="text-sm text-gray-700">{{ $response->follow_up_notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Response Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Response -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">📄 نص الرد الرئيسي</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4 min-h-[150px]">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $response->response_text }}</p>
                    </div>
                </div>

                <!-- Recommendations -->
                @if($response->recommendations)
                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">التوصيات</h4>
                    </div>
                    <div class="bg-emerald-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $response->recommendations }}</p>
                    </div>
                </div>
                @endif

                <!-- Additional Notes -->
                @if($response->notes)
                <div class="bg-white rounded-xl shadow-sm border border-blue-200 p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">ملاحظات إضافية</h4>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $response->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Actions Taken -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">✅ الإجراءات المتخذة</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Parent Notification -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-medium text-gray-700">إشعار ولي الأمر</span>
                                @if($response->parent_notified)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    تم الإشعار
                                </span>
                                @else
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    لم يتم الإشعار
                                </span>
                                @endif
                            </div>
                            
                            @if($response->parent_notified && $response->parent_notification_date)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">تاريخ الإشعار:</p>
                                <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($response->parent_notification_date) }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Specialist Referral -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-medium text-gray-700">تحويل لمختص</span>
                                @if($response->specialist_referred)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    تم التحويل
                                </span>
                                @else
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    لم يتم التحويل
                                </span>
                                @endif
                            </div>
                            
                            @if($response->specialist_referred && $response->specialist_type)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">نوع المختص:</p>
                                <p class="text-sm font-medium text-gray-900">{{ $response->specialist_type }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Specialist Notes -->
                    @if($response->specialist_notes)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">ملاحظات حول التحويل للمختص:</p>
                        <div class="bg-purple-50 rounded-lg p-3">
                            <p class="text-sm text-gray-700">{{ $response->specialist_notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Related Psychology Report (Optional - if you want to show it) -->
                @if($response->studentPsychology)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">📋 التقرير النفسي الأصلي</h3>
                        <a href="" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                            عرض التقرير الكامل
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">المزاج العام:</p>
                            <p class="font-medium">{{ $response->student_psychologies->mood ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">السلوك:</p>
                            <p class="font-medium">{{ $response->student_psychologies->behavior ?? 'غير محدد' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500">ملاحظات عامة:</p>
                            <p class="text-gray-700 line-clamp-2">{{ $response->studentPsychology->general_notes ?? 'لا توجد ملاحظات' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3 justify-between">
            <div class="flex gap-3">
                <a href="" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة للقائمة
                </a>
                
               
            </div>
            
            <div class="flex gap-3">
              
               
                
                
                <button onclick="printResponse()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    طباعة الرد
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Print Script -->
<script>
function printResponse() {
    const printContent = document.querySelector('.max-w-7xl').innerHTML;
    const originalContent = document.body.innerHTML;
    
    document.body.innerHTML = `
        <!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
            <meta charset="UTF-8">
            <title>رد الإدارة على التقرير النفسي</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap');
                
                body {
                    font-family: 'Cairo', sans-serif;
                    line-height: 1.6;
                    color: #333;
                    margin: 0;
                    padding: 20px;
                    background: #fff;
                }
                
                .print-header {
                    text-align: center;
                    margin-bottom: 30px;
                    padding-bottom: 20px;
                    border-bottom: 3px solid #2c3e50;
                }
                
                .print-header h1 {
                    color: #2c3e50;
                    margin: 0 0 10px 0;
                    font-size: 24px;
                }
                
                .print-header .subtitle {
                    color: #666;
                    font-size: 16px;
                }
                
                .print-section {
                    margin-bottom: 25px;
                    page-break-inside: avoid;
                }
                
                .print-section h3 {
                    background: #f8f9fa;
                    padding: 10px 15px;
                    border-right: 4px solid #3498db;
                    margin: 0 0 15px 0;
                    color: #2c3e50;
                }
                
                .info-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 15px;
                    margin-bottom: 20px;
                }
                
                .info-item {
                    background: #f8f9fa;
                    padding: 15px;
                    border-radius: 8px;
                }
                
                .info-label {
                    font-size: 12px;
                    color: #666;
                    margin-bottom: 5px;
                }
                
                .info-value {
                    font-weight: bold;
                    color: #2c3e50;
                }
                
                .content-box {
                    background: #f8f9fa;
                    padding: 15px;
                    border-radius: 8px;
                    margin-bottom: 15px;
                    border-right: 3px solid #e74c3c;
                }
                
                .status-badge {
                    display: inline-block;
                    padding: 5px 15px;
                    border-radius: 20px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                
                .urgent {
                    background: #ffebee;
                    color: #c62828;
                    border: 1px solid #c62828;
                }
                
                .footer {
                    text-align: center;
                    margin-top: 40px;
                    padding-top: 20px;
                    border-top: 1px solid #ddd;
                    color: #666;
                    font-size: 12px;
                }
                
                @media print {
                    body {
                        padding: 0;
                    }
                    
                    .no-print {
                        display: none !important;
                    }
                    
                    .print-section {
                        page-break-inside: avoid;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h1>رد الإدارة على التقرير النفسي</h1>
                <div class="subtitle">رقم الرد: {{ $response->id }} | تاريخ الإنشاء: {{ $response->created_at->format('Y-m-d') }}</div>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">الطالب</div>
                    <div class="info-value">{{ optional(optional($response->studentPsychology)->student)->user->name ?? 'غير محدد' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">المعلم</div>
                    <div class="info-value">{{ optional($response->teacher)->user->name ?? 'غير محدد' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">المسؤول</div>
                    <div class="info-value">{{ optional($response->admin)->user->name ?? 'لم يتم التعيين' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">الحالة</div>
                    <div class="info-value">{{ $response->status }}</div>
                </div>
            </div>
            
            <div class="print-section">
                <h3>نص الرد الرئيسي</h3>
                <div class="content-box">
                    {{ $response->response_text }}
                </div>
            </div>
            
            @if($response->recommendations)
            <div class="print-section">
                <h3>التوصيات</h3>
                <div class="content-box">
                    {{ $response->recommendations }}
                </div>
            </div>
            @endif
            
            <div class="print-section">
                <h3>معلومات إضافية</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">نوع الرد</div>
                        <div class="info-value">{{ $response->response_type }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">الأولوية</div>
                        <div class="info-value">{{ $response->priority }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">الحالة العاجلة</div>
                        <div class="info-value">{{ $response->is_urgent ? 'نعم' : 'لا' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                تم إنشاء هذا المستند في {{ now()->format('Y-m-d H:i') }}
            </div>
        </body>
        </html>
    `;
    
    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload();
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endsection