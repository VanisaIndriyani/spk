@extends('layouts.app')

@section('content')
@if(session('success'))
  <!-- Toast sukses -->
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
    <div id="toastSuccessAlt" class="toast align-items-center text-bg-success border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <script>
    (() => {
      const el = document.getElementById('toastSuccessAlt');
      if (el) new bootstrap.Toast(el, { delay: 3000, autohide: true }).show();
    })();
  </script>
@endif

<div class="row g-4">
  <!-- Form Tambah Alternatif -->
  <div class="col-12 col-xl-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white d-flex align-items-center justify-content-between">
        <span class="fw-semibold text-brand"><i class="bi bi-person-plus me-2"></i>Tambah Alternatif</span>
      </div>
      <div class="card-body">
        <form method="post" action="{{ route('admin.alternatif.store') }}" class="row g-3">
          @csrf
          <div class="col-12">
            <label class="form-label fw-semibold">Nama Kepala Keluarga</label>
            <input class="form-control form-control-sm" name="nama_kepala_keluarga" placeholder="cth: Budi Santoso" required>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">No KK</label>
            <input class="form-control form-control-sm" name="no_kk" placeholder="cth: 3578xxxxxxxxxxxx" required>
          </div>
          <div class="col-12 d-flex gap-2 mt-2">
            <button class="btn btn-sm btn-brand px-3" type="submit">
              <i class="bi bi-plus-circle me-1"></i> Simpan
            </button>
            <button class="btn btn-sm btn-outline-secondary px-3" type="reset">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Daftar Alternatif -->
  <div class="col-12 col-xl-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-2">
        <span class="fw-semibold text-brand"><i class="bi bi-people-fill me-2"></i>Daftar Alternatif</span>
        <div class="input-group input-group-sm" style="max-width: 280px;">
          <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
          <input type="text" id="altSearch" class="form-control border-start-0" placeholder="Cari nama atau No KK...">
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="altTable">
            <thead class="table-light text-center">
              <tr>
                <th style="width:60px">No</th>
                <th>Nama Kepala Keluarga</th>
                <th>No KK</th>
                <th style="width:180px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($items as $row)
                <tr>
                <td class="text-muted text-center">{{ $loop->iteration }}</td>
                  <td class="fw-semibold">{{ $row->nama_kepala_keluarga }}</td>
                  <td><code>{{ $row->no_kk }}</code></td>
                  <td>
                    <div class="d-flex justify-content-center gap-2">
                      <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.alternatif.nilai.form',$row->id) }}">
                        <i class="bi bi-sliders"></i> Nilai
                      </a>
                      <form method="post" action="{{ route('admin.alternatif.destroy',$row->id) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="bi bi-trash"></i> Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                    Belum ada data alternatif.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-white text-end">
        <small class="text-muted">Total: <strong>{{ $items->count() }}</strong> alternatif</small>
      </div>
    </div>
  </div>
</div>

<script>
  // Fitur pencarian
  const altSearch = document.getElementById('altSearch');
  const altTable = document.getElementById('altTable');
  if(altSearch && altTable){
    altSearch.addEventListener('input', function(){
      const q = this.value.toLowerCase();
      altTable.querySelectorAll('tbody tr').forEach(tr => {
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(q) ? '' : 'none';
      });
    });
  }
</script>
@endsection
