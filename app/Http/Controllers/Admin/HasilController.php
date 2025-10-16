<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function index()
    {
        $rows = DB::table('hasil_perangkingan')
            ->join('alternatif','hasil_perangkingan.alternatif_id','=','alternatif.id')
            ->select('alternatif.nama_kepala_keluarga','alternatif.no_kk','hasil_perangkingan.skor_akhir','hasil_perangkingan.peringkat')
            ->orderBy('peringkat')
            ->get();
        return view('roles.admin.hasil.index', compact('rows'));
    }

    public function pdf()
    {
        $rows = DB::table('hasil_perangkingan')
            ->join('alternatif','hasil_perangkingan.alternatif_id','=','alternatif.id')
            ->select('alternatif.nama_kepala_keluarga','alternatif.no_kk','hasil_perangkingan.skor_akhir','hasil_perangkingan.peringkat')
            ->orderBy('peringkat')
            ->get();
        $pdf = Pdf::loadView('roles.admin.hasil.pdf', compact('rows'));
        return $pdf->download('hasil-perangkingan.pdf');
    }
}


