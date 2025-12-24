<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran Mahasiswa Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('pendaftaran.store') }}" method="POST">
                        @csrf

                        <h3 class="text-lg font-bold mb-4 border-b pb-2">A. Data Pribadi</h3>
                        
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Nama Lengkap (Sesuai Ijazah)</label>
                            <input type="text" name="nama" value="{{ old('nama', $pendaftar->nama ?? Auth::user()->name) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftar->tempat_lahir ?? '') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pendaftar->tanggal_lahir ?? '') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Alamat Lengkap</label>
                            <textarea name="alamat" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" rows="3" required>{{ old('alamat', $pendaftar->alamat ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Nomor Telepon / WA</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $pendaftar->telepon ?? '') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>

                        <h3 class="text-lg font-bold mb-4 border-b pb-2 mt-8">B. Data Orang Tua</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nama Ayah Kandung</label>
                                <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $pendaftar->nama_ayah ?? '') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nama Ibu Kandung</label>
                                <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $pendaftar->nama_ibu ?? '') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold mb-4 border-b pb-2 mt-8">C. Data Sekolah & Pilihan Prodi</h3>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $pendaftar->asal_sekolah ?? '') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>

                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700">Pilihan Program Studi</label>
                            <select name="prodi_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                                <option value="">-- Pilih Prodi --</option>
                                @foreach(\App\Models\Prodi::all() as $prodi)
                                    <option value="{{ $prodi->id }}" {{ (isset($pendaftar) && $pendaftar->prodi_id == $prodi->id) ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                                SIMPAN & LANJUT UPLOAD &rarr;
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>