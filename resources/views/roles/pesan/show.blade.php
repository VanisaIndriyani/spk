@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-envelope-open text-primary me-2"></i>
            Detail Pesan
          </h2>
          <p class="text-muted mb-0">Lihat detail pesan yang diterima</p>
        </div>
        <a href="{{ route('pesan.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>
          Kembali
        </a>
      </div>
    </div>
  </div>

  <!-- Message Detail -->
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-0 py-3">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold mb-0 text-dark">{{ $pesan->judul }}</h5>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $pesan->id }})">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body p-4">
          <div class="row mb-3">
            <div class="col-md-6">
              <small class="text-muted">
                <i class="bi bi-person me-1"></i>
                <strong>Dari:</strong> {{ $pesan->nama_pengirim }}
              </small>
            </div>
            <div class="col-md-6">
              <small class="text-muted">
                <i class="bi bi-clock me-1"></i>
                <strong>Waktu:</strong> {{ \Carbon\Carbon::parse($pesan->created_at)->format('d M Y, H:i') }}
              </small>
            </div>
          </div>
          
          @if($pesan->read_at)
            <div class="row mb-3">
              <div class="col-12">
                <small class="text-success">
                  <i class="bi bi-check-circle me-1"></i>
                  <strong>Dibaca:</strong> {{ \Carbon\Carbon::parse($pesan->read_at)->format('d M Y, H:i') }}
                </small>
              </div>
            </div>
          @endif

          <div class="border-top pt-3">
            <h6 class="fw-semibold mb-3">Isi Pesan:</h6>
            <div class="bg-light p-3 rounded">
              {!! nl2br(e($pesan->isi_pesan)) !!}
            </div>
          </div>
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
