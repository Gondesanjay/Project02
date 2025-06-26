<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Jadwal Ujian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    {{-- Judul dan Status --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $ujian->nama_ujian }}</h3>
                            <p class="text-lg text-gray-600 dark:text-gray-400">{{ optional($ujian->mataPelajaran)->nama_mapel }}</p>
                        </div>
                        @if($ujian->is_selesai)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-800">Selesai</span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Akan Datang</span>
                        @endif
                    </div>

                    {{-- Detail dalam bentuk daftar --}}
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal & Waktu</dt>
                            <dd class="mt-1 text-md text-gray-900 dark:text-gray-100">{{ $ujian->tanggal_ujian->format('l, d F Y - H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi / Ruang</dt>
                            <dd class="mt-1 text-md text-gray-900 dark:text-gray-100">{{ $ujian->lokasi ?? 'Belum diatur' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan Tambahan</dt>
                            <dd class="mt-1 prose dark:prose-invert max-w-none">
                                {!! $ujian->catatan ?? '<p class="text-gray-500">Tidak ada catatan.</p>' !!}
                            </dd>
                        </div>
                    </div>

                    {{-- Tombol Aksi di Bawah --}}
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6 flex items-center gap-4">
                        <a href="{{ route('ujian.edit', $ujian) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600">
                            Edit Jadwal Ini
                        </a>
                        <a href="{{ route('ujian.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                            Kembali ke Daftar
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>