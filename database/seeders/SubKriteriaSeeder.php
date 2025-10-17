<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subKriteriaData = [
            // C1 - Kondisi Rumah (Fuzzy)
            ['C1', 'Layak', 1, 0.00, true, 'Difuzzykan'],
            ['C1', 'Cukup Layak', 2, 0.25, true, 'Difuzzykan'],
            ['C1', 'Sedang', 3, 0.50, true, 'Difuzzykan'],
            ['C1', 'Hampir Tidak Layak', 4, 0.75, true, 'Difuzzykan'],
            ['C1', 'Tidak Layak', 5, 1.00, true, 'Difuzzykan'],
            
            // C2 - Status Kepemilikan Rumah (Fuzzy)
            ['C2', 'Milik Sendiri', 1, 0.00, true, 'Difuzzykan'],
            ['C2', 'Milik Warisan / Tidak Jelas', 2, 0.25, true, 'Difuzzykan'],
            ['C2', 'Sewa', 3, 0.50, true, 'Difuzzykan'],
            ['C2', 'Menumpang', 4, 0.75, true, 'Difuzzykan'],
            ['C2', 'Fasilitas Umum', 5, 1.00, true, 'Difuzzykan'],
            
            // C3 - Menerima Bantuan (PKH/dll) (Tidak Fuzzy)
            ['C3', 'Menerima', 1, null, false, 'Tidak Difuzzykan'],
            ['C3', 'Tidak Menerima', 5, null, false, 'Tidak Difuzzykan'],
            
            // C4 - Kepala Keluarga Perempuan (Tidak Fuzzy)
            ['C4', 'Ya', 5, null, false, 'Tidak Difuzzykan'],
            ['C4', 'Tidak', 1, null, false, 'Tidak Difuzzykan'],
            
            // C5 - Anggota Sakit/Difabel (Tidak Fuzzy)
            ['C5', 'Ada', 5, null, false, 'Tidak Difuzzykan'],
            ['C5', 'Tidak', 1, null, false, 'Tidak Difuzzykan'],
            
            // C6 - Jumlah Anggota Keluarga (Fuzzy)
            ['C6', 'Sangat Sedikit (1-2 orang)', 1, 0.00, true, 'Difuzzykan'],
            ['C6', 'Sedikit (3-4 orang)', 2, 0.25, true, 'Difuzzykan'],
            ['C6', 'Sedang (5-6 orang)', 3, 0.50, true, 'Difuzzykan'],
            ['C6', 'Banyak (7-8 orang)', 4, 0.75, true, 'Difuzzykan'],
            ['C6', 'Sangat Banyak (≥9 orang)', 5, 1.00, true, 'Difuzzykan'],
        ];

        foreach ($subKriteriaData as $data) {
            \DB::table('sub_kriteria')->insert([
                'kode_kriteria' => $data[0],
                'nama_sub_kriteria' => $data[1],
                'nilai' => $data[2],
                'nilai_fuzzy' => $data[3],
                'is_fuzzy' => $data[4],
                'keterangan' => $data[5],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
