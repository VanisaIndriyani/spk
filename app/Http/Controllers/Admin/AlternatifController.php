<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternatifController extends Controller
{
    public function index()
    {
        $items = DB::table('alternatif')->orderByDesc('id')->get();
        return view('roles.admin.alternatif.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kepala_keluarga' => ['required','string'],
            'no_kk' => ['required','string'],
        ]);
        DB::table('alternatif')->insert([
            'nama_kepala_keluarga' => $data['nama_kepala_keluarga'],
            'no_kk' => $data['no_kk'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Alternatif berhasil ditambahkan.');
    }

    public function destroy(string $id)
    {
        DB::table('alternatif')->where('id', $id)->delete();
        return back();
    }

    public function nilaiForm(string $id)
    {
        $alt = DB::table('alternatif')->where('id',$id)->first();
        abort_unless($alt, 404);
        $kriteria = DB::table('kriteria')->orderBy('kode')->get();
        $nilai = DB::table('nilai_kriteria')->where('alternatif_id',$id)->get()->keyBy('kode_kriteria');
        return view('roles.admin.alternatif.nilai', compact('alt','kriteria','nilai'));
    }

    public function nilaiStore(Request $request, string $id)
    {
        $alt = DB::table('alternatif')->where('id',$id)->first();
        abort_unless($alt, 404);
        $data = $request->validate([
            'C1' => ['required','string'],
            'C2' => ['required','string'],
            'C3' => ['required','string'],
            'C4' => ['required','string'],
            'C5' => ['required','string'],
            'C6' => ['required','string'],
        ]);

        // Map linguistik ke crisp/fuzzy sesuai data yang diberikan
        $mapped = [];
        
        // C1: Kondisi Rumah (cost) - fuzzy
        $mapC1 = [
            'Layak' => ['crisp' => 1, 'fuzzy' => 0.00],
            'Cukup Layak' => ['crisp' => 2, 'fuzzy' => 0.25],
            'Sedang' => ['crisp' => 3, 'fuzzy' => 0.50],
            'Hampir Tidak Layak' => ['crisp' => 4, 'fuzzy' => 0.75],
            'Tidak Layak' => ['crisp' => 5, 'fuzzy' => 1.00],
        ];
        $c1Data = $mapC1[$data['C1']] ?? ['crisp' => 3, 'fuzzy' => 0.50];
        $mapped['C1'] = ['ling'=>$data['C1'],'fuzzy'=>$c1Data['fuzzy'],'crisp'=>$c1Data['crisp']];

        // C2: Status Kepemilikan Rumah (cost) - fuzzy
        $mapC2 = [
            'Milik Sendiri' => ['crisp' => 1, 'fuzzy' => 0.00],
            'Milik Warisan / Tidak Jelas' => ['crisp' => 2, 'fuzzy' => 0.25],
            'Sewa' => ['crisp' => 3, 'fuzzy' => 0.50],
            'Menumpang' => ['crisp' => 4, 'fuzzy' => 0.75],
            'Fasilitas Umum' => ['crisp' => 5, 'fuzzy' => 1.00],
        ];
        $c2Data = $mapC2[$data['C2']] ?? ['crisp' => 3, 'fuzzy' => 0.50];
        $mapped['C2'] = ['ling'=>$data['C2'],'fuzzy'=>$c2Data['fuzzy'],'crisp'=>$c2Data['crisp']];

        // C3: Menerima Bantuan (PKH/dll) (benefit) - tidak fuzzy
        $mapC3 = [ 
            'Menerima' => ['crisp' => 1, 'fuzzy' => null], 
            'Tidak Menerima' => ['crisp' => 5, 'fuzzy' => null] 
        ];
        $c3Data = $mapC3[$data['C3']] ?? ['crisp' => 1, 'fuzzy' => null];
        $mapped['C3'] = ['ling'=>$data['C3'],'fuzzy'=>$c3Data['fuzzy'],'crisp'=>$c3Data['crisp']];

        // C4: Kepala Keluarga Perempuan (benefit) - tidak fuzzy
        $mapC4 = [ 
            'Tidak' => ['crisp' => 1, 'fuzzy' => null], 
            'Ya' => ['crisp' => 5, 'fuzzy' => null] 
        ];
        $c4Data = $mapC4[$data['C4']] ?? ['crisp' => 1, 'fuzzy' => null];
        $mapped['C4'] = ['ling'=>$data['C4'],'fuzzy'=>$c4Data['fuzzy'],'crisp'=>$c4Data['crisp']];

        // C5: Anggota Sakit/Difabel (benefit) - tidak fuzzy
        $mapC5 = [ 
            'Tidak' => ['crisp' => 1, 'fuzzy' => null], 
            'Ada' => ['crisp' => 5, 'fuzzy' => null] 
        ];
        $c5Data = $mapC5[$data['C5']] ?? ['crisp' => 1, 'fuzzy' => null];
        $mapped['C5'] = ['ling'=>$data['C5'],'fuzzy'=>$c5Data['fuzzy'],'crisp'=>$c5Data['crisp']];

        // C6: Jumlah Anggota Keluarga (benefit) - fuzzy
        $mapC6 = [
            'Sangat Sedikit (1-2 orang)' => ['crisp' => 1, 'fuzzy' => 0.00],
            'Sedikit (3-4 orang)' => ['crisp' => 2, 'fuzzy' => 0.25],
            'Sedang (5-6 orang)' => ['crisp' => 3, 'fuzzy' => 0.50],
            'Banyak (7-8 orang)' => ['crisp' => 4, 'fuzzy' => 0.75],
            'Sangat Banyak (≥9 orang)' => ['crisp' => 5, 'fuzzy' => 1.00],
        ];
        $c6Data = $mapC6[$data['C6']] ?? ['crisp' => 3, 'fuzzy' => 0.50];
        $mapped['C6'] = ['ling'=>$data['C6'],'fuzzy'=>$c6Data['fuzzy'],'crisp'=>$c6Data['crisp']];

        // Ensure kriteria defaults exist before saving nilai_kriteria
        $existingCount = DB::table('kriteria')->count();
        if ($existingCount < 6) {
            $defaults = [
                ['kode'=>'C1','nama'=>'Kondisi Rumah','jenis'=>'cost','bobot'=>0.15],
                ['kode'=>'C2','nama'=>'Status Kepemilikan Rumah','jenis'=>'cost','bobot'=>0.15],
                ['kode'=>'C3','nama'=>'Menerima Bantuan (PKH/dll)','jenis'=>'benefit','bobot'=>0.20],
                ['kode'=>'C4','nama'=>'Kepala Keluarga Perempuan','jenis'=>'benefit','bobot'=>0.20],
                ['kode'=>'C5','nama'=>'Anggota Sakit/Difabel','jenis'=>'benefit','bobot'=>0.20],
                ['kode'=>'C6','nama'=>'Jumlah Anggota Keluarga','jenis'=>'benefit','bobot'=>0.10],
            ];
            foreach ($defaults as $d) {
                DB::table('kriteria')->updateOrInsert(['kode'=>$d['kode']], [
                    'nama'=>$d['nama'], 'jenis'=>$d['jenis'], 'bobot'=>$d['bobot'], 'updated_at'=>now(), 'created_at'=>now()
                ]);
            }
        }

        foreach ($mapped as $kode => $m) {
            DB::table('nilai_kriteria')->updateOrInsert(
                ['alternatif_id'=>$id, 'kode_kriteria'=>$kode],
                [
                    'nilai_linguistik' => $m['ling'],
                    'nilai_fuzzy' => $m['fuzzy'],
                    'nilai_crisp' => $m['crisp'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return redirect()->route('admin.alternatif.index')->with('success', 'Nilai kriteria berhasil disimpan.');
    }
}


