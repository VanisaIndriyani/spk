<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus foreign key sementara
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->dropForeign(['kode_kriteria']);
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->dropForeign(['kode_kriteria']);
        });

        // Ubah kolom di tabel induk dan anak
        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('kode', 10)->change();
        });

        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 10)->change();
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 10)->change();
        });

        // Tambahkan kembali foreign key-nya
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->foreign('kode_kriteria')->references('kode')->on('kriteria')->onDelete('cascade');
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->foreign('kode_kriteria')->references('kode')->on('kriteria')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Drop foreign key lagi
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->dropForeign(['kode_kriteria']);
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->dropForeign(['kode_kriteria']);
        });

        // Kembalikan ke panjang 2
        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('kode', 2)->change();
        });

        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 2)->change();
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 2)->change();
        });

        // Tambah lagi foreign key-nya
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->foreign('kode_kriteria')->references('kode')->on('kriteria')->onDelete('cascade');
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->foreign('kode_kriteria')->references('kode')->on('kriteria')->onDelete('cascade');
        });
    }
};
