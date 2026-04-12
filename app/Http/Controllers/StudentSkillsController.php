<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentSkillsController extends Controller
{
    /**
     * Display skills page for student
     */
    public function studentSkills(Request $request)
    {
        $studentId = 17;
        
        // Get validated levels for this student
        $validatedLevels = DB::table('student_levels')
            ->join('level_skills', 'student_levels.level_id', '=', 'level_skills.id')
            ->join('skills', 'level_skills.skill_id', '=', 'skills.id')
            ->where('student_levels.student_id', $studentId)
            ->where('student_levels.status', 'valid')
            ->select(
                'skills.id as skill_id',
                'skills.name as skill_name',
                'skills.description as skill_description',
                'level_skills.id as level_id',
                'level_skills.level'
            )
            ->get();
        
        // Get all available skills for subjects the student is enrolled in
        $allSkills = DB::table('skills')
            ->join('level_skills', 'skills.id', '=', 'level_skills.skill_id')
            ->join('exams_weekly_skills', 'level_skills.id', '=', 'exams_weekly_skills.id_level')
            ->join('exam_weecklies', 'exams_weekly_skills.exams_weekly_id', '=', 'exam_weecklies.id')
            ->join('classrooms', 'exam_weecklies.classroom_id', '=', 'classrooms.id')
            ->join('student_classrooms', 'classrooms.id', '=', 'student_classrooms.classroom_id')
            ->where('student_classrooms.student_id', $studentId)
            ->select('skills.id', 'skills.name', 'skills.description')
            ->distinct()
            ->get();
        
        // Get subjects for filter
        $subjects = DB::table('subjects')
            ->join('classrooms', 'subjects.id', '=', 'classrooms.subject_id')
            ->join('student_classrooms', 'classrooms.id', '=', 'student_classrooms.classroom_id')
            ->where('student_classrooms.student_id', $studentId)
            ->select('subjects.id', 'subjects.name')
            ->distinct()
            ->get();
        
        // Build skills array with all skills
        $skillsArray = [];
        foreach ($allSkills as $skill) {
            $skillsArray[$skill->id] = [
                'id' => $skill->id,
                'name' => $skill->name,
                'description' => $skill->description ?? 'لا يوجد وصف',
                'level_1_validated' => false,
                'level_2_validated' => false,
                'level_3_validated' => false
            ];
        }
        
        // Mark validated levels
        foreach ($validatedLevels as $level) {
            $skillId = $level->skill_id;
            if (isset($skillsArray[$skillId])) {
                if ($level->level == 'level_1') {
                    $skillsArray[$skillId]['level_1_validated'] = true;
                }
                if ($level->level == 'level_2') {
                    $skillsArray[$skillId]['level_2_validated'] = true;
                }
                if ($level->level == 'level_3') {
                    $skillsArray[$skillId]['level_3_validated'] = true;
                }
            }
        }
        
        // Apply subject filter
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
            
            $skillsArray = array_filter($skillsArray, function($skill) use ($skillIdsInSubject) {
                return in_array($skill['id'], $skillIdsInSubject);
            });
        }
        
        // Convert to indexed array
        $skills = array_values($skillsArray);
        
        // Calculate statistics
        $totalSkills = count($skills);
        
        // Count validated skills (level 3 achieved)
        $validatedSkills = 0;
        $inProgressSkills = 0;
        $totalLevels = 0;
        
        foreach ($skills as $skill) {
            if ($skill['level_3_validated']) {
                $validatedSkills++;
            } elseif ($skill['level_1_validated'] || $skill['level_2_validated']) {
                $inProgressSkills++;
            }
            
            // Count total levels achieved
            if ($skill['level_1_validated']) $totalLevels++;
            if ($skill['level_2_validated']) $totalLevels++;
            if ($skill['level_3_validated']) $totalLevels++;
        }
        
        // Calculate mastery percentage
        $masteryPercentage = $totalSkills > 0 ? round(($validatedSkills / $totalSkills) * 100) : 0;
        
        // Find highest level achieved
        $highestLevel = 'لا يوجد';
        $hasLevel3 = false;
        $hasLevel2 = false;
        $hasLevel1 = false;
        
        foreach ($skills as $skill) {
            if ($skill['level_3_validated']) $hasLevel3 = true;
            if ($skill['level_2_validated']) $hasLevel2 = true;
            if ($skill['level_1_validated']) $hasLevel1 = true;
        }
        
        if ($hasLevel3) {
            $highestLevel = 'متقدم (المستوى 3)';
        } elseif ($hasLevel2) {
            $highestLevel = 'متوسط (المستوى 2)';
        } elseif ($hasLevel1) {
            $highestLevel = 'أساسي (المستوى 1)';
        }
        
        return view('student-dashboard.skill.index', compact(
            'skills', 'totalSkills', 'validatedSkills', 'inProgressSkills',
            'totalLevels', 'masteryPercentage', 'highestLevel', 'subjects'
        ));
    }
    
    /**
     * Show specific skill details
     */
    public function show($skillId)
    {
        $studentId = Auth::user()->id;
        
        $skill = DB::table('skills')
            ->where('id', $skillId)
            ->first();
        
        if (!$skill) {
            abort(404, 'المهارة غير موجودة');
        }
        
        // Get validated levels for this skill
        $validatedLevels = DB::table('student_levels')
            ->join('level_skills', 'student_levels.level_id', '=', 'level_skills.id')
            ->where('student_levels.student_id', $studentId)
            ->where('level_skills.skill_id', $skillId)
            ->where('student_levels.status', 'valid')
            ->pluck('level_skills.level')
            ->toArray();
        
        // Get all exams that validated this skill
        $exams = DB::table('exam_schol_weeckly_reports')
            ->join('exam_weecklies', 'exam_schol_weeckly_reports.exam_weecklies_id', '=', 'exam_weecklies.id')
            ->join('exams_weekly_skills', 'exam_weecklies.id', '=', 'exams_weekly_skills.exams_weekly_id')
            ->join('level_skills', 'exams_weekly_skills.id_level', '=', 'level_skills.id')
            ->where('exam_schol_weeckly_reports.student_id', $studentId)
            ->where('level_skills.skill_id', $skillId)
            ->select(
                'exam_weecklies.title',
                'exam_schol_weeckly_reports.exam_total_point',
                'exam_schol_weeckly_reports.created_at'
            )
            ->orderBy('exam_schol_weeckly_reports.created_at', 'desc')
            ->get();
        
        return view('student-dashboard.skills.show', compact('skill', 'validatedLevels', 'exams'));
    }
    
    /**
     * Get skills data as JSON (for AJAX)
     */
    public function getSkillsData(Request $request)
    {
        $studentId = 17;
        
        $skills = DB::table('skills')
            ->select('id', 'name', 'description')
            ->get();
        
        $validatedLevels = DB::table('student_levels')
            ->where('student_id', $studentId)
            ->where('status', 'valid')
            ->pluck('level_id')
            ->toArray();
        
        return response()->json([
            'success' => true,
            'skills' => $skills,
            'validated_levels' => $validatedLevels
        ]);
    }
}