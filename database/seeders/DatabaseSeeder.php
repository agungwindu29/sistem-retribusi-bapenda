<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UploadRetribusi;
use App\Models\RealisasiRetribusi;
use App\Models\AuditLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'Administrator BAPENDA',
            'email' => 'admin@retribusi.go.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'opd_name' => 'Badan Pendapatan Daerah',
        ]);

        $userDishub = User::create([
            'name' => 'Operator Dishub',
            'email' => 'dishub@retribusi.go.id',
            'password' => Hash::make('password123'),
            'role' => 'user_opd',
            'opd_name' => 'Dinas Perhubungan',
        ]);

        $userDisdag = User::create([
            'name' => 'Operator Disdag',
            'email' => 'disdag@retribusi.go.id',
            'password' => Hash::make('password123'),
            'role' => 'user_opd',
            'opd_name' => 'Dinas Perdagangan',
        ]);

        $userPerkim = User::create([
            'name' => 'Operator Perkim',
            'email' => 'perkim@retribusi.go.id',
            'password' => Hash::make('password123'),
            'role' => 'user_opd',
            'opd_name' => 'Dinas Perkim',
        ]);

        $userDinkes = User::create([
            'name' => 'Operator Dinkes',
            'email' => 'dinkes@retribusi.go.id',
            'password' => Hash::make('password123'),
            'role' => 'user_opd',
            'opd_name' => 'Dinas Kesehatan',
        ]);

        // 2. Sample Data Realisasi Retribusi 2026
        $seedData = [
            // Dishub
            ['upload_user' => $userDishub, 'opd' => 'Dinas Perhubungan', 'kode' => '4.1.02.01.01', 'nama' => 'Retribusi Parkir Tepi Jalan Umum', 'nilai' => 125000000, 'periode' => 'Juli 2026', 'tahun' => 2026],
            ['upload_user' => $userDishub, 'opd' => 'Dinas Perhubungan', 'kode' => '4.1.02.01.02', 'nama' => 'Retribusi Pengujian Kendaraan Bermotor (Kir)', 'nilai' => 48200000, 'periode' => 'Juli 2026', 'tahun' => 2026],
            ['upload_user' => $userDishub, 'opd' => 'Dinas Perhubungan', 'kode' => '4.1.02.01.01', 'nama' => 'Retribusi Parkir Tepi Jalan Umum', 'nilai' => 135000000, 'periode' => 'Agustus 2026', 'tahun' => 2026],
            ['upload_user' => $userDishub, 'opd' => 'Dinas Perhubungan', 'kode' => '4.1.02.01.03', 'nama' => 'Retribusi Terminal & Markas Angkutan', 'nilai' => 19500000, 'periode' => 'Agustus 2026', 'tahun' => 2026],

            // Disdag
            ['upload_user' => $userDisdag, 'opd' => 'Dinas Perdagangan', 'kode' => '4.1.02.02.01', 'nama' => 'Retribusi Pelayanan Pasar Daerah', 'nilai' => 80500000, 'periode' => 'Juli 2026', 'tahun' => 2026],
            ['upload_user' => $userDisdag, 'opd' => 'Dinas Perdagangan', 'kode' => '4.1.02.02.03', 'nama' => 'Retribusi Sewa Toko & Ruko Pasar', 'nilai' => 62000000, 'periode' => 'Juli 2026', 'tahun' => 2026],
            ['upload_user' => $userDisdag, 'opd' => 'Dinas Perdagangan', 'kode' => '4.1.02.02.01', 'nama' => 'Retribusi Pelayanan Pasar Daerah', 'nilai' => 91000000, 'periode' => 'Agustus 2026', 'tahun' => 2026],

            // Perkim
            ['upload_user' => $userPerkim, 'opd' => 'Dinas Perkim', 'kode' => '4.1.02.03.01', 'nama' => 'Retribusi Persetujuan Bangunan Gedung (PBG)', 'nilai' => 175000000, 'periode' => 'Juli 2026', 'tahun' => 2026],
            ['upload_user' => $userPerkim, 'opd' => 'Dinas Perkim', 'kode' => '4.1.02.03.01', 'nama' => 'Retribusi Persetujuan Bangunan Gedung (PBG)', 'nilai' => 192000000, 'periode' => 'Agustus 2026', 'tahun' => 2026],

            // Dinkes
            ['upload_user' => $userDinkes, 'opd' => 'Dinas Kesehatan', 'kode' => '4.1.02.05.01', 'nama' => 'Retribusi Pelayanan Puskesmas & Labkesda', 'nilai' => 71500000, 'periode' => 'Juli 2026', 'tahun' => 2026],
            ['upload_user' => $userDinkes, 'opd' => 'Dinas Kesehatan', 'kode' => '4.1.02.05.01', 'nama' => 'Retribusi Pelayanan Puskesmas & Labkesda', 'nilai' => 78400000, 'periode' => 'Agustus 2026', 'tahun' => 2026],
        ];

        // Group into sample Upload Header records
        $uploadDishub = UploadRetribusi::create([
            'user_id' => $userDishub->id,
            'filename' => 'REKAP_RETRIBUSI_DISHUB_AUG2026.pdf',
            'original_filename' => 'Realisasi_Dishub_Agustus_2026.pdf',
            'tahun' => 2026,
            'periode' => 'Agustus 2026',
            'opd_name' => 'Dinas Perhubungan',
            'total_nilai' => 154500000,
            'total_item' => 2,
            'status' => 'Success',
            'keterangan' => 'Hasil ekstraksi OCR otomatis - Terverifikasi oleh Operator',
        ]);

        $uploadDisdag = UploadRetribusi::create([
            'user_id' => $userDisdag->id,
            'filename' => 'REKAP_RETRIBUSI_DISDAG_AUG2026.pdf',
            'original_filename' => 'Dokumen_Pasar_Agustus_2026.pdf',
            'tahun' => 2026,
            'periode' => 'Agustus 2026',
            'opd_name' => 'Dinas Perdagangan',
            'total_nilai' => 91000000,
            'total_item' => 1,
            'status' => 'Success',
            'keterangan' => 'Hasil ekstraksi OCR otomatis',
        ]);

        foreach ($seedData as $row) {
            RealisasiRetribusi::create([
                'upload_id' => ($row['opd'] == 'Dinas Perhubungan') ? $uploadDishub->id : (($row['opd'] == 'Dinas Perdagangan') ? $uploadDisdag->id : null),
                'user_id' => $row['upload_user']->id,
                'kode_rekening' => $row['kode'],
                'nama_retribusi' => $row['nama'],
                'opd_name' => $row['opd'],
                'nilai' => $row['nilai'],
                'periode' => $row['periode'],
                'tahun' => $row['tahun'],
                'tanggal_realisasi' => '2026-08-15',
            ]);
        }

        // 3. Seed Audit Logs
        AuditLog::create([
            'user_id' => $admin->id,
            'user_name' => 'Administrator BAPENDA',
            'action' => 'LOGIN',
            'details' => 'Sistem login sebagai Administrator BAPENDA',
            'ip_address' => '127.0.0.1',
        ]);

        AuditLog::create([
            'user_id' => $userDishub->id,
            'user_name' => 'Operator Dishub',
            'action' => 'UPLOAD_PDF',
            'details' => 'Mengupload & mengekstraksi file Realisasi_Dishub_Agustus_2026.pdf (Nilai: Rp 154.500.000)',
            'ip_address' => '127.0.0.1',
        ]);

        AuditLog::create([
            'user_id' => $userDisdag->id,
            'user_name' => 'Operator Disdag',
            'action' => 'VERIFY_DATA',
            'details' => 'Memvalidasi data realisasi retribusi pasar periode Agustus 2026',
            'ip_address' => '127.0.0.1',
        ]);
    }
}
