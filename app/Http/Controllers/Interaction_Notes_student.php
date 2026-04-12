<?php

namespace App\Http\Controllers;

use App\Models\Interaction_Notes_students;
use App\Models\StudentLessonProgress;
use Illuminate\Support\Facades\DB;
use App\Models\lessonss;
use App\Models\User;
use App\Models\classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->where('classrooms.teacher_id', Auth::user()->id)
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
            ->where('classrooms.teacher_id', Auth::user()->id)
            ->select('student_users.name', 'students.id')
            ->distinct()
            ->get();

        $classrooms = DB::table('interaction__notes_students')
            ->join('students', 'interaction__notes_students.student_id', '=', 'students.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id', Auth::user()->id)
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
    $teacherId = Auth::user()->id;
    $classrooms = classroom::where('teacher_id', $teacherId)->get();
    
    // Get all lessons first (or empty initially)
    $lessons = collect(); // Empty collection
    
    return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.create', 
        compact('classrooms', 'lessons'));
}

// Add AJAX method to get lessons without notes for a specific student
public function getLessonsWithoutNotesForStudent($studentId)
{
    // Get lessons that the student DOES NOT have an interaction note for
    $lessons = lessonss::whereDoesntHave('Interaction_Notes_students', function($query) use ($studentId) {
        $query->where('student_id', $studentId);
    })->get(['id', 'title']);
    
    return response()->json([
        'success' => true,
        'lessons' => $lessons
    ]);
}

    public function getClassroomStudentsAjax($classroomId)
    {
        $teacherId = Auth::user()->id;
        
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

    /**
     * Update student lesson progress from teacher note (max 25%)
     */
    private function updateStudentLessonProgress($studentId, $lessonId, $progressValue)
    {
        // Ensure progress doesn't exceed 25% from this single note
        $progressValue = min($progressValue, 25);
        
        // Get or create progress record
        $lessonProgress = StudentLessonProgress::firstOrCreate([
            'student_id' => $studentId,
            'lesson_id' => $lessonId
        ]);
        
        // Get current progress
        $currentProgress = $lessonProgress->progress ?? 0;
        
        // Calculate new progress (teacher notes contribute up to 25% cumulative)
        // You can either add to existing or set new value
        $newProgress = min($currentProgress + $progressValue, 100);
        
        // Update progress
        $lessonProgress->update([
            'progress' => $newProgress,
            'last_accessed_at' => now()
        ]);
        
        // Mark as completed if reached 100%
        if ($newProgress >= 100 && !$lessonProgress->completed) {
            $lessonProgress->update([
                'completed' => true,
                'completed_at' => now()
            ]);
        }
        
        return $lessonProgress;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'student_id' => 'required|exists:students,id',
            'lesson_id' => 'required|exists:lessonss,id',
            'note_content' => 'required|string|max:20000',
            'progress' => 'required|numeric|min:0|max:25', // Progress from teacher (0-25%)
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

        // Create the interaction note (without progress column)
        Interaction_Notes_students::create([
            'student_id' => $validatedData['student_id'],
            'lesson_id' => $validatedData['lesson_id'],
            'teacher_id' => Auth::user()->id,
            'note_content' => $validatedData['note_content'],
        ]);

        // Update student lesson progress with the teacher's note value (0-25%)
        $this->updateStudentLessonProgress(
            $validatedData['student_id'],
            $validatedData['lesson_id'],
            $validatedData['progress']
        );

        return redirect()->route('Interaction_Notes_student.index')->with('success', 'تم حفظ ملاحظة التفاعل وتحديث التقدم بنجاح!');
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
        $studentId = $delete->student_id;
        $lessonId = $delete->lesson_id;
        
        // Delete the note
        $delete->delete();
        
        // Recalculate total progress from remaining teacher notes
        // Note: Since we don't store progress in notes table, we need to recalculate
        // You might want to store the progress value or have a default value
        // For now, we'll just keep the existing progress or you can subtract a default value
        
        return redirect()->back()->with('success', 'تم حذف الملاحظة بنجاح.');
    }

    public function update(Interaction_Notes_students $Interaction_Notes_students)
    {
        $teacherId = Auth::user()->id;
        
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
        
        // Get current progress from student_lesson_progress
        $currentProgress = StudentLessonProgress::where('student_id', $interaction_notes_student->student_id)
            ->where('lesson_id', $interaction_notes_student->lesson_id)
            ->value('progress') ?? 0;
        
        $classrooms = classroom::where('teacher_id', $teacherId)->get();
        $lessons = lessonss::all();
        
        return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.update', 
            compact('interaction_notes_student', 'classrooms', 'lessons', 'currentProgress'));
    }

    public function edit(Request $request, Interaction_Notes_students $edit)
    {
        $validatedData = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'student_id' => 'required|exists:students,id',
            'lesson_id' => 'required|exists:lessonss,id',
            'note_content' => 'required|string',
            'progress' => 'required|numeric|min:0|max:25',
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

        // Update the note
        $edit->student_id = $validatedData['student_id'];
        $edit->lesson_id = $validatedData['lesson_id'];
        $edit->note_content = $validatedData['note_content'];
        $edit->save();
        
        // Update student lesson progress with the new progress value
        $this->updateStudentLessonProgress(
            $validatedData['student_id'],
            $validatedData['lesson_id'],
            $validatedData['progress']
        );
        
        return redirect()->route('Interaction_Notes_student.index')->with('success', 'تم تحديث ملاحظة التفاعل والتقدم بنجاح!');
    }
    public function studentNotes(Request $request)
{
    $studentId = 17;
    
    $query = Interaction_Notes_students::where('student_id', $studentId)
        ->with(['lesson', 'lesson.subject', 'teacher.user'])
        ->where('status','send');
    
    // Filter by subject
    if ($request->filled('subject_id')) {
        $query->whereHas('lesson.subject', function($q) use ($request) {
            $q->where('id', $request->subject_id);
        });
    }
    
    $notes = $query->orderBy('created_at', 'desc')->paginate(10);
    
    // Get subjects from student's enrolled classrooms (if no notes yet)
    $subjects = \App\Models\Subject::whereHas('classrooms.students', function($q) use ($studentId) {
        $q->where('students.id', $studentId);
    })->get();
    
    return view('student-dashboard.interaction_notes.index', compact('notes', 'subjects'));
}
public function studentNotesShow(Interaction_Notes_students $note)
{
    // Ensure the student can only see their own notes
    if ($note->student_id != 17) {
        abort(403, 'غير مصرح لك بمشاهدة هذه الملاحظة');
    }
    
    $note->load(['lesson', 'lesson.subject', 'teacher.user']);
    
    return view('student-dashboard.interaction_notes.show', compact('note'));
}
}