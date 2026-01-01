<?php

namespace App\Http\Controllers;

use App\Models\choices;
use App\Models\exams;
use App\Models\Fields_Of_Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\lessonss;
use App\Models\questions;
use App\Models\subject;
use Illuminate\Support\Facades\Log;

class exam_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Start query with relationships
    $query = exams::with([
        'lesson' => function($query) {
            $query->with('subject');
        }
    ])->latest();
 
    // Apply filters
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    if ($request->filled('subject_id')) {
        $query->whereHas('lesson', function($query) use ($request) {
            $query->where('subject_id', $request->subject_id);
        });
    }

    if ($request->filled('lesson_id')) {
        $query->where('lesson_id', $request->lesson_id);
    }

    // Get filter data for dropdowns
    $subjects = subject::pluck('name', 'id');
    $lessons = lessonss::pluck('title', 'id');
    
    // Get unique field studies for stats (if needed)
    $fieldStudies = Fields_Of_Study::with('subjects')->get();

    // Get paginated results
    $exams = $query->paginate(10)->withQueryString();

    // Calculate statistics
    $totalExamsCount = exams::count();
    $activeExams = exams::where('start_time', '<=', now())
                      ->where('end_time', '>=', now())
                      ->count();
    $upcomingExams = exams::where('start_time', '>', now())->count();
    $finishedExams = exams::where('end_time', '<', now())->count();

    return view('researchers-dashboard.exam.index', compact(
        'exams',
        'subjects',
        'lessons',
        'fieldStudies',
        'totalExamsCount',
        'activeExams',
        'upcomingExams',
        'finishedExams'
    ));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = lessonss::all();
        return view('researchers-dashboard.exam.create',compact('lessons'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'exam_title' => 'required|string|max:255',
            'exam_subject' => 'nullable|string|max:255',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.choices' => 'required|array|min:2',
            'questions.*.choices.*.text' => 'required|string',
            'questions.*.correct_choice' => 'required|integer|min:0',
            'lessons_id'=>'required',
        ],
        // Arabic error messages for better user experience
        [
            'exam_title.required' => 'عنوان الاختبار مطلوب.',
            'exam_title.string' => 'يجب أن يكون عنوان الاختبار نصًا.',
            'exam_title.max' => 'يجب ألا يتجاوز عنوان الاختبار 255 حرفًا.',
            'questions.required' => 'يجب إضافة سؤال واحد على الأقل.',
            'questions.array' => 'يجب أن تكون الأسئلة في صيغة مصفوفة.',
            'questions.*.text.required' => 'نص السؤال مطلوب.',
            'questions.*.choices.required' => 'يجب إضافة خيارين على الأقل لكل سؤال.',
            'questions.*.choices.min' => 'يجب أن يحتوي السؤال على خيارين على الأقل.',
            'questions.*.choices.*.text.required' => 'نص الاختيار مطلوب.',
            'questions.*.correct_choice.required' => 'يجب تحديد الخيار الصحيح لكل سؤال.',
            'end_time.after_or_equal' => 'وقت الانتهاء يجب أن يكون بعد أو يساوي وقت البدء.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Database Transaction
        // We use a transaction to ensure that if any part of the save process fails,
        // all changes are rolled back.
        DB::transaction(function () use ($request) {
            // Create the main Exam record
            $exam = exams::create([
                'title' => $request->input('exam_title'),
               
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                // Using researcher_id as per the new schema
                'researcher_id' => 1, // Use the authenticated user's ID
                'lesson_id' => $request->input('lessons_id'),
            ]);

            // Loop through the questions submitted
            foreach ($request->input('questions') as $questionData) {
                // Create a new Question record linked to the Exam
                $question = $exam->questions()->create([
                    // Using question_text as per the new schema
                    'question_text' => $questionData['text'], 
                ]);

                // Loop through the choices for the current question
                foreach ($questionData['choices'] as $choiceIndex => $choiceData) {
                    // Create a new Choice record linked to the Question
                    $question->choices()->create([
                        // Using choice_text as per the new schema
                        'choice_text' => $choiceData['text'], 
                        'is_correct' => ($choiceIndex == $questionData['correct_choice']), // Check if this is the correct choice
                    ]);
                }
            }
        });

        // Redirect back with a success message
        return redirect()->route('exam.index')->with('success', 'تم إنشاء الاختبار بنجاح!');
    }
    /**
     * Display the specified resource.
     */
    public function show(exams $exam)
{
    // Eagerly load the questions and their choices
    $exam->load('questions.choices');

    // Pass the exam to the view
    return view('researchers-dashboard.exam.show', compact('exam'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(exams $exam)
    {
        try {
            // Eager load all necessary relationships
            $exam->load([
                'questions.choices',
                'lesson',
                'lesson.subject'
            ]);
    
            // Get lessons for the dropdown with subject information
            $lessons = lessonss::with('subject')
                ->orderBy('title')
                ->get();
    
            // Define Arabic choice letters for the view
            $choiceLetters = ['أ', 'ب', 'ج', 'د', 'هـ', 'و', 'ز', 'ح'];
    
            // Prepare additional data if needed
            $examStats = [
                'total_questions' => $exam->questions->count(),
                'total_choices' => $exam->questions->sum(function($question) {
                    return $question->choices->count();
                }),
                'has_questions' => $exam->questions->isNotEmpty(),
            ];
    
            return view('researchers-dashboard.exam.edit', compact(
                'exam', 
                'lessons', 
                'choiceLetters',
                'examStats'
            ));
    
        } catch (\Exception $e) {
            // Log the error and redirect back with message
            
            
            
            return redirect()->route('exam.index')
                ->with('error', 'حدث خطأ أثناء تحميل صفحة التعديل. يرجى المحاولة مرة أخرى.');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, exams $exam)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'lesson_id' => 'required|exists:lessonss,id',
                'start_time' => 'nullable|date',
                'end_time' => 'nullable|date|after:start_time',
                'questions' => 'required|array|min:1',
                'questions.*.text' => 'required|string|max:1000',
                'questions.*.choices' => 'required|array|min:2|max:8',
                'questions.*.choices.*.text' => 'required|string|max:255',
                'questions.*.correct_choice' => 'required|integer|min:0',
            ], [
                'questions.required' => 'يجب إضافة سؤال واحد على الأقل',
                'questions.*.text.required' => 'نص السؤال مطلوب',
                'questions.*.choices.min' => 'يجب إضافة خيارين على الأقل لكل سؤال',
                'questions.*.correct_choice.required' => 'يجب تحديد الإجابة الصحيحة',
                'end_time.after' => 'وقت الانتهاء يجب أن يكون بعد وقت البدء',
            ]);
     
            DB::transaction(function () use ($validatedData, $exam) {
                // Update exam details
                $exam->update([
                    'title' => $validatedData['title'],
                    'lesson_id' => $validatedData['lesson_id'],
                    'start_time' => $validatedData['start_time'],
                    'end_time' => $validatedData['end_time'],
                ]);
    
                // Handle questions and choices
                $questions_to_keep_ids = [];
    
                foreach ($validatedData['questions'] as $questionIndex => $questionData) {
                    // Validate that correct_choice is within choices range
                    if ($questionData['correct_choice'] >= count($questionData['choices'])) {
                        throw new \Exception("الإجابة الصحيحة غير صالحة للسؤال " . ($questionIndex + 1));
                    }
    
                    // Update existing or create a new question
                    $question = questions::updateOrCreate(
                        ['id' => $questionData['id'] ?? null],
                        [
                            'exam_id' => $exam->id,
                            'question_text' => $questionData['text'],
                            'type' => 'multiple_choice',
                            'order' => $questionIndex, // Maintain question order
                        ]
                    );
                    
                    $questions_to_keep_ids[] = $question->id;
    
                    $choices_to_keep_ids = [];
                    foreach ($questionData['choices'] as $choiceIndex => $choiceData) {
                        $isCorrect = (int) $questionData['correct_choice'] === (int) $choiceIndex;
    
                        // Update existing or create a new choice
                        $choice = choices::updateOrCreate(
                            ['id' => $choiceData['id'] ?? null],
                            [
                                'question_id' => $question->id,
                                'choice_text' => $choiceData['text'],
                                'is_correct' => $isCorrect,
                                'order' => $choiceIndex, // Maintain choice order
                            ]
                        );
    
                        $choices_to_keep_ids[] = $choice->id;
                    }
    
                    // Delete choices that were removed
                    $question->choices()->whereNotIn('id', $choices_to_keep_ids)->delete();
                }
    
                // Delete questions that were removed
                $exam->questions()->whereNotIn('id', $questions_to_keep_ids)->delete();
            });
    
            return redirect()->route('exam.show', $exam->id)
                ->with('success', 'تم تحديث الاختبار بنجاح!');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // Re-throw validation exceptions
        } catch (\Exception $e) {

            
            return back()
                ->with('error', 'حدث خطأ أثناء تحديث الاختبار: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(exams $exam)
    {
        $exam->delete();

        return redirect()->route('exam.index')->with('success', 'تم حذف الدرس بنجاح.');
    }
}
