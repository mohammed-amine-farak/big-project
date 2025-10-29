<?php

namespace App\Http\Controllers;
use App\Models\lessonss;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\student_lesson_progresses;


class Progress_Controller extends Controller
{
    public function index(){

        $results = User::join('students', 'users.id', '=', 'students.id')
              ->join('student_lesson_progresses', 'students.id', '=', 'student_lesson_progresses.student_id')
              ->join('lessonss', 'lessonss.id', '=', 'student_lesson_progresses.lesson_id')
              ->whereNull('student_lesson_progresses.deleted_at')
              ->select(
                  'lessonss.*',
                  'users.name',
                  'students.*',
                  'student_lesson_progresses.*',
                  'student_lesson_progresses.id as progresses_id',
                  'student_lesson_progresses.created_at as created_at',
              )
              ->get();
              
        return view('teacher-dashboard.Student_Monitoring.progress.Progress',compact('results'));
    }  




    public function create(){
          $lessons = lessonss::all();
          $results = user::join('students', 'users.id', '=', 'students.id')
            ->select('users.name', 'students.*')
            ->get();
          
        return view('teacher-dashboard.Student_Monitoring.progress.create',compact('results', 'lessons'));
    }



    public function store(Request $request){
        $validatedData = $request->validate([

            'student_id' => 'required',
            'lesson_id' => 'required',
            'completion_percentage' => 'required|integer|min:0|max:100',
        ]);
        
        // 2. Create a new record in the database
        //    We use the validated data to prevent mass assignment vulnerabilities.
        student_lesson_progresses::create([
            'student_id' => $validatedData['student_id'],
            'lesson_id' => $validatedData['lesson_id'],
            'completion_percentage' => $validatedData['completion_percentage'],
        ]);
        
        // 3. Redirect the user back with a success message
        //    You can redirect to an index page, the dashboard, or a specific page.
        return redirect()->route('student_progress.index')->with('success', 'تم حفظ تقدم الطالب بنجاح!');
        
    }


    public function delete(student_lesson_progresses $studentLessonProgress)
    {
        $studentLessonProgress->delete(); 
        return redirect()->route('student_progress.index')->with('success', 'تم حدف تقدم الطالب بنجاح!');
        
    }
}
