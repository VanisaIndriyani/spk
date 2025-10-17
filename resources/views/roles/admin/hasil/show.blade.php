@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex align-items-center justify-content-between">
    <div>
      <h5 class="mb-0 fw-semibold">Detail Perhitungan</h5>
      <small class="text-muted">{{ $alt->nama_kepala_keluarga }} · KK: <code>{{ $alt->no_kk }}</code></small>
    </div>
    <a href="{{ route('admin.hasil') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 py-3">Kode</th>
            <th class="px-4 py-3">Jenis</th>
            <th class="px-4 py-3">Bobot (wj)</th>
            <th class="px-4 py-3">Linguistik</th>
            <th class="px-4 py-3">Crisp (x)</th>
            <th class="px-4 py-3">r</th>
            <th class="px-4 py-3">wj × r</th>
          </tr>
        </thead>
        <tbody>
          @foreach($detail as $d)
            <tr>
              <td class="px-4 py-3"><span class="badge bg-primary">{{ $d['kode'] }}</span></td>
              <td class="px-4 py-3"><span class="badge bg-{{ $d['jenis']==='benefit'?'success':'secondary' }}">{{ ucfirst($d['jenis']) }}</span></td>
              <td class="px-4 py-3">{{ number_format($d['bobot'], 2) }}</td>
              <td class="px-4 py-3">{{ $d['ling'] ?? '-' }}</td>
              <td class="px-4 py-3">{{ number_format($d['crisp'], 2) }}</td>
              <td class="px-4 py-3">{{ number_format($d['r'], 2) }}</td>
              <td class="px-4 py-3">{{ number_format($d['wjr'], 4) }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot class="table-light">
          <tr>
            <th colspan="6" class="text-end px-4 py-3">Total (V)</th>
            <th class="px-4 py-3">{{ number_format($total, 4) }}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endsection


