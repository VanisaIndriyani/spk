@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-sliders text-primary me-2"></i>
            Kriteria & Bobot
          </h2>
          <p class="text-muted mb-0">Kelola kriteria dan nilai bobot untuk perhitungan</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
          <i class="bi bi-plus-circle me-2"></i>
          Tambah Kriteria
        </button>
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

  <!-- Data Table -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-0 py-3">
          <h5 class="fw-semibold mb-0 text-dark">
            <i class="bi bi-table text-info me-2"></i>
            Data Kriteria
          </h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th class="border-0 py-3 px-4">No</th>
                  <th class="border-0 py-3 px-4">Kode Kriteria</th>
                  <th class="border-0 py-3 px-4">Nama Kriteria</th>
                  <th class="border-0 py-3 px-4">Jenis</th>
                  <th class="border-0 py-3 px-4">Bobot</th>
                  <th class="border-0 py-3 px-4 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php $total = 0; @endphp
                @forelse($rows as $index => $item)
                  @php $total += (float)$item->bobot; @endphp
                  <tr>
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">
                      <span class="badge bg-primary">{{ $item->kode }}</span>
                    </td>
                    <td class="px-4 py-3 fw-medium">{{ $item->nama }}</td>
                    <td class="px-4 py-3">
                      <span class="badge bg-{{ $item->jenis === 'benefit' ? 'success' : 'secondary' }}">
                        {{ ucfirst($item->jenis) }}
                      </span>
                    </td>
                    <td class="px-4 py-3">
                      <form method="POST" action="{{ route('admin.kriteria.update', $item->kode) }}" class="d-flex gap-2 align-items-center">
                        @csrf @method('PUT')
                        <input type="number" step="0.01" min="0" max="1" class="form-control form-control-sm" 
                               name="bobot" value="{{ $item->bobot }}" required style="width: 100px;" onchange="this.form.submit()">
                      </form>
                    </td>
                    <td class="px-4 py-3 text-center">
                      <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-info" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal"
                                data-kode="{{ $item->kode }}"
                                data-nama="{{ $item->nama }}"
                                data-jenis="{{ $item->jenis }}"
                                data-bobot="{{ $item->bobot }}">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="confirmDelete('{{ $item->kode }}')">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                      <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                      Belum ada data kriteria
                    </td>
                  </tr>
                @endforelse
              </tbody>
              <tfoot class="table-light">
                <tr>
                  <th colspan="4" class="text-end px-4 py-3">Total Bobot</th>
                  <th class="px-4 py-3">
                    <strong class="text-primary">{{ number_format($total, 2) }}</strong>
                  </th>
                  <th class="px-4 py-3"></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kriteria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.kriteria.store') }}">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kode Kriteria</label>
            <input type="text" class="form-control" name="kode" required maxlength="10">
            <small class="text-muted">Contoh: C1, C2, C3, dst.</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Kriteria</label>
            <input type="text" class="form-control" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Kriteria</label>
            <select class="form-select" name="jenis" required>
              <option value="">Pilih Jenis</option>
              <option value="benefit">Benefit (Semakin tinggi semakin baik)</option>
              <option value="cost">Cost (Semakin rendah semakin baik)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Bobot (0.00 - 1.00)</label>
            <input type="number" class="form-control" name="bobot" step="0.01" min="0" max="1" required>
            <small class="text-muted">Nilai bobot untuk kriteria ini</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kriteria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kode Kriteria</label>
            <input type="text" class="form-control" id="edit_kode" readonly>
            <small class="text-muted">Kode tidak dapat diubah</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Kriteria</label>
            <input type="text" class="form-control" id="edit_nama" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Kriteria</label>
            <select class="form-select" id="edit_jenis" name="jenis" required>
              <option value="benefit">Benefit (Semakin tinggi semakin baik)</option>
              <option value="cost">Cost (Semakin rendah semakin baik)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Bobot (0.00 - 1.00)</label>
            <input type="number" class="form-control" id="edit_bobot" name="bobot" step="0.01" min="0" max="1" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
  @csrf @method('DELETE')
</form>

<script>
// Edit Modal Handler
document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const kode = button.getAttribute('data-kode');
  const nama = button.getAttribute('data-nama');
  const jenis = button.getAttribute('data-jenis');
  const bobot = button.getAttribute('data-bobot');
  
  document.getElementById('editForm').action = `{{ url('admin/kriteria') }}/${kode}`;
  document.getElementById('edit_kode').value = kode;
  document.getElementById('edit_nama').value = nama;
  document.getElementById('edit_jenis').value = jenis;
  document.getElementById('edit_bobot').value = bobot;
});

// Delete Confirmation
function confirmDelete(kode) {
  if (confirm('Apakah Anda yakin ingin menghapus kriteria ini?')) {
    document.getElementById('deleteForm').action = `{{ url('admin/kriteria') }}/${kode}`;
    document.getElementById('deleteForm').submit();
  }
}
</script>
@endsection
