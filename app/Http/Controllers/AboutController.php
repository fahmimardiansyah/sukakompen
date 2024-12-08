<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\progress;

class AboutController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'About Us',
            'list' => ['Home', 'About Us']
        ];

        $activeMenu = 'about';

        return view('about.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
