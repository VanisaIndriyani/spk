@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-lg rounded-4 overflow-hidden">
  <!-- Header -->
  <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between py-3 px-4 border-bottom">
    <div class="mb-2 mb-md-0">
      <h5 class="fw-semibold mb-0 text-brand"><i class="bi bi-trophy me-2 text-warning"></i>Hasil Perangkingan</h5>
      <small class="text-muted">Urutan berdasarkan skor akhir dari <strong>tertinggi</strong> ke <strong>terendah</strong>.</small>
    </div>

    <div class="d-flex flex-wrap gap-2">
      <div class="input-group" style="max-width: 280px;">
        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
        <input type="text" id="hasilSearch" class="form-control border-0 shadow-sm rounded-3" placeholder="Cari nama atau No KK...">
      </div>
      <a class="btn btn-brand d-flex align-items-center gap-2 shadow-sm" href="{{ route('admin.hasil.pdf') }}">
        <i class="bi bi-filetype-pdf"></i> Cetak PDF
      </a>
    </div>
  </div>

  <!-- Body -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="hasilTable">
        <thead class="table-brand text-white">
          <tr>
            <th style="width:120px" class="text-center">Peringkat</th>
            <th>Nama Kepala Keluarga</th>
            <th>No KK</th>
            <th style="width:160px" class="text-center">Skor Akhir</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rows as $row)
            <tr class="animate-fade">
              <td class="text-center">
                <span class="badge {{ $row->peringkat == 1 ? 'bg-warning text-dark' : 'bg-primary' }} fs-6 px-3 py-2">
                  #{{ $row->peringkat }}
                </span>
              </td>
              <td class="fw-semibold">
                <a href="{{ route('admin.hasil.show', $row->alternatif_id) }}" class="text-decoration-none">
                  {{ $row->nama_kepala_keluarga }}
                </a>
              </td>
              <td><code>{{ $row->no_kk }}</code></td>
              <td class="text-center"><strong>{{ number_format($row->skor_akhir, 4) }}</strong></td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-5">
                <i class="bi bi-clipboard-x fs-3 d-block mb-2"></i>
                Belum ada hasil perhitungan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  :root {
    --brand: #1e90ff;
    --brand-600: #187bcd;
  }

  .btn-brand {
    background: var(--brand);
    color: #fff;
    border-radius: 8px;
    font-weight: 500;
    transition: 0.3s;
  }
  .btn-brand:hover {
    background: var(--brand-600);
    transform: scale(1.03);
  }

  .text-brand {
    color: var(--brand);
  }

  .table-brand {
    background: linear-gradient(90deg, #1e90ff, #6fb8ff);
  }

  .table-hover tbody tr:hover {
    background-color: rgba(30, 144, 255, 0.05);
  }

  .input-group .form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(30,144,255,0.2);
  }

  .animate-fade {
    animation: fadeIn 0.5s ease-in-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<script>
  const hasilSearch = document.getElementById('hasilSearch');
  const hasilTable = document.getElementById('hasilTable');
  if (hasilSearch && hasilTable) {
    hasilSearch.addEventListener('input', function() {
      const q = this.value.toLowerCase();
      hasilTable.querySelectorAll('tbody tr').forEach(tr => {
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(q) ? '' : 'none';
      });
    });
  }
</script>
@endsection
