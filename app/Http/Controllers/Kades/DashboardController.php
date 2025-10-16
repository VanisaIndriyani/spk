<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $count = DB::table('hasil_perangkingan')->count();
        return view('roles.kepala_desa.dashboard', compact('count'));
    }
}


