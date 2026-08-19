@extends('layouts.app')

@section('title', 'Data Realisasi Retribusi')
@section('page_heading', 'Data Realisasi Retribusi Daerah')

@section('content')
<div class="card-custom p-4 mb-4">
    <!-- Header Controls -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h6 class="fw-bold text-danger m-0">
                <i class="fas fa-database me-2"></i> Rekapitulasi Data Realisasi Retribusi
            </h6>
            <small class="text-muted">Total {{ $totalRecord }} catatan data ditemukan</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('realisasi.print', request()->all()) }}" target="_blank" class="btn btn-outline-danger fw-bold rounded-3 shadow-sm">
                <i class="fas fa-print me-2"></i> Cetak Laporan PDF
            </a>
            <a href="{{ route('realisasi.export', request()->all()) }}" class="btn btn-success fw-bold rounded-3 shadow-sm">
                <i class="fas fa-file-excel me-2"></i> Export Ke Excel (.xlsx/.csv)
            </a>
        </div>
    </div>

    <!-- FILTER & SEARCH FORM -->
    <form action="{{ route('realisasi.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-2 col-6">
            <select name="tahun" class="form-select form-select-sm rounded-3 bg-light border-danger-subtle fw-semibold" onchange="this.form.submit()">
                <option value="2026" {{ $tahun == 2026 ? 'selected' : '' }}>Tahun 2026</option>
                <option value="2025" {{ $tahun == 2025 ? 'selected' : '' }}>Tahun 2025</option>
            </select>
        </div>

        @if($isAdmin)
        <div class="col-md-3 col-6">
            <select name="opd" class="form-select form-select-sm rounded-3 bg-light border-danger-subtle fw-semibold" onchange="this.form.submit()">
                <option value="Semua OPD" {{ ($opd === 'Semua OPD' || !$opd) ? 'selected' : '' }}>Semua Instansi OPD</option>
                @foreach($opdList as $o)
                    <option value="{{ $o }}" {{ ($opd === $o) ? 'selected' : '' }}>{{ $o }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="col-md-2 col-6">
            <select name="periode" class="form-select form-select-sm rounded-3 bg-light border-danger-subtle fw-semibold" onchange="this.form.submit()">
                <option value="Semua Periode" {{ ($periode === 'Semua Periode' || !$periode) ? 'selected' : '' }}>Semua Periode</option>
                <option value="Agustus" {{ ($periode === 'Agustus') ? 'selected' : '' }}>Agustus</option>
                <option value="Juli" {{ ($periode === 'Juli') ? 'selected' : '' }}>Juli</option>
            </select>
        </div>

        <div class="col-md-3 col-6">
            <input type="text" name="search" class="form-control form-control-sm rounded-3 bg-light border-danger-subtle" placeholder="Cari Kode atau Nama Retribusi..." value="{{ $search }}">
        </div>

        <div class="col-md-2 col-12">
            <button type="submit" class="btn btn-sm btn-red w-100 rounded-3 fw-bold">
                <i class="fas fa-search me-1"></i> Cari Data
            </button>
        </div>
    </form>

    <!-- KPI FILTER SUMMARY -->
    <div class="bg-danger-subtle p-3 rounded-4 mb-4 border border-danger-subtle d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-calculator fa-2x text-danger opacity-75"></i>
            <div>
                <span class="small text-muted fw-bold d-block">Total Nilai Realisasi (Filter Terpilih):</span>
                <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($totalNilai, 0, ',', '.') }}</h4>
            </div>
        </div>
        <span class="badge bg-white text-danger border border-danger px-3 py-2 rounded-pill fw-bold">
            {{ $totalRecord }} Data Item
        </span>
    </div>

    <!-- DATA TABLE -->
    <div class="table-responsive">
        <table class="table table-hover align-middle border">
            <thead class="table-light">
                <tr>
                    <th class="small text-muted">Periode</th>
                    <th class="small text-muted">Kode Rekening</th>
                    <th class="small text-muted">Jenis Retribusi</th>
                    <th class="small text-muted">Instansi / OPD</th>
                    <th class="small text-muted">Nilai Realisasi</th>
                    <th class="small text-muted text-center" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                    <tr>
                        <td><span class="badge bg-light text-dark border">{{ $row->periode }}</span></td>
                        <td class="fw-bold text-danger">{{ $row->kode_rekening }}</td>
                        <td class="fw-semibold">{{ $row->nama_retribusi }}</td>
                        <td class="small text-muted">{{ $row->opd_name }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($row->nilai, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $row->id }}" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('realisasi.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin menghapus catatan realisasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus Data">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0">
                                <div class="modal-header bg-danger text-white rounded-top-4">
                                    <h6 class="modal-title fw-bold"><i class="fas fa-file-invoice me-2"></i> Detail Catatan Realisasi</h6>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td class="text-muted small">Kode Rekening:</td>
                                            <td class="fw-bold text-danger">{{ $row->kode_rekening }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small">Jenis Retribusi:</td>
                                            <td class="fw-semibold">{{ $row->nama_retribusi }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small">Instansi OPD:</td>
                                            <td>{{ $row->opd_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small">Periode / Tahun:</td>
                                            <td>{{ $row->periode }} {{ $row->tahun }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small">Nilai Realisasi:</td>
                                            <td class="fw-bold text-success fs-5">Rp {{ number_format($row->nilai, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small">Diinput Pada:</td>
                                            <td class="small text-muted">{{ $row->created_at->format('d F Y, H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer bg-light rounded-bottom-4">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0">
                                <form action="{{ route('realisasi.update', $row->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-warning text-dark rounded-top-4">
                                        <h6 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> Edit Data Realisasi</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Kode Rekening</label>
                                            <input type="text" name="kode_rekening" class="form-control rounded-3" value="{{ $row->kode_rekening }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Nama Retribusi</label>
                                            <input type="text" name="nama_retribusi" class="form-control rounded-3" value="{{ $row->nama_retribusi }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Nilai Realisasi (Rp)</label>
                                            <input type="number" name="nilai" class="form-control rounded-3 fw-bold text-success" value="{{ $row->nilai }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light rounded-bottom-4">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-sm btn-danger fw-bold">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                            Tidak ada data realisasi yang cocok dengan kriteria filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-end mt-3">
        {{ $data->links() }}
    </div>
</div>
@endsection
