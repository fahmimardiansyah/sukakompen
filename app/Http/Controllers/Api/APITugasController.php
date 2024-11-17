<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasModel;

class APITugasController extends Controller
{
    public function index()
    {
        $data = TugasModel::all();
        return $data;
    }
}
