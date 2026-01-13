<x-app-layout>
    {{-- ALPINE.JS ROOT STATE FOR MODAL --}}
    <div x-data="{ showModal: false, modalImageUrl: '' }">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - PMB Online') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Data Pendaftar Masuk</h3>
                        <span class="text-sm text-gray-500">Total: {{ $pendaftars->count() }} Peserta</span>
                    </div>

                    {{-- ============================================= --}}
                    {{-- SEARCH & FILTER TOOLBAR --}}
                    {{-- ============================================= --}}
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            
                            {{-- 1. Search Bar --}}
                            <div class="md:col-span-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                           placeholder="Cari Nama / Sekolah / No. HP... (Enter)">
                                </div>
                            </div>

                            {{-- 2. Filter Prodi --}}
                            <div class="md:col-span-3">
                                <select name="filter_prodi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                    <option value="">-- Semua Prodi --</option>
                                    @foreach($prodis as $prodi)
                                        <option value="{{ $prodi->id }}" {{ request('filter_prodi') == $prodi->id ? 'selected' : '' }}>
                                            {{ $prodi->nama_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 3. Filter Status --}}
                            <div class="md:col-span-2">
                                <select name="filter_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                    <option value="">-- Semua Status --</option>
                                    <option value="pending" {{ request('filter_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="lolos" {{ request('filter_status') == 'lolos' ? 'selected' : '' }}>Diterima</option>
                                    <option value="tidak_lolos" {{ request('filter_status') == 'tidak_lolos' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            {{-- 4. Sort --}}
                            <div class="md:col-span-2">
                                <select name="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                    <option value="sekolah_asc" {{ request('sort') == 'sekolah_asc' ? 'selected' : '' }}>Sekolah (A-Z)</option>
                                </select>
                            </div>

                            {{-- 5. Reset Button (UPDATED) --}}
                            <div class="md:col-span-1">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="w-full bg-gray-500 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition text-center items-center h-full">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    {{-- ============================================= --}}


                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto" id="table-container">
                        @include('admin.pendaftar_table')
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            setInterval(function () {
                                fetch("{{ route('admin.dashboard', request()->query()) }}", {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    if(html.trim()) {
                                        let container = document.getElementById('table-container');
                                        container.innerHTML = html;
                                        // Re-initialize Alpine.js for the new content if available
                                        if (typeof Alpine !== 'undefined') {
                                            Alpine.initTree(container);
                                        }
                                    }
                                })
                                .catch(error => console.error('Error refreshing table:', error));
                            }, 5000); // Poll every 5 seconds
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- FULL SCREEN IMAGE MODAL --}}
    {{-- ========================================== --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4" style="display: none;" x-transition.opacity x-cloak>
        <button @click="showModal = false" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none z-50">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="absolute inset-0" @click="showModal = false"></div>
        <div class="relative z-10 max-w-4xl max-h-full">
             <img :src="modalImageUrl" class="max-w-full max-h-[90vh] object-contain mx-auto rounded shadow-2xl" alt="Document Fullscreen Preview">
        </div>
    </div>

    </div> {{-- END ALPINE ROOT --}}
</x-app-layout>