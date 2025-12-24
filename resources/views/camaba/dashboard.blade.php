<x-app-layout>
    {{-- ALPINE.JS STATE FOR MODAL --}}
    <div x-data="{ showModal: false, modalImageUrl: '' }">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Calon Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ========================================== --}}
            {{-- ANNOUNCEMENT ALERT SECTION --}}
            {{-- ========================================== --}}
            @if(isset($pendaftaran))
                {{-- 1. STATUS: DITERIMA --}}
                @if($pendaftaran->status_seleksi == 'lolos')
                <div class="bg-green-50 border-l-8 border-green-500 rounded-lg shadow-lg p-6 mb-8 transition transform hover:scale-[1.01] duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-green-800">SELAMAT! ANDA DITERIMA.</h3>
                            <p class="text-green-700 mt-1">
                                Halo <strong>{{ $pendaftaran->nama }}</strong>, selamat bergabung di Program Studi 
                                <span class="font-bold underline">{{ $pendaftaran->prodi->nama_prodi ?? 'Pilihan Anda' }}</span>.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 2. STATUS: DITOLAK --}}
                @elseif($pendaftaran->status_seleksi == 'tidak_lolos')
                <div class="bg-red-50 border-l-8 border-red-500 rounded-lg shadow-lg p-6 mb-8">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-red-800">MOHON MAAF.</h3>
                            <p class="text-red-700 mt-1">
                                Halo <strong>{{ $pendaftaran->nama }}</strong>, berdasarkan hasil seleksi administrasi, Anda dinyatakan <strong>TIDAK LOLOS</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 3. STATUS: SEDANG DIPROSES --}}
                @elseif($pendaftaran->step_2_submitted)
                <div class="bg-yellow-50 border-l-8 border-yellow-400 rounded-lg shadow-sm p-6 mb-8">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-full mr-4 flex-shrink-0">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-yellow-800">BERKAS SEDANG DIVERIFIKASI</h3>
                            <p class="text-yellow-700 mt-1">
                                Data Anda sedang diperiksa oleh Admin. Mohon cek secara berkala untuk hasil seleksi.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            @endif


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-6">Welcome, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {{-- LEFT COLUMN: CONTENT --}}
                        <div class="lg:col-span-2 space-y-6">
                            
                            {{-- ACTION CARDS --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Card 1: Formulir --}}
                                <div class="p-4 border rounded shadow hover:bg-gray-50 relative">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold">Formulir Pendaftaran</h4>
                                            <p class="text-sm text-gray-600 mb-4">Isi data diri dan formulir pendaftaran.</p>
                                        </div>
                                        @if(isset($pendaftaran) && $pendaftaran->step_1_completed)
                                            <span class="text-green-500 bg-green-100 p-1 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></span>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        @if(isset($pendaftaran) && $pendaftaran->step_1_completed)
                                            <a href="{{ route('pendaftaran.create') }}" class="flex items-center text-yellow-600 hover:text-yellow-700 font-bold text-sm">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg> Edit Data
                                            </a>
                                        @else
                                            <a href="{{ route('pendaftaran.create') }}" class="text-blue-600 hover:underline font-semibold text-sm">Go to Registration &rarr;</a>
                                        @endif
                                    </div>
                                </div>

                                {{-- Card 2: Upload --}}
                                <div class="p-4 border rounded shadow hover:bg-gray-50 relative">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold">Upload Dokumen</h4>
                                            <p class="text-sm text-gray-600 mb-4">Upload 5 berkas persyaratan.</p>
                                        </div>
                                        @if(isset($pendaftaran) && $pendaftaran->step_2_submitted)
                                            <span class="text-green-500 bg-green-100 p-1 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></span>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        @if(isset($pendaftaran) && $pendaftaran->step_2_submitted)
                                            <a href="{{ route('dokumen.upload') }}" class="flex items-center text-yellow-600 hover:text-yellow-700 font-bold text-sm">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg> Update Dokumen
                                            </a>
                                        @else
                                            <a href="{{ route('dokumen.upload') }}" class="text-blue-600 hover:underline font-semibold text-sm">Go to Uploads &rarr;</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 text-sm">
                                <p class="font-bold">Informasi Penting:</p>
                                <p>Pastikan data benar. Anda dapat mengedit data kapan saja sebelum pengumuman final.</p>
                            </div>

                            {{-- PREVIEW SECTION (RESTORED FULL DATA) --}}
                            <div class="bg-white border rounded-lg shadow-sm p-6">
                                <h4 class="font-bold text-gray-800 text-lg mb-4 border-b pb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Preview Data & Dokumen
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    {{-- Data Text --}}
                                    <div class="md:col-span-2">
                                        @if(isset($pendaftaran))
                                            {{-- A. Data Pribadi --}}
                                            <div class="mb-5">
                                                <h5 class="font-bold text-blue-600 mb-2 text-xs uppercase tracking-wider bg-blue-50 p-1 inline-block rounded">A. Data Pribadi</h5>
                                                <dl class="space-y-2 text-sm text-gray-700">
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 border-b border-gray-50 pb-1">
                                                        <dt class="font-medium text-gray-500">Nama Lengkap</dt>
                                                        <dd class="sm:col-span-2 font-semibold text-gray-900">: {{ $pendaftaran->nama }}</dd>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 border-b border-gray-50 pb-1">
                                                        <dt class="font-medium text-gray-500">Tempat Lahir</dt>
                                                        <dd class="sm:col-span-2">: {{ $pendaftaran->tempat_lahir }}</dd>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 border-b border-gray-50 pb-1">
                                                        <dt class="font-medium text-gray-500">Tanggal Lahir</dt>
                                                        <dd class="sm:col-span-2">: {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d F Y') }}</dd>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 border-b border-gray-50 pb-1">
                                                        <dt class="font-medium text-gray-500">Alamat Lengkap</dt>
                                                        <dd class="sm:col-span-2">: {{ $pendaftaran->alamat }}</dd>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 pb-1">
                                                        <dt class="font-medium text-gray-500">Nomor Telepon / WA</dt>
                                                        <dd class="sm:col-span-2">: {{ $pendaftaran->telepon }}</dd>
                                                    </div>
                                                </dl>
                                            </div>

                                            {{-- B. Data Orang Tua --}}
                                            <div class="mb-5">
                                                <h5 class="font-bold text-blue-600 mb-2 text-xs uppercase tracking-wider bg-blue-50 p-1 inline-block rounded">B. Data Orang Tua</h5>
                                                <dl class="space-y-2 text-sm text-gray-700">
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 border-b border-gray-50 pb-1">
                                                        <dt class="font-medium text-gray-500">Nama Ayah</dt>
                                                        <dd class="sm:col-span-2">: {{ $pendaftaran->nama_ayah }}</dd>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 pb-1">
                                                        <dt class="font-medium text-gray-500">Nama Ibu</dt>
                                                        <dd class="sm:col-span-2">: {{ $pendaftaran->nama_ibu }}</dd>
                                                    </div>
                                                </dl>
                                            </div>

                                            {{-- C. Sekolah --}}
                                            <div class="mb-2">
                                                <h5 class="font-bold text-blue-600 mb-2 text-xs uppercase tracking-wider bg-blue-50 p-1 inline-block rounded">C. Data Sekolah & Prodi</h5>
                                                <dl class="space-y-2 text-sm text-gray-700">
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 border-b border-gray-50 pb-1">
                                                        <dt class="font-medium text-gray-500">Asal Sekolah</dt>
                                                        <dd class="sm:col-span-2">: {{ $pendaftaran->asal_sekolah }}</dd>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 pb-1">
                                                        <dt class="font-medium text-gray-500">Pilihan Prodi</dt>
                                                        <dd class="sm:col-span-2 font-bold text-blue-800">: {{ $pendaftaran->prodi->nama_prodi ?? 'Belum Dipilih' }}</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        @else
                                            <div class="p-6 bg-gray-50 rounded text-center text-sm text-gray-400 italic border border-dashed border-gray-300">
                                                Belum mengisi formulir.
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Dokumen Status with Thumbnails & Modal Trigger --}}
                                    <div class="border-l pl-0 md:pl-8 border-gray-100">
                                        <h5 class="font-bold text-gray-500 mb-3 text-xs uppercase tracking-wider">Status Dokumen</h5>
                                        @php
                                            $previewUploads = \App\Models\DokumenUpload::where('user_id', Auth::id())->pluck('file_path', 'jenis_dokumen')->toArray();
                                            $docsList = ['ktp'=>'KTP', 'kk'=>'Kartu Keluarga', 'ijazah'=>'Ijazah/SKL', 'transkrip'=>'Transkrip', 'foto'=>'Pas Foto'];
                                        @endphp
                                        <ul class="space-y-2 text-sm">
                                            @foreach($docsList as $key => $label)
                                                <li class="flex items-center justify-between p-2 rounded {{ isset($previewUploads[$key]) ? 'bg-green-50' : 'bg-red-50' }}">
                                                    <span class="text-gray-700 font-medium">{{ $label }}</span>
                                                    @if(isset($previewUploads[$key]))
                                                         <div class="flex items-center">
                                                            {{-- THUMBNAIL IMAGE (Click to open modal) --}}
                                                            <img src="{{ asset('storage/' . $previewUploads[$key]) }}" 
                                                                 alt="{{ $label }}" 
                                                                 class="w-10 h-10 object-cover rounded border cursor-pointer mr-2 hover:opacity-75 transition"
                                                                 @click="showModal = true; modalImageUrl = '{{ asset('storage/' . $previewUploads[$key]) }}'">
                                                            
                                                            <span class="text-green-600 font-bold text-xs flex items-center">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                Uploaded
                                                             </span>
                                                         </div>
                                                    @else
                                                        <span class="text-red-500 font-bold text-xs">Missing</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                        <p class="text-xs text-gray-400 mt-2 italic">Klik gambar untuk memperbesar.</p>
                                    </div>
                                </div>
                            </div>
                            {{-- END PREVIEW SECTION --}}

                        </div>

                        {{-- RIGHT COLUMN: SIDEBAR TIMELINE --}}
                        <div class="space-y-6 flex flex-col">
                            <div class="bg-white p-5 border rounded-lg shadow-sm">
                                <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Status Pendaftaran</h4>
                                <ol class="relative border-l border-gray-200 ml-3">                  
                                    {{-- 1. Akun Dibuat --}}
                                    <li class="mb-8 ml-6">
                                        <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>
                                        <h3 class="text-sm font-semibold text-gray-900">Akun Dibuat</h3>
                                        <p class="text-xs text-gray-500">Selesai</p>
                                    </li>

                                    {{-- 2. Formulir --}}
                                    <li class="mb-8 ml-6">
                                        @if(isset($pendaftaran) && $pendaftaran->step_1_completed)
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>
                                            <h3 class="text-sm font-semibold text-gray-900">Formulir Pendaftaran</h3>
                                            <p class="text-xs text-green-600">Lengkap</p>
                                        @else
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-4 ring-white"><span class="w-2.5 h-2.5 bg-blue-600 rounded-full animate-pulse"></span></span>
                                            <h3 class="text-sm font-semibold text-blue-600">Formulir Pendaftaran</h3>
                                            <p class="text-xs text-gray-500">Menunggu pengisian...</p>
                                        @endif
                                    </li>

                                    {{-- 3. Seleksi Berkas --}}
                                    <li class="mb-8 ml-6">
                                        @if(isset($pendaftaran) && $pendaftaran->step_2_submitted)
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>
                                            <h3 class="text-sm font-semibold text-gray-900">Seleksi Berkas</h3>
                                            <p class="text-xs text-green-600">Terupload</p>
                                        @else
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3 ring-4 ring-white"><span class="w-2.5 h-2.5 bg-gray-400 rounded-full"></span></span>
                                            <h3 class="text-sm font-semibold text-gray-500">Seleksi Berkas</h3>
                                            <p class="text-xs text-gray-400">Belum lengkap</p>
                                        @endif
                                    </li>

                                    {{-- 4. Ujian Potensi Akademik (Hidden Score) --}}
                                    <li class="mb-8 ml-6">
                                        @if(isset($pendaftaran) && $pendaftaran->nilai_ujian !== null)
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>
                                            <h3 class="text-sm font-semibold text-gray-900">Ujian Potensi Akademik</h3>
                                            <p class="text-xs text-green-600 font-bold">Selesai</p>
                                        @elseif(isset($pendaftaran) && $pendaftaran->step_2_submitted)
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-yellow-100 rounded-full -left-3 ring-4 ring-white"><span class="w-2.5 h-2.5 bg-yellow-500 rounded-full animate-pulse"></span></span>
                                            <h3 class="text-sm font-semibold text-gray-900">Ujian Potensi Akademik</h3>
                                            <a href="{{ route('ujian.show') }}" class="text-xs text-white bg-yellow-500 px-2 py-1 rounded hover:bg-yellow-600 mt-1 inline-block transition shadow-sm">Mulai Ujian &rarr;</a>
                                        @else
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3 ring-4 ring-white"><span class="w-2.5 h-2.5 bg-gray-400 rounded-full"></span></span>
                                            <h3 class="text-sm font-semibold text-gray-500">Ujian Potensi Akademik</h3>
                                            <p class="text-xs text-gray-400">Terkunci</p>
                                        @endif
                                    </li>

                                    {{-- 5. Admin Memproses --}}
                                    <li class="mb-8 ml-6">
                                        @if(isset($pendaftaran) && ($pendaftaran->status_seleksi == 'lolos' || $pendaftaran->status_seleksi == 'tidak_lolos'))
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>
                                            <h3 class="text-sm font-semibold text-gray-900">Admin Memproses</h3>
                                            <p class="text-xs text-green-600">Selesai</p>
                                        @else
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3 ring-4 ring-white"><span class="w-2.5 h-2.5 bg-gray-400 rounded-full"></span></span>
                                            <h3 class="text-sm font-semibold text-gray-500">Admin Memproses</h3>
                                            <p class="text-xs text-gray-400">Menunggu antrian...</p>
                                        @endif
                                    </li>

                                    {{-- 6. Hasil Kelulusan --}}
                                    <li class="ml-6">
                                        @if(isset($pendaftaran) && $pendaftaran->status_seleksi == 'lolos')
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg></span>
                                            <h3 class="text-sm font-semibold text-gray-900">Hasil Kelulusan</h3>
                                            <p class="text-xs text-green-600 font-bold">LULUS</p>
                                        @elseif(isset($pendaftaran) && $pendaftaran->status_seleksi == 'tidak_lolos')
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-red-100 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></span>
                                            <h3 class="text-sm font-semibold text-gray-900">Hasil Kelulusan</h3>
                                            <p class="text-xs text-red-600 font-bold">TIDAK LULUS</p>
                                        @else
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full -left-3 ring-4 ring-white"><svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg></span>
                                            <h3 class="text-sm font-semibold text-gray-400">Hasil Kelulusan</h3>
                                            <p class="text-xs text-gray-400">Menunggu Pengumuman</p>
                                        @endif
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- FULL SCREEN IMAGE MODAL (ALPINE.JS) --}}
    {{-- ========================================== --}}
    <div x-show="showModal" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4" 
         style="display: none;" 
         x-transition.opacity x-cloak>
        
        {{-- Close Button (Top Right) --}}
        <button @click="showModal = false" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none z-50">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        {{-- Click background to close --}}
        <div class="absolute inset-0" @click="showModal = false"></div>

        {{-- Image Container --}}
        <div class="relative z-10 max-w-4xl max-h-full">
             <img :src="modalImageUrl" class="max-w-full max-h-[90vh] object-contain mx-auto rounded shadow-2xl" alt="Document Fullscreen Preview">
        </div>
    </div>

    </div> {{-- END ALPINE.JS x-data ROOT --}}
</x-app-layout>