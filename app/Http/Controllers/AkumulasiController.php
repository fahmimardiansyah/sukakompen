<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkumulasiController extends Controller
{
    public function index()
    {

        return view('akumulasi.index');
    }
}
