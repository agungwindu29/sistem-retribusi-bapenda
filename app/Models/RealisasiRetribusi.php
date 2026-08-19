<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiRetribusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'upload_id',
        'user_id',
        'kode_rekening',
        'nama_retribusi',
        'opd_name',
        'nilai',
        'periode',
        'tahun',
        'tanggal_realisasi',
    ];

    public function upload()
    {
        return $this->belongsTo(UploadRetribusi::class, 'upload_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
