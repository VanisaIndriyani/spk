@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-people text-primary me-2"></i>
            Data Alternatif
          </h2>
          <p class="text-muted mb-0">Lihat data alternatif dan nilai sub kriteria</p>
        </div>
        <a href="{{ route('kades.dashboard') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>
          Kembali ke Dashboard
        </a>
      </div>
    </div>
  </div>

  <!-- Data Alternatif -->
  <div class="row">
    @forelse($alternatif as $altId => $data)
      @php
        $firstItem = $data->first();
      @endphp
      <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-primary text-white border-0 py-3">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h5 class="fw-semibold mb-0">{{ $firstItem->nama_kepala_keluarga }}</h5>
                <small class="opacity-75">No. KK: {{ $firstItem->no_kk }}</small>
              </div>
              <span class="badge bg-light text-dark fs-6">ID: {{ $altId }}</span>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th class="border-0 py-3 px-4">Kode Kriteria</th>
                    <th class="border-0 py-3 px-4">Nama Kriteria</th>
                    <th class="border-0 py-3 px-4">Nilai Linguistik</th>
                    <th class="border-0 py-3 px-4">Nilai Crisp</th>
                    <th class="border-0 py-3 px-4">Nilai Fuzzy (μ)</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $item)
                    <tr>
                      <td class="px-4 py-3">
                        <span class="badge bg-info">{{ $item->kode_kriteria }}</span>
                      </td>
                      <td class="px-4 py-3 fw-medium">{{ $item->nama_kriteria }}</td>
                      <td class="px-4 py-3">
                        <span class="badge bg-secondary">{{ $item->nilai_linguistik ?? '-' }}</span>
                      </td>
                      <td class="px-4 py-3">{{ $item->nilai_crisp ?? '-' }}</td>
                      <td class="px-4 py-3">
                        @if($item->nilai_fuzzy !== null)
                          <span class="badge bg-success">μ = {{ $item->nilai_fuzzy }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
            <h6 class="text-muted">Belum ada data alternatif</h6>
            <p class="text-muted small">Data alternatif akan muncul setelah admin menambahkan data</p>
          </div>
        </div>
      </div>
    @endforelse
  </div>
</div>
@endsection
