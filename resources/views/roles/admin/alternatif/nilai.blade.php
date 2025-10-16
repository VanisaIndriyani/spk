@extends('layouts.app')

@section('content')
@if(session('success'))
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
    <div id="toastSuccessNilai" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <script>
    (function(){
      const el = document.getElementById('toastSuccessNilai');
      if (el) {
        const t = new bootstrap.Toast(el, { delay: 3000, autohide: true });
        el.addEventListener('hidden.bs.toast', () => {
          window.location.href = "{{ route('admin.alternatif.index') }}";
        });
        t.show();
      }
    })();
  </script>
@endif
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex align-items-center justify-content-between">
    <div>
      <div class="fw-semibold">Input Nilai Kriteria</div>
      <small class="text-muted">{{ $alt->nama_kepala_keluarga }} &middot; KK: <code>{{ $alt->no_kk }}</code></small>
    </div>
  
  </div>
  <div class="card-body">
    <form method="post" action="{{ route('admin.alternatif.nilai.store',$alt->id) }}" class="row g-3">
      @csrf
      <div class="row g-3">
        <div class="col-12 col-lg-6">
          <label class="form-label fw-medium">C1 - Kondisi Tempat Tinggal <span class="badge bg-secondary">cost</span></label>
          <select class="form-select" name="C1" required>
            @php $v = $nilai['C1']->nilai_linguistik ?? null; @endphp
            <option value="Layak" {{ $v==='Layak'?'selected':'' }}>Layak</option>
            <option value="Kurang Layak" {{ $v==='Kurang Layak'?'selected':'' }}>Kurang Layak</option>
            <option value="Tidak Layak" {{ $v==='Tidak Layak'?'selected':'' }}>Tidak Layak</option>
          </select>
        </div>
        <div class="col-12 col-lg-6">
          <label class="form-label fw-medium">C2 - Status Kepemilikan Rumah <span class="badge bg-secondary">cost</span></label>
          <select class="form-select" name="C2" required>
            @php $v = $nilai['C2']->nilai_linguistik ?? null; @endphp
            <option value="Milik Sendiri" {{ $v==='Milik Sendiri'?'selected':'' }}>Milik Sendiri</option>
            <option value="Menumpang" {{ $v==='Menumpang'?'selected':'' }}>Menumpang</option>
            <option value="Fasilitas Umum" {{ $v==='Fasilitas Umum'?'selected':'' }}>Fasilitas Umum</option>
          </select>
        </div>
        <div class="col-12 col-lg-6">
          <label class="form-label fw-medium">C3 - Tidak Menerima PKH/dll <span class="badge bg-success">benefit</span></label>
          <select class="form-select" name="C3" required>
            @php $v = $nilai['C3']->nilai_linguistik ?? null; @endphp
            <option value="Menerima" {{ $v==='Menerima'?'selected':'' }}>Menerima</option>
            <option value="Tidak Menerima" {{ $v==='Tidak Menerima'?'selected':'' }}>Tidak Menerima</option>
          </select>
        </div>
        <div class="col-12 col-lg-6">
          <label class="form-label fw-medium">C4 - Perempuan Kepala Keluarga <span class="badge bg-success">benefit</span></label>
          <select class="form-select" name="C4" required>
            @php $v = $nilai['C4']->nilai_linguistik ?? null; @endphp
            <option value="Tidak" {{ $v==='Tidak'?'selected':'' }}>Tidak</option>
            <option value="Ya" {{ $v==='Ya'?'selected':'' }}>Ya</option>
          </select>
        </div>
        <div class="col-12 col-lg-6">
          <label class="form-label fw-medium">C5 - Anggota Sakit / Difabel <span class="badge bg-success">benefit</span></label>
          <select class="form-select" name="C5" required>
            @php $v = $nilai['C5']->nilai_linguistik ?? null; @endphp
            <option value="Tidak" {{ $v==='Tidak'?'selected':'' }}>Tidak</option>
            <option value="Ada" {{ $v==='Ada'?'selected':'' }}>Ada</option>
          </select>
        </div>
        <div class="col-12 col-lg-6">
          <label class="form-label fw-medium">C6 - Jumlah Anggota Keluarga <span class="badge bg-success">benefit</span></label>
          <select class="form-select" name="C6" required>
            @php $v = $nilai['C6']->nilai_linguistik ?? null; @endphp
            <option value="1-2" {{ $v==='1-2'?'selected':'' }}>1-2 org</option>
            <option value="3-4" {{ $v==='3-4'?'selected':'' }}>3-4 org</option>
            <option value="5-6" {{ $v==='5-6'?'selected':'' }}>5-6 org</option>
            <option value="7-8" {{ $v==='7-8'?'selected':'' }}>7-8 org</option>
            <option value=">=9" {{ $v==='>=9'?'selected':'' }}>>=9 org</option>
          </select>
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-brand" type="submit"><i class="bi bi-save"></i> Simpan Nilai</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.alternatif.index') }}"><i class="bi bi-arrow-left"></i> Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection