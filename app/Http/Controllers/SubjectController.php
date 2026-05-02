<?php

namespace App\Http\Controllers;

use App\Models\Fields_Of_Study;
use App\Models\subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = subject::with('fieldOfStudy');
        
        // Filter by field of study
        if ($request->filled('fields_id')) {
            $query->where('fields_id', $request->fields_id);
        }
        
        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $subjects = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get fields for filter
        $fields = Fields_Of_Study::all();
        
        // Statistics
        $stats = [
            'total_subjects' => Subject::count(),
            'total_fields' => Fields_Of_Study::count(),
            'subjects_by_field' => Subject::select('fields_id',FacadesDB::raw('count(*) as total'))
                ->groupBy('fields_id')
                ->with('fieldOfStudy')
                ->get()
        ];
        
        return view('admine-dashboard.subjects.index', compact('subjects', 'fields', 'stats'));
    }
    
    public function create()
    {
        $fields = Fields_Of_Study::all();
        return view('admine-dashboard.subjects.create', compact('fields'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
            'fields_id' => 'required|exists:fields_of_studies,id'
        ]);
        
        Subject::create([
            'name' => $request->name,
            'fields_id' => $request->fields_id
        ]);
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'تم إضافة المادة بنجاح');
    }
    
    public function edit(Subject $subject)
    {
        $fields = Fields_Of_Study::all();
        return view('admine-dashboard.subjects.edit', compact('subject', 'fields'));
    }
    
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'fields_id' => 'required|exists:fields_of_studies,id'
        ]);
        
        $subject->update([
            'name' => $request->name,
            'fields_id' => $request->fields_id
        ]);
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'تم تحديث المادة بنجاح');
    }
    
    public function destroy(Subject $subject)
    {
        // Check if subject has related records
        if ($subject->lessons()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف المادة لأنها مرتبطة بدروس');
        }
        
        if ($subject->exam_weecklies()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف المادة لأنها مرتبطة بامتحانات');
        }
        
        if ($subject->classrooms()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف المادة لأنها مرتبطة بصفوف');
        }
        
        $subject->delete();
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'تم حذف المادة بنجاح');
    }
    
    public function show(Subject $subject)
    {
        $subject->load(['fieldOfStudy', 'lessons', 'exam_weecklies', 'classrooms']);
        
        $stats = [
            'lessons_count' => $subject->lessons->count(),
            'exams_count' => $subject->exam_weecklies->count(),
            'classrooms_count' => $subject->classrooms->count(),
        ];
        
        return view('admine-dashboard.subjects.show', compact('subject', 'stats'));
    }
    
    // Get subjects by field (AJAX)
    public function getSubjectsByField($fieldsId)
    {
        $subjects = Subject::where('fields_id', $fieldsId)->get();
        return response()->json($subjects);
    }

}
