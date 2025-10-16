@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-lg rounded-4 overflow-hidden">
  <!-- Header -->
  <div class="card-header bg-white d-flex align-items-center justify-content-between py-3 px-4 border-bottom">
    <div>
      <h5 class="fw-semibold text-brand mb-0">
        <i class="bi bi-sliders me-2 text-primary"></i>Kriteria & Bobot
      </h5>
      <small class="text-muted">Atur nilai bobot (0.00 - 1.00). Total ideal mendekati <strong>1.00</strong></small>
    </div>
    <a class="btn btn-outline-secondary shadow-sm d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
  </div>

  <!-- Body -->
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-brand text-white">
          <tr>
            <th style="width:90px;">Kode</th>
            <th>Nama Kriteria</th>
            <th style="width:140px;">Jenis</th>
            <th style="width:260px;">Bobot (0 - 1)</th>
            <th class="text-center" style="width:100px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach ($rows as $r)
            @php $total += (float)$r->bobot; @endphp
            <tr class="animate-fade">
              <td class="fw-semibold text-primary">{{ $r->kode }}</td>
              <td>{{ $r->nama }}</td>
              <td>
                <span class="badge bg-{{ $r->jenis === 'benefit' ? 'success' : 'secondary' }}">
                  {{ ucfirst($r->jenis) }}
                </span>
              </td>
              <td>
                <form method="POST" action="{{ route('admin.kriteria.update', $r->kode) }}" class="d-flex gap-2 align-items-center">
                  @csrf @method('PUT')
                  <input 
                    type="number" 
                    step="0.01" 
                    min="0" 
                    max="1" 
                    class="form-control form-control-sm shadow-sm" 
                    name="bobot" 
                    value="{{ $r->bobot }}" 
                    required>
                  <button class="btn btn-sm btn-brand shadow-sm">
                    <i class="bi bi-save"></i>
                  </button>
                </form>
              </td>
              <td></td>
            </tr>
          @endforeach
        </tbody>
        <tfoot class="table-light">
          <tr>
            <th colspan="3" class="text-end">Total Bobot</th>
            <th colspan="2">
              <strong id="totalBobot" class="text-brand fs-6">{{ number_format($total, 2) }}</strong>
            </th>
          </tr>
        </tfoot>
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
    transition: 0.3s;
    border-radius: 8px;
  }
  .btn-brand:hover {
    background: var(--brand-600);
    color: #fff;
    transform: scale(1.05);
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
  .form-control-sm {
    border-radius: 8px;
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
  // Hitung total bobot secara real-time
  document.querySelectorAll('input[name="bobot"]').forEach(inp => {
    inp.addEventListener('input', () => {
      let sum = 0;
      document.querySelectorAll('input[name="bobot"]').forEach(i => sum += parseFloat(i.value || '0'));
      const totalBobot = document.getElementById('totalBobot');
      totalBobot.textContent = sum.toFixed(2);

      // Tambah warna jika total sudah mendekati 1
      totalBobot.style.color = (sum.toFixed(2) >= 0.95 && sum.toFixed(2) <= 1.05) ? 'green' : '#1e90ff';
    });
  });
</script>
@endsection
