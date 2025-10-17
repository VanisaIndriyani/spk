@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-pencil text-primary me-2"></i>
            Edit Profile
          </h2>
          <p class="text-muted mb-0">Ubah informasi akun dan keamanan</p>
        </div>
        <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>
          Kembali
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

  <!-- Edit Form -->
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white border-0 py-3">
          <h5 class="fw-semibold mb-0">
            <i class="bi bi-person-gear me-2"></i>
            Form Edit Profile
          </h5>
        </div>
        <div class="card-body p-4">
        <form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')

            
            <!-- Username -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Username</label>
              <input type="text" class="form-control @error('username') is-invalid @enderror" 
                     name="username" value="{{ old('username', $user->username) }}" required>
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Full Name -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Nama Lengkap</label>
              <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                     name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
              @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Current Password -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Password Saat Ini</label>
              <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                     name="current_password" required>
              @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="text-muted">Masukkan password saat ini untuk memverifikasi identitas Anda</small>
            </div>

            <!-- New Password -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Password Baru</label>
              <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                     name="new_password">
              @error('new_password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
            </div>

            <!-- Confirm New Password -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
              <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                     name="new_password_confirmation">
              @error('new_password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Role Info (Read Only) -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Role</label>
              <div class="form-control-plaintext bg-light p-3 rounded">
                <i class="bi bi-shield me-2"></i>
                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'info' }}">
                  {{ ucfirst($user->role) }}
                </span>
                <small class="text-muted ms-2">(Tidak dapat diubah)</small>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>
                Simpan Perubahan
              </button>
              <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">
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
