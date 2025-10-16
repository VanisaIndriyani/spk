@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-6">
    <div class="card border-0 shadow-lg rounded-4">
      <div class="card-header bg-brand text-white fw-semibold fs-5 d-flex align-items-center justify-content-center rounded-top-4 py-3">
        <i class="bi bi-cpu me-2"></i> Proses Hybrid Fuzzy–SAW
      </div>
      <div class="card-body text-center p-4">
        <p class="text-muted mb-4">
          Sistem akan melakukan perhitungan otomatis menggunakan metode 
          <strong>Hybrid Fuzzy–SAW</strong> berdasarkan data alternatif dan kriteria yang telah Anda input.
        </p>

        <div class="alert alert-info text-start">
          <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-2"></i>Petunjuk:</h6>
          <ul class="small mb-0">
            <li>Pastikan data alternatif dan kriteria sudah lengkap.</li>
            <li>Tekan tombol di bawah untuk memulai proses perhitungan.</li>
            <li>Hasil perhitungan akan ditampilkan pada halaman hasil setelah proses selesai.</li>
          </ul>
        </div>

        <form method="POST" action="{{ route('admin.proses.run') }}" class="mt-4">
          @csrf
          <button class="btn btn-brand btn-lg px-4 shadow-sm">
            <i class="bi bi-play-circle me-2"></i> Jalankan Perhitungan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
