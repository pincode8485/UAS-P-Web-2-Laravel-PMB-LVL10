<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\PendaftarLog;
use App\Models\Prodi; // Import Prodi model for the filter dropdown
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // 1. Show Dashboard with Search, Filter & Sort
    public function index(Request $request)
    {
        // Get all Prodis for the filter dropdown
        $prodis = Prodi::all();

        // Start the Query
        $query = Pendaftar::with(['user', 'prodi', 'dokumen', 'logs.admin']);

        // --- 1. SEARCH BAR LOGIC ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('asal_sekolah', 'like', "%{$search}%")
                  ->orWhere('nomor_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        // --- 2. FILTER BY PRODI ---
        if ($request->filled('filter_prodi')) {
            $query->where('prodi_id', $request->filter_prodi);
        }

        // --- 3. FILTER BY STATUS ---
        if ($request->filled('filter_status')) {
            // Check specifically for 'pending' (null or default) if needed, 
            // but usually status is explicitly stored as 'pending', 'lolos', 'tidak_lolos'
            // If your DB uses NULL for pending, change this logic slightly.
            // Assuming string values:
            $query->where('status_seleksi', $request->filter_status);
        }

        // --- 4. SORTING ---
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'nama_asc':
                    $query->orderBy('nama', 'asc');
                    break;
                case 'nama_desc':
                    $query->orderBy('nama', 'desc');
                    break;
                case 'sekolah_asc':
                    $query->orderBy('asal_sekolah', 'asc');
                    break;
                case 'sekolah_desc':
                    $query->orderBy('asal_sekolah', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default Sort: Newest First
            $query->latest();
        }

        // Execute Query
        $pendaftars = $query->get();

        if ($request->ajax()) {
            return view('admin.pendaftar_table', compact('pendaftars'));
        }

        return view('admin.dashboard', compact('pendaftars', 'prodis'));
    }

    // 2. Verify a Student
    public function verify(Request $request, $id)
    {
        $request->validate(['catatan' => 'required|string']);

        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update(['status_seleksi' => 'lolos']);

        PendaftarLog::create([
            'pendaftar_id' => $pendaftar->id,
            'admin_id' => Auth::id(),
            'action' => 'accepted',
            'reason' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Status updated to Accepted and logged.');
    }

    // 3. Reject a Student
    public function reject(Request $request, $id)
    {
        $request->validate(['catatan' => 'required|string']);

        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update(['status_seleksi' => 'tidak_lolos']);

        PendaftarLog::create([
            'pendaftar_id' => $pendaftar->id,
            'admin_id' => Auth::id(),
            'action' => 'rejected',
            'reason' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Student rejected and reason logged.');
    }
    public function exportPdf(Request $request)
    {
        // 1. Prepare the query (Replicate your dashboard's filtering logic here)
        $query = Pendaftar::with(['prodi', 'user']); // Eager load prodi relationship

        // --- 1. SEARCH BAR LOGIC ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('asal_sekolah', 'like', "%{$search}%")
                  ->orWhere('nomor_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        // --- 2. FILTER BY PRODI ---
        if ($request->filled('filter_prodi')) {
            $query->where('prodi_id', $request->filter_prodi);
        }

        // --- 3. FILTER BY STATUS ---
        if ($request->filled('filter_status')) {
            $query->where('status_seleksi', $request->filter_status);
        }

        // --- 4. SORTING ---
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'nama_asc': $query->orderBy('nama', 'asc'); break;
                case 'nama_desc': $query->orderBy('nama', 'desc'); break;
                case 'sekolah_asc': $query->orderBy('asal_sekolah', 'asc'); break;
                case 'sekolah_desc': $query->orderBy('asal_sekolah', 'desc'); break;
                case 'oldest': $query->orderBy('created_at', 'asc'); break;
                case 'newest':
                default: $query->orderBy('created_at', 'desc'); break;
            }
        } else {
            $query->latest();
        }

        // Get the data
        $data = $query->get();

        // 2. Setup Dompdf options
        $options = new Options();
        $options->set('defaultFont', 'sans-serif');
        $options->set('isRemoteEnabled', true); // Enable if you have images/css from URLs

        // 3. Instantiate Dompdf
        $dompdf = new Dompdf($options);

        // Get Filter Name for Title (Optional)
        $filter_prodi_name = null;
        if ($request->filled('filter_prodi')) {
            $prodi = Prodi::find($request->filter_prodi);
            if ($prodi) $filter_prodi_name = $prodi->nama_prodi;
        }

        // 4. Load HTML content
        // Create a separate blade view for the PDF layout (e.g., resources/views/admin/pdf_export.blade.php)
        $html = view('admin.pdf_export', [
            'students' => $data,
            'filter_prodi' => $filter_prodi_name
        ])->render();

        $dompdf->loadHtml($html);

        // 5. Setup paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // 6. Render the PDF
        $dompdf->render();

        // 7. Stream the file to the browser
        $fileName = date('Y-d-m-H.i') . '_PMB.pdf';
        return $dompdf->stream($fileName, ['Attachment' => true]); // Set Attachment to true to force download
    }
}