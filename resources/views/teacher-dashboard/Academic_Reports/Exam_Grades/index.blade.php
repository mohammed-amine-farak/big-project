@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-800">تقارير الاختبارات الأسبوعية</h1>
            <a href="{{route('Exam_Grade.create')}}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                إضافة تقرير جديد
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-4 shadow-md rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">تم إضافة التقرير بنجاح!</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التلميذ
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    اسم الاختبار
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 نقاط الاختبار
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ملاحظات الأستاذ
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التاريخ
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">إجراءات</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Check if there are any records --}}
                            @if($exam_grade->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        لا توجد تقارير حاليًا.
                                    </td>
                                </tr>
                            @else
                                {{-- Loop through the collection and display each record --}}
                                @foreach($exam_grade as $report)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        {{-- The selected columns from the query are available here --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $report->student_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->exam_weeckly_title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->exam_weeckly_total_point }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->exam_weeckly_note }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            {{-- You can add dynamic links for edit/delete here --}}
                                            @if ($report->exam_schol_weeckly_reports_STATUS == 'in_process')
                                            <a href="#" class="text-red-600 hover:text-red-900 mx-1">حذف</a>
                                            <a href="{{route('Exam_Grade.edit',$report->exam_schol_weeckly_reports_id)}}" class="text-blue-600 hover:text-red-900 mx-1">تعديل</a>
                                            <a href="{{route('Exam_Grade.update_status',$report->exam_schol_weeckly_reports_id)}}" class="text-green-600 hover:text-red-900 mx-1">ارسال</a>
                                            @else
                                            <p class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">تم الارسال</p>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection