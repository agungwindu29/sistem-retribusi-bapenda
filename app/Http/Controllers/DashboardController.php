<?php

namespace App\Http\Controllers;

use App\Models\RealisasiRetribusi;
use App\Models\UploadRetribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tahun = $request->input('tahun', 2026);
        $isAdmin = $user->isAdmin();

        // Strict Query Scoping
        $queryRealisasi = RealisasiRetribusi::where('tahun', $tahun);
        $queryUpload = UploadRetribusi::where('tahun', $tahun);

        if (!$isAdmin) {
            // Strict OPD isolation
            $queryRealisasi->where('opd_name', $user->opd_name);
            $queryUpload->where('opd_name', $user->opd_name);
        }

        // Stats summary
        $totalRealisasiBulanIni = (clone $queryRealisasi)->where('periode', 'like', '%Agustus%')->sum('nilai');
        $totalRealisasiTahun = (clone $queryRealisasi)->sum('nilai');
        $totalDokumenUploaded = (clone $queryUpload)->count();
        $totalOpdAktif = $isAdmin ? RealisasiRetribusi::distinct('opd_name')->count('opd_name') : 1;

        // Chart Data 1: Bulanan (Jan - Des)
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $chartBulanan = [];
        foreach ($bulanList as $bulan) {
            $val = (clone $queryRealisasi)->where('periode', 'like', "%{$bulan}%")->sum('nilai');
            $chartBulanan[] = (float) $val;
        }

        // Chart Data 2: Distribusi per OPD
        $opdChartLabels = [];
        $opdChartData = [];
        if ($isAdmin) {
            $byOpd = RealisasiRetribusi::where('tahun', $tahun)
                ->selectRaw('opd_name, SUM(nilai) as total')
                ->groupBy('opd_name')
                ->get();
            foreach ($byOpd as $row) {
                $opdChartLabels[] = $row->opd_name;
                $opdChartData[] = (float) $row->total;
            }
        } else {
            $byJenis = RealisasiRetribusi::where('tahun', $tahun)
                ->where('opd_name', $user->opd_name)
                ->selectRaw('nama_retribusi, SUM(nilai) as total')
                ->groupBy('nama_retribusi')
                ->get();
            foreach ($byJenis as $row) {
                $opdChartLabels[] = $row->nama_retribusi;
                $opdChartData[] = (float) $row->total;
            }
        }

        // Recent Uploads
        $recentUploads = (clone $queryUpload)->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard.index', compact(
            'user',
            'tahun',
            'isAdmin',
            'totalRealisasiBulanIni',
            'totalRealisasiTahun',
            'totalDokumenUploaded',
            'totalOpdAktif',
            'bulanList',
            'chartBulanan',
            'opdChartLabels',
            'opdChartData',
            'recentUploads'
        ));
    }
}
