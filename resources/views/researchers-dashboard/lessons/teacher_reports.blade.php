@extends('layouts.reseacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-800">تقاريرك 📊</h1>
            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                + إنشاء تقرير جديد
            </a>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-right">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الاستاد
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الدرس
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الأسبوع
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                المحتوى
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Example Row 1: Pending Report --}}
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                  محمد
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    مقدمة في الذكاء الاصطناعي
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                الأسبوع 3
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    قيد المراجعة
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                                هناك بعض الطلاب يجدون صعوبة في فهم مفاهيم الشبكات العصبية.
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:text-blue-900 ml-4">عرض</a>
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">تعديل</a>
                            </td>
                        </tr>
                        
                        {{-- Example Row 2: Reviewed Report --}}
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                  محمد
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    هياكل البيانات والخوارزميات
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                الأسبوع 2
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    تمت المراجعة
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                                تم إكمال الدرس من قبل جميع الطلاب بنجاح.
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:text-blue-900 ml-4">عرض</a>
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">تعديل</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection