<?php

namespace App\Http\Controllers;

use App\Models\Fields_Of_Study;
use App\Models\student;
use App\Models\subject;
use Illuminate\Http\Request;

class FieldOfStudyController extends Controller
{
        public function index(Request $request)
    {
        $query = Fields_Of_Study::withCount(['subjects', 'student']);
        
        // Filter by study level
        if ($request->filled('study_level')) {
            $query->where('study_level', $request->study_level);
        }
        
        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $fields = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Statistics
        $stats = [
            'total_fields' => Fields_Of_Study::count(),
            'common_core' => Fields_Of_Study::where('study_level', 'Common Core')->count(),
            'first_bac' => Fields_Of_Study::where('study_level', 'First Baccalaureate')->count(),
            'second_bac' => Fields_Of_Study::where('study_level', 'Second Baccalaureate')->count(),
            'total_subjects' => subject::count(),
            'total_students' => student::count(),
        ];
        
        return view('admine-dashboard.fields_of_study.index', compact('fields', 'stats'));
    }
    
    public function create()
    {
        return view('admine-dashboard.fields_of_study.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fields_of_studies,name',
            'study_level' => 'required|in:Common Core,First Baccalaureate,Second Baccalaureate',
            'description' => 'nullable|string|max:500'
        ]);
        
        Fields_Of_Study::create([
            'name' => $request->name,
            'study_level' => $request->study_level,
            'description' => $request->description
        ]);
        
        return redirect()->route('admin.fields-of-study.index')
            ->with('success', 'تم إضافة مجال الدراسة بنجاح');
    }
    
    public function show(Fields_Of_Study $fields_of_study)
    {
        $field = $fields_of_study;
        $field->load(['subjects', 'student.user']);
       
        $stats = [
            'subjects_count' => $field->subjects->count(),
            'students_count' => $field->student->count(),
          
        ];
        
        // Get subjects with their details
        $subjects = $field->subjects()->withCount(['lessons', 'exam_weecklies'])->get();
        
        // Get recent students
        $recentStudents = $field->student()->with('user')->latest()->take(10)->get();
        
        return view('admine-dashboard.fields_of_study.show', compact('field', 'stats', 'subjects', 'recentStudents'));
    }
    
    public function edit(Fields_Of_Study $fields_of_study)
    {
        return view('admine-dashboard.fields_of_study.edit', compact('fields_of_study'));
    }
    
    public function update(Request $request, Fields_Of_Study $fields_of_study)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fields_of_studies,name,' . $fields_of_study->id,
            'study_level' => 'required|in:Common Core,First Baccalaureate,Second Baccalaureate',
            'description' => 'nullable|string|max:500'
        ]);
        
        $fields_of_study->update([
            'name' => $request->name,
            'study_level' => $request->study_level,
            'description' => $request->description
        ]);
        
        return redirect()->route('admin.fields-of-study.index')
            ->with('success', 'تم تحديث مجال الدراسة بنجاح');
    }
    
    public function destroy(Fields_Of_Study $fields_of_study)
    {
        // Check if field has related records
        if ($fields_of_study->subjects()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف مجال الدراسة لأنه مرتبط بمواد دراسية');
        }
        
        if ($fields_of_study->students()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف مجال الدراسة لأنه مرتبط بطلاب');
        }
        
        $fields_of_study->delete();
        
        return redirect()->route('admin.fields-of-study.index')
            ->with('success', 'تم حذف مجال الدراسة بنجاح');
    }
    
    // Get fields by level (AJAX)
    public function getFieldsByLevel($level)
    {
        $fields = Fields_Of_Study::where('study_level', $level)->get();
        return response()->json($fields);
    }
    
    // Export fields to CSV
    public function export()
    {
        $fields = Fields_Of_Study::withCount(['subjects', 'student'])->get();
        
        $filename = 'fields_of_study_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['ID', 'اسم المجال', 'المستوى الدراسي', 'عدد المواد', 'عدد الطلاب', 'تاريخ الإضافة']);
        
        foreach ($fields as $field) {
            fputcsv($handle, [
                $field->id,
                $field->name,
                $field->study_level,
                $field->subjects_count,
                $field->students_count,
                $field->created_at->format('Y-m-d')
            ]);
        }
        
        fclose($handle);
        exit;
    }

}
