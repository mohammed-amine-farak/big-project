<?php

namespace App\Http\Controllers;

use App\Models\exam_schol_weeckly_report;
use App\Models\level_skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Skills;
use App\Models\StudentLevel;
use App\Models\LevelSkill;
use App\Models\student_level;

class StudentSkillsController extends Controller
{
    /**
     * Display skills page for student - Simplified version
     * Shows all skills with green (validated) or red (not validated)
     */
    public function studentSkills(Request $request)
    {
        $studentId =  Auth::user()->id; // In production: Auth::user()->id
        
        // Get all skills from the database
        $allSkills = Skills::all();
        
        // Get validated level IDs for this student
        $validatedLevelIds = student_level::where('student_id', $studentId)
            ->where('status', 'valid')
            ->pluck('level_id')
            ->toArray();
        
        // Get all level_skills to know which skills have level_3 validated
        $level3ValidatedSkills = level_skill::whereIn('id', $validatedLevelIds)
            ->where('level', 'level_3')
            ->pluck('skill_id')
            ->toArray();
        
        // Build skills array with validation status
        $skills = [];
        foreach ($allSkills as $skill) {
            // Check if skill is validated (has level 3 validated)
            $isValidated = in_array($skill->id, $level3ValidatedSkills);
            
            $skills[] = [
                'id' => $skill->id,
                'name' => $skill->name,
                'description' => $skill->description ?? 'لا يوجد وصف',
                'validated' => $isValidated,
                'status' => $isValidated ? 'validated' : 'not_validated',
                'status_text' => $isValidated ? 'مكتسبة' : 'غير مكتسبة',
                'status_color' => $isValidated ? '#1D9E75' : '#DC2626',
                'status_bg' => $isValidated ? '#E1F5EE' : '#FEE2E2',
                'icon' => $isValidated ? '✅' : '❌'
            ];
        }
        
        // Calculate statistics
        $totalSkills = count($skills);
        $validatedSkills = count(array_filter($skills, fn($s) => $s['validated']));
        $notValidatedSkills = $totalSkills - $validatedSkills;
        $masteryPercentage = $totalSkills > 0 ? round(($validatedSkills / $totalSkills) * 100) : 0;
        
        // Get subjects for filter (optional)
        $subjects = DB::table('subjects')
            ->join('classrooms', 'subjects.id', '=', 'classrooms.subject_id')
            ->join('student_classrooms', 'classrooms.id', '=', 'student_classrooms.classroom_id')
            ->where('student_classrooms.student_id', $studentId)
            ->select('subjects.id', 'subjects.name')
            ->distinct()
            ->get();
        
        // Apply subject filter if needed
        if ($request->filled('subject_id')) {
            $skillIdsInSubject = DB::table('skills')
                ->join('level_skills', 'skills.id', '=', 'level_skills.skill_id')
                ->join('exams_weekly_skills', 'level_skills.id', '=', 'exams_weekly_skills.id_level')
                ->join('exam_weecklies', 'exams_weekly_skills.exams_weekly_id', '=', 'exam_weecklies.id')
                ->join('classrooms', 'exam_weecklies.classroom_id', '=', 'classrooms.id')
                ->where('classrooms.subject_id', $request->subject_id)
                ->pluck('skills.id')
                ->unique()
                ->toArray();
            
            $skills = array_filter($skills, function($skill) use ($skillIdsInSubject) {
                return in_array($skill['id'], $skillIdsInSubject);
            });
            $skills = array_values($skills);
            
            // Recalculate statistics after filter
            $totalSkills = count($skills);
            $validatedSkills = count(array_filter($skills, fn($s) => $s['validated']));
            $notValidatedSkills = $totalSkills - $validatedSkills;
            $masteryPercentage = $totalSkills > 0 ? round(($validatedSkills / $totalSkills) * 100) : 0;
        }
        
        return view('student-dashboard.skill.index', compact(
            'skills', 'totalSkills', 'validatedSkills', 'notValidatedSkills',
            'masteryPercentage', 'subjects'
        ));
    }
    /**
 * Show specific skill details with all levels
 */
public function show($skillId)
{
    $studentId =  Auth::user()->id; // In production: Auth::user()->id
    
    // Get the skill with its levels
    $skill = Skills::with(['levelSkills' => function($q) {
        $q->orderByRaw("FIELD(level, 'level_1', 'level_2', 'level_3')");
    }])->find($skillId);
    
    if (!$skill) {
        abort(404, 'المهارة غير موجودة');
    }
    
    // Get validated level IDs for this student
    $validatedLevelIds = student_level::where('student_id', $studentId)
        ->where('status', 'valid')
        ->pluck('level_id')
        ->toArray();
    
    // Get validated level types
    $validatedLevelTypes = level_skill::whereIn('id', $validatedLevelIds)
        ->where('skill_id', $skillId)
        ->pluck('level')
        ->toArray();
    
    // Process each level with status and colors
    foreach ($skill->levelSkills as $level) {
        $level->validated = in_array($level->id, $validatedLevelIds);
        
        // Determine level status for display
        if ($level->validated) {
            $level->status = 'validated';
            $level->status_text = 'مكتسب';
            $level->status_icon = '✅';
        } elseif ($level->level == 'level_1') {
            $level->status = 'not_validated';
            $level->status_text = 'غير مكتسب';
            $level->status_icon = '❌';
        } elseif ($level->level == 'level_2' && in_array('level_1', $validatedLevelTypes)) {
            $level->status = 'available';
            $level->status_text = 'متاح للتعلم';
            $level->status_icon = '📖';
        } elseif ($level->level == 'level_3' && in_array('level_2', $validatedLevelTypes)) {
            $level->status = 'available';
            $level->status_text = 'متاح للتعلم';
            $level->status_icon = '📖';
        } else {
            $level->status = 'locked';
            $level->status_text = 'مغلق';
            $level->status_icon = '🔒';
        }
    }
    
    // Get exams that validated this skill
    $exams = exam_schol_weeckly_report::where('student_id', $studentId)
        ->whereHas('examWeeckly.weeklySkills.levelSkill', function($q) use ($skillId) {
            $q->where('skill_id', $skillId);
        })
        ->with(['examWeeckly' => function($q) {
            $q->with(['weeklySkills' => function($q2) {
                $q2->with('levelSkill');
            }]);
        }])
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Transform exams data
    $examHistory = [];
    foreach ($exams as $exam) {
        foreach ($exam->examWeeckly->weeklySkills as $examSkill) {
            if ($examSkill->levelSkill->skill_id == $skillId) {
                $examHistory[] = (object)[
                    'exam_title' => $exam->examWeeckly->title,
                    'exam_total_point' => $exam->exam_total_point,
                    'created_at' => $exam->created_at,
                    'level_name' => $examSkill->levelSkill->level_name,
                    'level' => $examSkill->levelSkill->level
                ];
            }
        }
    }
    
    // Calculate progress percentage
    $totalLevels = $skill->levelSkills->count();
    $validatedLevelsCount = $skill->levelSkills->where('validated', true)->count();
    $progressPercentage = $totalLevels > 0 ? round(($validatedLevelsCount / $totalLevels) * 100) : 0;
    
    return view('student-dashboard.skill.show', compact('skill', 'progressPercentage', 'validatedLevelsCount', 'totalLevels', 'examHistory'));
}
}