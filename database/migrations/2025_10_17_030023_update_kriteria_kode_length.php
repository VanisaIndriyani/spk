<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('kode', 10)->change();
        });
        
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 10)->change();
        });
        
        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('kode', 2)->change();
        });
        
        Schema::table('nilai_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 2)->change();
        });
        
        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 2)->change();
        });
    }
};
