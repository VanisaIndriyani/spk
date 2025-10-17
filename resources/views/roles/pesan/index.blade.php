@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-envelope text-primary me-2"></i>
            Pesan
          </h2>
          <p class="text-muted mb-0">Kelola pesan dari {{ auth()->user()->role === 'admin' ? 'Kepala Desa' : 'Admin' }}</p>
        </div>
        <a href="{{ route('pesan.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-circle me-2"></i>
          Kirim Pesan
        </a>
      </div>
    </div>
  </div>

  <!-- Alert Messages -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-circle me-2"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Messages List -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="fw-semibold mb-0 text-dark">
            <i class="bi bi-inbox text-info me-2"></i>
            Kotak Masuk
          </h5>
        </div>
        <div class="card-body p-0">
          @forelse($pesan as $item)
            <div class="border-bottom p-3 {{ !$item->is_read ? 'bg-light' : '' }}">
              <div class="d-flex align-items-start justify-content-between">
                <div class="flex-grow-1">
                  <div class="d-flex align-items-center mb-2">
                    @if(!$item->is_read)
                      <span class="badge bg-primary me-2">Baru</span>
                    @endif
                    <h6 class="fw-semibold mb-0 text-dark">{{ $item->judul }}</h6>
                  </div>
                  <p class="text-muted small mb-2">
                    <i class="bi bi-person me-1"></i>
                    Dari: <strong>{{ $item->nama_pengirim }}</strong>
                  </p>
                  <p class="text-muted small mb-2">
                    <i class="bi bi-clock me-1"></i>
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
                  </p>
                  <p class="text-muted mb-0">
                    {{ Str::limit($item->isi_pesan, 150) }}
                  </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <a href="{{ route('pesan.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i>
                  </a>
                  <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $item->id }})">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          @empty
            <div class="text-center py-5">
              <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
              <h6 class="text-muted">Belum ada pesan</h6>
              <p class="text-muted small">Pesan dari {{ auth()->user()->role === 'admin' ? 'Kepala Desa' : 'Admin' }} akan muncul di sini</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

<script>
function confirmDelete(id) {
  if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
    document.getElementById('deleteForm').action = `/pesan/${id}`;
    document.getElementById('deleteForm').submit();
  }
}
</script>
@endsection
