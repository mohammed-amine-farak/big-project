<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admine_report;

class admine_report_controller extends Controller
{
    public function index(){
        $query = admine_report::with(['researcher'])
        ->where('researcher_id', 10);
        dd($query);
        return view('researchers-dashboard\admin_report\index');
    }
}
