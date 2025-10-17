<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data alternatif sesuai dengan tabel yang diberikan
        $alternatifData = [
            [
                'nama_kepala_keluarga' => 'Ahmad Yani',
                'no_kk' => '1234567890123456',
                'nilai_kriteria' => [
                    'C1' => ['ling' => 'Hampir Tidak Layak', 'crisp' => 4, 'fuzzy' => 0.75],
                    'C2' => ['ling' => 'Menumpang', 'crisp' => 4, 'fuzzy' => 0.75],
                    'C3' => ['ling' => 'Tidak Menerima', 'crisp' => 5, 'fuzzy' => null],
                    'C4' => ['ling' => 'Tidak', 'crisp' => 1, 'fuzzy' => null],
                    'C5' => ['ling' => 'Ada', 'crisp' => 5, 'fuzzy' => null],
                    'C6' => ['ling' => 'Sedang (5-6 orang)', 'crisp' => 3, 'fuzzy' => 0.50],
                ]
            ],
            [
                'nama_kepala_keluarga' => 'Siti Aminah',
                'no_kk' => '1234567890123457',
                'nilai_kriteria' => [
                    'C1' => ['ling' => 'Cukup Layak', 'crisp' => 2, 'fuzzy' => 0.25],
                    'C2' => ['ling' => 'Milik Warisan / Tidak Jelas', 'crisp' => 2, 'fuzzy' => 0.25],
                    'C3' => ['ling' => 'Menerima', 'crisp' => 1, 'fuzzy' => null],
                    'C4' => ['ling' => 'Ya', 'crisp' => 5, 'fuzzy' => null],
                    'C5' => ['ling' => 'Tidak', 'crisp' => 1, 'fuzzy' => null],
                    'C6' => ['ling' => 'Sedikit (3-4 orang)', 'crisp' => 2, 'fuzzy' => 0.25],
                ]
            ],
            [
                'nama_kepala_keluarga' => 'Junaidi',
                'no_kk' => '1234567890123458',
                'nilai_kriteria' => [
                    'C1' => ['ling' => 'Tidak Layak', 'crisp' => 5, 'fuzzy' => 1.00],
                    'C2' => ['ling' => 'Fasilitas Umum', 'crisp' => 5, 'fuzzy' => 1.00],
                    'C3' => ['ling' => 'Tidak Menerima', 'crisp' => 5, 'fuzzy' => null],
                    'C4' => ['ling' => 'Tidak', 'crisp' => 1, 'fuzzy' => null],
                    'C5' => ['ling' => 'Ada', 'crisp' => 5, 'fuzzy' => null],
                    'C6' => ['ling' => 'Sedang (5-6 orang)', 'crisp' => 3, 'fuzzy' => 0.50],
                ]
            ],
            [
                'nama_kepala_keluarga' => 'Rahmawati',
                'no_kk' => '1234567890123459',
                'nilai_kriteria' => [
                    'C1' => ['ling' => 'Sedang', 'crisp' => 3, 'fuzzy' => 0.50],
                    'C2' => ['ling' => 'Sewa', 'crisp' => 3, 'fuzzy' => 0.50],
                    'C3' => ['ling' => 'Tidak Menerima', 'crisp' => 5, 'fuzzy' => null],
                    'C4' => ['ling' => 'Ya', 'crisp' => 5, 'fuzzy' => null],
                    'C5' => ['ling' => 'Tidak', 'crisp' => 1, 'fuzzy' => null],
                    'C6' => ['ling' => 'Sedang (5-6 orang)', 'crisp' => 3, 'fuzzy' => 0.50],
                ]
            ],
            [
                'nama_kepala_keluarga' => 'Budi Santoso',
                'no_kk' => '1234567890123460',
                'nilai_kriteria' => [
                    'C1' => ['ling' => 'Layak', 'crisp' => 1, 'fuzzy' => 0.00],
                    'C2' => ['ling' => 'Milik Sendiri', 'crisp' => 1, 'fuzzy' => 0.00],
                    'C3' => ['ling' => 'Tidak Menerima', 'crisp' => 5, 'fuzzy' => null],
                    'C4' => ['ling' => 'Tidak', 'crisp' => 1, 'fuzzy' => null],
                    'C5' => ['ling' => 'Tidak', 'crisp' => 1, 'fuzzy' => null],
                    'C6' => ['ling' => 'Sedikit (3-4 orang)', 'crisp' => 2, 'fuzzy' => 0.25],
                ]
            ],
        ];

        foreach ($alternatifData as $alt) {
            // Insert alternatif
            $altId = \DB::table('alternatif')->insertGetId([
                'nama_kepala_keluarga' => $alt['nama_kepala_keluarga'],
                'no_kk' => $alt['no_kk'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert nilai kriteria
            foreach ($alt['nilai_kriteria'] as $kode => $data) {
                \DB::table('nilai_kriteria')->insert([
                    'alternatif_id' => $altId,
                    'kode_kriteria' => $kode,
                    'nilai_linguistik' => $data['ling'],
                    'nilai_crisp' => $data['crisp'],
                    'nilai_fuzzy' => $data['fuzzy'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
