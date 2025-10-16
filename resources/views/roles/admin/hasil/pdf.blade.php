<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <title>Laporan Hasil Perangkingan BLT-DD</title>
    <style>
      @page { margin: 40px 30px; }
      body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #222;
      }
      .header {
        text-align: center;
        border-bottom: 2px solid #003366;
        padding-bottom: 8px;
        margin-bottom: 20px;
      }
      .header h2 {
        margin: 0;
        font-size: 18px;
        color: #003366;
      }
      .header p {
        margin: 0;
        font-size: 12px;
        color: #555;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
      }
      th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
      }
      th {
        background-color: #e6f0ff;
        color: #003366;
        font-weight: bold;
      }
      tr:nth-child(even) td {
        background-color: #f9f9f9;
      }
      .footer {
        text-align: right;
        font-size: 11px;
        color: #777;
        margin-top: 25px;
      }
    </style>
  </head>
  <body>
    <div class="header">
      <h2>Hasil Perangkingan BLT-DD</h2>
      <p>Desa Contoh, Kecamatan Contoh, Kabupaten Contoh</p>
      <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y') }}</p>
    </div>

    <table>
      <thead>
        <tr>
          <th style="width: 70px;">Peringkat</th>
          <th>Nama Kepala Keluarga</th>
          <th style="width: 180px;">No KK</th>
          <th style="width: 120px;">Skor Akhir</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $row)
        <tr>
          <td>{{ $row->peringkat }}</td>
          <td style="text-align: left;">{{ $row->nama_kepala_keluarga }}</td>
          <td>{{ $row->no_kk }}</td>
          <td>{{ number_format($row->skor_akhir, 4) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="footer">
      Dicetak otomatis melalui sistem BLT-DD |
      <em>{{ config('app.name', 'Sistem BLT-DD') }}</em>
    </div>
  </body>
</html>
