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
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria', 10);
            $table->string('nama_sub_kriteria');
            $table->decimal('nilai', 8, 2);
            $table->decimal('nilai_fuzzy', 8, 2)->nullable();
            $table->boolean('is_fuzzy')->default(false);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('kode_kriteria')->references('kode')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria');
    }
};
