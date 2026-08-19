<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadRetribusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filename',
        'original_filename',
        'tahun',
        'periode',
        'opd_name',
        'total_nilai',
        'total_item',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function realisasis()
    {
        return $this->hasMany(RealisasiRetribusi::class, 'upload_id');
    }
}
