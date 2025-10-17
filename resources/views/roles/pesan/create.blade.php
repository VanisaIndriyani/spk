@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-send text-primary me-2"></i>
            Kirim Pesan
          </h2>
          <p class="text-muted mb-0">Kirim pesan ke {{ auth()->user()->role === 'admin' ? 'Kepala Desa' : 'Admin' }}</p>
        </div>
        <a href="{{ route('pesan.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>
          Kembali
        </a>
      </div>
    </div>
  </div>

  <!-- Form -->
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white border-0 py-3">
          <h5 class="fw-semibold mb-0">
            <i class="bi bi-envelope me-2"></i>
            Form Pesan
          </h5>
        </div>
        <div class="card-body p-4">
          <form method="POST" action="{{ route('pesan.store') }}">
            @csrf
            
            <div class="mb-3">
              <label class="form-label fw-semibold">Penerima</label>
              <select class="form-select" name="penerima_id" required>
                <option value="">Pilih Penerima</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->full_name }} ({{ ucfirst($user->role) }})</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Judul Pesan</label>
              <input type="text" class="form-control" name="judul" required placeholder="Masukkan judul pesan">
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Isi Pesan</label>
              <textarea class="form-control" name="isi_pesan" rows="6" required placeholder="Tulis pesan Anda di sini..."></textarea>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-2"></i>
                Kirim Pesan
              </button>
              <a href="{{ route('pesan.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-2"></i>
                Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
