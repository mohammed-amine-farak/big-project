<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReseacherDashboardController extends Controller
{
    public function index(){
        return view('researchers-dashboard\dashboard\index');
    }
}
