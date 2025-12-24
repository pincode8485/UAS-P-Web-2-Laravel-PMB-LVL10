<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarLog extends Model
{
    use HasFactory;

    protected $fillable = ['pendaftar_id', 'admin_id', 'action', 'reason'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}