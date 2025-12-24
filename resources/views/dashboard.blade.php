<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @php
                        $pendaftar = \App\Models\Pendaftar::where('user_id', Auth::id())->first();
                    @endphp

                    @if($pendaftar)
                        <div class="border-l-4 border-indigo-500 pl-4 mb-6">
                            <h3 class="text-lg font-bold text-indigo-700">Status: {{ ucfirst($pendaftar->status_seleksi) }}</h3>
                            <p class="mt-2">Registration Number: <strong class="text-black">{{ $pendaftar->nomor_pendaftaran }}</strong></p>
                            <p>Chosen Major: {{ $pendaftar->prodi->nama_prodi }}</p>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="font-bold mb-2">Next Step:</h4>
                            <a href="{{ route('dokumen.upload') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Manage Documents (Upload)
                            </a>
                        </div>
                    @else
                        <h3 class="text-lg font-medium">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="mb-6 text-gray-600">You have not registered for the new academic year yet.</p>
                        
                        <a href="{{ route('pendaftaran.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Register Now
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>