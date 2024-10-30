<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifController extends Controller
{
    public function index()
    {

        return view('notif.index');
    }
}
