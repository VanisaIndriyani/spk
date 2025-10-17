<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProsesController extends Controller
{
    public function index()
    {
        return view('roles.admin.proses.index');
    }

    public function run()
    {
        // Ambil semua kriteria, bobot dan jenis
        $kriteria = DB::table('kriteria')->orderBy('kode')->get();
        if ($kriteria->count() < 6) {
            return back()->with('error','Bobot kriteria belum lengkap.');
        }

        // Ambil nilai crisp per alternatif per kriteria
        $nilai = DB::table('nilai_kriteria')
            ->select('alternatif_id','kode_kriteria','nilai_crisp','nilai_fuzzy')
            ->get();
        if ($nilai->isEmpty()) {
            return back()->with('error','Belum ada nilai kriteria.');
        }

        // Kelompokkan per kriteria dan per alternatif
        $perKriteria = [];
        $perAlternatif = [];
        foreach ($nilai as $n) {
            $perKriteria[$n->kode_kriteria][] = $n->nilai_crisp;
            $perAlternatif[$n->alternatif_id][$n->kode_kriteria] = [
                'crisp' => $n->nilai_crisp,
                'fuzzy' => $n->nilai_fuzzy
            ];
        }

        // Pastikan setiap alternatif memiliki 6 kriteria
        $alternatifLengkap = array_filter($perAlternatif, fn($arr) => count($arr) === 6);
        if (empty($alternatifLengkap)) {
            return back()->with('error','Data alternatif belum lengkap 6 kriteria.');
        }

        // Hitung max/min untuk normalisasi
        $normBase = [];
        foreach ($kriteria as $k) {
            $kode = $k->kode;
            $jenis = $k->jenis; // benefit/cost
            $values = $perKriteria[$kode] ?? [];
            if (empty($values)) continue;
            $normBase[$kode] = [
                'jenis' => $jenis,
                'max' => max($values),
                'min' => min($values),
                'bobot' => (float)$k->bobot,
            ];
        }

        // Bersihkan hasil sebelumnya
        DB::table('hasil_perangkingan')->truncate();

        // Hitung skor akhir per alternatif menggunakan Fuzzy-SAW
        $skors = [];
        foreach ($alternatifLengkap as $altId => $vals) {
            $total = 0.0;
            foreach ($vals as $kode => $data) {
                $base = $normBase[$kode] ?? null;
                if (!$base) continue;
                
                $crisp = $data['crisp'];
                $fuzzy = $data['fuzzy'];
                
                // Normalisasi nilai
                if ($base['jenis'] === 'benefit') {
                    $norm = $crisp / ($base['max'] ?: 1);
                } else { // cost
                    $norm = ($base['min'] ?: 1) / $crisp;
                }
                
                // Jika ada nilai fuzzy, gunakan untuk perhitungan
                if ($fuzzy !== null) {
                    // Gunakan nilai fuzzy untuk perhitungan
                    $fuzzyNorm = $fuzzy; // Nilai fuzzy sudah dalam range 0-1
                    $total += $fuzzyNorm * $base['bobot'];
                } else {
                    // Gunakan nilai normalisasi biasa
                    $total += $norm * $base['bobot'];
                }
                
                // Simpan nilai normalisasi & bobot
                DB::table('nilai_kriteria')
                    ->where('alternatif_id',$altId)
                    ->where('kode_kriteria',$kode)
                    ->update([
                        'nilai_normalisasi' => $norm,
                        'nilai_bobot' => $total,
                        'updated_at' => now(),
                    ]);
            }
            $skors[$altId] = $total;
        }

        // Urutkan dan simpan ranking
        arsort($skors); // highest first
        $rank = 1;
        foreach ($skors as $altId => $skor) {
            DB::table('hasil_perangkingan')->insert([
                'alternatif_id' => $altId,
                'skor_akhir' => $skor,
                'peringkat' => $rank++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.hasil');
    }
}


