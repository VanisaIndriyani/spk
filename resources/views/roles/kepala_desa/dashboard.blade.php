@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-6">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="card-header brand d-flex align-items-center justify-content-center py-3">
        <i class="bi bi-person-badge fs-5 me-2"></i>
        <h5 class="mb-0 fw-semibold text-white">Dashboard Kepala Desa</h5>
      </div>

      <div class="card-body text-center p-4">
        <h6 class="text-secondary mb-2">Selamat Datang di Sistem SPK BLT-DD</h6>
        <p class="text-muted small mb-4">
          Sistem ini membantu menentukan <strong>prioritas penerima BLT-DD</strong> menggunakan metode 
          <strong>Hybrid Fuzzy–SAW</strong>.  
        </p>

        <div class="bg-light rounded-3 p-4 mb-4 shadow-sm">
          <h1 class="display-6 fw-bold text-brand mb-0">{{ $count }}</h1>
          <p class="text-secondary mb-0">Jumlah Hasil Perhitungan Tersedia</p>
        </div>

        <a href="{{ route('kades.hasil') }}" class="btn btn-brand btn-lg px-4 shadow-sm">
          <i class="bi bi-bar-chart-line me-2"></i> Lihat Hasil Perhitungan
        </a>
      </div>
    </div>
  </div>
</div>

<style>
  :root {
    --brand: #1e90ff;
    --brand-600: #187bcd;
  }
  .btn-brand {
    background: var(--brand);
    color: #fff;
    border-radius: 10px;
    transition: 0.3s;
    font-weight: 500;
  }
  .btn-brand:hover {
    background: var(--brand-600);
    color: #fff;
    transform: scale(1.03);
  }
  .card-header.brand {
    background: linear-gradient(90deg, #1e90ff, #6fb8ff);
    border: none;
  }
  .text-brand {
    color: var(--brand);
  }
</style>
@endsection
