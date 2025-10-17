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

    public function alternatif()
    {
        $alternatif = DB::table('alternatif')
            ->leftJoin('nilai_kriteria', 'alternatif.id', '=', 'nilai_kriteria.alternatif_id')
            ->leftJoin('kriteria', 'nilai_kriteria.kode_kriteria', '=', 'kriteria.kode')
            ->select(
                'alternatif.id',
                'alternatif.nama_kepala_keluarga',
                'alternatif.no_kk',
                'nilai_kriteria.kode_kriteria',
                'kriteria.nama as nama_kriteria',
                'nilai_kriteria.nilai_linguistik',
                'nilai_kriteria.nilai_crisp',
                'nilai_kriteria.nilai_fuzzy'
            )
            ->orderBy('alternatif.nama_kepala_keluarga')
            ->orderBy('kriteria.kode')
            ->get()
            ->groupBy('id');
        
        return view('roles.kepala_desa.alternatif', compact('alternatif'));
    }
}


