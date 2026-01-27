<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\exam_weeckly;
use App\Models\exam_schol_weeckly_report;
use App\Models\student_level;
use App\Models\subject;
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
            ->where('classrooms.teacher_id', 12)
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

        if ($request->filled('student_name')) {
            $query->where('student_users.name', 'like', '%' . $request->student_name . '%');
        }

        if ($request->filled('classroom_id')) {
            $query->where('classrooms.id', $request->classroom_id);
        }

        if ($request->filled('status')) {
            $query->where('exam_schol_weeckly_reports.status', $request->status);
        }

        $exam_grade = $query->get();

        $students = DB::table('exam_schol_weeckly_reports')
            ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
            ->join('users as student_users', 'students.id', '=', 'student_users.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->join('classrooms', 'student_classrooms.classroom_id', '=', 'classrooms.id')
            ->where('classrooms.teacher_id', 12)
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
        $classrooms = classroom::where('teacher_id', $teacherId)->get();
        
        return view('teacher-dashboard.Academic_Reports.Exam_Grades.create', compact('classrooms'));
    }

    public function getClassroomDataAjax($classroomId)
    {
        $teacherId = 12;
        
        $students = DB::table('students')
            ->join('users', 'students.id', '=', 'users.id')
            ->join('student_classrooms', 'students.id', '=', 'student_classrooms.student_id')
            ->where('student_classrooms.classroom_id', $classroomId)
            ->select('students.id', 'users.name')
            ->orderBy('users.name')
            ->get();
        
        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }

    public function getStudentExamsAjax($classroomId, $studentId)
    {
        $teacherId = 12;
        
        $allExams = exam_weeckly::where('classroom_id', $classroomId)->get();
        
        $reportedExams = exam_schol_weeckly_report::where('student_id', $studentId)
            ->where('teacher_id', $teacherId)
            ->pluck('exam_weecklies_id')
            ->toArray();
        
        $availableExams = $allExams->whereNotIn('id', $reportedExams)->values();
        
        return response()->json([
            'success' => true,
            'exams' => $availableExams
        ]);
    }

    public function getExamSkillsAjax($examId, $studentId = null)
    {
        $examExists = DB::table('exam_weecklies')->where('id', $examId)->exists();
        
        if (!$examExists) {
            return response()->json([
                'success' => false,
                'message' => 'الاختبار غير موجود'
            ]);
        }

        // Get skills with their levels including level type
        $examSkills = DB::table('exams_weekly_skills')
            ->join('level_skills', 'exams_weekly_skills.id_level', '=', 'level_skills.id')
            ->join('skills', 'level_skills.skill_id', '=', 'skills.id')
            ->where('exams_weekly_skills.exams_weekly_id', $examId)
            ->select(
                'skills.id as skill_id',
                'skills.name as skill_name',
                'skills.description as skill_description',
                'level_skills.id as level_id',
                'level_skills.level_name',
                'level_skills.level_description',
                'level_skills.level as level_type',
                'exams_weekly_skills.status as exam_skill_status'
            )
            ->orderBy('skills.id')
            ->orderByRaw("FIELD(level_skills.level, 'level_3', 'level_2', 'level_1')")
            ->get();

        if ($examSkills->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد مهارات مرتبطة بهذا الاختبار'
            ]);
        }

        // Get already validated levels for this student
        $alreadyValidatedLevels = [];
        if ($studentId) {
            $alreadyValidatedLevels = DB::table('student_levels')
                ->where('student_id', $studentId)
                ->where('status', 'valid')
                ->pluck('level_id')
                ->toArray();
        }

        // Group by skill
        $groupedSkills = [];
        
        foreach ($examSkills as $examSkill) {
            $skillId = $examSkill->skill_id;
            
            // Check if this level is already validated
            $isAlreadyValidated = in_array($examSkill->level_id, $alreadyValidatedLevels);
            
            if (!isset($groupedSkills[$skillId])) {
                $groupedSkills[$skillId] = [
                    'skill_id' => $examSkill->skill_id,
                    'skill_name' => $examSkill->skill_name,
                    'skill_description' => $examSkill->skill_description,
                    'levels' => []
                ];
            }
            
            // Add level with validation status
            $groupedSkills[$skillId]['levels'][] = [
                'level_id' => $examSkill->level_id,
                'level_name' => $examSkill->level_name,
                'level_description' => $examSkill->level_description,
                'level_type' => $examSkill->level_type,
                'exam_skill_status' => $examSkill->exam_skill_status,
                'already_validated' => $isAlreadyValidated  // We'll use this for UI only
            ];
        }

        // Convert to indexed array
        $groupedSkills = array_values($groupedSkills);

        return response()->json([
            'success' => true,
            'skills' => $groupedSkills,
            'already_validated_levels' => $alreadyValidatedLevels,
            'already_validated_count' => count($alreadyValidatedLevels)
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'student_id' => 'required|exists:students,id',
                'exam_weecklies_id' => 'required|exists:exam_weecklies,id',
                'exam_total_point' => 'required|numeric|min:0|max:20',
                'exam_note' => 'required|string|max:255',
                'selected_levels' => 'nullable|array',
                'selected_levels.*' => 'exists:level_skills,id'
            ]);

            // Save the report
            $report = exam_schol_weeckly_report::create([
                'student_id' => $validatedData['student_id'],
                'exam_weecklies_id' => $validatedData['exam_weecklies_id'],
                'exam_total_point' => $validatedData['exam_total_point'],
                'exam_note' => $validatedData['exam_note'],
                'teacher_id' => 12,
            ]);

            $levelsCount = 0;
            $newLevelsCount = 0;
            
            if (!empty($validatedData['selected_levels'])) {
                // Get selected levels
                $selectedLevelIds = $validatedData['selected_levels'];
                
                // Get already validated levels for this student
                $alreadyValidatedLevels = DB::table('student_levels')
                    ->where('student_id', $validatedData['student_id'])
                    ->where('status', 'valid')
                    ->pluck('level_id')
                    ->toArray();
                
                // Filter out levels that are already validated
                $newLevelsToValidate = array_diff($selectedLevelIds, $alreadyValidatedLevels);
                
                // Apply hierarchical logic for NEW levels only
                if (!empty($newLevelsToValidate)) {
                    // Get level details including skill_id and level type
                    $newLevelsDetails = DB::table('level_skills')
                        ->whereIn('id', $newLevelsToValidate)
                        ->get(['id', 'skill_id', 'level']);
                    
                    // Group by skill
                    $skillsLevels = [];
                    foreach ($newLevelsDetails as $level) {
                        $skillId = $level->skill_id;
                        if (!isset($skillsLevels[$skillId])) {
                            $skillsLevels[$skillId] = [];
                        }
                        $skillsLevels[$skillId][] = $level;
                    }
                    
                    // Apply hierarchical logic for new levels
                    $allNewLevelsToValidate = [];
                    
                    foreach ($skillsLevels as $skillId => $levels) {
                        // Find the highest level selected for this skill
                        $highestLevel = null;
                        $highestLevelOrder = 0;
                        $levelOrder = ['level_1' => 1, 'level_2' => 2, 'level_3' => 3];
                        
                        foreach ($levels as $level) {
                            $order = $levelOrder[$level->level] ?? 0;
                            if ($order > $highestLevelOrder) {
                                $highestLevelOrder = $order;
                                $highestLevel = $level;
                            }
                        }
                        
                        if ($highestLevel) {
                            // Get all lower levels for this skill based on the highest selected level
                            $levelsToAdd = DB::table('level_skills')
                                ->where('skill_id', $skillId)
                                ->where(function($query) use ($levelOrder, $highestLevelOrder) {
                                    foreach ($levelOrder as $level => $order) {
                                        if ($order <= $highestLevelOrder) {
                                            $query->orWhere('level', $level);
                                        }
                                    }
                                })
                                ->pluck('id')
                                ->toArray();
                            
                            // Filter out levels that are already validated
                            $levelsToAdd = array_diff($levelsToAdd, $alreadyValidatedLevels);
                            
                            $allNewLevelsToValidate = array_merge($allNewLevelsToValidate, $levelsToAdd);
                        }
                    }
                    
                    // Remove duplicates
                    $allNewLevelsToValidate = array_unique($allNewLevelsToValidate);
                    $newLevelsCount = count($allNewLevelsToValidate);
                    
                    // Prepare data for insertion
                    $levelsData = [];
                    foreach ($allNewLevelsToValidate as $levelId) {
                        $levelsData[] = [
                            'student_id' => $validatedData['student_id'],
                            'teacher_id' => $report->teacher_id,
                            'level_id' => $levelId,
                            'status' => 'valid',
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                    
                    // Insert only new levels
                    if (!empty($levelsData)) {
                        student_level::insertOrIgnore($levelsData);
                    }
                }
                
                // Total levels count (including already validated ones)
                $levelsCount = count($selectedLevelIds);
            }

            $message = "تم حفظ التقرير بنجاح!";
            if ($levelsCount > 0) {
                if ($newLevelsCount > 0) {
                    $message .= " ($newLevelsCount مستوى جديد تم التحقق منه)";
                } else {
                    $message .= " (جميع المستويات المحددة محققة مسبقاً)";
                }
            }

            return redirect()->route('Exam_Grade.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }


   public function edit(exam_schol_weeckly_report $Exam_Grade)
{
    $teacherId = 12;
    
    // Get the current exam grade with student and exam details
    $exam_grade = DB::table('exam_schol_weeckly_reports')
        ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
        ->join('users as student_users', 'students.id', '=', 'student_users.id')
        ->join('teachers', 'exam_schol_weeckly_reports.teacher_id', '=', 'teachers.id')
        ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
        ->join('exam_weecklies', 'exam_schol_weeckly_reports.exam_weecklies_id', '=', 'exam_weecklies.id')
        ->join('classrooms', 'exam_weecklies.classroom_id', '=', 'classrooms.id')
        ->where('exam_schol_weeckly_reports.id', $Exam_Grade->id)
        ->select(
            'student_users.name AS student_name',
            'student_users.id AS student_id',
            'teacher_users.name AS teacher_name',
            'exam_weecklies.title AS exam_weeckly_title',
            'exam_weecklies.id AS exam_weeckly_id',
            'exam_weecklies.classroom_id AS classroom_id',
            'classrooms.class_name AS classroom_name',
            'exam_schol_weeckly_reports.exam_total_point AS exam_weeckly_total_point',
            'exam_schol_weeckly_reports.exam_note AS exam_weeckly_note',
            'exam_schol_weeckly_reports.created_at AS created_at',
            'exam_schol_weeckly_reports.id AS exam_schol_weeckly_reports_id'
        )
        ->first();
    
    if (!$exam_grade) {
        abort(404, 'التقرير غير موجود');
    }
    
    // Get already validated levels for this student in this report
    $alreadyValidatedLevels = DB::table('student_levels')
        ->where('student_id', $exam_grade->student_id)
        ->where('teacher_id', $teacherId)
        ->where('status', 'valid')
        ->pluck('level_id')
        ->toArray();
    
    // Get classrooms for dropdown
    $classrooms = classroom::where('teacher_id', $teacherId)->get();
    
    return view('teacher-dashboard.Academic_Reports.Exam_Grades.update', compact(
        'exam_grade', 
        'classrooms',
        'alreadyValidatedLevels'
    ));
}

   public function update(exam_schol_weeckly_report $Exam_Grade, Request $request)
{
    try {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_weecklies_id' => 'required|exists:exam_weecklies,id',
            'exam_total_point' => 'required|numeric|min:0|max:20',
            'exam_note' => 'required|string|max:255',
            'selected_levels' => 'nullable|array',
            'selected_levels.*' => 'exists:level_skills,id'
        ]);

        $teacherId = 12;
        
        // Update the report
        $Exam_Grade->student_id = $validatedData['student_id'];
        $Exam_Grade->exam_weecklies_id = $validatedData['exam_weecklies_id'];
        $Exam_Grade->exam_total_point = $validatedData['exam_total_point'];
        $Exam_Grade->exam_note = $validatedData['exam_note'];
        $Exam_Grade->save();

        // Handle levels update
        $levelsCount = 0;
        $newLevelsCount = 0;
        
        // Get current validated levels for this student from this teacher
        $currentValidatedLevels = DB::table('student_levels')
            ->where('student_id', $validatedData['student_id'])
            ->where('teacher_id', $teacherId)
            ->where('status', 'valid')
            ->pluck('level_id')
            ->toArray();
        
        if (!empty($validatedData['selected_levels'])) {
            $selectedLevelIds = $validatedData['selected_levels'];
            
            // Filter out levels that are already validated
            $newLevelsToValidate = array_diff($selectedLevelIds, $currentValidatedLevels);
            
            // Apply hierarchical logic for NEW levels only
            if (!empty($newLevelsToValidate)) {
                // Get level details including skill_id and level type
                $newLevelsDetails = DB::table('level_skills')
                    ->whereIn('id', $newLevelsToValidate)
                    ->get(['id', 'skill_id', 'level']);
                
                // Group by skill
                $skillsLevels = [];
                foreach ($newLevelsDetails as $level) {
                    $skillId = $level->skill_id;
                    if (!isset($skillsLevels[$skillId])) {
                        $skillsLevels[$skillId] = [];
                    }
                    $skillsLevels[$skillId][] = $level;
                }
                
                // Apply hierarchical logic for new levels
                $allNewLevelsToValidate = [];
                
                foreach ($skillsLevels as $skillId => $levels) {
                    // Find the highest level selected for this skill
                    $highestLevel = null;
                    $highestLevelOrder = 0;
                    $levelOrder = ['level_1' => 1, 'level_2' => 2, 'level_3' => 3];
                    
                    foreach ($levels as $level) {
                        $order = $levelOrder[$level->level] ?? 0;
                        if ($order > $highestLevelOrder) {
                            $highestLevelOrder = $order;
                            $highestLevel = $level;
                        }
                    }
                    
                    if ($highestLevel) {
                        // Get all lower levels for this skill based on the highest selected level
                        $levelsToAdd = DB::table('level_skills')
                            ->where('skill_id', $skillId)
                            ->where(function($query) use ($levelOrder, $highestLevelOrder) {
                                foreach ($levelOrder as $level => $order) {
                                    if ($order <= $highestLevelOrder) {
                                        $query->orWhere('level', $level);
                                    }
                                }
                            })
                            ->pluck('id')
                            ->toArray();
                        
                        // Filter out levels that are already validated
                        $levelsToAdd = array_diff($levelsToAdd, $currentValidatedLevels);
                        
                        $allNewLevelsToValidate = array_merge($allNewLevelsToValidate, $levelsToAdd);
                    }
                }
                
                // Remove duplicates
                $allNewLevelsToValidate = array_unique($allNewLevelsToValidate);
                $newLevelsCount = count($allNewLevelsToValidate);
                
                // Prepare data for insertion
                $levelsData = [];
                foreach ($allNewLevelsToValidate as $levelId) {
                    $levelsData[] = [
                        'student_id' => $validatedData['student_id'],
                        'teacher_id' => $teacherId,
                        'level_id' => $levelId,
                        'status' => 'valid',
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                
                // Insert only new levels
                if (!empty($levelsData)) {
                    student_level::insertOrIgnore($levelsData);
                }
            }
            
            // Total levels count (including already validated ones)
            $levelsCount = count($selectedLevelIds);
        } else {
            // If no levels selected, keep existing validated levels
            $levelsCount = count($currentValidatedLevels);
        }

        $message = "تم تحديث التقرير بنجاح!";
        if ($levelsCount > 0) {
            if ($newLevelsCount > 0) {
                $message .= " ($newLevelsCount مستوى جديد تم التحقق منه)";
            } else {
                $message .= " (تم الاحتفاظ بالمستويات المحققة مسبقاً)";
            }
        }

        return redirect()->route('Exam_Grade.index')
            ->with('success', $message);

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
}

    public function update_status(exam_schol_weeckly_report $Exam_Grade)
    {
        if ($Exam_Grade->status === 'send') {
            return redirect()->back()->with('error', 'هذه الملاحظة تم إرسالها بالفعل.');
        }

        $Exam_Grade->status = 'send';
        $Exam_Grade->save();

        return redirect()->back()->with('success', 'تم إرسال الملاحظة بنجاح.');
    }

    public function destroy(exam_schol_weeckly_report $Exam_Grade)
    {
        $Exam_Grade->delete();
        return redirect()->back()->with('success', 'تم حذف الملاحظة بنجاح.');
    }
    public function show($id)
{
    $teacherId = 12;
    
    // Find the exam report by ID
    $Exam_Grade = exam_schol_weeckly_report::findOrFail($id);
    
    // Get the exam report with all details
    $exam_grade = DB::table('exam_schol_weeckly_reports')
        ->join('students', 'exam_schol_weeckly_reports.student_id', '=', 'students.id')
        ->join('users as student_users', 'students.id', '=', 'student_users.id')
        ->join('teachers', 'exam_schol_weeckly_reports.teacher_id', '=', 'teachers.id')
        ->join('users as teacher_users', 'teachers.id', '=', 'teacher_users.id')
        ->join('exam_weecklies', 'exam_schol_weeckly_reports.exam_weecklies_id', '=', 'exam_weecklies.id')
        ->join('classrooms', 'exam_weecklies.classroom_id', '=', 'classrooms.id')
        ->where('exam_schol_weeckly_reports.id', $id)
        ->select(
            'student_users.name AS student_name',
            'student_users.id AS student_id',
            'teacher_users.name AS teacher_name',
            'exam_weecklies.title AS exam_weeckly_title',
            'exam_weecklies.id AS exam_weeckly_id',
            'exam_weecklies.classroom_id AS classroom_id',
            'classrooms.class_name AS classroom_name',
            'exam_schol_weeckly_reports.exam_total_point AS exam_weeckly_total_point',
            'exam_schol_weeckly_reports.exam_note AS exam_weeckly_note',
            'exam_schol_weeckly_reports.created_at AS created_at',
            'exam_schol_weeckly_reports.updated_at AS updated_at',
            'exam_schol_weeckly_reports.id AS exam_schol_weeckly_reports_id',
            'exam_schol_weeckly_reports.status AS status'
        )
        ->first();
    
    if (!$exam_grade) {
        abort(404, 'التقرير غير موجود');
    }
    
    // Get validated levels for this report
    $validatedLevels = DB::table('student_levels')
        ->join('level_skills', 'student_levels.level_id', '=', 'level_skills.id')
        ->join('skills', 'level_skills.skill_id', '=', 'skills.id')
        ->where('student_levels.student_id', $exam_grade->student_id)
        ->where('student_levels.teacher_id', $teacherId)
        ->where('student_levels.status', 'valid')
        ->select(
            'skills.id as skill_id',
            'skills.name as skill_name',
            'skills.description as skill_description',
            'level_skills.id as level_id',
            'level_skills.level_name',
            'level_skills.level_description',
            'level_skills.level as level_type',
            'student_levels.created_at as validated_at'
        )
        ->orderBy('skills.id')
        ->orderByRaw("FIELD(level_skills.level, 'level_3', 'level_2', 'level_1')")
        ->get();
    
    // Group levels by skill
    $groupedSkills = [];
    foreach ($validatedLevels as $level) {
        $skillId = $level->skill_id;
        
        if (!isset($groupedSkills[$skillId])) {
            $groupedSkills[$skillId] = [
                'skill_id' => $level->skill_id,
                'skill_name' => $level->skill_name,
                'skill_description' => $level->skill_description,
                'levels' => []
            ];
        }
        
        $groupedSkills[$skillId]['levels'][] = [
            'level_id' => $level->level_id,
            'level_name' => $level->level_name,
            'level_description' => $level->level_description,
            'level_type' => $level->level_type,
            'validated_at' => $level->validated_at
        ];
    }
    
    // Convert to indexed array
    $groupedSkills = array_values($groupedSkills);
    
    // Calculate statistics
    $totalSkills = count($groupedSkills);
    $totalLevels = $validatedLevels->count();
    
    // Count levels by type
    $level1Count = $validatedLevels->where('level_type', 'level_1')->count();
    $level2Count = $validatedLevels->where('level_type', 'level_2')->count();
    $level3Count = $validatedLevels->where('level_type', 'level_3')->count();
    
    // Get previous report for comparison (if any)
    $previousReport = DB::table('exam_schol_weeckly_reports')
        ->join('exam_weecklies', 'exam_schol_weeckly_reports.exam_weecklies_id', '=', 'exam_weecklies.id')
        ->where('exam_schol_weeckly_reports.student_id', $exam_grade->student_id)
        ->where('exam_schol_weeckly_reports.id', '<', $id)
        ->where('exam_schol_weeckly_reports.teacher_id', $teacherId)
        ->orderBy('exam_schol_weeckly_reports.created_at', 'desc')
        ->select(
            'exam_weecklies.title',
            'exam_schol_weeckly_reports.exam_total_point',
            'exam_schol_weeckly_reports.created_at'
        )
        ->first();
    
    return view('teacher-dashboard.Academic_Reports.Exam_Grades.show', compact(
        'exam_grade',
        'groupedSkills',
        'totalSkills',
        'totalLevels',
        'level1Count',
        'level2Count',
        'level3Count',
        'previousReport'
    ));
}
// In your controller
public function examsList(Request $request)
{
    $teacherId = 12; // Or get from auth: auth()->id()

    $query = exam_weeckly::with([
        'weeklySkills',
        'classroom',
        'subject',
        'weeklySkills.levelSkill.skill'
    ])->whereHas('classroom', function($q) use ($teacherId) {
        $q->where('teacher_id', $teacherId);
    })->whereHas('weeklySkills', function($q) {
        $q->where('status', '=', 'send');
    });

    // Apply classroom filter
    if ($request->filled('classroom')) {
        $query->where('classroom_id', $request->classroom);
    }

    // Paginate results - REMOVED ->get() from here
    $exams = $query->orderBy('created_at', 'desc')
                  ->paginate(15)
                  ->withQueryString();

    // Get classrooms for filter dropdown - only teacher's classrooms
    $classrooms = Classroom::where('teacher_id', $teacherId)->get();

    // Calculate monthly count for stats
    $monthlyCount = exam_weeckly::whereHas('classroom', function($q) use ($teacherId) {
        $q->where('teacher_id', $teacherId);
    })->whereHas('weeklySkills', function($q) {
        $q->where('status', '=', 'send');
    })->whereMonth('created_at', now()->month)->count();

    return view('teacher-dashboard.Academic_Reports.Exam_Grades.exam', compact('exams', 'classrooms', 'monthlyCount'));
}// View single exam
public function viewExam($id)
{
     $exam = exam_weeckly::with([
        'classroom',
        'subject',
        'researcher',
        'weeklySkills' => function($query) {
            $query->with([
                'levelSkill.skill',
                'levelSkill' => function($q) {
                    $q->select('id', 'skill_id', 'level_name', 'level_description', 'level');
                }
            ]);
        }
    ])->findOrFail($id);

    return view('teacher-dashboard.Academic_Reports.Exam_Grades.view', compact('exam'));
}

// Print exam page
public function printExam($id)
{
    $exam = exam_weeckly::with([
        'classroom',
        'subject',
        'researcher',
        'weeklySkills.levelSkill.skill'
    ])->findOrFail($id);

    return view('teacher-dashboard.Academic_Reports.Exam_Grades.print', compact('exam'));
}
}