<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\DokumenUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftarController extends Controller
{
    // 1. Show Registration Form
    public function create()
    {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        return view('camaba.pendaftaran', compact('pendaftar'));
    }

    // 2. Save Registration Data (Step 1)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'asal_sekolah' => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        $regNumber = $pendaftar ? $pendaftar->nomor_pendaftaran : 'REG-' . mt_rand(1000000, 9999999);

        Pendaftar::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nomor_pendaftaran' => $regNumber,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'asal_sekolah' => $request->asal_sekolah,
                'prodi_id' => $request->prodi_id,
                'step_1_completed' => true, 
            ]
        );

        return redirect()->route('camaba.dashboard')->with('success', 'Formulir berhasil disimpan!');
    }

    // 3. Show Upload Page (Step 2)
    public function upload()
    {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        
        if (!$pendaftar) {
            return redirect()->route('pendaftaran.create')->with('error', 'Silakan isi formulir pendaftaran dulu.');
        }

        $uploads = DokumenUpload::where('user_id', Auth::id())
                    ->pluck('file_path', 'jenis_dokumen')
                    ->toArray();

        return view('camaba.upload', compact('pendaftar', 'uploads'));
    }

    // 4. Handle Single File Upload
    public function storeFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'jenis_dokumen' => 'required|string'
        ]);

        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();

        if (!$pendaftar) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $file = $request->file('file');
        $filename = time() . '_' . $request->jenis_dokumen . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $filename, 'public');

        DokumenUpload::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'jenis_dokumen' => $request->jenis_dokumen
            ],
            [
                'pendaftar_id' => $pendaftar->id,
                'file_path' => $path,
                'path_file' => $path, 
                'nama_dokumen' => $file->getClientOriginalName(),
            ]
        );

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
    }

    // 5. Final Submit (Step 2 Complete)
    public function submitDokumen()
    {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();
        $pendaftar->update(['step_2_submitted' => true]);

        return redirect()->route('camaba.dashboard')->with('success', 'Berkas terkirim! Silakan lanjut ke tahap Ujian Seleksi.');
    }

    // --- NEW EXAM FUNCTIONS ---

    // 6. Show Exam Page
    public function showUjian()
    {
        $pendaftar = Pendaftar::where('user_id', Auth::id())->first();

        // Security Checks
        if (!$pendaftar || !$pendaftar->step_2_submitted) {
            return redirect()->route('camaba.dashboard')->with('error', 'Selesaikan upload berkas terlebih dahulu.');
        }

        if ($pendaftar->nilai_ujian !== null) {
            return redirect()->route('camaba.dashboard')->with('error', 'Anda sudah mengerjakan ujian.');
        }

        return view('camaba.ujian');
    }

    // 7. Grade and Submit Exam
    public function submitUjian(Request $request)
    {
        // Grading Logic (Answers: 1=A, 2=C, 3=B, 4=D, 5=A)
        $score = 0;
        
        if ($request->q1 == 'a') $score += 20;
        if ($request->q2 == 'c') $score += 20;
        if ($request->q3 == 'b') $score += 20;
        if ($request->q4 == 'd') $score += 20;
        if ($request->q5 == 'a') $score += 20;

        Pendaftar::where('user_id', Auth::id())->update(['nilai_ujian' => $score]);

        return redirect()->route('camaba.dashboard')->with('success', 'Ujian selesai! Nilai Anda telah dikirim ke Admin.');
    }
    // --------------------------

    public function destroyFile($jenis_dokumen)
    {
        $dokumen = DokumenUpload::where('user_id', Auth::id())
                    ->where('jenis_dokumen', $jenis_dokumen)
                    ->first();

        if ($dokumen) {
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $dokumen->delete();
            return back()->with('success', 'Dokumen berhasil dihapus.');
        }
        return back()->with('error', 'Dokumen tidak ditemukan.');
    }
}