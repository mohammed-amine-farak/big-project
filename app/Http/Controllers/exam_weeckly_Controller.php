<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\exam_weeckly;
use App\Models\classroom;
use App\Models\subject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class exam_weeckly_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = exam_weeckly::with(['subject', 'classroom']);
      
    
        // Apply filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
    
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
    
        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }
    
        $exams = $query->latest()->paginate(10);
    
        // Get counts for stats
        $totalExamsCount = exam_weeckly::count();
       
        $subjectsCount = subject::count();
        $classroomsCount = Classroom::count();
    
        // Get filter options
        $subjects = Subject::all();
        $classrooms = Classroom::all();
    
        return view('researchers-dashboard\exam_weecklies\index', compact(
            'exams',
            'totalExamsCount',
            
            'subjectsCount',
            'classroomsCount',
            'subjects',
            'classrooms'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::with('fieldOfStudy')->get();
        $classrooms = Classroom::all();
        
        return view('researchers-dashboard\exam_weecklies\create', compact('subjects', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'file_path' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('exam_weeklies', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }

        // Add researcher_id from authenticated user
        $validated['researcher_id'] = 1;

        // Create the exam
        exam_weeckly::create($validated);

        return redirect()->route('exam_weeckly.index')
                        ->with('success', 'تم إنشاء الامتحان الأسبوعي بنجاح.');
    }
    public function getClassroomsBySubject(Request $request)
    {
        Log::info('AJAX request received', $request->all());

        $request->validate([
            'subject_id' => 'required|exists:subjects,id'
        ]);

        // Get classrooms that belong to this subject (one-to-many)
        $classrooms = Classroom::where('subject_id', $request->subject_id)->get();

        Log::info('Classrooms found:', $classrooms->toArray());

        return response()->json([
            'success' => true,
            'classrooms' => $classrooms
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $exam = exam_weeckly::findOrFail($id);
            
            // Check if the authenticated user owns this exam
            

            $subjects =  Subject::with('fieldOfStudy')->get();
            $classrooms = Classroom::where('subject_id', $exam->subject_id)->get();
            
            return view('researchers-dashboard\exam_weecklies\edit', compact('exam', 'subjects', 'classrooms'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('exam_weeckly.index')
                            ->with('error', 'الامتحان غير موجود.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $exam = exam_weeckly::findOrFail($id);
            
            // Check if the authenticated user owns this exam
           

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'subject_id' => 'required|exists:subjects,id',
                'classroom_id' => 'required|exists:classrooms,id',
                'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            ]);

            // Handle file upload if new file is provided
            if ($request->hasFile('file_path')) {
                // Delete old file if exists
                if ($exam->file_path && Storage::disk('public')->exists($exam->file_path)) {
                    Storage::disk('public')->delete($exam->file_path);
                }
                
                $file = $request->file('file_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('exam_weeklies', $fileName, 'public');
                $validated['file_path'] = $filePath;
            } else {
                // Keep the existing file path
                $validated['file_path'] = $exam->file_path;
            }

            // Update the exam
            $exam->update($validated);

            return redirect()->route('exam_weeckly.index')
                            ->with('success', 'تم تحديث الامتحان الأسبوعي بنجاح.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('exam_weeckly.index')
                            ->with('error', 'الامتحان غير موجود.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
            $exam = exam_weeckly::findOrFail($id);
            
            // Check if the authenticated user owns this exam
            

            // Delete file if exists
            if ($exam->file_path && Storage::disk('public')->exists($exam->file_path)) {
                Storage::disk('public')->delete($exam->file_path);
            }

            $exam->delete();

            return redirect()->route('exam_weeckly.index')
                        ->with('success');
    }
}
