<?php

namespace App\Http\Controllers;

use App\Models\content_blocks;
use App\Models\Lessonss;
use App\Models\rules;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class rule_controller extends Controller
{
    public function create()
    {
        $user = Auth::user()->id;
        $lessons = Lessonss::with('researcher.researcherProfile')
            ->where('researcher_id', $user)
            ->get();
        return view('researchers-dashboard.rules.create', compact('lessons'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'lessons_id' => 'required|numeric',
        ]);
        rules::create($data);
        return redirect()->route('rules.index')->with('success', 'rules created successfully!');
    }

    public function index(Request $request)
    {
        $query = rules::with(['lesson', 'lesson.researcher.researcherProfile'])
            ->whereHas('lesson', function($q) {
                $q->where('researcher_id', Auth::id()); // ✅ كان 1 ثابت
            });

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('lesson_id')) {
            $query->where('lessons_id', $request->lesson_id);
        }

        $rules = $query->latest()->paginate(10)->withQueryString();
        $totalRulesCount = rules::count();
        $lessons = Lessonss::all();

        return view('researchers-dashboard.rules.index', compact('rules', 'lessons'));
    }

    public function destroy(rules $rule){
        // ✅ تحقق أن القاعدة تخص الباحث الحالي
        if ($rule->lesson->researcher_id !== Auth::id()) {
            abort(403);
        }
        $rule->delete();
        return redirect()->route('rules.index')->with('success', 'rules deleted successfully!');
    }

    public function update(rules $rule){
        // ✅ تحقق أن القاعدة تخص الباحث الحالي
        if ($rule->lesson->researcher_id !== Auth::id()) {
            abort(403);
        }
        $lessons = Lessonss::orderBy('title')
            ->where('researcher_id', Auth::id()) // ✅ كان 1 ثابت
            ->get();
        return view('researchers-dashboard.rules.update', compact('rule', 'lessons'));
    }

    public function edit(Request $request, rules $rule){
        // ✅ تحقق أن القاعدة تخص الباحث الحالي
        if ($rule->lesson->researcher_id !== Auth::id()) {
            abort(403);
        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'lessons_id' => 'required|exists:lessonss,id',
        ]);

        $rule->update([
            'title'      => $validatedData['title'],
            'lessons_id' => $validatedData['lessons_id'],
        ]);

        return redirect()->route('rules.index')->with('success', 'تم تحديث القاعدة بنجاح!');

        return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث الدرس. الرجاء المحاولة مرة أخرى.');
    }
public function content_block_show(Rules $rule)
{
    // ✅ تحقق أن القاعدة تخص الباحث الحالي
    if ($rule->lesson->researcher_id !== Auth::id()) {
        abort(403);
    }
    
    $rule->load([
        'content_blocks' => function($query) {
            $query->orderBy('block_order', 'asc');
        }, 
        'lesson', 
        'lesson.researcher.researcherProfile', 
        'content_blocks.video',
        'content_blocks.exerciseSolution' // Load the exercise solution relationship
    ]);

    $totalBlocks   = $rule->content_blocks->count();
    $textCount     = $rule->content_blocks->where('type', 'text')->count();
    $mathCount     = $rule->content_blocks->where('type', 'math')->count();
    $imageCount    = $rule->content_blocks->where('type', 'image')->count();
    $exerciseCount = $rule->content_blocks->where('type', 'exercise')->count();

    return view('researchers-dashboard.rules.rule_Content_Blocks', compact(
        'rule',
        'totalBlocks',
        'textCount',
        'mathCount',
        'imageCount',
        'exerciseCount'
    ));
}

    public function create_rule_content(Rules $rule)
    {
        // ✅ تحقق أن القاعدة تخص الباحث الحالي
        if ($rule->lesson->researcher_id !== Auth::id()) {
            abort(403);
        }
        $nextOrder = $rule->content_blocks()->max('block_order') + 1;
        return view('researchers-dashboard.rules.Content_Blocks_Create', compact('rule', 'nextOrder'));
    }

    public function store_rule_content(Request $request, Rules $rule)
{
    // ✅ تحقق أن القاعدة تخص الباحث الحالي
    if ($rule->lesson->researcher_id !== Auth::id()) {
        abort(403);
    }
    
    $rules = [
        'type' => 'required|in:text,math,image,video,exercise',
        'block_order' => 'nullable|integer|min:0',
    ];

    switch ($request->type) {
        case 'text':
            $rules['content'] = 'required|string|max:10000';
            break;
        case 'math':
            $rules['content'] = 'required|string|max:5000';
            break;
        case 'image':
            $rules['content'] = 'required|image|mimes:jpeg,png,jpg,gif|max:10240';
            $rules['image_alt'] = 'nullable|string|max:255';
            break;
        case 'video':
            $rules['content'] = 'required|url|max:500';
            break;
        case 'exercise':
            $rules['content'] = 'required|string|max:10000';
            $rules['solution_text'] = 'required|string|max:20000'; // الحل التفصيلي
            $rules['hint'] = 'nullable|string|max:5000'; // التلميح (اختياري)
            break;
    }

    $validated = $request->validate($rules, [
        'content.required' => 'حقل المحتوى مطلوب',
        'content.image'    => 'يجب أن يكون الملف صورة',
        'content.mimes'    => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif',
        'content.max'      => 'حجم الصورة يجب أن لا يتجاوز 10MB',
        'content.url'      => 'الرجاء إدخال رابط صحيح',
        'type.in'          => 'نوع المحتوى غير صحيح',
        'solution_text.required' => 'حقل حل التمرين مطلوب',
        'solution_text.max' => 'حل التمرين يجب أن لا يتجاوز 20000 حرف',
        'hint.max' => 'التلميح يجب أن لا يتجاوز 5000 حرف',
    ]);

    try {
        DB::beginTransaction(); // بدء المعاملة لضمان سلامة البيانات
        
        if ($request->type === 'image' && $request->hasFile('content')) {
            $path = $request->file('content')->store('content-images', 'public');
            $content = $path;
            $metadata = json_encode(['alt' => $request->image_alt]);
        } else {
            $content = $request->content;
            $metadata = null;
        }

        $blockOrder = $request->block_order ?? ($rule->contentBlocks()->max('block_order') + 1);

        // إنشاء محتوى البلوك
        $contentBlock = new content_blocks();
        $contentBlock->rule_id     = $rule->id;
        $contentBlock->type        = $request->type;
        $contentBlock->content     = $content;
        $contentBlock->block_order = $blockOrder;
        $contentBlock->save();

        // إذا كان النوع تمرين، قم بإنشاء سجل في جدول exercise_solutions
        if ($request->type === 'exercise') {
            $exerciseSolution = new \App\Models\exercise_solution(); // استخدم الـ Model الصحيح
            $exerciseSolution->content_block_id = $contentBlock->id;
            $exerciseSolution->solution_text = $request->solution_text;
            $exerciseSolution->hint = $request->hint;
            $exerciseSolution->save();
        }

        if ($request->block_order !== null) {
            $this->shiftBlockOrders($rule, $contentBlock->id, $blockOrder);
        }

        DB::commit(); // تأكيد المعاملة

        return redirect()
            ->route('content_block.show', $rule)
            ->with('success', 'تم إضافة المحتوى بنجاح');

    } catch (\Exception $e) {
        DB::rollBack(); // التراجع عن المعاملة في حالة الخطأ
        
        return back()->withInput()->with('error', 'حدث خطأ أثناء إضافة المحتوى: ' . $e->getMessage());
    }
}
    private function shiftBlockOrders(rules $rule, $newBlockId, $newOrder)
    {
        $blocks = $rule->content_blocks()
            ->where('id', '!=', $newBlockId)
            ->where('block_order', '>=', $newOrder)
            ->orderBy('block_order', 'asc')
            ->get();

        foreach ($blocks as $index => $block) {
            $block->block_order = $newOrder + $index + 1;
            $block->save();
        }
    }

    public function content_blocks_edit(rules $rule, content_blocks $contentBlock)
    {
        // ✅ تحقق أن القاعدة تخص الباحث الحالي
        if ($rule->lesson->researcher_id !== Auth::id()) {
            abort(403);
        }
        if ($contentBlock->rule_id !== $rule->id) {
            abort(404, 'المحتوى غير موجود لهذه القاعدة');
        }
        return view('researchers-dashboard.rules.Content_Blocks_edit', compact('rule', 'contentBlock'));
    }

    public function content_blocks_update(Request $request, rules $rule, content_blocks $contentBlock)
    {
        // ✅ تحقق أن القاعدة تخص الباحث الحالي
        if ($rule->lesson->researcher_id !== Auth::id()) {
            abort(403);
        }
        if ($contentBlock->rule_id !== $rule->id) {
            abort(404, 'المحتوى غير موجود لهذه القاعدة');
        }

        $rules = [
            'type' => 'required|in:text,math,image,video,exercise',
            'block_order' => 'nullable|integer|min:0',
        ];

        switch ($request->type) {
            case 'text':
                $rules['content'] = 'required|string|max:10000';
                break;
            case 'math':
                $rules['content'] = 'required|string|max:5000';
                break;
            case 'image':
                if ($request->hasFile('content')) {
                    $rules['content'] = 'required|image|mimes:jpeg,png,jpg,gif|max:10240';
                }
                $rules['image_alt'] = 'nullable|string|max:255';
                break;
            case 'video':
                $rules['content'] = 'required|url|max:500';
                break;
            case 'exercise':
                $rules['content'] = 'required|string|max:10000';
                break;
        }

        $validated = $request->validate($rules, [
            'content.required' => 'حقل المحتوى مطلوب',
            'content.string'   => 'المحتوى يجب أن يكون نصاً',
            'content.image'    => 'يجب أن يكون الملف صورة',
            'content.mimes'    => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif',
            'content.max'      => 'حجم الصورة يجب أن لا يتجاوز 10MB',
            'content.url'      => 'الرجاء إدخال رابط صحيح',
            'type.in'          => 'نوع المحتوى غير صحيح',
            'block_order.integer' => 'رقم الترتيب يجب أن يكون رقماً صحيحاً',
        ]);

        try {
            $oldOrder = $contentBlock->block_order;
            $newOrder = $request->block_order ?? $oldOrder;

            if ($request->type === 'image') {
                if ($request->hasFile('content')) {
                    if ($contentBlock->content) {
                        Storage::disk('public')->delete($contentBlock->content);
                    }
                    $path = $request->file('content')->store('content-images', 'public');
                    $content = $path;
                } else {
                    $content = $contentBlock->content;
                }
                $metadata = json_encode(['alt' => $request->image_alt]);
            } else {
                $content  = $request->content;
                $metadata = $contentBlock->metadata;
            }

            $contentBlock->update([
                'type'        => $request->type,
                'content'     => $content,
                'block_order' => $newOrder,
            ]);

            if ($oldOrder != $newOrder) {
                $this->reorderBlocks($rule, $contentBlock->id, $newOrder, $oldOrder);
            }

            return redirect()
                ->route('content_block.show', $rule)
                ->with('success', 'تم تحديث المحتوى بنجاح');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ أثناء تحديث المحتوى: ' . $e->getMessage());
        }
    }

    private function reorderBlocks(rules $rule, $updatedBlockId, $newOrder, $oldOrder)
    {
        if ($newOrder > $oldOrder) {
            $blocks = $rule->contentBlocks()
                ->where('id', '!=', $updatedBlockId)
                ->whereBetween('block_order', [$oldOrder + 1, $newOrder])
                ->orderBy('block_order', 'asc')
                ->get();

            foreach ($blocks as $block) {
                $block->block_order = $block->block_order - 1;
                $block->save();
            }
        } else {
            $blocks = $rule->contentBlocks()
                ->where('id', '!=', $updatedBlockId)
                ->whereBetween('block_order', [$newOrder, $oldOrder - 1])
                ->orderBy('block_order', 'asc')
                ->get();

            foreach ($blocks as $block) {
                $block->block_order = $block->block_order + 1;
                $block->save();
            }
        }
    }

    public function content_blocks_destroy(rules $rule, content_blocks $contentBlock)
    {
        // ✅ تحقق أن القاعدة تخص الباحث الحالي
        if ($rule->lesson->researcher_id !== Auth::id()) {
            abort(403);
        }
        if ($contentBlock->rule_id !== $rule->id) {
            abort(404, 'المحتوى غير موجود لهذه القاعدة');
        }

        try {
            $deletedOrder = $contentBlock->block_order;

            if ($contentBlock->type === 'image' && $contentBlock->content) {
                Storage::disk('public')->delete($contentBlock->content);
            }

            $contentBlock->delete();

            $rule->contentBlocks()
                ->where('block_order', '>', $deletedOrder)
                ->decrement('block_order');

            return redirect()
                ->route('rules.content.index', $rule)
                ->with('success', 'تم حذف المحتوى بنجاح');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء حذف المحتوى: ' . $e->getMessage());
        }
    }
}