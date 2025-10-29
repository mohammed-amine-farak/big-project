@extends('layouts.teacher_dashboard')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-gray-800">إنشاء تقرير اختبار جديد</h1>
            <a href="#" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                العودة إلى التقارير
            </a>
        </div>

        <!-- Success Message -->
        <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-4 shadow-md rounded-lg" role="alert">
            <div class="flex items-center">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">تم حفظ التقرير بنجاح!</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
            <form action="{{ route('Exam_Grade.store') }}" method="POST">
                @csrf    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- حقل اختيار التلميذ -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">اختر التلميذ</label>
                        <select id="student_id" name="student_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                            <option value="">اختر التلميذ...</option>
                            <!-- يتم ملء هذا القسم ديناميكياً باستخدام بيانات التلميذ من المتحكم -->
                            @foreach ($results as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
    

                    <!-- حقل اختيار الاختبار -->
                    <div>
                        <label for="exam_weecklies_id" class="block text-sm font-medium text-gray-700 mb-1">اختر الاختبار</label>
                        <select id="exam_weecklies_id" name="exam_weecklies_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150">
                            <option value="">اختر الاختبار...</option>
                            <!-- يتم ملء هذا القسم ديناميكياً باستخدام بيانات الاختبارات من المتحكم -->
                            @foreach ($exam_weeckly as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- حقل مجموع النقاط -->
                <div class="mt-6">
                    <label for="exam_total_point" class="block text-sm font-medium text-gray-700 mb-1">مجموع النقاط</label>
                    <input type="number" name="exam_total_point" id="exam_total_point" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150" placeholder="أدخل مجموع النقاط">
                </div>

                <!-- حقل ملاحظات الأستاذ -->
                <div class="mt-6">
                    <label for="exam_note" class="block text-sm font-medium text-gray-700 mb-1">ملاحظات الأستاذ</label>
                    <textarea id="exam_note" name="exam_note" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 transition duration-150" placeholder="أضف ملاحظاتك حول أداء التلميذ في هذا الاختبار..."></textarea>
                </div>

                <!-- زر الإرسال -->
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                        حفظ التقرير
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection