<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PendaftarController;
use App\Models\Pendaftar; // <--- CRITICAL IMPORT

// --- PUBLIC PAGE ---
Route::get('/', function () {
    return view('welcome');
});

// --- LOGIN REDIRECT ---
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('camaba.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- AREA ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Export Routes
    Route::get('/admin/export/excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/admin/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');

    Route::patch('/admin/verify/{id}', [AdminController::class, 'verify'])->name('admin.verify');
    Route::patch('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
});

// --- AREA CALON MAHASISWA (CAMABA) ---
Route::middleware(['auth', 'role:camaba'])->group(function () {
    
   // Dashboard Route
    Route::get('/camaba/dashboard', function () {
        $user = Auth::user();
        
        // 1. Fetch the data
        $data = \App\Models\Pendaftar::where('user_id', $user->id)->first(); 
        
        // 2. Send it as 'pendaftaran' (THIS IS WHAT YOUR VIEW WANTS)
        return view('camaba.dashboard', [
            'pendaftaran' => $data,  // <--- Changed from 'pendaftar' to 'pendaftaran'
            'user' => $user
        ]);
    })->name('camaba.dashboard');
        
    // Registration (Step 1)
    Route::get('/register-pmb', [PendaftarController::class, 'create'])->name('pendaftaran.create');
    Route::post('/register-pmb', [PendaftarController::class, 'store'])->name('pendaftaran.store');

    // Upload (Step 2)
    Route::get('/upload-dokumen', [PendaftarController::class, 'upload'])->name('dokumen.upload');
    Route::post('/upload-dokumen', [PendaftarController::class, 'storeFile'])->name('dokumen.store');
    Route::delete('/upload-dokumen/{jenis}', [PendaftarController::class, 'destroyFile'])->name('dokumen.destroy');
    Route::post('/upload-dokumen/submit', [PendaftarController::class, 'submitDokumen'])->name('dokumen.submit');

    // Exam (Step 3)
    Route::get('/ujian-seleksi', [PendaftarController::class, 'showUjian'])->name('ujian.show');
    Route::post('/ujian-seleksi', [PendaftarController::class, 'submitUjian'])->name('ujian.submit');
});

// --- PROFILE ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';