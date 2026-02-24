<?php

namespace App\Http\Controllers;

use App\Models\content_blocks;
use App\Models\Lessonss;
use App\Models\rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class rule_controller extends Controller
{
    public function create()
    {
       $lessons = Lessonss::with('researcher.researcherProfile')
          ->where('researcher_id', 1)  // ✅ Direct filter on lessons table
          ->get();
        return view('researchers-dashboard.rules.create',compact('lessons'));
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
              $q->where('researcher_id', 1);
          });
        // Apply filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        
        if ($request->filled('lesson_id')) {
            $query->where('lessons_id', $request->lesson_id);
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
        $lessons = Lessonss::orderBy('title')->where('researcher_id', 1)  // ✅ Direct filter on lessons table
          ->get(); 
        return view('researchers-dashboard.rules.update', compact('rule', 'lessons'));
    }







    public function edit(Request $request,rules $rule){
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
          
            'lessons_id' => 'required|exists:lessonss,id',
        ]);
    
        
            // 2. Update the lesson with the validated data
            $rule->update([
                'title'       => $validatedData['title'],
               
                'lessons_id'     => $validatedData['lessons_id'],
            ]);
    
            // 3. Redirect back with a success message
            return redirect()->route('rules.index')->with('success', 'تم تحديث القاعدة بنجاح!');
            // Replace 'lessons.index' with the appropriate route for your lessons list.
    
       
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث الدرس. الرجاء المحاولة مرة أخرى.');
       
    }
     public function content_block_show(Rules $rule)
{
    // Load the rule with its content blocks ordered by block_order
    $rule->load(['content_blocks' => function($query) {
        $query->orderBy('block_order', 'asc');
    } ,'lesson','lesson.researcher.researcherProfile']);
    
  

    // Get statistics
    $totalBlocks = $rule->content_blocks->count();
    $textCount = $rule->content_blocks->where('type', 'text')->count();
    $mathCount = $rule->content_blocks->where('type', 'math')->count();
    $imageCount = $rule->content_blocks->where('type', 'image')->count();
    $videoCount = $rule->content_blocks->where('type', 'video')->count();
    $exerciseCount = $rule->content_blocks->where('type', 'exercise')->count();
    
    return view('researchers-dashboard.rules.rule_Content_Blocks', compact(
        'rule', 
        'totalBlocks', 
        'textCount', 
        'mathCount', 
        'imageCount', 
        'videoCount', 
        'exerciseCount'
    ));
}
    public function create_rule_content(Rules $rule)
    {
        // Get the next available order number
        $nextOrder = $rule->content_blocks()->max('block_order') + 1;
        
        return view('researchers-dashboard.rules.Content_Blocks_Create', compact('rule', 'nextOrder'));
    }

    /**
     * Store a newly created content block in storage.
     */
    public function store_rule_content(Request $request, Rules $rule)
    {
        // Validate based on content type
        $rules = [
            'type' => 'required|in:text,math,image,video,exercise',
            'block_order' => 'nullable|integer|min:0',
        ];

        // Add type-specific validation
        switch ($request->type) {
            case 'text':
                $rules['content'] = 'required|string|max:10000';
                break;
                
            case 'math':
                $rules['content'] = 'required|string|max:5000';
                break;
                
            case 'image':
                $rules['content'] = 'required|image|mimes:jpeg,png,jpg,gif|max:10240'; // 10MB max
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
            'content.image' => 'يجب أن يكون الملف صورة',
            'content.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif',
            'content.max' => 'حجم الصورة يجب أن لا يتجاوز 10MB',
            'content.url' => 'الرجاء إدخال رابط صحيح',
            'type.in' => 'نوع المحتوى غير صحيح',
        ]);

        try {
            // Handle image upload
            if ($request->type === 'image' && $request->hasFile('content')) {
                $path = $request->file('content')->store('content-images', 'public');
                $content = $path;
                
                // Store image metadata
                $metadata = json_encode(['alt' => $request->image_alt]);
            } else {
                $content = $request->content;
                $metadata = null;
            }

            // Set block order
            $blockOrder = $request->block_order ?? ($rule->contentBlocks()->max('block_order') + 1);

            // Create the content block
            $contentBlock = new content_blocks();
            $contentBlock->rule_id = $rule->id;
            $contentBlock->type = $request->type;
            $contentBlock->content = $content;
            $contentBlock->block_order = $blockOrder;
           
            $contentBlock->save();

            // If order is specified, shift other blocks
            if ($request->block_order !== null) {
                $this->shiftBlockOrders($rule, $contentBlock->id, $blockOrder);
            }

            return redirect()
                ->route('content_block.show', $rule)
                ->with('success', 'تم إضافة المحتوى بنجاح');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة المحتوى: ' . $e->getMessage());
        }
    }

    /**
     * Shift block orders when inserting at a specific position
     */
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
        
        // Ensure the content block belongs to the rule

    // Verify the content block belongs to this rule
    if ($contentBlock->rule_id !== $rule->id) {
        abort(404, 'المحتوى غير موجود لهذه القاعدة');
    }
    
  
        
        return view('researchers-dashboard.rules.Content_Blocks_edit', compact('rule', 'contentBlock'));
    }

    /**
     * Update the specified content block in storage.
     */
    public function content_blocks_update(Request $request, rules $rule, content_blocks $contentBlock)
    {
        // Ensure the content block belongs to the rule
        if ($contentBlock->rule_id !== $rule->id) {
            abort(404, 'المحتوى غير موجود لهذه القاعدة');
        }

        // Validate based on content type
        $rules = [
            'type' => 'required|in:text,math,image,video,exercise',
            'block_order' => 'nullable|integer|min:0',
        ];

        // Add type-specific validation
        switch ($request->type) {
            case 'text':
                $rules['content'] = 'required|string|max:10000';
                break;
                
            case 'math':
                $rules['content'] = 'required|string|max:5000';
                break;
                
            case 'image':
                if ($request->hasFile('content')) {
                    $rules['content'] = 'required|image|mimes:jpeg,png,jpg,gif|max:10240'; // 10MB max
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
            'content.string' => 'المحتوى يجب أن يكون نصاً',
            'content.image' => 'يجب أن يكون الملف صورة',
            'content.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif',
            'content.max' => 'حجم الصورة يجب أن لا يتجاوز 10MB',
            'content.url' => 'الرجاء إدخال رابط صحيح',
            'type.in' => 'نوع المحتوى غير صحيح',
            'block_order.integer' => 'رقم الترتيب يجب أن يكون رقماً صحيحاً',
        ]);

        try {
            // Store old order for reordering
            $oldOrder = $contentBlock->block_order;
            $newOrder = $request->block_order ?? $oldOrder;

            // Handle image upload
            if ($request->type === 'image') {
                if ($request->hasFile('content')) {
                    // Delete old image
                    if ($contentBlock->content) {
                        Storage::disk('public')->delete($contentBlock->content);
                    }
                    
                    // Upload new image
                    $path = $request->file('content')->store('content-images', 'public');
                    $content = $path;
                } else {
                    // Keep existing image
                    $content = $contentBlock->content;
                }
                
                // Prepare metadata
                $metadata = json_encode(['alt' => $request->image_alt]);
            } else {
                $content = $request->content;
                $metadata = $contentBlock->metadata; // Keep existing metadata
            }

            // Update the content block
            $contentBlock->update([
                'type' => $request->type,
                'content' => $content,
                'block_order' => $newOrder,
                
            ]);

            // Reorder if order changed
            if ($oldOrder != $newOrder) {
                $this->reorderBlocks($rule, $contentBlock->id, $newOrder, $oldOrder);
            }

            return redirect()
                ->route('content_block.show', $rule)
                ->with('success', 'تم تحديث المحتوى بنجاح');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث المحتوى: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified content block from storage.
     */
   
    /**
     * Reorder blocks when order changes
     */
    private function reorderBlocks(rules $rule, $updatedBlockId, $newOrder, $oldOrder)
    {
        if ($newOrder > $oldOrder) {
            // Moving down - shift blocks between old+1 and new up by 1
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
            // Moving up - shift blocks between new and old-1 down by 1
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
        // Ensure the content block belongs to the rule
        if ($contentBlock->rule_id !== $rule->id) {
            abort(404, 'المحتوى غير موجود لهذه القاعدة');
        }

        try {
            // Store the order of the deleted block
            $deletedOrder = $contentBlock->block_order;

            // Delete image file if it's an image type
            if ($contentBlock->type === 'image' && $contentBlock->content) {
                Storage::disk('public')->delete($contentBlock->content);
            }

            // Delete the content block
            $contentBlock->delete();

            // Reorder remaining blocks (shift all blocks with higher order down by 1)
            $rule->contentBlocks()
                ->where('block_order', '>', $deletedOrder)
                ->decrement('block_order');

            return redirect()
                ->route('rules.content.index', $rule)
                ->with('success', 'تم حذف المحتوى بنجاح');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'حدث خطأ أثناء حذف المحتوى: ' . $e->getMessage());
        }
    }

    /**
     * Reorder blocks after deletion
     */
   
}
