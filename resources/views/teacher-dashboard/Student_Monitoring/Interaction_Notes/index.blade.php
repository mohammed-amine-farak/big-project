@extends('layouts.teacher_dashboard')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-gray-800">سجل ملاحظات التفاعل 📝</h1>
            <a href="{{route('Interaction_Notes_student.create')}}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                إضافة ملاحظة جديدة
            </a>
        </div>

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
        {{-- Add error session display if needed, similar to your rules page --}}
        @if (session('error'))
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-4 shadow-md rounded-lg" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" fill-rule="evenodd"></path></svg></div>
                    <div>
                        <p class="font-bold">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                {{-- Changed $results->isEmpty() to empty($results) --}}
                @if (empty($results))
                    <div class="text-center py-12 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">لا توجد ملاحظات تفاعل بعد</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            ابدأ بإضافة أول ملاحظة تفاعل.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('Interaction_Notes_student.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                إضافة ملاحظة جديدة
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        التلميذ
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        الدرس الحالي
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ملاحظات المعلم
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        تاريخ الإنشاء
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      الحالة
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">إجراءات</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($results as $result)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$result->student_name}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$result->lesson_title}}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 max-w-sm">
                                        @php
                                            $fullNoteContent = $result->note_content ?? '';
                                            $shortNoteContent = Str::limit($fullNoteContent, 80); // Adjust 80 to desired length
                                        @endphp

                                        @if (strlen($fullNoteContent) > 80)
                                            {{ $shortNoteContent }}...
                                            <button type="button"
                                                    class="text-blue-600 hover:text-blue-800 font-medium ml-1 text-xs focus:outline-none open-note-modal"
                                                    data-student-name="{{ $result->student_name }}"
                                                    data-lesson-title="{{ $result->lesson_title }}"
                                                    data-note-content="{{ addslashes(nl2br($fullNoteContent)) }}"
                                                    data-created-at="{{ \Carbon\Carbon::parse($result->created_at)->format('Y-m-d H:i') }}">
                                                عرض المزيد
                                            </button>
                                        @else
                                            {{ $fullNoteContent }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($result->created_at)->format('Y-m-d H:i') }}</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$result->interaction__notes_status}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            @if ($result->interaction__notes_status == 'In_process')
                                            <a href="{{route('Interaction_Notes_student.update',$result->interaction__notes_id)}}" class="text-indigo-600 hover:text-indigo-900 mx-1">تعديل</a>
                                            <form action="{{ route('Interaction_Notes_student.send', $result->interaction__notes_id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من إرسال هذه الملاحظة؟ لا يمكن التراجع عن هذا الإجراء.');">
                                                @csrf
                                                @method('PUT') {{-- Use PUT for updating a resource --}}
                                                <button type="submit" class="text-green-600 hover:text-green-900 mx-1">ارسال</button>
                                            </form>
                                            <form action="{{route('Interaction_Notes_student.delete', $result->interaction__notes_id)}}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 mx-1" onclick="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟')">
                                                    حذف
                                                </button>
                                            </form>
                                            @else
                                            <p class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">تم الارسال</p>
                                            @endif
                                            
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Structure --}}
<div id="noteDetailsModal"
     class="hidden fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-8 text-center sm:block sm:p-0">
        {{-- Modal Overlay --}}
        <div id="modalOverlay"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-right w-full">
                        <h3 class="text-2xl leading-6 font-bold text-gray-900 mb-4" id="modalTitle">تفاصيل الملاحظة</h3>
                        <div class="mt-2 text-right">
                            <p><strong class="block text-gray-800">التلميذ:</strong> <span id="modalStudentName"></span></p>
                            <p><strong class="block text-gray-800 mt-2">الدرس:</strong> <span id="modalLessonTitle"></span></p>
                            <p><strong class="block text-gray-800 mt-2">تاريخ الإنشاء:</strong> <span id="modalCreatedAt"></span></p>
                            <p><strong class="block text-gray-800 mt-2">الملاحظة كاملة:</strong> <span id="modalNoteContent" class="block mt-1 p-2 bg-gray-50 rounded-md border border-gray-200 whitespace-pre-line"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                        id="closeNoteModalButton"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('noteDetailsModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalStudentName = document.getElementById('modalStudentName');
        const modalLessonTitle = document.getElementById('modalLessonTitle');
        const modalNoteContent = document.getElementById('modalNoteContent');
        const modalCreatedAt = document.getElementById('modalCreatedAt');
        const modalOverlay = document.getElementById('modalOverlay');
        const closeNoteModalButton = document.getElementById('closeNoteModalButton');

        function showNoteModal(studentName, lessonTitle, noteContent, createdAt) {
            modalStudentName.textContent = studentName;
            modalLessonTitle.textContent = lessonTitle;
            modalNoteContent.innerHTML = noteContent;
            modalCreatedAt.textContent = createdAt;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideNoteModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            modalStudentName.textContent = '';
            modalLessonTitle.textContent = '';
            modalNoteContent.innerHTML = '';
            modalCreatedAt.textContent = '';
        }

        document.querySelectorAll('.open-note-modal').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const studentName = this.dataset.studentName;
                const lessonTitle = this.dataset.lessonTitle;
                const noteContent = this.dataset.noteContent;
                const createdAt = this.dataset.createdAt;

                showNoteModal(studentName, lessonTitle, noteContent, createdAt);
            });
        });

        if (modalOverlay) {
            modalOverlay.addEventListener('click', hideNoteModal);
        }
        if (closeNoteModalButton) {
            closeNoteModalButton.addEventListener('click', hideNoteModal);
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                hideNoteModal();
            }
        });
    });
</script>
@endsection