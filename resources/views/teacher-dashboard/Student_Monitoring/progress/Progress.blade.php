@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-8"> {{-- هذا الـ div هو الذي يغلف المحتوى بالكامل في قالبك الجديد، لذا نتركه --}}
    <div class="max-w-7xl mx-auto"> {{-- لمركزة المحتوى وتحديد عرضه الأقصى --}}

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-800">نسبة إنجاز الدروس 📊</h1> {{-- تحديث العنوان --}}
            <a href="{{route('student_progress.create')}}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
          انشاء تقدم جديد


</a>        </div>

     
         @if (session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-4 shadow-md rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif 

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden"> {{-- هذا هو تصميم البطاقة الذي تريده --}}
            <div class="p-6"> {{-- بادينغ داخلي للبطاقة --}}

                {{-- هذا القسم يستخدم @if ($exams->isEmpty()) لكننا سنستخدم بيانات الدروس هنا.
                     لغرض العرض، سنفترض أن هناك دروسًا دائمًا لعرض الجدول.
                     يمكنك استبدال هذا بمنطق Laravel الخاص بك للتحقق مما إذا كانت هناك دروس لعرضها. --}}
                {{-- @if ($lessons->isEmpty()) --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50"> {{-- لون رأس الجدول من قالب الاختبارات --}}
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التلميذ
                                </th>
                               
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الدرس الحالي
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    نسبة الإنجاز
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التقدم
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التاريخ
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">إجراءات</span> {{-- تم تعديلها لتكون أكثر عمومية --}}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- مثال لصفوف البيانات. في تطبيق Laravel الفعلي، ستقوم بالمرور عبر مجموعة بيانات --}}
                          @foreach ($results as $result) 
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$result->name}}</td>
                            
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$result->title}} </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$result->completion_percentage}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="w-32 bg-gray-200 rounded-full h-2.5 mx-auto">
                                        @if ($result->completion_percentage < 20)
                                            <div class="bg-red-500 h-2.5 rounded-full" style="width: {{ $result->completion_percentage }}%;"></div>
                                        @elseif ($result->completion_percentage < 50)
                                            <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $result->completion_percentage }}%;"></div>
                                        @else
                                            <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $result->completion_percentage }}%;"></div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$result->created_at}}</td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{route('student_progress.delete',$result->progresses_id)}}" class="text-indigo-600 hover:text-indigo-900 mx-1">حذف</a>
                                    {{-- يمكنك إضافة أزرار تعديل أو حذف هنا إذا كان ذلك منطقيًا لتقدم الدروس --}}
                                </td>
                            </tr>
                            
                         @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
</div>
@endsection