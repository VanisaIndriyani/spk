@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-cpu-fill text-primary me-2"></i>
            Proses Perhitungan Fuzzy-SAW
          </h2>
          <p class="text-muted mb-0">Sistem Pendukung Keputusan Cerdas BLT-DD</p>
        </div>
        <div class="text-end">
          <span class="badge bg-success fs-6 px-3 py-2">
            <i class="bi bi-check-circle me-1"></i>
            Sistem Siap
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="row">
    <!-- Left Panel - Information -->
    <div class="col-lg-4 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="fw-semibold mb-0 text-dark">
            <i class="bi bi-info-circle text-info me-2"></i>
            Informasi Sistem
          </h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <h6 class="fw-semibold text-dark mb-2">Metode Perhitungan</h6>
            <p class="text-muted small mb-0">
              Menggunakan metode <strong>Hybrid Fuzzy-SAW</strong> yang menggabungkan 
              logika fuzzy dengan Simple Additive Weighting untuk menghasilkan 
              perangkingan yang akurat.
            </p>
          </div>
          
          <div class="mb-3">
            <h6 class="fw-semibold text-dark mb-2">Kriteria yang Dianalisis</h6>
            @php($kriteria = \Illuminate\Support\Facades\DB::table('kriteria')->select(['kode','nama'])->orderBy('kode')->get())
            @if($kriteria->count())
            <ul class="list-unstyled small text-muted">
              @foreach($kriteria as $kr)
              <li><i class="bi bi-dot text-primary"></i> {{ $kr->nama }}</li>
              @endforeach
            </ul>
            @else
            <div class="alert alert-warning small mb-0">
              Belum ada kriteria.
              <a href="{{ route('admin.kriteria.index') }}" class="alert-link">Tambah di halaman Kriteria</a>.
            </div>
            @endif
          </div>
          <div class="alert alert-warning border-0">
            <h6 class="fw-semibold mb-2 text-warning">
              <i class="bi bi-exclamation-triangle me-1"></i>
              Perhatian
            </h6>
            <p class="small mb-0">
              Pastikan data alternatif dan kriteria sudah lengkap sebelum menjalankan perhitungan.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Panel - Action -->
    <div class="col-lg-8 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-primary text-white border-0 py-3">
          <h5 class="fw-semibold mb-0">
            <i class="bi bi-play-circle me-2"></i>
            Jalankan Perhitungan
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h6 class="fw-semibold text-dark mb-2">Status Data</h6>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-success">
                  <i class="bi bi-check me-1"></i>
                  Data Alternatif: Lengkap
                </span>
                <span class="badge bg-success">
                  <i class="bi bi-check me-1"></i>
                  Kriteria: Terdefinisi
                </span>
                <span class="badge bg-success">
                  <i class="bi bi-check me-1"></i>
                  Bobot: Tersimpan
                </span>
              </div>
              
              <p class="text-muted mb-3">
                Sistem siap melakukan perhitungan perangkingan menggunakan metode 
                <strong>Fuzzy-SAW</strong>. Klik tombol di bawah untuk memulai proses.
              </p>
            </div>
            
            <div class="col-md-4 text-center">
              <form method="POST" action="{{ route('admin.proses.run') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg px-4 py-3 shadow-sm">
                  <i class="bi bi-play-fill me-2"></i>
                  Mulai Perhitungan
                </button>
              </form>
            </div>
          </div>

          <!-- Progress Steps -->
          <div class="mt-4">
            <h6 class="fw-semibold text-dark mb-3">Tahapan Proses</h6>
            <div class="row g-3">
              <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 p-3 h-100">
                  <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary me-2">1</span>
                    <strong>Fuzzyfikasi</strong>
                  </div>
              
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 p-3 h-100">
                  <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary me-2">2</span>
                    <strong>Defuzzyfikasi</strong>
                  </div>
                
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 p-3 h-100">
                  <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary me-2">3</span>
                    <strong>Normalisasi (SAW)</strong>
                  </div>
                
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 p-3 h-100">
                  <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary me-2">4</span>
                    <strong>Perhitungan</strong>
                  </div>
                
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 p-3 h-100">
                  <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-primary me-2">5</span>
                    <strong>Perangkingan</strong>
                  </div>
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h6 class="fw-semibold text-dark mb-3">
            <i class="bi bi-lightning text-warning me-2"></i>
            Akses Cepat
          </h6>
          <div class="row">
            <div class="col-md-3 mb-2">
              <a href="{{ route('admin.alternatif.index') }}" class="btn btn-outline-primary btn-sm w-100">
                <i class="bi bi-people me-1"></i>
                Kelola Alternatif
              </a>
            </div>
            <div class="col-md-3 mb-2">
              <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-info btn-sm w-100">
                <i class="bi bi-list-check me-1"></i>
                Kelola Kriteria
              </a>
            </div>
            <div class="col-md-3 mb-2">
              <a href="{{ route('admin.hasil') }}" class="btn btn-outline-success btn-sm w-100">
                <i class="bi bi-graph-up me-1"></i>
                Lihat Hasil
              </a>
            </div>
            <div class="col-md-3 mb-2">
              <a href="{{ route('admin.hasil.pdf') }}" class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-file-pdf me-1"></i>
                Export PDF
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
