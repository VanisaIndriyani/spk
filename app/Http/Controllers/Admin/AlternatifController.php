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

        // Map linguistik ke crisp/fuzzy
        $mapped = [];
        // C1: Kondisi Tempat Tinggal (cost) - fuzzy
        $mapC1 = [
            'Layak' => 0.0,
            'Kurang Layak' => 0.5,
            'Tidak Layak' => 1.0,
        ];
        $mu1 = $mapC1[$data['C1']] ?? 0.0;
        $crisp1 = ($mu1 * 4) + 1; // 1..5
        $mapped['C1'] = ['ling'=>$data['C1'],'fuzzy'=>$mu1,'crisp'=>$crisp1];

        // C2: Status Kepemilikan Rumah (cost) - crisp
        $mapC2 = [
            'Milik Sendiri' => 1.0,
            'Menumpang' => 3.0,
            'Fasilitas Umum' => 5.0,
        ];
        $mapped['C2'] = ['ling'=>$data['C2'],'fuzzy'=>null,'crisp'=>($mapC2[$data['C2']] ?? 3.0)];

        // C3: Tidak Menerima PKH/dll (benefit) - crisp
        $mapC3 = [ 'Menerima' => 1.0, 'Tidak Menerima' => 5.0 ];
        $mapped['C3'] = ['ling'=>$data['C3'],'fuzzy'=>null,'crisp'=>($mapC3[$data['C3']] ?? 1.0)];

        // C4: Perempuan Kepala Keluarga (benefit) - crisp
        $mapC4 = [ 'Tidak' => 1.0, 'Ya' => 5.0 ];
        $mapped['C4'] = ['ling'=>$data['C4'],'fuzzy'=>null,'crisp'=>($mapC4[$data['C4']] ?? 1.0)];

        // C5: Anggota Sakit / Difabel (benefit) - crisp
        $mapC5 = [ 'Tidak' => 1.0, 'Ada' => 5.0 ];
        $mapped['C5'] = ['ling'=>$data['C5'],'fuzzy'=>null,'crisp'=>($mapC5[$data['C5']] ?? 1.0)];

        // C6: Jumlah Anggota Keluarga (benefit) - fuzzy
        $mapC6 = [
            '1-2' => 0.0,
            '3-4' => 0.25,
            '5-6' => 0.5,
            '7-8' => 0.75,
            '>=9' => 1.0,
        ];
        $mu6 = $mapC6[$data['C6']] ?? 0.0;
        $crisp6 = ($mu6 * 4) + 1;
        $mapped['C6'] = ['ling'=>$data['C6'],'fuzzy'=>$mu6,'crisp'=>$crisp6];

        // Ensure kriteria defaults exist before saving nilai_kriteria
        $existingCount = DB::table('kriteria')->count();
        if ($existingCount < 6) {
            $defaults = [
                ['kode'=>'C1','nama'=>'Kondisi Tempat Tinggal','jenis'=>'cost','bobot'=>0.10],
                ['kode'=>'C2','nama'=>'Status Kepemilikan Rumah','jenis'=>'cost','bobot'=>0.15],
                ['kode'=>'C3','nama'=>'Tidak Menerima PKH/dll','jenis'=>'benefit','bobot'=>0.20],
                ['kode'=>'C4','nama'=>'Perempuan Kepala Keluarga','jenis'=>'benefit','bobot'=>0.20],
                ['kode'=>'C5','nama'=>'Anggota Sakit / Difabel','jenis'=>'benefit','bobot'=>0.25],
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

        return redirect()->route('admin.alternatif.nilai.form', $id)->with('success', 'Nilai kriteria berhasil disimpan.');
    }
}


