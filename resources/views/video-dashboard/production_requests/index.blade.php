@extends('layouts.video_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">📥 طلبات الإنتاج</h1>
            <p class="text-gray-600 text-sm">إدارة جميع طلبات إنتاج الفيديوهات</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-5 gap-3 mb-6">
            <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-200">
                <p class="text-xs text-gray-500">الكل</p>
                <p class="text-lg font-bold text-gray-900">{{ $totalRequests }}</p>
            </div>
            <div class="bg-orange-50 rounded-lg p-3 shadow-sm border border-orange-200">
                <p class="text-xs text-orange-600">جديدة</p>
                <p class="text-lg font-bold text-orange-700">{{ $pendingCount }}</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-3 shadow-sm border border-blue-200">
                <p class="text-xs text-blue-600">قيد التنفيذ</p>
                <p class="text-lg font-bold text-blue-700">{{ $acceptedCount }}</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-3 shadow-sm border border-yellow-200">
                <p class="text-xs text-yellow-600">تحتاج تعديل</p>
                <p class="text-lg font-bold text-yellow-700">{{ $revisionCount }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-3 shadow-sm border border-green-200">
                <p class="text-xs text-green-600">مكتملة</p>
                <p class="text-lg font-bold text-green-700">{{ $approvedCount }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <ul class="flex flex-wrap gap-1 text-sm font-medium">
                <li>
                    <a href="" 
                       class="inline-block px-4 py-2 rounded-t-lg {{ !request('status') ? 'bg-orange-600 text-white' : 'text-gray-600 hover:text-orange-600' }}">
                        الكل ({{ $totalRequests }})
                    </a>
                </li>
                <li>
                    <a href="" 
                       class="inline-block px-4 py-2 rounded-t-lg {{ request('status') == 'pending' ? 'bg-orange-600 text-white' : 'text-gray-600 hover:text-orange-600' }}">
                        جديدة ({{ $pendingCount }})
                    </a>
                </li>
                <li>
                    <a href="" 
                       class="inline-block px-4 py-2 rounded-t-lg {{ request('status') == 'accepted' ? 'bg-orange-600 text-white' : 'text-gray-600 hover:text-orange-600' }}">
                        قيد التنفيذ ({{ $acceptedCount }})
                    </a>
                </li>
                <li>
                    <a href="" 
                       class="inline-block px-4 py-2 rounded-t-lg {{ request('status') == 'revision_required' ? 'bg-orange-600 text-white' : 'text-gray-600 hover:text-orange-600' }}">
                        تحتاج تعديل ({{ $revisionCount }})
                    </a>
                </li>
                <li>
                    <a href="" 
                       class="inline-block px-4 py-2 rounded-t-lg {{ request('status') == 'approved' ? 'bg-orange-600 text-white' : 'text-gray-600 hover:text-orange-600' }}">
                        مكتملة ({{ $approvedCount }})
                    </a>
                </li>
                <li>
                    <a href="" 
                       class="inline-block px-4 py-2 rounded-t-lg {{ request('status') == 'rejected' ? 'bg-orange-600 text-white' : 'text-gray-600 hover:text-orange-600' }}">
                        مرفوضة ({{ $rejectedCount }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <input type="hidden" name="status" value="{{ request('status') }}">
                
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">الباحث</label>
                    <select name="researcher_id" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option value="">الكل</option>
                        @foreach($researchers as $researcher)
                            <option value="{{ $researcher->id }}" {{ request('researcher_id') == $researcher->id ? 'selected' : '' }}>
                                {{ $researcher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">الدرس</label>
                    <select name="lesson_id" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option value="">الكل</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">من تاريخ</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full px-3 py-2 border rounded-lg text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">إلى تاريخ</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full px-3 py-2 border rounded-lg text-sm">
                </div>
                
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm">
                        تطبيق
                    </button>
                    <a href="" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
                        إعادة تعيين
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">الباحث</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">العنوان</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">الدرس</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">التسليم</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">الحالة</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($production_requests as $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $request->researcher->name }}</td>
                            <td class="px-4 py-3">{{ $request->title }}</td>
                            <td class="px-4 py-3">{{ $request->lesson->title }}</td>
                            <td class="px-4 py-3 text-center">{{ $request->deadline ? $request->deadline->format('Y-m-d') : '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-orange-100 text-orange-800',
                                        'accepted' => 'bg-blue-100 text-blue-800',
                                        'revision_required' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusTexts = [
                                        'pending' => 'جديدة',
                                        'accepted' => 'قيد التنفيذ',
                                        'revision_required' => 'تحتاج تعديل',
                                        'approved' => 'مكتملة',
                                        'rejected' => 'مرفوضة'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs {{ $statusColors[$request->status] }}">
                                    {{ $statusTexts[$request->status] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{route('video_creator.production_request.show',$request->id)}}" 
                                   class="text-blue-600 hover:text-blue-800 mx-1" title="عرض">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if($request->status == 'pending')
                                <a href="" 
                                   class="text-green-600 hover:text-green-800 mx-1" title="قبول">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                @endif
                                @if($request->status == 'accepted')
                                <a href="" 
                                   class="text-blue-600 hover:text-blue-800 mx-1" title="رفع فيديو">
                                    <i class="fa-solid fa-upload"></i>
                                </a>
                                @endif
                                @if($request->status == 'revision_required')
                                <a href="" 
                                   class="text-yellow-600 hover:text-yellow-800 mx-1" title="تعديل">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t">
                {{ $production_requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection