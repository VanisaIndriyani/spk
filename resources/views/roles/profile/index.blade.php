@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-person-circle text-primary me-2"></i>
            Profile Saya
          </h2>
          <p class="text-muted mb-0">Kelola informasi akun dan keamanan</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
          <i class="bi bi-pencil me-2"></i>
          Edit Profile
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

  <!-- Profile Information -->
  <div class="row">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white border-0 py-3">
          <h5 class="fw-semibold mb-0">
            <i class="bi bi-info-circle me-2"></i>
            Informasi Akun
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Username</label>
              <div class="form-control-plaintext bg-light p-3 rounded">
                <i class="bi bi-person me-2"></i>
                {{ $user->username }}
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
              <div class="form-control-plaintext bg-light p-3 rounded">
                <i class="bi bi-card-text me-2"></i>
                {{ $user->full_name }}
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Role</label>
              <div class="form-control-plaintext bg-light p-3 rounded">
                <i class="bi bi-shield me-2"></i>
                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'info' }}">
                  {{ ucfirst($user->role) }}
                </span>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold text-muted">Terakhir Login</label>
              <div class="form-control-plaintext bg-light p-3 rounded">
                <i class="bi bi-clock me-2"></i>
                {{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : 'Belum pernah' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-info text-white border-0 py-3">
          <h5 class="fw-semibold mb-0">
            <i class="bi bi-shield-check me-2"></i>
            Keamanan Akun
          </h5>
        </div>
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <i class="bi bi-key text-success me-2"></i>
            <span class="fw-medium">Password</span>
            <span class="badge bg-success ms-auto">Aktif</span>
          </div>
          
          <div class="d-flex align-items-center mb-3">
            <i class="bi bi-person-check text-success me-2"></i>
            <span class="fw-medium">Akun</span>
            <span class="badge bg-success ms-auto">Aktif</span>
          </div>

          <div class="d-flex align-items-center">
            <i class="bi bi-calendar text-info me-2"></i>
            <span class="fw-medium">Bergabung</span>
            <span class="text-muted ms-auto">{{ $user->created_at->format('M Y') }}</span>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card border-0 shadow-sm mt-3">
        <div class="card-header bg-light border-0 py-3">
          <h6 class="fw-semibold mb-0">
            <i class="bi bi-lightning text-warning me-2"></i>
            Aksi Cepat
          </h6>
        </div>
        <div class="card-body p-3">
          <div class="d-grid gap-2">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
              <i class="bi bi-pencil me-2"></i>
              Edit Profile
            </a>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning btn-sm">
              <i class="bi bi-key me-2"></i>
              Ubah Password
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
