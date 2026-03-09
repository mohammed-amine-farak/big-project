<?php

namespace App\Http\Controllers;

use App\Models\skills;
use Illuminate\Http\Request;
use App\Models\exam_weeckly;
use App\Models\exams;
use App\Models\exams_weekly_skills;
use App\Models\level_skill;
use App\Models\subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class exam_skills_level_Controller extends Controller
{
    public function create(){
        $results = exam_weeckly::with('subject')
            ->where('researcher_id', Auth::id()) // ✅
            ->whereDoesntHave('weeklySkills')
            ->get();
        
        return view('researchers-dashboard\exam_skills\create', compact('results'));
    }

    public function getSkillLevelsByExam(Request $request)
    {
        $examId = $request->input('exam_id');
        
        $exam = exam_weeckly::with('subject')->find($examId);
        
        if (!$exam) {
            return response()->json(['skill_levels' => []]);
        }

        // ✅ تحقق أن الاختبار يخص الباحث الحالي
        if ($exam->researcher_id !== Auth::id()) {
            return response()->json(['skill_levels' => []]);
        }

        $skillLevels = level_skill::with(['skill' => function($query) use ($exam) {
                $query->where('subject_id', $exam->subject_id);
            }])
            ->whereHas('skill', function($query) use ($exam) {
                $query->where('subject_id', $exam->subject_id);
            })
            ->get(['id', 'level_name', 'level_description', 'skill_id'])
            ->map(function($level) {
                return [
                    'id' => $level->id,
                    'name' => $level->level_name,
                    'description' => $level->level_description,
                    'skill_name' => $level->skill->name ?? 'Unknown Skill',
                    'level' => $level->level
                ];
            });

        return response()->json(['skill_levels' => $skillLevels]);
    }

    public function index(Request $request)
    {
        $query = exam_weeckly::with([
            'subject', 
            'weeklySkills.levelSkill.skill'
        ])
        ->where('researcher_id', Auth::id()) // ✅
        ->has('weeklySkills')
        ->withCount(['weeklySkills']);
    
        if ($request->has('exam_title') && $request->exam_title) {
            $query->where('title', 'like', '%' . $request->exam_title . '%');
        }
    
        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }
    
        if ($request->has('skills_count') && $request->skills_count) {
            if ($request->skills_count == '3+') {
                $query->has('weeklySkills', '>=', 3);
            } else {
                $query->has('weeklySkills', '=', $request->skills_count);
            }
        }
    
        if ($request->has('skill_id') && $request->skill_id) {
            $query->whereHas('weeklySkills.levelSkill', function($q) use ($request) {
                $q->where('skill_id', $request->skill_id);
            });
        }
    
        $results = $query->paginate(10)->withQueryString();
        
        $subjects = \App\Models\subject::all();
        $skills = \App\Models\skills::with('subject')->get();
    
        return view('researchers-dashboard.exam_skills.index', compact('results', 'subjects', 'skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exam_weecklies,id',
            'skill_level_ids' => 'required|array|min:1',
            'skill_level_ids.*' => 'exists:level_skills,id'
        ]);

        // ✅ تحقق أن الاختبار يخص الباحث الحالي
        $exam = exam_weeckly::findOrFail($request->exam_id);
        if ($exam->researcher_id !== Auth::id()) {
            abort(403);
        }

        $uniqueLevelIds = array_unique($request->skill_level_ids);

        foreach ($uniqueLevelIds as $levelId) {
            exams_weekly_skills::firstOrCreate([
                'exams_weekly_id' => $request->exam_id,
                'id_level' => $levelId
            ], [
                'status' => 'in_progress'
            ]);
        }

        return redirect()->route('Exam_skill.index')->with('success', 'تم ربط مستويات المهارات بالاختبار بنجاح!');
    }

    public function show($id)
    {
        $exam = exam_weeckly::with([
                'subject', 
                'weeklySkills.levelSkill.skill'
            ])
            ->withCount(['weeklySkills'])
            ->findOrFail($id);

        // ✅ تحقق أن الاختبار يخص الباحث الحالي
        if ($exam->researcher_id !== Auth::id()) {
            abort(403);
        }

        $levelSkills = level_skill::with('skill')
            ->whereHas('skill', function($query) use ($exam) {
                $query->where('subject_id', $exam->subject_id);
            }) 
            ->get();
          
        return view('researchers-dashboard.exam_skills.show', compact('exam', 'levelSkills'));
    }
   
    public function delete_level(exams_weekly_skills $exam_id){
        // ✅ تحقق أن الاختبار يخص الباحث الحالي
        if ($exam_id->examWeeckly->researcher_id !== Auth::id()) {
            abort(403);
        }

        exams_weekly_skills::destroy([$exam_id->id]);
    
        return redirect()->back()->with('success', 'Level deleted successfully');
    }

    public function delete($exam_id){
        try {
            $exam = exam_weeckly::findOrFail($exam_id);

            // ✅ تحقق أن الاختبار يخص الباحث الحالي
            if ($exam->researcher_id !== Auth::id()) {
                abort(403);
            }

            $level = exams_weekly_skills::where('exams_weekly_id', $exam_id)->delete();
            
            if (!$level) {
                return redirect()->back()
                    ->with('error', 'لم يتم العثور على المهارة المطلوبة');
            }
            
            return redirect()->back()
                ->with('success', 'تم حذف المهارة من الاختبار بنجاح');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'فشل في حذف المهارة: ' . $e->getMessage());
        }
    }

    public function add_to_exam_skills(Request $request, exam_weeckly $exam_id)
    {
        // ✅ تحقق أن الاختبار يخص الباحث الحالي
        if ($exam_id->researcher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'level_skill_id' => 'required|exists:level_skills,id'
        ]);

        try {
            $existing = exams_weekly_skills::where([
                'exams_weekly_id' => $exam_id->id,
                'id_level' => $request->level_skill_id
            ])->exists();

            if ($existing) {
                return redirect()->back()
                    ->with('error', 'هذه المهارة مرتبطة بالفعل بالاختبار');
            }

            exams_weekly_skills::create([
                'exams_weekly_id' => $exam_id->id,
                'id_level' => $request->level_skill_id,
                'status' => 'in_progress'
            ]);

            return redirect()->back()
                ->with('success', 'تم ربط المهارة بالاختبار بنجاح!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'فشل في الربط: ' . $e->getMessage());
        }
    }
}