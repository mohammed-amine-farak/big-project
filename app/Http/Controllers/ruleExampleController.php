<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rules;
use App\Models\rule_examples;
use Illuminate\Support\Facades\Storage;
class ruleExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(rules $rule)
    {
        $rule->load('examples');
           
        // Pass the rule (now with its examples) to the view.
       
        return view('researchers-dashboard.rules_example.index',compact('rule'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(rules $rule) // <<< This method does NOT expect a Rule object
    {
        return view('researchers-dashboard.rules_example.create',compact('rule'));
    }



    public function destroy(rules $rule, rule_examples $example)
    {
        if ($example->rule_id !== $rule->id) {
            return redirect()->back()->with('error', 'خطأ: المثال لا ينتمي إلى القاعدة المحددة.');
        }
    
        $example->delete();
        return redirect()->route('Example.index',$rule->id)->with('success', 'rules example deleted successfully!');
    }


    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,rules $rule)
    {      
        $validatedData = $request->validate([
            'example_title' => 'required|string|max:255',
            'example_text' => 'required|string',
            'example_description' => 'nullable|string|max:1000',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
            'image_alt_ar' => 'nullable|string|max:255',
            'image_caption_ar' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('rule_examples_images', 'public');
            $validatedData['image_url'] = $imagePath;
        }

        $rule->examples()->create($validatedData);

        return redirect()->route('Example.index', $rule->id)->with('success', 'تم إضافة المثال بنجاح!');
   
        
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rule_examples $example,rules $rule)
    {
        return view('researchers-dashboard.rules_example.update', compact('rule', 'example'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }



    /**
     * Update the specified resource in storage.lcs
     */
    public function update(Request $request, rule_examples $example, rules $rule)
    {
        // 1. Parameter order check: The order of parameters in the method signature
        //    (Rule $rule, RuleExample $example) must match the order in your route URI
        //    (/rules/{rule}/examples/{example}).
        //    Also, the class names should be PascalCase (Rule, RuleExample).

        // 2. Add the crucial security check: This ensures the example being updated
        //    actually belongs to the rule specified in the URL.
        if ($example->rule_id !== $rule->id) {
            abort(404, 'The example does not belong to the specified rule.');
        }

        // 3. Validate the incoming request data
        $validatedData = $request->validate([
            'example_title' => 'required|string|max:255',
            'example_text' => 'required|string',
            'example_description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB max
            'image_alt_ar' => 'nullable|string|max:255',
            'image_caption_ar' => 'nullable|string|max:255',
        ]);

        // 4. Handle image upload and update the model's image_url property.
        //    It's important to update the image_url on the model separately from other fields.
        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            if ($example->image_url) {
                Storage::delete($example->image_url);
            }

            // Store the new image and get its path
            $imagePath = $request->file('image_url')->store('public/images');
            $example->image_url = $imagePath;
        }

        // 5. Update the other attributes on the model instance.
        //    You can't use $validatedData['image_url'] here because it's a file object,
        //    not the path. So, we update the image_url above and then update the rest here.
        $example->example_title = $validatedData['example_title'];
        $example->example_text = $validatedData['example_text'];
        $example->example_description = $validatedData['example_description'];
        $example->image_alt_ar = $validatedData['image_alt_ar'];
        $example->image_caption_ar = $validatedData['image_caption_ar'];

        // Save the changes to the database
        $example->save();

        // 6. Correct the redirect route: 'rules.show' is the standard way to return
        //    to the parent rule's detail page.
        return redirect()->route('Example.index',$rule->id)->with('success', 'تم تحديث المثال بنجاح!');
    }
    /**
     * Remove the specified resource from storage.
     */
   
}
