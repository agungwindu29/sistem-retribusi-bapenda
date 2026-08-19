<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<style>
  body { font-family: 'Calibri', 'Arial', sans-serif; }
  .title-header { font-size: 16pt; font-weight: bold; text-align: center; color: #991b1b; }
  .subtitle-header { font-size: 11pt; text-align: center; color: #555555; }
  table { border-collapse: collapse; width: 100%; border: 1px solid #991b1b; }
  th { background-color: #991b1b; color: #ffffff; font-weight: bold; border: 1px solid #7f1d1d; text-align: center; padding: 10px; }
  td { border: 1px solid #cccccc; padding: 8px; vertical-align: middle; }
  .num-format { mso-number-format:"\#\,\#\#0"; text-align: right; font-weight: bold; color: #166534; }
  .code-format { mso-number-format:"\@"; text-align: center; font-weight: bold; color: #991b1b; }
  .total-row { background-color: #fef2f2; font-weight: bold; color: #991b1b; border-top: 2px solid #991b1b; }
</style>
</head>
<body>

<table border="1">
    <tr>
        <td colspan="6" class="title-header">LAPORAN REKAPITULASI REALISASI RETRIBUSI DAERAH</td>
    </tr>
    <tr>
        <td colspan="6" class="subtitle-header">Tahun Anggaran {{ $tahun }} {{ $opd ? ' - Instansi: ' . $opd : '' }} | Tanggal Ekspor: {{ date('d F Y H:i') }} WIB</td>
    </tr>
    <tr><td colspan="6"></td></tr>
    <thead>
        <tr>
            <th width="50">No</th>
            <th width="120">Periode</th>
            <th width="150">Kode Rekening</th>
            <th width="320">Jenis Retribusi</th>
            <th width="220">Instansi OPD</th>
            <th width="200">Nilai Realisasi (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $index => $row)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $row->periode }}</td>
                <td class="code-format">{{ $row->kode_rekening }}</td>
                <td>{{ $row->nama_retribusi }}</td>
                <td>{{ $row->opd_name }}</td>
                <td class="num-format">{{ $row->nilai }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="5" style="text-align: right; font-size: 11pt;">TOTAL REALISASI RETRIBUSI:</td>
            <td class="num-format" style="font-size: 12pt; color: #991b1b;">{{ $totalNilai }}</td>
        </tr>
    </tfoot>
</table>

</body>
</html>
