<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacher;
use App\Models\Researchers;
use App\Models\lessonss;
use App\Models\rules;
use App\Models\rule_examples;
use App\Models\subject;
use App\Models\Fields_Of_Study;

class teacher_lesson_controller extends Controller
{
  
     public function index(Request $request)
    {
        // Start building the query - only show lessons created by current user
        $query = Lessonss::with(['subject.fieldOfStudy', 'researcher']);
        
        // Apply title filter
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        };
        
        // Apply subject filter
       
        
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
        
        return view('teacher-dashboard.lesson.index', compact('lessons', 'subjects', 'fieldStudies', 'totalLessonsCount'));
    
    }
}
