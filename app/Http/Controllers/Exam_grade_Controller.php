<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\exam_weeckly;
use App\Models\exams;
use App\Models\exam_schol_weeckly_report;
use App\Models\skills;
use App\Models\student_level;
use Illuminate\Support\Facades\DB;

class Exam_grade_Controller extends Controller
{
 

public function index(Request $request)
{
    $query = DB::table('exam_schol_weeckly_reports')
        ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
        ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
        ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
        ->join('users as student_users', 'students.id', '=', 'student_users.id')
        ->join('teachers', 'exam_schol_weeckly_reports.teacher_id', '=', 'teachers.id')
        ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
        ->join('exam_weecklies', 'exam_schol_weeckly_reports.exam_weecklies_id', '=', 'exam_weecklies.id')
        ->where('classrooms.teacher_id',12)
        ->select(
            'student_users.name AS student_name',
            'student_users.id AS student_id',
            'teacher_users.name AS teacher_name',
            'exam_weecklies.title AS exam_weeckly_title',
            'exam_schol_weeckly_reports.exam_total_point AS exam_weeckly_total_point',
            'exam_schol_weeckly_reports.exam_note AS exam_weeckly_note',
            'exam_schol_weeckly_reports.created_at AS created_at',
            'exam_schol_weeckly_reports.id AS exam_schol_weeckly_reports_id', 
            'exam_schol_weeckly_reports.status AS exam_schol_weeckly_reports_STATUS',
            'classrooms.id AS classroom_id',
            'classrooms.class_name AS classroom_name'
        );

    // تطبيق التصفية حسب اسم الطالب
    if ($request->filled('student_name')) {
        $query->where('student_users.name', 'like', '%' . $request->student_name . '%');
    }

    // تطبيق التصفية حسب الصف
    if ($request->filled('classroom_id')) {
        $query->where('classrooms.id', $request->classroom_id);
    }

    // تطبيق التصفية حسب حالة التقرير
    if ($request->filled('status')) {
        $query->where('exam_schol_weeckly_reports.status', $request->status);
    }

    $exam_grade = $query->get();

    // جلب البيانات للتصفية
    $students =  DB::table('exam_schol_weeckly_reports')
        ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
        ->join('users as student_users', 'students.id', '=', 'student_users.id')
        ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
        ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
        ->where('classrooms.teacher_id',12)
        ->select('student_users.name', 'students.id')
        ->distinct()
        ->get();
      
       
    $classrooms = DB::table('exam_schol_weeckly_reports')
        ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
        ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
        ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
        ->where('classrooms.teacher_id', 12)
        ->select('classrooms.id', 'classrooms.class_name')
        ->distinct()
        ->get();

    return view('teacher-dashboard.Academic_Reports.Exam_Grades.index', compact('exam_grade', 'students', 'classrooms'));
}

    public function create()
{
    $teacherId = 12;
    
    // الصفوف فقط
    $classrooms = classroom::where('teacher_id', $teacherId)->get();
       
    return view('teacher-dashboard.Academic_Reports.Exam_Grades.create', compact('classrooms'));
}

public function getClassroomDataAjax($classroomId)
{
    $teacherId = 12;
    
    // 1. الحصول على طلاب الصف
    $students = DB::table('students')
        ->join('users', 'students.id', '=', 'users.id')
        ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
        ->where('student_classrooms.classroom_id', $classroomId)
        ->select('students.id', 'users.name')
        ->orderBy('users.name')
        ->get();
    
    // 2. الحصول على اختبارات هذا الصف
    // طريقة 1: إذا كان هناك علاقة مباشرة
    $exams = exam_weeckly::where('classroom_id', $classroomId)->get();
    
   
    
    return response()->json([
        'success' => true,
        'students' => $students,
        'exams' => $exams
    ]);
}
public function getExamSkillsAjax($examId)
{
    // استعلام أبسط للتحقق من صحة البيانات
    $examExists = DB::table('exam_weecklies')->where('id', $examId)->exists();
    
    if (!$examExists) {
        return response()->json([
            'success' => false,
            'message' => 'الاختبار غير موجود'
        ]);
    }

    // جلب البيانات خطوة بخطوة
    $examsWeeklySkills = DB::table('exams_weekly_skills')
        ->where('exams_weekly_id', $examId)
        ->get();

    if ($examsWeeklySkills->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'لا توجد مستويات مرتبطة بهذا الاختبار'
        ]);
    }

    // جلب المستويات
    $levelIds = $examsWeeklySkills->pluck('id_level');
    $levels = DB::table('level_skills')
        ->whereIn('id', $levelIds)
        ->get();

    if ($levels->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'المستويات المرتبطة غير موجودة'
        ]);
    }

    // جلب المهارات
    $skillIds = $levels->pluck('skill_id');
    $skills = DB::table('skills')
        ->whereIn('id', $skillIds)
        ->get();

    // تجميع البيانات
    $groupedSkills = [];
    
    foreach ($skills as $skill) {
        $groupedSkills[$skill->id] = [
            'skill_id' => $skill->id,
            'skill_name' => $skill->name,
            'skill_description' => $skill->description,
            'levels' => []
        ];
    }

    foreach ($levels as $level) {
        if (isset($groupedSkills[$level->skill_id])) {
            $examSkillStatus = $examsWeeklySkills
                ->where('id_level', $level->id)
                ->first()
                ->status ?? 'unknown';

            $groupedSkills[$level->skill_id]['levels'][] = [
                'level_id' => $level->id,
                'level_name' => $level->level_name,
                'level_description' => $level->level_description,
                'exam_skill_status' => $examSkillStatus
            ];
        }
    }

    return response()->json([
        'success' => true,
        'debug_info' => [
            'exam_exists' => $examExists,
            'exam_skills_count' => $examsWeeklySkills->count(),
            'levels_count' => $levels->count(),
            'skills_count' => $skills->count(),
            'grouped_skills_count' => count($groupedSkills)
        ],
        'skills' => array_values($groupedSkills)
    ]);
}  public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_weecklies_id' => 'required|exists:exam_weecklies,id',
            'exam_total_point' => 'required|integer|min:0|max:20',
            'exam_note' => 'required|string|max:255',
            'selected_levels' => 'nullable|array',
            'selected_levels.*' => 'exists:level_skills,id'
        ]);

        // حفظ التقرير
        $report = exam_schol_weeckly_report::create([
            'student_id' => $validatedData['student_id'],
            'exam_weecklies_id' => $validatedData['exam_weecklies_id'],
            'exam_total_point' => $validatedData['exam_total_point'],
            'exam_note' => $validatedData['exam_note'],
            'teacher_id' =>  12,
        ]);

        // حفظ المستويات
        $levelsCount = 0;
        if (!empty($validatedData['selected_levels'])) {
            $levelsCount = count($validatedData['selected_levels']);
            
            $levelsData = [];
            foreach ($validatedData['selected_levels'] as $levelId) {
                $levelsData[] = [
                    'student_id' => $validatedData['student_id'],
                    'teacher_id' => $report->teacher_id,
                    'level_id' => $levelId,
                    'status' => 'valid',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            
            // استخدام insertOrIgnore لتجنب الأخطاء عند التكرار
            student_level::insertOrIgnore($levelsData);
        }

        return redirect()->route('Exam_Grade.index')
            ->with('success', "تم حفظ التقرير بنجاح! ($levelsCount مستوى تم التحقق منه)");

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
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
      $results = User::join('students', 'users.id', '=', 'students.id')
        ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
        ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
        ->where('classrooms.teacher_id', 12)
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
    public function destroy(exam_schol_weeckly_report $Exam_Grade){
        $Exam_Grade->delete();
        return redirect()->back()->with('success', 'تم حدف الملاحظة بنجاح.');
    }
}
