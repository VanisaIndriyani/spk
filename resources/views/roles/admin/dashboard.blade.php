@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
  <h4 class="fw-bold mb-4 text-primary">
    <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
  </h4>

  <div class="row g-4">
    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm h-100 dashboard-card">
        <div class="card-header text-white bg-gradient-primary d-flex align-items-center justify-content-between">
          <span><i class="bi bi-people-fill me-2"></i>Data Alternatif</span>
          <i class="bi bi-arrow-right-circle fs-5"></i>
        </div>
        <div class="card-body">
          <p class="text-muted">Kelola data calon penerima BLT-DD untuk proses perhitungan.</p>
          <a class="btn btn-brand w-100" href="{{ route('admin.alternatif.index') }}">
            <i class="bi bi-pencil-square me-1"></i>Kelola Data
          </a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm h-100 dashboard-card">
        <div class="card-header text-white bg-gradient-primary d-flex align-items-center justify-content-between">
          <span><i class="bi bi-diagram-3-fill me-2"></i>Kriteria & Bobot</span>
          <i class="bi bi-arrow-right-circle fs-5"></i>
        </div>
        <div class="card-body">
          <p class="text-muted">Atur nilai dan bobot kriteria seperti penghasilan, tanggungan, dan kondisi rumah.</p>
          <a class="btn btn-brand w-100" href="{{ route('admin.kriteria.index') }}">
            <i class="bi bi-sliders me-1"></i>Atur Kriteria
          </a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm h-100 dashboard-card">
        <div class="card-header text-white bg-gradient-primary d-flex align-items-center justify-content-between">
          <span><i class="bi bi-cpu-fill me-2"></i>Proses & Hasil</span>
          <i class="bi bi-arrow-right-circle fs-5"></i>
        </div>
        <div class="card-body">
          <p class="text-muted">Lakukan perhitungan menggunakan metode Hybrid Fuzzy–SAW dan lihat hasil peringkat akhir.</p>
          <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-brand flex-fill" href="{{ route('admin.proses') }}">
              <i class="bi bi-play-fill me-1"></i>Proses
            </a>
            <a class="btn btn-outline-primary flex-fill" href="{{ route('admin.hasil') }}">
              <i class="bi bi-bar-chart-fill me-1"></i>Hasil
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .bg-gradient-primary {
    background: linear-gradient(90deg, #1e90ff, #66b3ff);
  }

  .dashboard-card {
    transition: transform .25s ease, box-shadow .25s ease;
  }

  .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
  }

  .dashboard-card .card-header {
    font-weight: 600;
    border: none;
    border-top-left-radius: .75rem;
    border-top-right-radius: .75rem;
  }

  .dashboard-card .card-body {
    padding: 1.2rem 1.5rem;
  }

  .btn-brand {
    background: var(--brand);
    border: none;
    transition: all .2s;
  }

  .btn-brand:hover {
    background: var(--brand-dark);
    transform: scale(1.03);
  }
</style>
@endsection
