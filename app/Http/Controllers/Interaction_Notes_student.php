<?php

namespace App\Http\Controllers;

use App\Models\Interaction_Notes_students;
use Illuminate\Support\Facades\DB;
use App\Models\lessonss;
use App\Models\User;
use App\Models\classroom;
use Illuminate\Http\Request;

class Interaction_Notes_student extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('interaction__notes_students')
            ->join('students', 'interaction__notes_students.student_id', '=', 'students.id')
            ->join('users as student_users', 'students.id', '=', 'student_users.id')
            ->join('teachers', 'interaction__notes_students.teacher_id', '=', 'teachers.id')
            ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
            ->join('lessonss', 'interaction__notes_students.lesson_id', '=', 'lessonss.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id', 12)
            ->select(
                'student_users.name AS student_name',
                'teacher_users.name AS teacher_name',
                'classrooms.class_name',
                'lessonss.title AS lesson_title',
                'interaction__notes_students.note_content',
                'interaction__notes_students.created_at',
                'interaction__notes_students.status AS interaction__notes_status',
                'interaction__notes_students.id AS interaction__notes_id'
            );

        if ($request->filled('student_name')) {
            $query->where('student_users.name', 'like', '%' . $request->student_name . '%');
        }

        if ($request->filled('classroom_id')) {
            $query->where('classrooms.id', $request->classroom_id);
        }

        if ($request->filled('status')) {
            $query->where('interaction__notes_students.status', $request->status);
        }

        if ($request->filled('lesson_id')) {
            $query->where('lessonss.id', $request->lesson_id);
        }

        $query->orderBy('interaction__notes_students.created_at', 'desc');
        $results = $query->paginate(10);

        $students = DB::table('interaction__notes_students')
            ->join('students', 'interaction__notes_students.student_id', '=', 'students.id')
            ->join('users as student_users', 'students.id', '=', 'student_users.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id', 12)
            ->select('student_users.name', 'students.id')
            ->distinct()
            ->get();

        $classrooms = DB::table('interaction__notes_students')
            ->join('students', 'interaction__notes_students.student_id', '=', 'students.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id', 12)
            ->select('classrooms.id', 'classrooms.class_name')
            ->distinct()
            ->get();

        $lessons = DB::table('interaction__notes_students')
            ->join('lessonss', 'interaction__notes_students.lesson_id', '=', 'lessonss.id')
            ->select('lessonss.id', 'lessonss.title')
            ->distinct()
            ->get();

        return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.index', 
            compact('results', 'students', 'classrooms', 'lessons'));
    }

    public function create()
    {
        $teacherId = 12;
        $classrooms = classroom::where('teacher_id', $teacherId)->get();
        $lessons = lessonss::all(); // Get all lessons (unique across all classrooms)
        
        return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.create', 
            compact('classrooms', 'lessons'));
    }

    public function getClassroomStudentsAjax($classroomId)
    {
        $teacherId = 12;
        
        $students = DB::table('students')
            ->join('users', 'students.id', '=', 'users.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->where('student_classrooms.classroom_id', $classroomId)
            ->whereExists(function ($query) use ($teacherId) {
                $query->select(DB::raw(1))
                    ->from('classrooms')
                    ->whereColumn('classrooms.id', 'student_classrooms.classroom_id')
                    ->where('classrooms.teacher_id', $teacherId);
            })
            ->select('students.id', 'users.name')
            ->orderBy('users.name')
            ->get();

        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'student_id' => 'required|exists:students,id',
            'lesson_id' => 'required|exists:lessonss,id',
            'note_content' => 'required|string|max:20000',
        ]);

        // Verify student belongs to the selected classroom
        $studentInClassroom = DB::table('student_classrooms')
            ->where('student_id', $validatedData['student_id'])
            ->where('classroom_id', $validatedData['classroom_id'])
            ->exists();

        if (!$studentInClassroom) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'الطالب لا ينتمي إلى الصف المحدد.');
        }

        Interaction_Notes_students::create([
            'student_id' => $validatedData['student_id'],
            'lesson_id' => $validatedData['lesson_id'],
            'teacher_id' => 12,
            'note_content' => $validatedData['note_content'],
        ]);

        return redirect()->route('Interaction_Notes_student.index')->with('success', 'تم حفظ ملاحظة التفاعل بنجاح!');
    }

    public function send(Interaction_Notes_students $send)
    {
        if ($send->status === 'send') {
            return redirect()->back()->with('error', 'هذه الملاحظة تم إرسالها بالفعل.');
        }

        $send->status = 'send';
        $send->save();

        return redirect()->back()->with('success', 'تم إرسال الملاحظة بنجاح.');
    }

    public function delete(Interaction_Notes_students $delete)
    {
        $delete->delete();
        return redirect()->back()->with('success', 'تم حذف الملاحظة بنجاح.');
    }

    public function update(Interaction_Notes_students $Interaction_Notes_students)
    {
        $teacherId = 12;
        
        $interaction_notes_student = Interaction_Notes_students::where('interaction__notes_students.id', $Interaction_Notes_students->id)
            ->join('students', 'interaction__notes_students.student_id', '=', 'students.id')
            ->join('users as student_users', 'students.id', '=', 'student_users.id')
            ->join('teachers', 'interaction__notes_students.teacher_id', '=', 'teachers.id')
            ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
            ->join('lessonss', 'interaction__notes_students.lesson_id', '=', 'lessonss.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->select(
                'student_users.name AS student_name',
                'student_users.id AS student_id',
                'teacher_users.name AS teacher_name',
                'lessonss.title AS lesson_title',
                'lessonss.id AS lesson_id',
                'interaction__notes_students.note_content',
                'interaction__notes_students.created_at',
                'interaction__notes_students.status AS interaction__notes_status',
                'interaction__notes_students.id AS interaction__notes_id',
                'classrooms.id AS classroom_id',
                'classrooms.class_name AS classroom_name'
            )
            ->first();
        
        $classrooms = classroom::where('teacher_id', $teacherId)->get();
        $lessons = lessonss::all(); // Get all lessons
        
        return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.update', 
            compact('interaction_notes_student', 'classrooms', 'lessons'));
    }

    public function edit(Request $request, Interaction_Notes_students $edit)
    {
        $validatedData = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'student_id' => 'required|exists:students,id',
            'lesson_id' => 'required|exists:lessonss,id',
            'note_content' => 'required|string',
        ]);

        // Verify student belongs to the selected classroom
        $studentInClassroom = DB::table('student_classrooms')
            ->where('student_id', $validatedData['student_id'])
            ->where('classroom_id', $validatedData['classroom_id'])
            ->exists();

        if (!$studentInClassroom) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'الطالب لا ينتمي إلى الصف المحدد.');
        }

        $edit->student_id = $validatedData['student_id'];
        $edit->lesson_id = $validatedData['lesson_id'];
        $edit->note_content = $validatedData['note_content'];
        $edit->save();
        
        return redirect()->route('Interaction_Notes_student.index')->with('success', 'تم تحديث ملاحظة التفاعل بنجاح!');
    }
}