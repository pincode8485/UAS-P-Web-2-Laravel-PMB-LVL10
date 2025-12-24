<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_prodi', 'jenjang', 'kuota'];
    
    // Relasi: One Prodi has many Pendaftar
    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class);
    }
}