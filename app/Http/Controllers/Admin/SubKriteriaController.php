<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $kriteria = DB::table('kriteria')->orderBy('kode')->get();
        $subKriteria = DB::table('sub_kriteria')
            ->join('kriteria', 'sub_kriteria.kode_kriteria', '=', 'kriteria.kode')
            ->select('sub_kriteria.*', 'kriteria.nama as nama_kriteria')
            ->orderBy('kriteria.kode')
            ->orderBy('sub_kriteria.nilai')
            ->get();
        
        return view('roles.admin.sub_kriteria.index', compact('kriteria', 'subKriteria'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_kriteria' => 'required|string|max:10',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0',
            'nilai_fuzzy' => 'nullable|numeric|min:0|max:1',
            'keterangan' => 'nullable|string'
        ]);

        // Handle checkbox is_fuzzy
        $data['is_fuzzy'] = $request->has('is_fuzzy');
        
        // Jika tidak difuzzykan, set nilai_fuzzy ke null
        if (!$data['is_fuzzy']) {
            $data['nilai_fuzzy'] = null;
        }
        
        DB::table('sub_kriteria')->insert([
            ...$data,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Sub kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nama_sub_kriteria' => 'required|string|max:255',
                'nilai' => 'required|numeric|min:0',
                'nilai_fuzzy' => 'nullable|numeric|min:0|max:1',
                'keterangan' => 'nullable|string'
            ]);

            // Handle checkbox is_fuzzy
            $data['is_fuzzy'] = $request->has('is_fuzzy');
            
            // Jika tidak difuzzykan, set nilai_fuzzy ke null
            if (!$data['is_fuzzy']) {
                $data['nilai_fuzzy'] = null;
            }
            
            $result = DB::table('sub_kriteria')->where('id', $id)->update([
                ...$data,
                'updated_at' => now()
            ]);

            if ($result > 0) {
                return back()->with('success', 'Sub kriteria berhasil diperbarui.');
            } else {
                return back()->with('error', 'Tidak ada perubahan data atau data tidak ditemukan.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::table('sub_kriteria')->where('id', $id)->delete();
        return back()->with('success', 'Sub kriteria berhasil dihapus.');
    }
}
