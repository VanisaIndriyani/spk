<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
      body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
      h3 { margin: 0 0 10px 0; }
      table { width: 100%; border-collapse: collapse; }
      th, td { border: 1px solid #444; padding: 6px; }
      th { background: #e8f3ff; }
    </style>
  </head>
  <body>
    <h3>Hasil Perangkingan BLT-DD</h3>
    <table>
      <thead>
        <tr>
          <th>Peringkat</th><th>Nama Kepala Keluarga</th><th>No KK</th><th>Skor Akhir</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $row)
          <tr>
            <td>{{ $row->peringkat }}</td>
            <td>{{ $row->nama_kepala_keluarga }}</td>
            <td>{{ $row->no_kk }}</td>
            <td>{{ number_format($row->skor_akhir,4) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
  </html>


