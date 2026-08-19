<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Realisasi Retribusi {{ $tahun }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #fff; color: #000; padding: 20px; }
        .kop-header { border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 24px; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <!-- Printable Header Controls -->
    <div class="no-print d-flex justify-content-between align-items-center bg-light p-3 rounded mb-4 border">
        <a href="{{ route('realisasi.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        <button onclick="window.print()" class="btn btn-danger btn-sm fw-bold"><i class="fas fa-print"></i> Cetak / Simpan ke PDF</button>
    </div>

    <!-- Official Kop Surat -->
    <div class="kop-header text-center">
        <h5 class="fw-bold m-0 text-uppercase">Pemerintah Daerah Kabupaten / Kota</h5>
        <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">Badan Pendapatan Daerah (BAPENDA)</h4>
        <small class="d-block text-muted">Jl. Perda Retribusi No. 01, Kompleks Perkantoran Pemda | Telp. (021) 555-0192</small>
    </div>

    <div class="text-center mb-4">
        <h5 class="fw-bold text-decoration-underline mb-1">LAPORAN REKAPITULASI REALISASI RETRIBUSI DAERAH</h5>
        <span class="small fw-bold">Tahun Anggaran {{ $tahun }} {{ $opd ? ' - ' . $opd : '' }}</span>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 130px;">Kode Rekening</th>
                <th>Jenis Retribusi</th>
                <th>Instansi / OPD</th>
                <th style="width: 110px;">Periode</th>
                <th style="width: 170px;">Nilai Realisasi (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="fw-bold text-center">{{ $row->kode_rekening }}</td>
                    <td>{{ $row->nama_retribusi }}</td>
                    <td>{{ $row->opd_name }}</td>
                    <td class="text-center">{{ $row->periode }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($row->nilai, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="fw-bold table-light">
                <td colspan="5" class="text-end">TOTAL REALISASI RETRIBUSI:</td>
                <td class="text-end fs-6">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-5 pt-4">
        <div class="col-6 text-center">
            <p class="mb-5">Mengetahui,<br><strong>Kepala Badan Pendapatan Daerah</strong></p>
            <p class="mt-5 pt-3 mb-0"><u>( H. Ahmad Subagyo, S.E., M.Si )</u><br>NIP. 19780512 200312 1 004</p>
        </div>
        <div class="col-6 text-center">
            <p class="mb-5">Dicetak Tanggal: {{ date('d F Y') }}<br><strong>Administrator Sistem Retribusi</strong></p>
            <p class="mt-5 pt-3 mb-0"><u>( {{ $user->name ?? 'Admin BAPENDA' }} )</u><br>NIP. 19890211 201204 1 002</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Auto print prompt
        };
    </script>

</body>
</html>
