@extends('layouts.app')

@section('title', 'Upload Dokumen PDF & Parsing')
@section('page_heading', 'Upload Dokumen Realisasi PDF')

@section('content')
<div class="row">
    <!-- Form Upload (Col-5) -->
    <div class="col-lg-5 col-12 mb-4">
        <div class="card-custom p-4">
            <h6 class="fw-bold text-danger mb-3">
                <i class="fas fa-cloud-upload-alt me-2"></i> Form Pengunggahan PDF Realisasi
            </h6>
            <p class="text-muted small mb-4">Pilih OPD, periode, dan unggah berkas PDF resmi. Sistem akan membaca dan mengoperasikan ekstraksi data secara otomatis.</p>

            <form action="{{ route('upload.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Instansi / Unit OPD</label>
                    <select name="opd_name" class="form-select rounded-3 border-danger-subtle" required>
                        @foreach($opdList as $opd)
                            <option value="{{ $opd }}" {{ ($user->opd_name === $opd) ? 'selected' : '' }}>{{ $opd }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold small text-muted">Periode Bulan</label>
                        <select name="periode" class="form-select rounded-3 border-danger-subtle" required>
                            <option value="Agustus 2026" selected>Agustus 2026</option>
                            <option value="Juli 2026">Juli 2026</option>
                            <option value="Juni 2026">Juni 2026</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold small text-muted">Tahun Anggaran</label>
                        <select name="tahun" class="form-select rounded-3 border-danger-subtle" required>
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                </div>

                <!-- Drag and drop PDF box -->
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">Berkas PDF Realisasi (.pdf)</label>
                    <div class="border border-2 border-danger-subtle rounded-4 p-4 text-center bg-light" id="dropZone" style="border-style: dashed !important;">
                        <i class="fas fa-file-pdf fa-3x text-danger opacity-75 mb-2"></i>
                        <h6 class="fw-bold mb-1">Pilih Berkas atau Seret ke Sini</h6>
                        <small class="text-muted d-block mb-3">Format PDF resmi retribusi daerah (Maksimal 10 MB)</small>
                        <input type="file" name="file_pdf" id="filePdf" class="form-control" accept=".pdf" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-red w-100 py-2 fw-bold shadow-sm">
                    <i class="fas fa-microchip me-2"></i> Ekstraksi Data PDF & Parsing
                </button>
            </form>
        </div>
    </div>

    <!-- Informasi Alur Kerja & Panduan (Col-7) -->
    <div class="col-lg-7 col-12">
        <div class="card-custom p-4">
            <h6 class="fw-bold text-danger mb-3">
                <i class="fas fa-circle-info me-2"></i> Alur Proses Ekstraksi PDF ke Database
            </h6>
            
            <div class="timeline ps-3 border-start border-danger border-2 ms-2">
                <div class="mb-4 position-relative">
                    <span class="badge bg-danger rounded-circle position-absolute" style="left: -26px; top: 0; width: 22px; height: 22px;">1</span>
                    <h6 class="fw-bold mb-1 text-dark">Unggah Berkas PDF</h6>
                    <p class="text-muted small mb-0">Operator OPD mengunggah dokumen PDF rekapitulasi realisasi bulanan.</p>
                </div>
                <div class="mb-4 position-relative">
                    <span class="badge bg-danger rounded-circle position-absolute" style="left: -26px; top: 0; width: 22px; height: 22px;">2</span>
                    <h6 class="fw-bold mb-1 text-dark">Sistem Ekstraksi (Parser Engine)</h6>
                    <p class="text-muted small mb-0">Sistem menganalisis struktur PDF dan mengekstrak Kode Rekening, Nama Retribusi, dan Nilai Realisasi (Rp).</p>
                </div>
                <div class="mb-4 position-relative">
                    <span class="badge bg-danger rounded-circle position-absolute" style="left: -26px; top: 0; width: 22px; height: 22px;">3</span>
                    <h6 class="fw-bold mb-1 text-dark">Preview & Validasi Interaktif</h6>
                    <p class="text-muted small mb-0">Operator memeriksa dan memperbaiki nilai jika ada kesalahan pengetikan sebelum disimpan permanen.</p>
                </div>
                <div class="position-relative">
                    <span class="badge bg-danger rounded-circle position-absolute" style="left: -26px; top: 0; width: 22px; height: 22px;">4</span>
                    <h6 class="fw-bold mb-1 text-dark">Simpan Database & Grafik Audit</h6>
                    <p class="text-muted small mb-0">Data tersimpan di MySQL, siap diekspor ke Excel dan direkap pada Dashboard BAPENDA.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
