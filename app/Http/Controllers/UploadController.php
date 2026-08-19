<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\RealisasiRetribusi;
use App\Models\UploadRetribusi;
use App\Services\PdfParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    protected $parserService;

    public function __construct(PdfParserService $parserService)
    {
        $this->parserService = $parserService;
    }

    public function index()
    {
        $user = Auth::user();
        $opdList = [
            'Dinas Perhubungan',
            'Dinas Perdagangan',
            'Dinas Perkim',
            'Dinas Lingkungan Hidup',
            'Dinas Kesehatan',
            'Dinas Pariwisata & Kebudayaan',
        ];

        return view('upload.index', compact('user', 'opdList'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'opd_name' => 'required|string',
            'periode' => 'required|string',
            'tahun' => 'required|integer',
            'file_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        $user = Auth::user();
        $file = $request->file('file_pdf');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . str_replace(' ', '_', $originalName);

        $destinationPath = public_path('uploads');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $filename;
        $file->move($destinationPath, $filename);

        // Extract Data via PdfParserService
        $parsed = $this->parserService->extractData($fullPath, $request->opd_name, $request->periode);

        // Create upload header record
        $uploadRecord = UploadRetribusi::create([
            'user_id' => $user->id,
            'filename' => $filename,
            'original_filename' => $originalName,
            'tahun' => $request->tahun,
            'periode' => $request->periode,
            'opd_name' => $request->opd_name,
            'total_nilai' => $parsed['total_nilai'],
            'total_item' => $parsed['total_items'],
            'status' => 'Processing',
            'keterangan' => 'Menunggu konfirmasi validasi pengguna',
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action' => 'UPLOAD_PDF',
            'details' => "Mengunggah berkas PDF {$originalName} untuk OPD {$request->opd_name} ({$request->periode})",
            'ip_address' => $request->ip(),
        ]);

        return view('upload.preview', [
            'upload' => $uploadRecord,
            'parsedItems' => $parsed['items'],
            'opd_name' => $request->opd_name,
            'periode' => $request->periode,
            'tahun' => $request->tahun,
            'user' => $user,
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'upload_id' => 'required|exists:upload_retribusis,id',
            'kode_rekening' => 'required|array',
            'nama_retribusi' => 'required|array',
            'nilai' => 'required|array',
        ]);

        $user = Auth::user();
        $upload = UploadRetribusi::findOrFail($request->upload_id);

        $totalVal = 0;
        $count = count($request->kode_rekening);

        for ($i = 0; $i < $count; $i++) {
            $val = (float) str_replace(['.', ','], ['', '.'], $request->nilai[$i]);
            $totalVal += $val;

            RealisasiRetribusi::create([
                'upload_id' => $upload->id,
                'user_id' => $user->id,
                'kode_rekening' => $request->kode_rekening[$i],
                'nama_retribusi' => $request->nama_retribusi[$i],
                'opd_name' => $upload->opd_name,
                'nilai' => $val,
                'periode' => $upload->periode,
                'tahun' => $upload->tahun,
                'tanggal_realisasi' => now()->toDateString(),
            ]);
        }

        // UPDATE STATUS TO 'Success'!
        $upload->update([
            'total_nilai' => $totalVal,
            'total_item' => $count,
            'status' => 'Success',
            'keterangan' => 'Validasi berhasil & data telah tersimpan di database MySQL.',
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action' => 'SAVE_DATABASE',
            'details' => "Data realisasi dari PDF {$upload->original_filename} disetujui & disimpan (Status: SUCCESS, Total: Rp " . number_format($totalVal, 0, ',', '.') . ")",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('realisasi.index')->with('success', 'Data realisasi retribusi berhasil divalidasi & disimpan ke database (Status: SUCCESS)!');
    }
}
