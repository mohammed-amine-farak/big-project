<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\school;
use App\Models\student;
use App\Models\student_classroom;
use App\Models\study_year;
use App\Models\subject;
use App\Models\teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
  public function index(Request $request)
{
    $query = Classroom::with([
        'studyYear',
        'teacher.user',
        'subjects',
        'subjects.fieldOfStudy',
        'school',
        'student_classroom' => function($q) {
            $q->whereHas('student', function($sq) {
                $sq->whereHas('user');
            });
        },
        'student_classroom.student',
        'student_classroom.student.user'
    ]);
    
    // Apply filters
    if ($request->filled('study_year_id')) {
        $query->where('study_year_id', $request->study_year_id);
    }
    
    if ($request->filled('teacher_id')) {
        $query->where('teacher_id', $request->teacher_id);
    }
    
    if ($request->filled('subject_id')) {
        $query->where('subject_id', $request->subject_id);
    }
    
    if ($request->filled('school_id')) {
        $query->where('school_id', $request->school_id);
    }
    
    if ($request->filled('status')) {
        $query->where('is_active', $request->status == 'active');
    }
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('class_name', 'like', "%{$search}%")
              ->orWhere('class_name_ar', 'like', "%{$search}%");
        });
    }
    
    $classrooms = $query->orderBy('created_at', 'desc')->paginate(15);
    
    $stats = [
        'total_classrooms' => Classroom::count(),
        'active_classrooms' => Classroom::where('is_active', true)->count(),
        'inactive_classrooms' => Classroom::where('is_active', false)->count(),
        'total_students_enrolled' => DB::table('student_classrooms')->count(),
        'full_classrooms' => Classroom::whereRaw('(SELECT COUNT(*) FROM student_classrooms WHERE classroom_id = classrooms.id AND is_active = 1) >= max_students')->count(),
    ];
    
    $studyYears = study_year::all();
    $teachers = Teacher::with('user')->get();
    $subjects = Subject::with('fieldOfStudy')->get();
    $schools = School::all();
    
    return view('admine-dashboard.classrooms.index', compact('classrooms', 'stats', 'studyYears', 'teachers', 'subjects', 'schools'));
}
public function create()
    {
        // Get data for dropdowns
        $studyYears = study_year::all();
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::with('fieldOfStudy')->get();
        $schools = School::all();
        
        // Grade levels for dropdown
        $gradeLevels = [
            'Common Core',
            'First Baccalaureate',
            'Second Baccalaureate',
           
        ];
        
        return view('admine-dashboard.classrooms.create', compact('studyYears', 'teachers', 'subjects', 'schools', 'gradeLevels'));
    }
    
    /**
     * Store a newly created classroom in storage.
     */
  public function store(Request $request)
    {
        $request->validate([
            'study_year_id' => 'required|exists:study_years,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'school_id' => 'required|exists:schools,id',
            'class_name' => 'required|string|max:255|unique:classrooms,class_name',
            'class_name_ar' => 'required|string|max:255|unique:classrooms,class_name_ar',
            'grade_level' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'max_students' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean'
        ], [
            'class_name.unique' => 'اسم الفصل باللغة الانجليزية موجود بالفعل',
            'class_name_ar.unique' => 'اسم الفصل بالعربية موجود بالفعل',
        ]);
        
        // ✅ Check if teacher's subject matches the selected subject
        $teacher = Teacher::find($request->teacher_id);
        $subject = Subject::find($request->subject_id);
        
        if (!$teacher || !$subject) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'المعلم أو المادة غير موجودين في النظام');
        }
        
        // Compare teacher's subject with subject name
        if ($teacher->subject != $subject->name) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'هذا المعلم غير متخصص في تدريس مادة "' . $subject->name . '". تخصص المعلم هو "' . $teacher->subject . '". يرجى اختيار معلم متخصص في هذه المادة أو اختيار المادة المناسبة لتخصص المعلم.');
        }
        
        try {
            DB::beginTransaction();
            
            $classroom = Classroom::create([
                'study_year_id' => $request->study_year_id,
                'teacher_id' => $request->teacher_id,
                'subject_id' => $request->subject_id,
                'school_id' => $request->school_id,
                'class_name' => $request->class_name,
                'class_name_ar' => $request->class_name_ar,
                'grade_level' => $request->grade_level,
                'description' => $request->description,
                'max_students' => $request->max_students,
                'is_active' => $request->has('is_active') ? true : false
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.classrooms.index')
                ->with('success', 'تم إضافة الفصل الدراسي بنجاح');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة الفصل: ' . $e->getMessage());
        }
    }
    
    /**
     * AJAX: Get teacher's subject
     */
    public function getTeacherSubject($teacherId)
    {
        $teacher = Teacher::with('user')->find($teacherId);
        
        if (!$teacher) {
            return response()->json([
                'success' => false, 
                'message' => 'المعلم غير موجود'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'teacher_id' => $teacher->id,
            'teacher_name' => $teacher->user->name ?? 'غير معروف',
            'teacher_subject' => $teacher->subject,
            'message' => 'تخصص هذا المعلم هو: ' . $teacher->subject
        ]);
    }
    
    /**
     * AJAX: Check if teacher can teach selected subject
     */
    public function checkTeacherSubject($teacherId, $subjectId)
    {
        $teacher = Teacher::find($teacherId);
        $subject = Subject::find($subjectId);
        
        if (!$teacher || !$subject) {
            return response()->json([
                'success' => false,
                'can_teach' => false,
                'message' => 'المعلم أو المادة غير موجودين'
            ]);
        }
        
        // Compare teacher's subject with subject name
        $canTeach = ($teacher->subject == $subject->name);
        
        return response()->json([
            'success' => true,
            'can_teach' => $canTeach,
            'teacher_name' => $teacher->user->name ?? 'غير معروف',
            'teacher_subject' => $teacher->subject,
            'subject_name' => $subject->name,
            'message' => $canTeach 
                ? '✓ هذا المعلم متخصص في مادة "' . $subject->name . '"' 
                : '✗ هذا المعلم غير متخصص في مادة "' . $subject->name . '". تخصصه هو "' . $teacher->subject . '"'
        ]);
    }
    
    public function students(Classroom $classroom)
    {
        // Load classroom with relationships
        $classroom->load([
            'studyYear',
            'teacher.user',
            'subjects',
            'school',
            'student_classroom' => function($q) {
                $q->with('student.user')->orderBy('created_at', 'desc');
            }
        ]);
        
        // Get current students with their pivot data
        $enrolledStudents = $classroom->student_classroom;
        $enrolledStudentIds = $enrolledStudents->pluck('student_id')->toArray();
        
        // Get available students (not enrolled in this classroom)
        $availableStudents = student::with('user')
            ->whereNotIn('id', $enrolledStudentIds)
             ->where('fields_id', $classroom->subjects->fieldOfStudy->id ?? null)
            ->orderBy('id')
            ->get();
        
        // Get statistics
        $stats = [
            'total_students' => $enrolledStudents->count(),
            'max_students' => $classroom->max_students,
            'available_seats' => $classroom->max_students - $enrolledStudents->count(),
            'occupancy_percentage' => $classroom->max_students > 0 ? round(($enrolledStudents->count() / $classroom->max_students) * 100, 2) : 0,
            'active_students' => $enrolledStudents->where('is_active', true)->count(),
            'inactive_students' => $enrolledStudents->where('is_active', false)->count(),
        ];
        
        return view('admine-dashboard.classrooms.students', compact('classroom', 'availableStudents', 'enrolledStudents', 'stats'));
    }
    
    /**
     * Add a student to classroom.
     */
    /**
 * Add a student to classroom.
 */
public function addStudent(Request $request, Classroom $classroom)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'enrollment_date' => 'nullable|date'
    ]);
    
    // Check if classroom is full
    $currentCount = student_classroom::where('classroom_id', $classroom->id)->count();
    if ($currentCount >= $classroom->max_students) {
        return redirect()->back()->with('error', 'الفصل مكتمل، لا يمكن إضافة المزيد من الطلاب');
    }
    
    // Check if student is already enrolled in THIS classroom
    $existsInThisClassroom = student_classroom::where('student_id', $request->student_id)
        ->where('classroom_id', $classroom->id)
        ->exists();
        
    if ($existsInThisClassroom) {
        return redirect()->back()->with('error', 'هذا الطالب مسجل بالفعل في هذا الفصل');
    }
    
    // ✅ Check for existing enrollment in same subject
    $existingEnrollment = student_classroom::where('student_id', $request->student_id)
        ->whereHas('classroom', function($q) use ($classroom) {
            $q->where('subject_id', $classroom->subject_id);
        })
        ->with(['classroom', 'classroom.subjects'])
        ->first();
    
    if ($existingEnrollment) {
        $existingClassroom = $existingEnrollment->classroom;
        $subjectName = $existingClassroom->subjects->name ?? 'غير معروف';
        
        return redirect()->back()
            ->with('error', 'لا يمكن تسجيل الطالب في هذا الفصل لأنه مسجل بالفعل في فصل آخر بنفس المادة "' . $subjectName . '". 
            الفصل الحالي: "' . ($classroom->class_name_ar ?? $classroom->class_name) . '" - 
            الفصل المسجل فيه: "' . ($existingClassroom->class_name_ar ?? $existingClassroom->class_name) . '"');
    }
    
    try {
        DB::beginTransaction();
        
        // Add student to classroom
        student_classroom::create([
            'student_id' => $request->student_id,
            'classroom_id' => $classroom->id,
            'enrollment_date' => $request->enrollment_date ?? now(),
            'is_active' => true,
        ]);
        
        DB::commit();
        
        return redirect()->back()->with('success', 'تم إضافة الطالب إلى الفصل بنجاح');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة الطالب: ' . $e->getMessage());
    }
}
    /**
     * Remove a student from classroom.
     */
    public function removeStudent(Classroom $classroom, $studentId)
    {
        try {
            DB::beginTransaction();
            
            // Remove student from classroom
            student_classroom::where('student_id', $studentId)
                ->where('classroom_id', $classroom->id)
                ->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'تم حذف الطالب من الفصل بنجاح');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الطالب: ' . $e->getMessage());
        }
    }
    
    /**
     * Update student status in classroom (activate/deactivate).
     */
    public function updateStudentStatus(Request $request, Classroom $classroom, $studentId)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);
        
        try {
            DB::beginTransaction();
            
            $studentClassroom = student_classroom::where('student_id', $studentId)
                ->where('classroom_id', $classroom->id)
                ->first();
                
            if ($studentClassroom) {
                $studentClassroom->update([
                    'is_active' => $request->is_active,
                    'updated_at' => now()
                ]);
            }
            
            DB::commit();
            
            $status = $request->is_active ? 'تم تفعيل' : 'تم إلغاء تفعيل';
            return redirect()->back()->with('success', $status . ' الطالب بنجاح');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث حالة الطالب');
        }
    }
    
    /**
     * Export students list to CSV.
     */
    public function exportStudents(Classroom $classroom)
    {
        $students = student_classroom::with(['student.user'])
            ->where('classroom_id', $classroom->id)
            ->get();
        
        $filename = 'students_' . $classroom->class_name . '_' . date('Y-m-d') . '.csv';
        
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Add CSV headers
        fputcsv($handle, ['#', 'اسم الطالب', 'البريد الإلكتروني', 'تاريخ التسجيل', 'الحالة', 'تاريخ الانضمام']);
        
        // Add data rows
        foreach ($students as $index => $studentClassroom) {
            fputcsv($handle, [
                $index + 1,
                $studentClassroom->student->user->name ?? 'غير معروف',
                $studentClassroom->student->user->email ?? 'غير معروف',
                $studentClassroom->enrollment_date,
                $studentClassroom->is_active ? 'نشط' : 'غير نشط',
                $studentClassroom->created_at->format('Y-m-d')
            ]);
        }
        
        fclose($handle);
        exit;
    }
        public function edit(Classroom $classroom)
    {
        // Load relationships
        $classroom->load([
            'studyYear',
            'teacher.user',
            'subjects',
            'school'
        ]);
        
        // Get data for dropdowns
        $studyYears = study_year::all();
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::with('fieldOfStudy')->get();
        $schools = School::all();
        
        // Grade levels for dropdown
        $gradeLevels = [
           'Common Core',
            'First Baccalaureate',
            'Second Baccalaureate',
        ];
        
        return view('admine-dashboard.classrooms.edit', compact('classroom', 'studyYears', 'teachers', 'subjects', 'schools', 'gradeLevels'));
    }
    
    /**
     * Update the specified classroom in storage.
     */
    /**
 * Update the specified classroom in storage.
 */
public function update(Request $request, Classroom $classroom)
{
    $request->validate([
        'study_year_id' => 'required|exists:study_years,id',
        'school_id' => 'required|exists:schools,id',
        'class_name' => 'required|string|max:255|unique:classrooms,class_name,' . $classroom->id,
        'class_name_ar' => 'required|string|max:255|unique:classrooms,class_name_ar,' . $classroom->id,
        'grade_level' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
        'max_students' => 'required|integer|min:1|max:100',
        'is_active' => 'boolean'
        // Removed teacher_id and subject_id validation since they won't be submitted
    ], [
        'class_name.unique' => 'اسم الفصل باللغة الانجليزية موجود بالفعل',
        'class_name_ar.unique' => 'اسم الفصل بالعربية موجود بالفعل',
        'study_year_id.required' => 'الرجاء اختيار السنة الدراسية',
        'school_id.required' => 'الرجاء اختيار المدرسة',
        'class_name.required' => 'اسم الفصل بالانجليزية مطلوب',
        'class_name_ar.required' => 'اسم الفصل بالعربية مطلوب',
        'grade_level.required' => 'المستوى الدراسي مطلوب',
        'max_students.required' => 'الحد الأقصى للطلاب مطلوب',
        'max_students.min' => 'الحد الأقصى للطلاب يجب أن يكون على الأقل 1',
        'max_students.max' => 'الحد الأقصى للطلاب يجب أن لا يتجاوز 100'
    ]);
    
    // Check if max_students is less than current enrolled students
    $currentEnrolledCount = student_classroom::where('classroom_id', $classroom->id)->count();
    if ($request->max_students < $currentEnrolledCount) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'لا يمكن تقليل الحد الأقصى للطلاب إلى ' . $request->max_students . ' لأن هناك ' . $currentEnrolledCount . ' طالب مسجل حالياً في الفصل.');
    }
    
    try {
        DB::beginTransaction();
        
        $classroom->update([
            'study_year_id' => $request->study_year_id,
            'school_id' => $request->school_id,
            'class_name' => $request->class_name,
            'class_name_ar' => $request->class_name_ar,
            'grade_level' => $request->grade_level,
            'description' => $request->description,
            'max_students' => $request->max_students,
            'is_active' => $request->has('is_active') ? true : false
            // teacher_id and subject_id are NOT updated
        ]);
        
        DB::commit();
        
        return redirect()->route('admin.classrooms.index')
            ->with('success', 'تم تحديث الفصل الدراسي بنجاح');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ أثناء تحديث الفصل: ' . $e->getMessage());
    }
}  
/**
 * Display the specified classroom.
 */
public function show(Classroom $classroom)
{
    // Load all relationships
    $classroom->load([
        'studyYear',
        'teacher.user',
        'subjects.fieldOfStudy',
        'school',
        'student_classroom' => function($q) {
            $q->with('student.user')->orderBy('created_at', 'desc');
        }
    ]);
    
    // Get enrolled students with their pivot data
    $enrolledStudents = $classroom->student_classroom;
    
    // Calculate statistics
    $stats = [
        'total_students' => $enrolledStudents->count(),
        'max_students' => $classroom->max_students,
        'available_seats' => $classroom->max_students - $enrolledStudents->count(),
        'occupancy_percentage' => $classroom->max_students > 0 ? round(($enrolledStudents->count() / $classroom->max_students) * 100, 2) : 0,
        'active_students' => $enrolledStudents->where('is_active', true)->count(),
        'inactive_students' => $enrolledStudents->where('is_active', false)->count(),
    ];
    
    // Get recent students (last 10)
    $recentStudents = $enrolledStudents->take(10);
    
    return view('admine-dashboard.classrooms.show', compact('classroom', 'stats', 'recentStudents', 'enrolledStudents'));
}  
/**
 * Remove the specified classroom from storage.
 */
public function destroy(Classroom $classroom)
{
    // Check if classroom has enrolled students
    $enrolledStudentsCount = student_classroom::where('classroom_id', $classroom->id)->count();
    
    if ($enrolledStudentsCount > 0) {
        return redirect()->back()->with('error', 'لا يمكن حذف الفصل لأنه يحتوي على ' . $enrolledStudentsCount . ' طالب مسجل. يرجى نقل الطلاب أولاً.');
    }
    
    // Check if classroom has exam weeklies
    $examWeekliesCount = $classroom->examWeeklies()->count();
    if ($examWeekliesCount > 0) {
        return redirect()->back()->with('error', 'لا يمكن حذف الفصل لأنه يحتوي على ' . $examWeekliesCount . ' اختبار أسبوعي مرتبط به.');
    }
    
    // Check if classroom has psychology records
    $psychologyCount = $classroom->student_psychology()->count();
    if ($psychologyCount > 0) {
        return redirect()->back()->with('error', 'لا يمكن حذف الفصل لأنه يحتوي على ' . $psychologyCount . ' سجل نفسي مرتبط به.');
    }
    
    // Check if classroom has lesson reports
    $lessonReportsCount = $classroom->lessonReports()->count();
    if ($lessonReportsCount > 0) {
        return redirect()->back()->with('error', 'لا يمكن حذف الفصل لأنه يحتوي على ' . $lessonReportsCount . ' تقرير درس مرتبط به.');
    }
    
    try {
        DB::beginTransaction();
        
        // Delete all student_classroom records first (if any)
        student_classroom::where('classroom_id', $classroom->id)->delete();
        
        // Delete the classroom
        $classroom->delete();
        
        DB::commit();
        
        return redirect()->route('admin.classrooms.index')
            ->with('success', 'تم حذف الفصل الدراسي بنجاح');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'حدث خطأ أثناء حذف الفصل: ' . $e->getMessage());
    }
}
    }
