<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InboxController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Inbox Page',
            'list' => ['Home', 'Inbox']
        ];

        $activeMenu = 'index';

        return view('inbox.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
