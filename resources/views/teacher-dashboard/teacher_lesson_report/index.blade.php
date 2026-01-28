@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-4 sm:p-6">
    <div class="max-w-full mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 truncate">
                        📋 تقاريري حول مشاكل الدروس
                    </h1>
                    <p class="text-gray-600 text-sm">
                        جميع التقارير التي قمتُ بإرسالها بخصوص الدروس
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border">
                <p class="text-xs text-gray-600">إجمالي التقارير</p>
                <p class="text-lg font-bold">{{ $reports->total() }}</p>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border">
                <p class="text-xs text-gray-600">قيد الانتظار</p>
                <p class="text-lg font-bold text-yellow-600">
                    {{ $reports->where('status','pending')->count() }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border">
                <p class="text-xs text-gray-600">عالية الأولوية</p>
                <p class="text-lg font-bold text-red-600">
                    {{ $reports->whereIn('priority',['high','critical'])->count() }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border">
                <p class="text-xs text-gray-600">تم الحل</p>
                <p class="text-lg font-bold text-green-600">
                    {{ $reports->where('status','resolved')->count() }}
                </p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                <input type="text" name="title" placeholder="البحث بالعنوان"
                    value="{{ request('title') }}"
                    class="px-3 py-2 border rounded-lg text-sm">

                <select name="lesson_id" class="px-3 py-2 border rounded-lg text-sm">
                    <option value="">جميع الدروس</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}"
                            @selected(request('lesson_id')==$lesson->id)>
                            {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>

                <select name="classroom_id" class="px-3 py-2 border rounded-lg text-sm">
                    <option value="">جميع الفصول</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            @selected(request('classroom_id')==$classroom->id)>
                            {{ $classroom->class_name }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="px-3 py-2 border rounded-lg text-sm">
                    <option value="">جميع الحالات</option>
                    <option value="pending">قيد الانتظار</option>
                    <option value="under_review">قيد المراجعة</option>
                    <option value="resolved">تم الحل</option>
                    <option value="closed">مغلق</option>
                </select>

                <select name="priority" class="px-3 py-2 border rounded-lg text-sm">
                    <option value="">جميع الأولويات</option>
                    <option value="low">منخفضة</option>
                    <option value="medium">متوسطة</option>
                    <option value="high">عالية</option>
                    <option value="critical">حرجة</option>
                </select>

                <div class="lg:col-span-5 flex justify-end gap-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                        تطبيق
                    </button>
                    <a href="{{ route('teacher.lesson-reports.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm">
                        إعادة تعيين
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-right">التقرير</th>
                            <th class="px-3 py-3 text-right">الدرس</th>
                            <th class="px-3 py-3 text-right hidden xl:table-cell">الفصل</th>
                            <th class="px-3 py-3 text-right hidden md:table-cell">النوع</th>
                            <th class="px-3 py-3 text-right">الأولوية</th>
                            <th class="px-3 py-3 text-right">الحالة</th>
                            <th class="px-3 py-3 text-right">الإجراء</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-3">
                                <p class="font-medium">{{ $report->title }}</p>
                                <p class="text-xs text-gray-500">{{ $report->created_at }}</p>
                            </td>

                            <td class="px-3 py-3">
                                {{ $report->lesson->title ?? '—' }}
                            </td>

                            <td class="px-3 py-3 hidden xl:table-cell">
                                {{ $report->classroom->class_name ?? '—' }}
                            </td>

                            <td class="px-3 py-3 hidden md:table-cell">
                                {{ $report->problem_type }}
                            </td>

                            <td class="px-3 py-3">
                                {{ $report->priority }}
                            </td>

                            <td class="px-3 py-3">
                                {{ $report->status }}
                            </td>

                            <td class="px-3 py-3">
                                <a href="{{ route('teacher.lesson-reports.show',$report->id) }}"
                                   class="text-blue-600 hover:underline">
                                    عرض
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $reports->links() }}
            </div>
        </div>

    </div>
</div>

<style>
@media (min-width: 475px) {
    .xs\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select').forEach(el => {
        el.addEventListener('change', () => el.form.submit());
    });
});
</script>
@endsection
