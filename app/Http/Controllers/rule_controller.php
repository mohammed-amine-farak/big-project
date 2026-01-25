<?php

namespace App\Http\Controllers;
use App\Models\Lessonss;
use App\Models\rules;
use Illuminate\Http\Request;

class rule_controller extends Controller
{
    public function create()
    {
        $lessons = Lessonss::all();
        return view('researchers-dashboard.rules.create',compact('lessons'));
    }

   


    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lessons_id' => 'required|numeric',
        ]);
        rules::create($data);
        return redirect()->route('rules.index')->with('success', 'rules created successfully!');
    }




    public function index(Request $request)
    {
        $query = rules::with('lesson');
        
        // Apply filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        
        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }
        
        $rules = $query->latest()->paginate(10)->withQueryString();
        $totalRulesCount = rules::count();
        // Get all lessons for filter dropdown
        $lessons = Lessonss::all();
        
        // Get total rules count for stats (without pagination)
        
        // For the filter dropdown
       
        return view('researchers-dashboard.rules.index', compact('rules', 'lessons'));
    }







    public function destroy(rules $rule){
        $rule->delete();
        return redirect()->route('rules.index')->with('success', 'rules deleted successfully!');

    }





    public function update(rules $rule){
        $lessons = Lessonss::orderBy('title')->get(); // <<< This line creates the $lessons variable!

        // Pass both the specific rule ($rule) AND the collection of all lessons ($lessons)
        // to the view.
        return view('researchers-dashboard.rules.update', compact('rule', 'lessons'));
    }







    public function edit(Request $request,rules $rule){
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lessons_id' => 'required|exists:lessonss,id',
        ]);
    
        
            // 2. Update the lesson with the validated data
            $rule->update([
                'title'       => $validatedData['title'],
                'description'     => $validatedData['description'],
                'lessons_id'     => $validatedData['lessons_id'],
            ]);
    
            // 3. Redirect back with a success message
            return redirect()->route('rules.index')->with('success', 'تم تحديث القاعدة بنجاح!');
            // Replace 'lessons.index' with the appropriate route for your lessons list.
    
       
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث الدرس. الرجاء المحاولة مرة أخرى.');
       
    }
}
