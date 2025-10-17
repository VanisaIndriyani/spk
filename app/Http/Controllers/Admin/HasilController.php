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
            ->select('alternatif.id as alternatif_id','alternatif.nama_kepala_keluarga','alternatif.no_kk','hasil_perangkingan.skor_akhir','hasil_perangkingan.peringkat')
            ->orderBy('peringkat')
            ->get();
        return view('roles.admin.hasil.index', compact('rows'));
    }

    public function show(string $alternatifId)
    {
        $alt = DB::table('alternatif')->where('id',$alternatifId)->first();
        abort_unless($alt, 404);

        $bobotByKode = DB::table('kriteria')->select('kode','jenis','bobot')->get()->keyBy('kode');

        $nilai = DB::table('nilai_kriteria')
            ->where('alternatif_id',$alternatifId)
            ->orderBy('kode_kriteria')
            ->get();

        // Hitung base max/min per kriteria untuk normalisasi
        $all = DB::table('nilai_kriteria')->select('alternatif_id','kode_kriteria','nilai_crisp')->get();
        $perKriteria = [];
        foreach ($all as $n) {
            $perKriteria[$n->kode_kriteria][] = $n->nilai_crisp;
        }

        $detail = [];
        $total = 0.0;
        foreach ($nilai as $row) {
            $kode = $row->kode_kriteria;
            $crisp = (float)$row->nilai_crisp;
            $base = $bobotByKode[$kode] ?? null;
            if (!$base) continue;
            $min = min($perKriteria[$kode] ?? [1]);
            $max = max($perKriteria[$kode] ?? [1]);
            $r = $base->jenis === 'benefit' ? ($crisp / ($max ?: 1)) : (($min ?: 1) / ($crisp ?: 1));
            $wjr = $r * (float)$base->bobot;
            $total += $wjr;
            $detail[] = [
                'kode' => $kode,
                'jenis' => $base->jenis,
                'bobot' => (float)$base->bobot,
                'ling' => $row->nilai_linguistik,
                'crisp' => $crisp,
                'r' => $r,
                'wjr' => $wjr,
            ];
        }

        return view('roles.admin.hasil.show', compact('alt','detail','total'));
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


