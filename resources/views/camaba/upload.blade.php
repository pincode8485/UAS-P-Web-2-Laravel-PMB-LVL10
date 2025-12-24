<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Dokumen Persyaratan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6 flex justify-between items-center border-b pb-4">
                    <div>
                        <h3 class="font-bold text-lg">Kelengkapan Berkas</h3>
                        <p class="text-sm text-gray-600">Silakan upload 5 dokumen wajib di bawah ini.</p>
                    </div>
                    <div class="text-right">
                        @php
                            $uploaded_count = count($uploads ?? []);
                            $is_submitted = $pendaftar->step_2_submitted ?? false;
                        @endphp
                        <span class="text-xs font-bold px-2 py-1 bg-blue-100 text-blue-800 rounded">
                            Progress: {{ $uploaded_count }}/5
                        </span>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @php
                    $required_docs = [
                        'ktp' => 'KTP / Kartu Identitas',
                        'kk' => 'Kartu Keluarga',
                        'ijazah' => 'Ijazah Terakhir / SKL',
                        'transkrip' => 'Transkrip Nilai Rapor',
                        'foto' => 'Pas Foto Resmi (3x4)'
                    ];
                @endphp

                <ul class="space-y-4">
                    @foreach($required_docs as $key => $label)
                        <li class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 border rounded-lg {{ isset($uploads[$key]) ? 'border-green-200 bg-green-50' : '' }}">
                            
                            <div class="mb-2 sm:mb-0">
                                <h4 class="font-bold text-gray-700">{{ $label }}</h4>
                                @if(isset($uploads[$key]))
                                    <span class="text-xs text-green-600 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Sudah diupload
                                    </span>
                                @else
                                    <span class="text-xs text-red-400 italic">Belum ada file</span>
                                @endif
                            </div>

                            <div class="flex-shrink-0">
                                @if(isset($uploads[$key]))
                                    {{-- STATE: UPLOADED --}}
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ asset('storage/' . $uploads[$key]) }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">
                                            Lihat File
                                        </a>
                                        
                                        @if(!$is_submitted)
                                            <form action="{{ route('dokumen.destroy', $key) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:text-red-700" onclick="return confirm('Hapus file ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    {{-- STATE: EMPTY (Auto Upload) --}}
                                    @if(!$is_submitted)
                                        <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center w-full">
                                            @csrf
                                            <input type="hidden" name="jenis_dokumen" value="{{ $key }}">
                                            
                                            {{-- 
                                                UPDATED INPUT:
                                                1. Removed Button
                                                2. Added onchange="this.form.submit()"
                                                3. Added cursor-pointer
                                            --}}
                                            <input 
                                                type="file" 
                                                name="file" 
                                                onchange="this.form.submit()"
                                                class="block w-full text-xs text-gray-500
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-full file:border-0
                                                    file:text-xs file:font-semibold
                                                    file:bg-blue-50 file:text-blue-700
                                                    hover:file:bg-blue-100 cursor-pointer" 
                                                required
                                            >
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">Terkunci</span>
                                    @endif
                                @endif
                            </div>

                        </li>
                    @endforeach
                </ul>

                <div class="mt-8 pt-6 border-t border-gray-100 text-right">
                    @if($is_submitted)
                        <div class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded font-bold">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Berkas Sedang Diverifikasi Admin
                            </span>
                        </div>
                    @elseif($uploaded_count >= 5)
                        <form action="{{ route('dokumen.submit') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white font-bold py-3 px-8 rounded shadow hover:bg-green-700 transition" onclick="return confirm('Kirim semua berkas ke admin? Data tidak bisa diubah lagi.')">
                                ✅ SUBMIT SEMUA BERKAS
                            </button>
                        </form>
                    @else
                        <button disabled class="bg-gray-300 text-gray-500 font-bold py-3 px-8 rounded cursor-not-allowed">
                            Lengkapi 5 Dokumen untuk Submit
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>