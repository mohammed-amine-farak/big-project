<?php

namespace App\Http\Controllers;

use App\Http\Controllers\student as ControllersStudent;
use Illuminate\Http\Request;
use App\Models\student_psychology ;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\student as ModelsStudent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\psychology_report_response_admine;
use Illuminate\Support\Facades\Auth;
class StudentPsychologyController extends Controller
{
  public function index(Request $request)
{
  
    
    $query = student_psychology::with(['student.user', 'classroom', 'teacher.user'])
        ->where('teacher_id', Auth::user()->id);
    
    // Filters - no table prefixes needed in Eloquent
    if ($request->filled('student_id')) {
        $query->where('student_id', $request->student_id);
    }

    if ($request->filled('classroom_id')) {
        $query->where('classroom_id', $request->classroom_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('mood')) {
        $query->where('mood', $request->mood);
    }

    if ($request->filled('behavior')) {
        $query->where('behavior', $request->behavior);
    }

    $reports = $query->orderBy('created_at', 'desc')->paginate(10);

    // Get filter data for current teacher only
    $students = Student::with('user')
        ->whereIn('id', function($query)  {
            $query->select('student_id')
                  ->from('student_psychologies')
                  ->where('teacher_id',Auth::user()->id);
        })
        ->get()
        ->map(function($student) {
            return [
                'id' => $student->id,
                'name' => $student->user->name
            ];
        });

    $classrooms = Classroom::whereIn('id', function($query) {
        $query->select('classroom_id')
              ->from('student_psychologies')
              ->where('teacher_id', Auth::user()->id);
    })->get();

    return view('teacher-dashboard.StudentPsychology.index', 
        compact('reports', 'students', 'classrooms'));
}
     public function show(student_psychology $student_psychology)
    {
        // Check authorization
        if ($student_psychology->teacher_id != Auth::user()->id) {
            abort(403, 'غير مصرح لك بعرض هذا التقرير النفسي.');
        }

        // Load relationships
        $report = $student_psychology->load(['student.user', 'classroom', 'teacher.user']);
        
        return view('teacher-dashboard.StudentPsychology.show', compact('report'));
    }
    public function updateStatus(Request $request, student_psychology $student_psychology)
    {
        // Check authorization
       
        if ($student_psychology->teacher_id != Auth::user()->id) {
            abort(403, 'ليس لديك صلاحية لتغيير حالة هذا التقرير.');
        }

        // Can only send draft reports to management
        if ($student_psychology->status != 'مسودة') {
            return back()->with('error', 'لا يمكن إرسال تقرير غير مسودة.');
        }

        $student_psychology->update([
            'status' => 'مرسل_للإدارة',
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('StudentPsychology.show', $student_psychology)
            ->with('success', 'تم إرسال التقرير للإدارة بنجاح.');
    }
   public function edit(student_psychology $student_psychology)
{
    // Check authorization and status
    $teacherId = Auth::user()->id;
    
    if ($student_psychology->teacher_id != $teacherId) {
        abort(403, 'ليس لديك صلاحية لتعديل هذا التقرير.');
    }

    if ($student_psychology->status == 'مرسل_للإدارة') {
        return redirect()->route('StudentPsychology.show', $student_psychology)
            ->with('error', 'لا يمكن تعديل تقرير تم إرساله للإدارة.');
    }
    
    // Load report with relationships
    $report = $student_psychology->load(['student.user', 'classroom']);
    

    // Get students for dropdown (only students from teacher's classrooms)
   $students = Student::select([
        'students.id',
        'users.name',
        'classrooms.id as classroom_id',
        'classrooms.class_name'
    ])
    ->distinct('students.id') // Use distinct if needed
    ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
    ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
    ->join('teachers', 'classrooms.teacher_id', '=', 'teachers.id')
    ->join('users', 'students.id', '=', 'users.id')
    ->where('teachers.id', $teacherId)
    ->get()
    ->map(function($student) {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'classroom_id' => $student->classroom_id,
            'class_name' => $student->class_name
        ];
    });
   
    $classrooms = Classroom::where('teacher_id', $teacherId)->get();
   
    return view('teacher-dashboard.StudentPsychology.edit', 
        compact('report', 'students', 'classrooms'));
}

public function update(Request $request, student_psychology $student_psychology)
{
    // Check authorization and status
    $teacherId =  Auth::user()->id;
    
    if ($student_psychology->teacher_id != $teacherId) {
        abort(403, 'ليس لديك صلاحية لتعديل هذا التقرير.');
    }

    if ($student_psychology->status == 'مرسل_للإدارة') {
        return redirect()->route('StudentPsychology.show', $student_psychology)
            ->with('error', 'لا يمكن تعديل تقرير تم إرساله للإدارة.');
    }

    // Validation rules
    $validated = $request->validate([
        
        'mood' => 'required|in:مبتهج,هادئ,قلق,حزين,غاضب,متحمس',
        'social_interaction' => 'required|in:منطوي,متواصل_بشكل_معتدل,اجتماعي,قائد_مجموعة',
        'concentration' => 'required|in:ضعيف,متوسط,جيد,ممتاز',
        'participation' => 'required|in:سلبي,مشارك_أحياناً,نشط,مبادر',
        'behavior' => 'required|in:ممتاز,جيد,مقبول,يحتاج_تحسين',
        'strengths' => 'nullable|string|max:1000',
        'challenges' => 'nullable|string|max:1000',
        'recommendations' => 'nullable|string|max:1000',
        'general_notes' => 'nullable|string|max:1000',
        'teacher_note' => 'nullable|string|max:1000',
        'status' => 'sometimes|in:مسودة,مرسل_للإدارة'
    ]);

    // Verify that student is in the selected classroom
    // Check through student_classrooms table
  

    // Verify teacher has access to this classroom
    $teacherHasClassroom = DB::table('classrooms')
        ->where('teacher_id', $teacherId)
       
        ->exists();

    if (!$teacherHasClassroom) {
        return back()->withErrors(['classroom_id' => 'ليس لديك صلاحية لتعديل تقارير لهذا الصف.'])
            ->withInput();
    }
        
    
    
  // Update the report
    $student_psychology->update([
     
        'mood' => $request->mood,
        'social_interaction' => $request->social_interaction,
        'concentration' => $request->concentration,
        'participation' => $request->participation,
        'behavior' => $request->behavior,
        'strengths' => $request->strengths,
        'challenges' => $request->challenges,
        'recommendations' => $request->recommendations,
        'general_notes' => $request->general_notes,
        'teacher_note' => $request->teacher_note,
        'status' => $request->status ?? $student_psychology->status,
        'updated_at' => Carbon::now()
    ]);

    // Determine success message based on status
    $message = $request->status == 'مرسل_للإدارة' 
        ? 'تم تحديث وإرسال التقرير للإدارة بنجاح.'
        : 'تم تحديث التقرير النفسي بنجاح.';

    return redirect()->route('StudentPsychology.show', $student_psychology->id)
        ->with('success', $message);
}
public function create()
{
      $teacherId =  Auth::user()->id;
    $students = Student::select([
        'students.id',
        'users.name',
        'classrooms.id as classroom_id',
        'classrooms.class_name'
    ])
    ->distinct('students.id') // Use distinct if needed
    ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
    ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
    ->join('teachers', 'classrooms.teacher_id', '=', 'teachers.id')
    ->join('users', 'students.id', '=', 'users.id')
    ->where('teachers.id', $teacherId)
    ->get()
    ->map(function($student) {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'classroom_id' => $student->classroom_id,
            'class_name' => $student->class_name
        ];
    });  

    
    // الحصول على الصفوف التي يدرسها المعلم
   $classrooms = Classroom::with('subjects.fieldOfStudy')->where('teacher_id', $teacherId)->get();
  

    return view('teacher-dashboard.StudentPsychology.create', 
        compact('students', 'classrooms'));
}
public function store(Request $request)
{
    $teacherId =  Auth::user()->id;
    
    // Validate inputs
    $validated = $request->validate([
        'student_id' => 'required|integer|exists:students,id',
        'classroom_id' => 'required|integer|exists:classrooms,id',
        'mood' => 'required|string|in:مبتهج,هادئ,قلق,حزين,غاضب,متحمس',
        'social_interaction' => 'required|string|in:منطوي,متواصل_بشكل_معتدل,اجتماعي,قائد_مجموعة',
        'concentration' => 'required|string|in:ضعيف,متوسط,جيد,ممتاز',
        'participation' => 'required|string|in:سلبي,مشارك_أحياناً,نشط,مبادر',
       
        'behavior' => 'required|string|in:ممتاز,جيد,مقبول,يحتاج_تحسين',
        'strengths' => 'nullable|string',
        'challenges' => 'nullable|string',
        'recommendations' => 'nullable|string',
        'general_notes' => 'nullable|string',
        'teacher_note' => 'nullable|string',
        'status' => 'required|string|in:مسودة,مرسل_للإدارة'
    ]);

    // Verify student is in classroom
    $studentCheck = DB::table('student_classrooms')
        ->where('student_id', $validated['student_id'])
        ->where('classroom_id', $validated['classroom_id'])
        ->first();

    if (!$studentCheck) {
        return back()
            ->with('error', '❌ الطالب غير مسجل في هذا الصف.')
            ->withInput();
    }

    // Verify teacher access
    $teacherCheck = DB::table('classrooms')
        ->where('teacher_id', $teacherId)
        ->where('id', $validated['classroom_id'])
        ->first();

    if (!$teacherCheck) {
        return back()
            ->with('error', '⛔ ليس لديك صلاحية الوصول إلى هذا الصف.')
            ->withInput();
    }

    // Create the report
    $report = new student_psychology();
    $report->student_id = $validated['student_id'];
    $report->teacher_id = $teacherId;
    $report->classroom_id = $validated['classroom_id'];
    $report->mood = $validated['mood'];
    $report->social_interaction = $validated['social_interaction'];
    $report->concentration = $validated['concentration'];
    $report->participation = $validated['participation'];
    $report->behavior = $validated['behavior'];
    $report->strengths = $validated['strengths'];
    $report->challenges = $validated['challenges'];
    $report->recommendations = $validated['recommendations'];
    $report->general_notes = $validated['general_notes'];
    $report->teacher_note = $validated['teacher_note'];
    $report->status = $validated['status'];
    $report->save();

    // Redirect with success message
    $message = $validated['status'] == 'مرسل_للإدارة' 
        ? '✅ تم إرسال التقرير للإدارة بنجاح.'
        : '💾 تم حفظ التقرير كمسودة بنجاح.';

    return redirect()
        ->route('StudentPsychology.show', $report->id)
        ->with('success', $message);
}
public function destroy(student_psychology $student_psychology)
{
    // Check authorization
    $teacherId = Auth::user()->id;
    
    if ($student_psychology->teacher_id != $teacherId) {
        abort(403, 'ليس لديك صلاحية لحذف هذا التقرير.');
    }

    // Only draft reports can be deleted
    if ($student_psychology->status != 'مسودة') {
        return redirect()->route('StudentPsychology.show', $student_psychology->id)
            ->with('error', 'لا يمكن حذف تقرير تم إرساله للإدارة.');
    }

    // Delete the report
    $student_psychology->delete();

    return redirect()->route('StudentPsychology.index')
        ->with('success', 'تم حذف التقرير النفسي بنجاح.');  

}





public function student_psychology_response(Request $request)
{
    $teacherId = 12;

    $query = psychology_report_response_admine::with([
        'student_psychologies.student.user',
        'student_psychologies.classroom',
        'admin.user',
    ]);

    // Filters
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('priority')) {
        $query->where('priority', $request->priority);
    }

    if ($request->filled('response_type')) {
        $query->where('response_type', $request->response_type);
    }

    // Order by latest responses first and paginate
    $responses = $query->orderBy('created_at', 'desc')->paginate(15);

    return view('teacher-dashboard.StudentPsychology.admine_response', compact('responses'));
}
 public function student_psychology_response_show(psychology_report_response_admine $response_admine)
    {
      
        $response = $response_admine->load([
            'student_psychologies.student.user',
            'teacher.user',
            'admin.user'
        ]);
        
        return view('teacher-dashboard.StudentPsychology.admine_response_show', compact('response'));
    }
}