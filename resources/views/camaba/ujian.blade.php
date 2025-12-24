<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ujian Seleksi Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4">
                    <p class="font-bold text-blue-700">Petunjuk:</p>
                    <p class="text-sm text-blue-600">Jawablah pertanyaan berikut dengan benar. Nilai akan otomatis dikirim ke Admin sebagai pertimbangan kelulusan.</p>
                </div>

                <form action="{{ route('ujian.submit') }}" method="POST">
                    @csrf
                    
                    {{-- Q1 --}}
                    <div class="mb-6">
                        <p class="font-bold mb-2">1. Apa kepanjangan dari HTML?</p>
                        <label class="block"><input type="radio" name="q1" value="a" class="mr-2"> Hyper Text Markup Language</label>
                        <label class="block"><input type="radio" name="q1" value="b" class="mr-2"> High Tech Modern Language</label>
                    </div>

                    {{-- Q2 --}}
                    <div class="mb-6">
                        <p class="font-bold mb-2">2. Bahasa pemrograman server-side adalah...</p>
                        <label class="block"><input type="radio" name="q2" value="a" class="mr-2"> CSS</label>
                        <label class="block"><input type="radio" name="q2" value="b" class="mr-2"> HTML</label>
                        <label class="block"><input type="radio" name="q2" value="c" class="mr-2"> PHP</label>
                    </div>

                    {{-- Q3 --}}
                    <div class="mb-6">
                        <p class="font-bold mb-2">3. Tag untuk membuat baris baru di HTML?</p>
                        <label class="block"><input type="radio" name="q3" value="a" class="mr-2"> &lt;lb&gt;</label>
                        <label class="block"><input type="radio" name="q3" value="b" class="mr-2"> &lt;br&gt;</label>
                    </div>

                    {{-- Q4 --}}
                    <div class="mb-6">
                        <p class="font-bold mb-2">4. CSS digunakan untuk...</p>
                        <label class="block"><input type="radio" name="q4" value="a" class="mr-2"> Struktur Data</label>
                        <label class="block"><input type="radio" name="q4" value="d" class="mr-2"> Styling Halaman</label>
                    </div>

                    {{-- Q5 --}}
                    <div class="mb-6">
                        <p class="font-bold mb-2">5. Laravel adalah framework dari bahasa...</p>
                        <label class="block"><input type="radio" name="q5" value="a" class="mr-2"> PHP</label>
                        <label class="block"><input type="radio" name="q5" value="b" class="mr-2"> Python</label>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Kirim Jawaban
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>