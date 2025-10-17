@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-list-check text-primary me-2"></i>
            Sub Kriteria
          </h2>
          <p class="text-muted mb-0">Kelola sub kriteria dan nilai fuzzy untuk setiap kriteria</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
          <i class="bi bi-plus-circle me-2"></i>
          Tambah Sub Kriteria
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
            Data Sub Kriteria
          </h5>
        </div>
        <div class="card-body">
          @if(isset($grouped) && $grouped->count())
            @foreach($grouped as $kode => $rows)
              <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white d-flex align-items-center">
                  <span class="badge bg-primary me-2">{{ $kode }}</span>
                  <strong>{{ optional($rows->first())->nama_kriteria }}</strong>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-sm mb-0">
                      <thead class="table-light">
                        <tr>
                          <th class="border-0 py-2 px-3" style="width:56px;">No</th>
                          <th class="border-0 py-2 px-3">Nama Sub Kriteria</th>
                          <th class="border-0 py-2 px-3">Nilai</th>
                          <th class="border-0 py-2 px-3">Nilai Fuzzy (μ)</th>
                          <th class="border-0 py-2 px-3">Status</th>
                          <th class="border-0 py-2 px-3">Keterangan</th>
                          <th class="border-0 py-2 px-3 text-center" style="width:120px;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $num = 1; @endphp
                        @foreach($rows as $item)
                          <tr>
                            <td class="px-3 py-2">{{ $num++ }}</td>
                            <td class="px-3 py-2 fw-medium">{{ $item->nama_sub_kriteria }}</td>
                            <td class="px-3 py-2">{{ $item->nilai }}</td>
                            <td class="px-3 py-2">
                              @if($item->is_fuzzy && $item->nilai_fuzzy !== null)
                                <span class="badge bg-info">μ = {{ $item->nilai_fuzzy }}</span>
                              @else
                                <span class="text-muted">-</span>
                              @endif
                            </td>
                            <td class="px-3 py-2">
                              @if($item->is_fuzzy)
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Difuzzykan</span>
                              @else
                                <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i> Tidak Difuzzykan</span>
                              @endif
                            </td>
                            <td class="px-3 py-2"><small class="text-muted">{{ $item->keterangan ?? '-' }}</small></td>
                            <td class="px-3 py-2 text-center">
                              <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                                  data-id="{{ $item->id }}" data-kode="{{ $item->kode_kriteria }}" data-nama="{{ $item->nama_sub_kriteria }}"
                                  data-nilai="{{ $item->nilai }}" data-fuzzy="{{ $item->nilai_fuzzy }}" data-is-fuzzy="{{ $item->is_fuzzy ? '1' : '0' }}"
                                  data-keterangan="{{ $item->keterangan }}">
                                  <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $item->id }})">
                                  <i class="bi bi-trash"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th class="border-0 py-3 px-4">No</th>
                    <th class="border-0 py-3 px-4">Kode Kriteria</th>
                    <th class="border-0 py-3 px-4">Nama Kriteria</th>
                    <th class="border-0 py-3 px-4">Nama Sub Kriteria</th>
                    <th class="border-0 py-3 px-4">Nilai</th>
                    <th class="border-0 py-3 px-4">Nilai Fuzzy (μ)</th>
                    <th class="border-0 py-3 px-4">Status</th>
                    <th class="border-0 py-3 px-4">Keterangan</th>
                    <th class="border-0 py-3 px-4 text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($subKriteria as $index => $item)
                    <tr>
                      <td class="px-4 py-3">{{ $index + 1 }}</td>
                      <td class="px-4 py-3"><span class="badge bg-primary">{{ $item->kode_kriteria }}</span></td>
                      <td class="px-4 py-3">{{ $item->nama_kriteria }}</td>
                      <td class="px-4 py-3 fw-medium">{{ $item->nama_sub_kriteria }}</td>
                      <td class="px-4 py-3">{{ $item->nilai }}</td>
                      <td class="px-4 py-3">
                        @if($item->is_fuzzy && $item->nilai_fuzzy !== null)
                          <span class="badge bg-info">μ = {{ $item->nilai_fuzzy }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td class="px-4 py-3">
                        @if($item->is_fuzzy)
                          <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Difuzzykan</span>
                        @else
                          <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i> Tidak Difuzzykan</span>
                        @endif
                      </td>
                      <td class="px-4 py-3"><small class="text-muted">{{ $item->keterangan ?? '-' }}</small></td>
                      <td class="px-4 py-3 text-center">
                        <div class="btn-group" role="group">
                          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="{{ $item->id }}" data-kode="{{ $item->kode_kriteria }}" data-nama="{{ $item->nama_sub_kriteria }}"
                            data-nilai="{{ $item->nilai }}" data-fuzzy="{{ $item->nilai_fuzzy }}" data-is-fuzzy="{{ $item->is_fuzzy ? '1' : '0' }}"
                            data-keterangan="{{ $item->keterangan }}">
                            <i class="bi bi-pencil"></i>
                          </button>
                          <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $item->id }})">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        Belum ada data sub kriteria
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="bi bi-plus-circle me-2"></i>
          Tambah Sub Kriteria
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.sub-kriteria.store') }}">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Kode Kriteria</label>
              <select class="form-select" name="kode_kriteria" required>
                <option value="">Pilih Kriteria</option>
                @foreach($kriteria as $k)
                  <option value="{{ $k->kode }}">{{ $k->kode }} - {{ $k->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nama Sub Kriteria</label>
              <input type="text" class="form-control" name="nama_sub_kriteria" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Nilai</label>
              <input type="number" class="form-control" name="nilai" step="0.01" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Nilai Fuzzy (μ)</label>
              <input type="number" class="form-control" name="nilai_fuzzy" step="0.01" min="0" max="1">
              <small class="text-muted">Nilai antara 0-1</small>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="is_fuzzy" id="is_fuzzy_add">
                <label class="form-check-label" for="is_fuzzy_add">
                  Difuzzykan
                </label>
              </div>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label fw-semibold">Keterangan</label>
              <textarea class="form-control" name="keterangan" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-2"></i>
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
          <i class="bi bi-pencil me-2"></i>
          Edit Sub Kriteria
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" id="editForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nama Sub Kriteria</label>
              <input type="text" class="form-control" name="nama_sub_kriteria" id="edit_nama" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nilai</label>
              <input type="number" class="form-control" name="nilai" id="edit_nilai" step="0.01" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Nilai Fuzzy (μ)</label>
              <input type="number" class="form-control" name="nilai_fuzzy" id="edit_fuzzy" step="0.01" min="0" max="1">
              <small class="text-muted">Nilai antara 0-1</small>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="is_fuzzy" id="edit_is_fuzzy">
                <label class="form-check-label" for="edit_is_fuzzy">
                  Difuzzykan
                </label>
              </div>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label fw-semibold">Keterangan</label>
              <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info">
            <i class="bi bi-check-circle me-2"></i>
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

<script>
// Edit Modal Handler
document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute('data-id');
  const nama = button.getAttribute('data-nama');
  const nilai = button.getAttribute('data-nilai');
  const fuzzy = button.getAttribute('data-fuzzy');
  const isFuzzy = button.getAttribute('data-is-fuzzy') === '1';
  const keterangan = button.getAttribute('data-keterangan');
  
  
  document.getElementById('editForm').action = `{{ url('admin/sub-kriteria') }}/${id}`;
  document.getElementById('edit_nama').value = nama;
  document.getElementById('edit_nilai').value = nilai;
  document.getElementById('edit_fuzzy').value = fuzzy || '';
  document.getElementById('edit_is_fuzzy').checked = isFuzzy;
  document.getElementById('edit_keterangan').value = keterangan || '';
});

// Delete Confirmation
function confirmDelete(id) {
  if (confirm('Apakah Anda yakin ingin menghapus sub kriteria ini?')) {
    document.getElementById('deleteForm').action = `{{ url('admin/sub-kriteria') }}/${id}`;
    document.getElementById('deleteForm').submit();
  }
}
</script>
@endsection
