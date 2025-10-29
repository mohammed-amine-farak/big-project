<?php

namespace App\Http\Controllers;
use App\Models\Interaction_Notes_students;
use Illuminate\Support\Facades\DB;
use App\Models\lessonss;
use App\Models\User;
use Illuminate\Http\Request;

class Interaction_Notes_student extends Controller
{
    public function index(){
        $results = DB::select("
    SELECT 
        student_users.name AS student_name,
        teacher_users.name AS teacher_name,
        lessonss.title AS lesson_title,
        interaction__notes_students.note_content,
        interaction__notes_students.created_at,
        interaction__notes_students.status AS interaction__notes_status,
        interaction__notes_students.id AS interaction__notes_id

    FROM 
        interaction__notes_students
    INNER JOIN 
        students ON interaction__notes_students.student_id = students.id
    INNER JOIN 
        users AS student_users ON students.id = student_users.id
    INNER JOIN 
        teachers ON interaction__notes_students.teacher_id = teachers.id
    INNER JOIN 
        users AS teacher_users ON teachers.id = teacher_users.id
    INNER JOIN 
        lessonss ON interaction__notes_students.lesson_id = lessonss.id
");
        return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.index',compact('results'));
    }
    public function create(){
        $lessons = lessonss::all();
        $results = User::join('students', 'users.id', '=', 'students.id') // <-- CHANGED HERE
        ->select('users.name', 'students.*')
        ->get();
        return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.create',compact('results','lessons'));
    }
    public function store(Request $request){

         


        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id', // Added exists rule for safety
            'lesson_id' => 'required|exists:lessonss,id',   // Added exists rule for safety
            'note_content' => 'required|string|max:20000', // Added string and max rules for better validation
        ]);

        Interaction_Notes_students::create([
            'student_id' => $validatedData['student_id'],
            'lesson_id' => $validatedData['lesson_id'],
            'teacher_id' => 1, // Get the ID of the authenticated user
            'note_content' => $validatedData['note_content'],
        ]);

    
        // 3. Redirect with a success message
        return redirect()->route('Interaction_Notes_student.index')->with('success', 'تم حفظ تقدم الطالب بنجاح!'); // <-- PROBLEM 4: Route name and success message
}
public function send(Interaction_Notes_students $send){

    if ($send->status === 'send') {
        return redirect()->back()->with('error', 'هذه الملاحظة تم إرسالها بالفعل.');
    }

    $send->status = 'send'; // Assuming 'Sent' is the desired status string
    $send->save(); // Save the changes to the database

    return redirect()->back()->with('success', 'تم إرسال الملاحظة بنجاح.');

   
}
public function delete(Interaction_Notes_students $delete){
    $delete->delete();
    return redirect()->back()->with('success', 'تم حدف الملاحظة بنجاح.');
}

public function update(Interaction_Notes_students $Interaction_Notes_students){
    $interaction_notes_student = Interaction_Notes_students::where('interaction__notes_students.id', $Interaction_Notes_students->id)
        ->join('students', 'interaction__notes_students.student_id', '=', 'students.id')
        ->join('users as student_users', 'students.id', '=', 'student_users.id')
        ->join('teachers', 'interaction__notes_students.teacher_id', '=', 'teachers.id')
        ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
        ->join('lessonss', 'interaction__notes_students.lesson_id', '=', 'lessonss.id')
        ->select(
            'student_users.name AS student_name',
            'student_users.id AS student_id',
            'teacher_users.name AS teacher_name',
            'lessonss.title AS lesson_title',
            'interaction__notes_students.note_content',
            'interaction__notes_students.created_at',
            'interaction__notes_students.status AS interaction__notes_status',
            'interaction__notes_students.id AS interaction__notes_id',
            'interaction__notes_students.lesson_id AS interaction__notes_lesson_id',
        )
        ->first();
        $lessons = lessonss::all();
        $results = User::join('students', 'users.id', '=', 'students.id') // <-- CHANGED HERE
        ->select('users.name', 'students.*')
        ->get();
    return view('teacher-dashboard.Student_Monitoring.Interaction_Notes.update', compact('interaction_notes_student','results','lessons'));
}


public function edit(Request $request,Interaction_Notes_students $edit){
    
    $validatedData = $request->validate([
        'note_content' => 'required|string',
    ]);

    // 2. Update the specific note instance with the validated data
    $edit->note_content = $validatedData['note_content'];

    // 3. Save the changes to the database
    $edit->save();
    return redirect()->route('Interaction_Notes_student.index')->with('success', 'تم تجديت تقدم الطالب بنجاح!');
}

}