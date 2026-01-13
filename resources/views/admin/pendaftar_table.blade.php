<table class="min-w-full text-left text-sm">
    <thead class="bg-gray-100 text-gray-600 uppercase font-bold">
        <tr>
            <th class="px-6 py-3">No</th>
            <th class="px-6 py-3">Nama Lengkap</th>
            <th class="px-6 py-3">Prodi Pilihan</th>
            <th class="px-6 py-3">Asal Sekolah</th>
            <th class="px-6 py-3 text-center">Status</th>
            <th class="px-6 py-3 text-center">Aksi</th>
        </tr>
    </thead>
    @foreach($pendaftars as $index => $data)
    {{-- ADDED adminNote state to x-data --}}
    <tbody x-data="{ open: false, adminNote: '' }" class="border-b hover:bg-gray-50 transition duration-150">
        {{-- MAIN ROW --}}
        <tr class="cursor-pointer" @click="open = !open">
            <td class="px-6 py-4 font-medium text-gray-900 text-center">{{ $index + 1 }}</td>
            <td class="px-6 py-4">
                <div class="font-bold text-gray-900">{{ $data->nama }}</div>
                <div class="text-xs text-gray-500">{{ $data->user->email ?? '-' }}</div>
            </td>
            <td class="px-6 py-4 text-sm">
                <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs font-bold">{{ $data->prodi->nama_prodi ?? 'Belum Pilih Prodi' }}</span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ $data->asal_sekolah }}</td>
            <td class="px-6 py-4 text-center">
                @if($data->status_seleksi == 'lolos')
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold shadow-sm">DITERIMA</span>
                @elseif($data->status_seleksi == 'tidak_lolos')
                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold shadow-sm">DITOLAK</span>
                @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold shadow-sm">PENDING</span>
                @endif
            </td>
            <td class="px-6 py-4 text-center">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition text-xs font-bold flex items-center justify-center mx-auto">
                    <span x-text="open ? 'Tutup' : 'Review'"></span>
                </button>
            </td>
        </tr>

        {{-- EXPANDED DETAILS --}}
        <tr x-show="open" x-transition class="bg-white border-b border-gray-200">
            <td colspan="6" class="p-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-8">
                    
                    {{-- LEFT COLUMN: BIODATA, HISTORY & ACTION --}}
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 flex flex-col h-full">
                        
                        {{-- SCORE CARD --}}
                        <div class="mb-6 p-4 bg-white border border-gray-200 rounded shadow-sm flex justify-between items-center">
                            <div>
                                <h5 class="font-bold text-gray-800 text-sm">Hasil Ujian Seleksi</h5>
                                <p class="text-xs text-gray-500">Nilai Potensi Akademik</p>
                            </div>
                            @if($data->nilai_ujian !== null)
                                <div class="text-2xl font-bold {{ $data->nilai_ujian >= 60 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $data->nilai_ujian }} <span class="text-sm text-gray-400 font-normal">/100</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic bg-gray-100 px-2 py-1 rounded">Belum Ujian</span>
                            @endif
                        </div>

                        <h4 class="font-bold text-gray-800 mb-6 flex items-center text-lg border-b pb-3">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Review Biodata Peserta
                        </h4>
                        
                        {{-- A. DATA PRIBADI --}}
                        <div class="mb-5">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded mb-3">A. DATA PRIBADI</span>
                            <dl class="space-y-2 text-sm text-gray-700 ml-2">
                                <div class="grid grid-cols-3 gap-4 border-b border-gray-100 pb-1">
                                    <dt class="font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="sm:col-span-2 font-semibold text-gray-900">: {{ $data->nama }}</dd>
                                </div>
                                <div class="grid grid-cols-3 gap-4 border-b border-gray-100 pb-1">
                                    <dt class="font-medium text-gray-500">Tempat Lahir</dt>
                                    <dd class="sm:col-span-2">: {{ $data->tempat_lahir }}</dd>
                                </div>
                                <div class="grid grid-cols-3 gap-4 border-b border-gray-100 pb-1">
                                    <dt class="font-medium text-gray-500">Tanggal Lahir</dt>
                                    <dd class="sm:col-span-2">: {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d F Y') }}</dd>
                                </div>
                                <div class="grid grid-cols-3 gap-4 border-b border-gray-100 pb-1">
                                    <dt class="font-medium text-gray-500">Alamat Lengkap</dt>
                                    <dd class="sm:col-span-2 truncate">: {{ $data->alamat }}</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- B. DATA ORANG TUA --}}
                        <div class="mb-5">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded mb-3">B. DATA ORANG TUA</span>
                            <dl class="space-y-2 text-sm text-gray-700 ml-2">
                                <div class="grid grid-cols-3 gap-4 border-b border-gray-100 pb-1">
                                    <dt class="font-medium text-gray-500">Nama Ayah</dt>
                                    <dd class="sm:col-span-2">: {{ $data->nama_ayah }}</dd>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <dt class="font-medium text-gray-500">Nama Ibu</dt>
                                    <dd class="sm:col-span-2">: {{ $data->nama_ibu }}</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- C. DATA SEKOLAH --}}
                        <div class="mb-5">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded mb-3">C. DATA SEKOLAH & PRODI</span>
                            <dl class="space-y-2 text-sm text-gray-700 ml-2">
                                <div class="grid grid-cols-3 gap-4 border-b border-gray-100 pb-1">
                                    <dt class="font-medium text-gray-500">Asal Sekolah</dt>
                                    <dd class="sm:col-span-2">: {{ $data->asal_sekolah }}</dd>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <dt class="font-medium text-gray-500">Pilihan Prodi</dt>
                                    <dd class="sm:col-span-2 font-bold text-blue-800">: {{ $data->prodi->nama_prodi ?? 'Belum Dipilih' }}</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- CATATAN ADMIN (REQUIRED) --}}
                        <div class="mt-auto pt-4 border-t border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Catatan Admin <span class="text-red-500">*</span>
                                <span class="text-xs font-normal text-gray-400 ml-1">(Wajib diisi untuk memproses)</span>
                            </label>
                            <textarea 
                                x-model="adminNote"
                                name="catatan" 
                                form="form-verify-{{ $data->id }}" 
                                class="w-full text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 mb-3" 
                                rows="3" 
                                placeholder="Tulis alasan diterima atau ditolak..."></textarea>
                                
                            {{-- HIDDEN TEXTAREA FOR REJECT FORM TO SYNC --}}
                            <textarea x-model="adminNote" name="catatan" form="form-reject-{{ $data->id }}" class="hidden"></textarea>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div>
                            @if($data->nilai_ujian === null)
                                {{-- STATE 1: UJIAN BELUM SELESAI --}}
                                <div class="bg-gray-100 text-gray-500 text-center py-3 rounded text-sm font-bold border border-gray-300 cursor-not-allowed">
                                    Peserta belum menyelesaikan ujian
                                </div>
                            @else
                                {{-- STATE 2: UJIAN SELESAI --}}
                                <div class="flex gap-4">
                                    {{-- FORM TERIMA --}}
                                    <form id="form-verify-{{ $data->id }}" action="{{ route('admin.verify', $data->id) }}" method="POST" onsubmit="return confirm('Terima?');" class="flex-1">
                                        @csrf @method('PATCH')
                                        <button 
                                            type="submit" 
                                            :disabled="!adminNote"
                                            :class="!adminNote ? 'bg-gray-300 cursor-not-allowed text-gray-500' : 'bg-green-600 hover:bg-green-700 text-white shadow'"
                                            class="w-full py-3 rounded font-bold text-sm uppercase tracking-wider transition">
                                            TERIMA
                                        </button>
                                    </form>

                                    {{-- FORM TOLAK --}}
                                    <form id="form-reject-{{ $data->id }}" action="{{ route('admin.reject', $data->id) }}" method="POST" onsubmit="return confirm('Tolak?');" class="flex-1">
                                        @csrf @method('PATCH')
                                        <button 
                                            type="submit" 
                                            :disabled="!adminNote"
                                            :class="!adminNote ? 'bg-gray-300 cursor-not-allowed text-gray-500' : 'bg-red-600 hover:bg-red-700 text-white shadow'"
                                            class="w-full py-3 rounded font-bold text-sm uppercase tracking-wider transition">
                                            TOLAK
                                        </button>
                                    </form>
                                </div>
                                <p x-show="!adminNote" class="text-xs text-red-500 mt-2 text-center">
                                    * Harap isi Catatan Admin terlebih dahulu.
                                </p>
                            @endif
                        </div>

                    </div> {{-- END LEFT COLUMN --}}

                    {{-- RIGHT COLUMN: FILES & STATUS HISTORY --}}
                    <div class="flex flex-col h-full">
                        
                        {{-- VERIFIKASI BERKAS --}}
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-800 mb-3 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                Verifikasi Berkas
                            </h4>
                            
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                @php
                                    $uploads = $data->dokumen->pluck('file_path', 'jenis_dokumen')->toArray();
                                    $docLabels = ['ktp' => 'KTP', 'kk' => 'KARTU KELUARGA', 'ijazah' => 'IJAZAH', 'transkrip' => 'TRANSKRIP', 'foto' => 'PAS FOTO'];
                                @endphp
                                
                                <ul class="space-y-3">
                                    @foreach($docLabels as $key => $label)
                                        <li class="flex items-center justify-between p-3 rounded border {{ isset($uploads[$key]) ? 'bg-green-50 border-green-100' : 'bg-red-50 border-red-100' }}">
                                            <span class="text-gray-700 font-bold text-xs uppercase">{{ $label }}</span>
                                            @if(isset($uploads[$key]))
                                                <div class="flex items-center">
                                                    @php
                                                        $path = asset('storage/' . $uploads[$key]);
                                                        $ext = pathinfo($uploads[$key], PATHINFO_EXTENSION);
                                                        $isImage = in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']);
                                                    @endphp
                                                    @if($isImage)
                                                        <img src="{{ $path }}" class="w-10 h-10 object-cover rounded border cursor-pointer mr-3 hover:opacity-75 transition" @click="showModal = true; modalImageUrl = '{{ $path }}'">
                                                    @else
                                                        <a href="{{ $path }}" target="_blank" class="mr-3 flex items-center justify-center w-10 h-10 bg-gray-200 rounded text-gray-500 hover:bg-gray-300">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                        </a>
                                                    @endif
                                                    <span class="text-green-600 font-bold text-xs flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Ada</span>
                                                </div>
                                            @else
                                                <span class="text-red-500 font-bold text-xs">Kosong</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- STATUS & RIWAYAT (FILLING THE RED BOX IN RIGHT COLUMN) --}}
                        <div class="mb-6 flex-grow">
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm h-full flex flex-col">
                                <h4 class="font-bold text-gray-800 mb-4 flex items-center text-sm uppercase tracking-wide">
                                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Status & Riwayat
                                </h4>
                                
                                {{-- LOG HISTORY SCROLLABLE AREA --}}
                                <div class="flex-grow space-y-4 overflow-y-auto max-h-60 pr-2">
                                    {{-- If logs exist, show them --}}
                                    @if($data->logs && $data->logs->count() > 0)
                                        @foreach($data->logs as $log)
                                            <div class="flex items-start bg-gray-50 p-3 rounded border border-gray-100">
                                                <div class="flex-shrink-0 h-6 w-6 rounded-full {{ $log->action == 'accepted' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center mt-0.5">
                                                    @if($log->action == 'accepted')
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    @else
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    @endif
                                                </div>
                                                <div class="ml-3 text-xs">
                                                    <p class="font-bold text-gray-700">
                                                        [{{ $log->created_at->format('d/m/Y H:i') }}] {{ $log->admin->name ?? 'Admin' }}
                                                    </p>
                                                    <p class="text-gray-600 mt-1">
                                                        changed status to 
                                                        <span class="font-bold uppercase {{ $log->action == 'accepted' ? 'text-green-600' : 'text-red-600' }}">{{ $log->action }}</span>
                                                    </p>
                                                    <p class="text-gray-500 italic mt-1">"{{ $log->reason }}"</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4 text-gray-400 italic text-xs">Belum ada riwayat perubahan status.</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- HUBUNGI PESERTA (RIGHT COLUMN) --}}
                        <div>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 shadow-sm w-full">
                                <h4 class="font-bold text-blue-800 mb-4 flex items-center text-sm uppercase tracking-wide">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Hubungi Calon Mahasiswa
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $data->telepon)) }}" target="_blank" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded text-sm font-bold shadow transition">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        WhatsApp
                                    </a>
                                    <a href="mailto:{{ $data->user->email }}" class="flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white py-3 px-4 rounded text-sm font-bold shadow transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        Email
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div> {{-- END RIGHT COLUMN --}}
                </div>
            </td>
        </tr>
    </tbody>
    @endforeach
</table>
<!-- Place this right below your table HTML -->
<div class="mt-3 mb-3">
    <a href="{{ route('admin.export.pdf', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Export PDF
    </a>
</div>