<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Page',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'landing';

        return view('landing', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
