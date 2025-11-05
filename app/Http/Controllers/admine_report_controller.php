<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admine_report;

use function Laravel\Prompts\select;

class admine_report_controller extends Controller
{
    public function index(Request $request){
        $query = admine_report::where('admine_reports.researcher_id', 10)
            ->join('researchers', 'admine_reports.researcher_id', '=', 'researchers.id')
            ->join('users as researcher_users', 'researchers.id', '=', 'researcher_users.id')
            ->join('admins', 'admine_reports.admin_id', '=', 'admins.id')
            ->join('users as admin_users', 'admins.id', '=', 'admin_users.id')
            ->select(
                'admine_reports.*',
                'researcher_users.name as researcher_name',
                'admin_users.name as admin_name'
            );
    
        // Apply filters
        if ($request->filled('title')) {
            $query->where('admine_reports.title', 'like', '%' . $request->title . '%');
        }
    
        if ($request->filled('admin_id')) {
            $query->where('admine_reports.admin_id', $request->admin_id);
        }
    
        if ($request->filled('report_type')) {
            $query->where('admine_reports.report_type', $request->report_type);
        }
    
        if ($request->filled('status')) {
            $query->where('admine_reports.status', $request->status);
        }
    
        if ($request->filled('priority')) {
            $query->where('admine_reports.priority', $request->priority);
        }
    
        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('admine_reports.created_at', '>=', $request->date_from);
        }
    
        if ($request->filled('date_to')) {
            $query->whereDate('admine_reports.created_at', '<=', $request->date_to);
        }
    
        // Deadline filters
        if ($request->filled('deadline_from')) {
            $query->whereDate('admine_reports.deadline', '>=', $request->deadline_from);
        }
    
        if ($request->filled('deadline_to')) {
            $query->whereDate('admine_reports.deadline', '<=', $request->deadline_to);
        }
    
        // Sort results
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'deadline', 'title', 'status', 'priority'];
        $allowedDirections = ['asc', 'desc'];
        
        if (in_array($sort, $allowedSorts) && in_array($direction, $allowedDirections)) {
            $query->orderBy('admine_reports.' . $sort, $direction);
        } else {
            $query->orderBy('admine_reports.created_at', 'desc');
        }
    
        // Use pagination instead of get()
        $reports = $query->paginate(10)->withQueryString();
    
        // Get admins for filter dropdown
        $admins = \App\Models\admin::with('user')
            ->join('users', 'admins.id', '=', 'users.id')
            ->select('admins.*', 'users.name')
            ->get();
    
        return view('researchers-dashboard.admin_report.index', compact('reports', 'admins'));
    }
    public function show($id){
        $adminReport = admine_report::where('admine_reports.id', $id)
        ->where('admine_reports.researcher_id', 10) // or remove this if you want any report
        ->join('researchers', 'admine_reports.researcher_id', '=', 'researchers.id')
        ->join('users as researcher_users', 'researchers.id', '=', 'researcher_users.id')
        ->join('admins', 'admine_reports.admin_id', '=', 'admins.id')
        ->join('users as admin_users', 'admins.id', '=', 'admin_users.id')
        ->select(
            'admine_reports.*',
            'researcher_users.name as researcher_name',
            'admin_users.name as admin_name'
        )
        ->firstOrFail();

        return view('researchers-dashboard\admin_report\show' 
        ,compact('adminReport')); 
    }
    public function updateResponse(Request $request, $id)
    {
        $researcherId = 10; // Replace with the actual authenticated researcher ID
        
        $adminReport = admine_report::where('id', $id)
            ->where('researcher_id', $researcherId)
            ->firstOrFail();

        $validated = $request->validate([
            'researcher_response' => 'required|string|min:10|max:2000',
        ], [
            'researcher_response.required' => 'حقل الرد مطلوب.',
            'researcher_response.min' => 'يجب أن يكون الرد至少 10 أحرف.',
        ]);

        $adminReport->update([
            'researcher_response' => $validated['researcher_response'],
            'status' => 'under_review', // Automatically set to under review when response is added
        ]);

        return redirect()->route('admine_report.show', $adminReport->id)
            ->with('success', 'تم إرسال الرد بنجاح وتغيير الحالة إلى قيد المراجعة');
    }
}
