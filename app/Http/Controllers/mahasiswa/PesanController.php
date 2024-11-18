<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Inbox Page',
            'list' => ['Home', 'Inbox']
        ];

        $activeMenu = 'index';

        return view('mahasiswa.inbox.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
