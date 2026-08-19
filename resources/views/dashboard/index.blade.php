@extends('layouts.app')

@section('title', 'Dashboard Overview')
@section('page_heading', 'Overview Realisasi Retribusi')

@section('content')
<!-- Filter Tahun Bar -->
<div class="card-custom p-3 mb-4">
    <form action="{{ route('dashboard') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-auto">
            <label class="fw-bold text-muted small"><i class="fas fa-filter me-1 text-danger"></i> Filter Periode:</label>
        </div>
        <div class="col-auto">
            <select name="tahun" class="form-select form-select-sm rounded-3 border-danger-subtle fw-semibold" onchange="this.form.submit()">
                <option value="2026" {{ $tahun == 2026 ? 'selected' : '' }}>Tahun 2026</option>
                <option value="2025" {{ $tahun == 2025 ? 'selected' : '' }}>Tahun 2025</option>
            </select>
        </div>
        <div class="col-auto ms-auto">
            <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold">
                <i class="fas fa-building me-1"></i> Unit OPD: {{ strtoupper($user->opd_name) }}
            </span>
        </div>
    </form>
</div>

<!-- STAT CARDS ROW -->
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-md-3 col-sm-6">
        <div class="card-custom p-3 d-flex align-items-center">
            <div class="stat-icon bg-danger text-white me-3">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small fw-semibold">Realisasi Agustus {{ $tahun }}</p>
                <h5 class="fw-bold mb-0 text-danger">Rp {{ number_format($totalRealisasiBulanIni, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="col-md-3 col-sm-6">
        <div class="card-custom p-3 d-flex align-items-center">
            <div class="stat-icon bg-dark text-white me-3" style="background: var(--deep-burgundy) !important;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small fw-semibold">Total Realisasi {{ $tahun }}</p>
                <h5 class="fw-bold mb-0">Rp {{ number_format($totalRealisasiTahun, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="col-md-3 col-sm-6">
        <div class="card-custom p-3 d-flex align-items-center">
            <div class="stat-icon bg-danger-subtle text-danger me-3">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small fw-semibold">Dokumen PDF Diupload</p>
                <h5 class="fw-bold mb-0">{{ $totalDokumenUploaded }} File</h5>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="col-md-3 col-sm-6">
        <div class="card-custom p-3 d-flex align-items-center">
            <div class="stat-icon bg-warning text-dark bg-opacity-75 me-3">
                <i class="fas fa-building"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small fw-semibold">Unit OPD Terdaftar</p>
                <h5 class="fw-bold mb-0">{{ $totalOpdAktif }} Instansi</h5>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS ROW -->
<div class="row g-4 mb-4">
    <!-- Bar Chart Realisasi Bulanan -->
    <div class="col-lg-8">
        <div class="card-custom p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-chart-column me-2"></i>Grafik Perkembangan Realisasi {{ $tahun }}</h6>
                    <small class="text-muted">Total penerimaan per bulan dalam Rupiah</small>
                </div>
                <span class="badge badge-red px-3 py-2 rounded-pill">Data Terverifikasi</span>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Doughnut Chart OPD Distribution -->
    <div class="col-lg-4">
        <div class="card-custom p-4 h-100">
            <div class="mb-3">
                <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-chart-pie me-2"></i>{{ $isAdmin ? 'Kontribusi per OPD' : 'Distribusi Retribusi' }}</h6>
                <small class="text-muted">Proporsi penerimaan {{ $tahun }}</small>
            </div>
            <div style="height: 260px; position: relative;" class="d-flex justify-content-center align-items-center">
                <canvas id="opdChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- RECENT PDF UPLOADS TABLE -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-clock-rotate-left me-2"></i>Aktivitas Upload Dokumen Terakhir</h6>
        <a href="{{ route('upload.index') }}" class="btn btn-sm btn-red">
            <i class="fas fa-plus me-1"></i> Upload PDF Baru
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="small text-muted">File PDF</th>
                    <th class="small text-muted">Periode</th>
                    <th class="small text-muted">OPD / Instansi</th>
                    <th class="small text-muted">Total Nilai</th>
                    <th class="small text-muted">Status Parsing</th>
                    <th class="small text-muted">Tanggal Upload</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUploads as $item)
                    <tr>
                        <td class="fw-bold text-danger">
                            <i class="fas fa-file-pdf me-2"></i>{{ $item->original_filename }}
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $item->periode }}</span></td>
                        <td class="small fw-semibold">{{ $item->opd_name }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status === 'Success')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="fas fa-check-circle me-1"></i> Success</span>
                            @elseif($item->status === 'Processing')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1"><i class="fas fa-spinner fa-spin me-1"></i> Processing</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="fas fa-times-circle me-1"></i> Failed</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $item->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada dokumen PDF diupload.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: @json($bulanList),
                datasets: [{
                    label: 'Realisasi (Rp)',
                    data: @json($chartBulanan),
                    backgroundColor: 'rgba(153, 27, 27, 0.85)',
                    borderColor: '#7f1d1d',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toLocaleString('id-ID') + ' Jt';
                            }
                        }
                    }
                }
            }
        });

        const ctxOpd = document.getElementById('opdChart').getContext('2d');
        new Chart(ctxOpd, {
            type: 'doughnut',
            data: {
                labels: @json($opdChartLabels),
                datasets: [{
                    data: @json($opdChartData),
                    backgroundColor: [
                        '#991b1b',
                        '#dc2626',
                        '#b91c1c',
                        '#7f1d1d',
                        '#f87171',
                        '#ef4444'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>
@endsection
