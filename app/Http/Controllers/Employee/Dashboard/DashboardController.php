<?php

namespace App\Http\Controllers\Employee\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('employee');
    }

    public function index()
    {
        return view('employee.dashboard.index');
    }
}
