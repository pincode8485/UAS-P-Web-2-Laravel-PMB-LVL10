<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prodi; // Import the Model

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 sample majors for the dropdown
        Prodi::create([
            'nama_prodi' => 'Sistem Informasi', 
            'jenjang' => 'S1',
            'kuota' => 100
        ]);
        
        Prodi::create([
            'nama_prodi' => 'Teknik Informatika', 
            'jenjang' => 'S1',
            'kuota' => 120
        ]);
        
        Prodi::create([
            'nama_prodi' => 'Manajemen Bisnis', 
            'jenjang' => 'S1',
            'kuota' => 80
        ]);
        
        Prodi::create([
            'nama_prodi' => 'Komputerisasi Akuntansi', 
            'jenjang' => 'D3',
            'kuota' => 60
        ]);

        Prodi::create([
            'nama_prodi' => 'Desain Komunikasi Visual', 
            'jenjang' => 'S1',
            'kuota' => 90
        ]);
    }
}