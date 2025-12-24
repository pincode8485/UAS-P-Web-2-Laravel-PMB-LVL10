<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_dokumen',
        'pendaftar_id', // <--- ADD THIS
        'file_path',
        'path_file',    // Make sure this is here too if you use it
        'nama_dokumen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}