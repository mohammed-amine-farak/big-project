<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\exam_weeckly;
use App\Models\exams;
use App\Models\exam_schol_weeckly_report;
use Illuminate\Support\Facades\DB;

class Exam_grade_Controller extends Controller
{
    public function index(){
       // $users = DB::table('users')
        //->join('contacts', 'users.id', '=', 'contacts.user_id')
        //->join('orders', 'users.id', '=', 'orders.user_id')
        //->select('users.*', 'contacts.phone', 'orders.price')
        //->get();
       
       $exam_grade = DB::table('exam_schol_weeckly_reports')
       ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
       ->join('users as student_users', 'students.id', '=', 'student_users.id')
       ->join('teachers', 'exam_schol_weeckly_reports.teacher_id', '=', 'teachers.id')
       ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
       ->join('exam_weecklies', 'exam_schol_weeckly_reports.exam_weecklies_id', '=', 'exam_weecklies.id')
      
       ->select(
        'student_users.name AS student_name',
        'student_users.id AS student_id',
        'teacher_users.name AS teacher_name',
        'exam_weecklies.title AS exam_weeckly_title',
        'exam_schol_weeckly_reports.exam_total_point AS exam_weeckly_total_point',
        'exam_schol_weeckly_reports.exam_note AS exam_weeckly_note',
       'exam_schol_weeckly_reports.created_at AS created_at',
        'exam_schol_weeckly_reports.id AS exam_schol_weeckly_reports_id', 
        'exam_schol_weeckly_reports.STATUS AS exam_schol_weeckly_reports_STATUS'


        
    )->get();
   


        return view('teacher-dashboard.Academic_Reports\Exam_Grades\index',compact('exam_grade'));
    }
    public function create(){
       $exam_weeckly = exam_weeckly::all();
      
        $results = User::join('students', 'users.id', '=', 'students.id') // <-- CHANGED HERE
        ->select('users.name', 'students.*')
        ->get();
        
        return view('teacher-dashboard.Academic_Reports\Exam_Grades\create',compact('results','exam_weeckly'));
    }
    public function store (Request $request){
       

        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_weecklies_id' => 'required|exists:exam_weecklies,id',
            'exam_total_point' => 'required|integer|min:0|max:20',
            'exam_note' => 'required|string|max:255',
        ]);

        // 2. Create a new report instance
        $report = new exam_schol_weeckly_report();

        // 3. Assign the validated data to the model
        $report->student_id = $validatedData['student_id'];
        $report->exam_weecklies_id = $validatedData['exam_weecklies_id'];
        $report->exam_total_point = $validatedData['exam_total_point'];
        $report->exam_note = $validatedData['exam_note'];
        
        // Assign the currently authenticated teacher's ID
        $report->teacher_id = 1;

        // 4. Save the new report to the database
        $report->save();

        // 5. Redirect back with a success message
        return redirect()->route('Exam_Grade.index')->with('success', 'تم حفظ التقرير بنجاح!');    
    }



    public function edit(exam_schol_weeckly_report $Exam_Grade){
        $exam_grade = DB::table('exam_schol_weeckly_reports')
        ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
        ->join('users as student_users', 'students.id', '=', 'student_users.id')
        ->join('teachers', 'exam_schol_weeckly_reports.teacher_id', '=', 'teachers.id')
        ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
        ->join('exam_weecklies', 'exam_schol_weeckly_reports.exam_weecklies_id', '=', 'exam_weecklies.id')
        ->where('exam_schol_weeckly_reports.id',$Exam_Grade->id)
        ->select(
         'student_users.name AS student_name',
         'student_users.id AS student_id',
         'teacher_users.name AS teacher_name',
         'exam_weecklies.title AS exam_weeckly_title',
         'exam_weecklies.id AS exam_weeckly_id',

         'exam_schol_weeckly_reports.exam_total_point AS exam_weeckly_total_point',
         'exam_schol_weeckly_reports.exam_note AS exam_weeckly_note',
        'exam_schol_weeckly_reports.created_at AS created_at',
        'exam_schol_weeckly_reports.id AS exam_schol_weeckly_reports_id'
         
     )
     ->first();
      $exam_weeckly = exam_weeckly::all();
      $results = User::join('students', 'users.id', '=', 'students.id') // <-- CHANGED HERE
     ->select('users.name', 'students.*')
     ->get();
     return view('teacher-dashboard.Academic_Reports\Exam_Grades\update',compact('exam_grade','exam_weeckly','results'));
    }
    public function update(exam_schol_weeckly_report $Exam_Grade , Request $request){

        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_weecklies_id' => 'required|exists:exam_weecklies,id',
            'exam_total_point' => 'required|integer|min:0|max:20',
            'exam_note' => 'required|string|max:255',
        ]);

        // 2. Create a new report instance
        

        // 3. Assign the validated data to the model
        $Exam_Grade->student_id = $validatedData['student_id'];
        $Exam_Grade->exam_weecklies_id = $validatedData['exam_weecklies_id'];
        $Exam_Grade->exam_total_point = $validatedData['exam_total_point'];
        $Exam_Grade->exam_note = $validatedData['exam_note'];
      
        $Exam_Grade->save();

        // 5. Redirect back with a success message
        return redirect()->route('Exam_Grade.index')->with('success', 'تم حفظ التقرير بنجاح!');   
    }

    public function update_status(exam_schol_weeckly_report $Exam_Grade){
        if ($Exam_Grade->STATUS === 'send') {
            return redirect()->back()->with('error', 'هذه الملاحظة تم إرسالها بالفعل.');
        }
    
        $Exam_Grade->status = 'send'; // Assuming 'Sent' is the desired status string
        $Exam_Grade->save(); // Save the changes to the database
    
        return redirect()->back()->with('success', 'تم إرسال الملاحظة بنجاح.');
    }
}
