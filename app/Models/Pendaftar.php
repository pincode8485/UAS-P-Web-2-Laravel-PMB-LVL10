<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_pendaftaran',
        'nama', 
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'telepon',
        'nama_ayah',
        'nama_ibu',
        'asal_sekolah',
        'prodi_id',
        'status_seleksi',
        'step_1_completed',
        'step_2_submitted',
        'nilai_ujian',
    ];

    protected $casts = [
        'step_1_completed' => 'boolean',
        'step_2_submitted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // This is the critical relationship for the Table Column 'pendaftar.prodi.nama_prodi'
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenUpload::class, 'pendaftar_id');
    }

    public function logs()
    {
        return $this->hasMany(PendaftarLog::class)->latest();
    }
}