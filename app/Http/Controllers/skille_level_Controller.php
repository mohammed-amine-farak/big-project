<?php

namespace App\Http\Controllers;

use App\Models\Fields_Of_Study;
use App\Models\level_skill;
use Illuminate\Http\Request;
use App\Models\skills;
use Illuminate\Support\Facades\DB;
use App\Models\subject;
use Illuminate\Validation\Rule;
class skille_level_Controller extends Controller
{
   
    public function index(Request $request)
    {
        // Start building the query with necessary eager loading
        $query = skills::with(['subject', 'subject.fieldOfStudy']);
        
        // --- 1. Filtering Logic ---

        // Apply skill name (or description) filter, analogous to the 'title' filter
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        // Apply subject filter
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        
        // Apply field of study filter (using whereHas on the subject relation)
        if ($request->filled('field_study_id')) {
            $query->whereHas('subject', function($q) use ($request) {
                // Assuming the foreign key on the subjects table is 'fields_id'
                $q->where('fields_id', $request->field_study_id);
            });
        }
        
        // --- 2. Execution and Pagination ---
        
        // Get filtered skills, ordered by creation date (latest), with pagination (10 per page),
        // and append all current query string parameters (for filtering) to the pagination links.
        $skills = $query->latest()->paginate(10)->withQueryString();
        
        // --- 3. Data for Filter Dropdowns and Stats ---
        
        // Get all subjects and field studies for filter dropdowns
        $subjects = Subject::all();
        $fieldStudies = Fields_Of_Study::all();
        
        // Get total skills count for stats (without pagination)
        $totalSkillsCount = skills::count();

        // --- 4. Return View ---

        return view('researchers-dashboard.skille.index', compact(
            'skills',
            'subjects',
            'fieldStudies',
            'totalSkillsCount'
        ));
    }

    public function show(skills $skills){
        $result = Skills::with(['subject', 'subject.fieldOfStudy', 'levelSkills'])
        ->where('id', $skills->id)
        ->first();
     
    return view('researchers-dashboard.skille.show', compact('result'));
    }
      
    public function create(){
        $subjects = subject::with('fieldOfStudy')->get();
        return view('researchers-dashboard\skille\create',compact('subjects')); 
    }

    public function edit($id)
{
    $skill = skills::findOrFail($id);
    $subjects = subject::with('fieldOfStudy')->get();
    return view('researchers-dashboard.skille.edit', compact('skill', 'subjects'));
}
public function destroy($id)
{
    $skill = skills::findOrFail($id);
    $skill->delete();
    
    return redirect()->route('skills.index')->with('success', 'تم حذف المهارة بنجاح!');
}
public function update(Request $request, $id)
{
    $skill = skills::findOrFail($id);
    
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:skills,name,' . $id,
        'description' => 'required|string',
        'subject_id' => 'required|string|max:255',
    ]);

    $skill->update($validatedData);

    return redirect()->route('skills.index')->with('success', 'تم تحديث المهارة بنجاح!');
}

    public function store(Request $request){
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:skills,name',
            'description' => 'required|string',
            'subject_id' => 'required|string|max:255',
        ]);

        // Create a new Skill instance and save it to the database
        $skill = new skills();
        $skill->name = $validatedData['name'];
        $skill->description = $validatedData['description'];
        $skill->subject_id = $validatedData['subject_id'];
        $skill->save();

        return redirect()->route('skills.index')->with('success', 'تمت إضافة المهارة بنجاح!');  
    }


    public function create_level($id){
        return view('researchers-dashboard\skille\create_level_skill',compact('id'));
    }


    public function store_level(Request $request)
{
    $validated = $request->validate([
        'skill_id' => 'required|exists:skills,id',
        'level_name' => 'required|string|max:255',
        'level_description' => 'nullable|string',
        'level' => [
            'required',
            'in:level_1,level_2,level_3',
            Rule::unique('level_skills')->where(function ($query) use ($request) {
                return $query->where('skill_id', $request->skill_id)
                           ->where('level', $request->level);
            })
        ]
    ]);

    // التحقق من أن المهارة لا تحتوي على أكثر من 3 مستويات
    $existingLevelsCount = level_skill::where('skill_id', $validated['skill_id'])->count();
    
    if ($existingLevelsCount >= 3) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['level' => 'لا يمكن إضافة أكثر من 3 مستويات للمهارة الواحدة']);
    }

    // حفظ البيانات
    level_skill::create($validated);
    
    return redirect()->route('show_more_skills.show', $validated['skill_id'])
                    ->with('success', 'تمت إضافة المستوى بنجاح!'); 
}
public function edit_level($id)
{
    $level = level_skill::findOrFail($id);
    return view('researchers-dashboard\skille\level_edit', compact('level'));
}

public function update_level(Request $request, $id)
{
    $level = level_skill::findOrFail($id);
    
    $validated = $request->validate([
        'level_name' => 'required|string|max:255',
        'level_description' => 'nullable|string',
        'level' => [
            'required',
            'in:level_1,level_2,level_3',
            Rule::unique('level_skills')->where(function ($query) use ($request, $level) {
                return $query->where('skill_id', $level->skill_id)
                           ->where('level', $request->level)
                           ->where('id', '!=', $level->id);
            })
        ]
    ]);

    $level->update($validated);
    
    return redirect()->route('show_more_skills.show', $level->skill_id)
                    ->with('success', 'تم تحديث المستوى بنجاح!');
}
public function destroy_level($id)
{
    $level = level_skill::findOrFail($id);
    $skill_id = $level->skill_id;
    $level->delete();
    
    return redirect()->route('show_more_skills.show', $skill_id)->with('success', 'تم حذف المستوى بنجاح!');
}
}
