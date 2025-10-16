<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternatif', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kepala_keluarga');
            $table->string('no_kk');
            $table->timestamps();
        });

        Schema::create('kriteria', function (Blueprint $table) {
            $table->string('kode', 2)->primary();
            $table->string('nama');
            $table->enum('jenis', ['benefit','cost']);
            $table->decimal('bobot',5,2);
            $table->timestamps();
        });

        Schema::create('nilai_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternatif_id')->constrained('alternatif')->cascadeOnDelete();
            $table->string('kode_kriteria', 2);
            $table->string('nilai_linguistik')->nullable();
            $table->decimal('nilai_fuzzy',5,3)->nullable();
            $table->decimal('nilai_crisp',5,2)->nullable();
            $table->decimal('nilai_normalisasi',6,4)->nullable();
            $table->decimal('nilai_bobot',6,4)->nullable();
            $table->timestamps();
            $table->foreign('kode_kriteria')->references('kode')->on('kriteria')->cascadeOnDelete();
        });

        Schema::create('hasil_perangkingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternatif_id')->constrained('alternatif')->cascadeOnDelete();
            $table->decimal('skor_akhir',8,4);
            $table->unsignedInteger('peringkat');
            $table->boolean('approved_by_kepala_desa')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_perangkingan');
        Schema::dropIfExists('nilai_kriteria');
        Schema::dropIfExists('kriteria');
        Schema::dropIfExists('alternatif');
    }
};


