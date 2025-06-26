<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('ujian.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                + Tambah Ujian
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ===== PERBAIKAN: BLOK PESAN SUKSES LAMA DIHAPUS ===== --}}
            {{-- SEKARANG DIGANTIKAN DENGAN EVENT DISPATCHER DI BAWAH INI --}}
            {{-- Ini akan "memberi tahu" komponen toast untuk muncul --}}
            @if (session('success'))
            <div x-data x-init="$dispatch('notify', { message: '{{ session('success') }}', type: 'success' })"></div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Ujian Anda Berikutnya:</h3>

                    @if ($ujianSelanjutnya)
                    <div class="border-l-4 p-4 border-blue-500 bg-blue-50 dark:bg-gray-900/50 rounded-r-lg">
                        <p class="font-bold text-xl">{{ $ujianSelanjutnya->nama_ujian }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ optional($ujianSelanjutnya->mataPelajaran)->nama_mapel ?? 'Mata Pelajaran Umum' }}
                        </p>

                        @if ($ujianSelanjutnya->lokasi)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            {{ $ujianSelanjutnya->lokasi }}
                        </p>
                        @endif

                        <p class="text-sm mt-2">
                            <span class="font-semibold">{{ $ujianSelanjutnya->tanggal_ujian->format('l, d F Y \p\u\k\u\l H:i') }}</span>
                            <span class="block text-blue-600 dark:text-blue-400 text-xs mt-1">({{ $ujianSelanjutnya->tanggal_ujian->diffForHumans() }})</span>
                        </p>
                    </div>
                    @else
                    <div class="text-center p-6 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                        <p>Tidak ada jadwal ujian yang akan datang. Selamat beristirahat!</p>
                    </div>
                    @endif

                    <div class="mt-8 border-t dark:border-gray-700 pt-6">
                        <p class="text-gray-600 dark:text-gray-400">Total ujian yang telah selesai:</p>
                        <p class="font-bold text-3xl">{{ $totalUjianSelesai }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== KOMPONEN TOAST NOTIFIKASI BARU ===== --}}
    <!-- Toast akan muncul di pojok kanan bawah, diatur oleh Alpine.js -->
    <div
        x-data="{ show: false, message: '', type: '' }"
        x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800"
        role="alert"
        style="display: none;">
        <div x-show="type === 'success'" class="text-green-500">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
        </div>
        {{-- Anda bisa menambahkan x-show untuk tipe 'error' dengan ikon berbeda di sini --}}
        <div class="ps-4 text-sm font-normal" x-text="message"></div>
    </div>

</x-app-layout>