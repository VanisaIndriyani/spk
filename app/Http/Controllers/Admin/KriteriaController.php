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
            ['C1','Kondisi Tempat Tinggal','cost',0.10],
            ['C2','Status Kepemilikan Rumah','cost',0.15],
            ['C3','Tidak Menerima PKH/dll','benefit',0.20],
            ['C4','Perempuan Kepala Keluarga','benefit',0.20],
            ['C5','Anggota Sakit / Difabel','benefit',0.25],
            ['C6','Jumlah Anggota Keluarga','benefit',0.10],
        ];
        foreach ($defaults as $d) {
            DB::table('kriteria')->updateOrInsert(['kode'=>$d[0]], [
                'nama'=>$d[1], 'jenis'=>$d[2], 'bobot'=>$d[3], 'updated_at'=>now(), 'created_at'=>now()
            ]);
        }
        $rows = DB::table('kriteria')->orderBy('kode')->get();
        return view('roles.admin.kriteria.index', compact('rows'));
    }

    public function update(Request $request, string $kode)
    {
        $bobot = (float)$request->validate(['bobot'=>['required','numeric','min:0','max:1']])['bobot'];
        DB::table('kriteria')->where('kode',$kode)->update(['bobot'=>$bobot,'updated_at'=>now()]);
        return back();
    }
}


