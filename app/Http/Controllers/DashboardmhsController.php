<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardmhsController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Page',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboardmhs';

        return view('dashboardmhs', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
