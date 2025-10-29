<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Lessonss;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psy\Command\WhereamiCommand;
use App\Models\subject;
use App\Models\Fields_Of_Study;


class LessonController extends Controller
{
    public function create()
    {
        $subjects = Subject::join('fields_of_studies', 'subjects.fields_id', '=', 'fields_of_studies.id')
        ->select(

        'subjects.name AS subject_name', 
        'subjects.id AS subjects_id',
        'fields_of_studies.name AS field_name',
        'fields_of_studies.study_level'
         )
        ->get();

        return view('researchers-dashboard.lessons.create',compact('subjects'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'subject_id' => 'required',
            
        ]);

        $data['researcher_id'] =  1; // use 1 if not using auth

        Lessonss::create($data);

        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully!');
    }


    public function index(Request $request)
    {
        // Start building the query - only show lessons created by current user
        $query = Lessonss::with(['subject.fieldOfStudy', 'researcher'])
                      ->where('researcher_id', 1);
        
        // Apply title filter
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        
        // Apply subject filter
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        
        // Apply field of study filter
        if ($request->filled('field_study_id')) {
            $query->whereHas('subject', function($q) use ($request) {
                $q->where('fields_id', $request->field_study_id);
            });
        }
        
        // Get filtered lessons with pagination (10 per page)
        $lessons = $query->latest()->paginate(10)->withQueryString();
        
        // Get all subjects and field studies for filter dropdowns
        $subjects = Subject::all();
        $fieldStudies = Fields_Of_Study::all();
        
        // Get total lessons count for stats (without pagination)
        $totalLessonsCount = Lessonss::where('researcher_id', 1)->count();
        
        return view('researchers-dashboard.lessons.index', compact('lessons', 'subjects', 'fieldStudies', 'totalLessonsCount'));
    }

    public function update(Lessonss $lessonID) {
        $lesson = $lessonID->load(['subject', 'subject.fieldOfStudy']);
        $subjects = subject::with('fieldOfStudy')->get();
        
        return view('researchers-dashboard.lessons.update',compact('lesson','subjects'));
    }


public function edit(Request $request, Lessonss $lessonID)
{
    // 1. Validate the incoming request data
    $validatedData = $request->validate([
        'title'       => 'required|string|max:255',
        'content'     => 'nullable|string', // Changed from 'description' to 'content' to match your form's name attribute
        'subject_id'     => 'required',
        
    ]);

    
        // 2. Update the lesson with the validated data
        $lessonID->update([
            'title'       => $validatedData['title'],
            'content'     => $validatedData['content'],
            'subject_id'     => $validatedData['subject_id'],
           
            // Add any other fields you need to update
        ]);

        // 3. Redirect back with a success message
        return redirect()->route('lessons.index')->with('success', 'تم تحديث الدرس بنجاح!');
        // Replace 'lessons.index' with the appropriate route for your lessons list.

   
        return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث الدرس. الرجاء المحاولة مرة أخرى.');
    }

    public function destroy($lessonID)
{
    $lesson = Lessonss::findOrFail($lessonID); // أو Lesson::where('id', $id)->firstOrFail();

    // يمكنك إضافة تحقق من الصلاحيات هنا مثلاً: Gate::authorize('delete', $lesson);

    $lesson->delete();

    return redirect()->route('lessons.index')->with('success', 'تم حذف الدرس بنجاح.');
}

public function show(Lessonss $lesson){

   
      $lesson->load([
        'researcher.researcherProfile', // Load user (researcher), then their specific researcher profile
        'rules.examples',               // Load rules, and for each rule, load its examples
                       // Load the next lesson object
    ]);
  
   
    return view('researchers-dashboard.lessons.show', compact('lesson'));
}


public function ProgressTracker(){
       $lessons = Lessonss::all();
    return view('researchers-dashboard.lessons.Progress_Tracker',compact('lessons'));
}
public function updateStatus(Request $request, Lessonss $lesson)
{
    // 1. Validate the incoming request
    $request->validate([
        'status' => 'required|string|in:completed,in_progress,not_started',
    ]);
    
    // 2. Update the lesson's status
    $lesson->status = $request->input('status');

    // 3. Conditionally update the completed_at timestamp
    if ($lesson->status === 'completed') {
        // If the status is completed, set the timestamp to now
        $lesson->completed_at = now();
    } else {
        // Otherwise, set it to null
        $lesson->completed_at = null;
    }

    // 4. Save the changes to the database
    $lesson->save();

    // 5. Redirect back with a success message
    return redirect()->back()->with('success', 'تم تحديث حالة الدرس بنجاح!');
}

public function teacher_reports(){
    return view('researchers-dashboard.lessons.teacher_reports');
}

public function student_reports(){
    return view('researchers-dashboard.lessons.student_reports');
}

}
    
    

