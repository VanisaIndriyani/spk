<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    public function index()
    {
        $defaults = [
            ['C1','Kondisi Rumah','cost',0.10],
            ['C2','Status Kepemilikan Rumah','cost',0.15],
            ['C3','Tidak Menerima PKH/dll','benefit',0.20],
            ['C4','Perempuan Kepala Keluarga','benefit',0.20],
            ['C5','Anggota Sakit/Difabel','benefit',0.25],
            ['C6','Jumlah Anggota Keluarga','benefit',0.10],
        ];
        foreach ($defaults as $d) {
            // Only insert missing defaults; do not overwrite existing bobot edits
            $exists = DB::table('kriteria')->where('kode', $d[0])->exists();
            if (!$exists) {
                DB::table('kriteria')->insert([
                    'kode' => $d[0],
                    'nama' => $d[1],
                    'jenis' => $d[2],
                    'bobot' => $d[3],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $rows = DB::table('kriteria')->orderBy('kode')->get();
        return view('roles.admin.kriteria.index', compact('rows'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:10|unique:kriteria,kode',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1'
        ]);

        DB::table('kriteria')->insert([
            ...$data,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, string $kode)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1'
        ]);

        DB::table('kriteria')->where('kode', $kode)->update([
            ...$data,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(string $kode)
    {
        // Check if kriteria is used in sub_kriteria
        $subKriteriaCount = DB::table('sub_kriteria')->where('kode_kriteria', $kode)->count();
        if ($subKriteriaCount > 0) {
            return back()->with('error', 'Kriteria tidak dapat dihapus karena masih digunakan dalam sub kriteria.');
        }

        // Check if kriteria is used in nilai_kriteria
        $nilaiKriteriaCount = DB::table('nilai_kriteria')->where('kode_kriteria', $kode)->count();
        if ($nilaiKriteriaCount > 0) {
            return back()->with('error', 'Kriteria tidak dapat dihapus karena masih digunakan dalam nilai kriteria.');
        }

        DB::table('kriteria')->where('kode', $kode)->delete();
        return back()->with('success', 'Kriteria berhasil dihapus.');
    }
}


