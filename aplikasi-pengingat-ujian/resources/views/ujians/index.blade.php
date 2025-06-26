<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Jadwal Ujian Saya') }}
            </h2>
            <a href="{{ route('ujian.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                + Tambah Ujian Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Sukses --}}
            @if(session('success'))
            <div x-data x-init="$dispatch('notify', { message: '{{ session('success') }}', type: 'success' })"></div>
            @endif

            {{-- Navigasi Filter --}}
            <div class="mb-4">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <a href="{{ route('ujian.index') }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ !request('filter') ? 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Semua
                        </a>
                        <a href="{{ route('ujian.index', ['filter' => 'akan-datang']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('filter') == 'akan-datang' ? 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Akan Datang
                        </a>
                        <a href="{{ route('ujian.index', ['filter' => 'selesai']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('filter') == 'selesai' ? 'border-indigo-500 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Selesai
                        </a>
                    </nav>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Daftar Ujian Anda</h3>
                    <div class="space-y-4">
                        @forelse ($ujians as $ujian)
                        <div class="border-l-4 p-4 rounded-r-lg {{ $ujian->is_selesai ? 'border-gray-500 bg-gray-100 dark:bg-gray-700' : 'border-blue-500 bg-blue-50 dark:bg-gray-900/50' }}">
                            <div class="flex justify-between items-center">
                                {{-- Bagian Kiri: Detail Ujian --}}
                                <div>
                                    <p class="font-bold text-lg">{{ $ujian->nama_ujian }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ optional($ujian->mataPelajaran)->nama_mapel ?? 'Mata Pelajaran Telah Dihapus' }}
                                    </p>
                                    @if($ujian->lokasi)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block -mt-1 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold">Lokasi:</span> {{ $ujian->lokasi }}
                                    </p>
                                    @endif
                                    <p class="text-sm mt-1">
                                        <span class="font-semibold">{{ $ujian->tanggal_ujian->format('l, d F Y \p\u\k\u\l H:i') }}</span>
                                        @if(!$ujian->is_selesai)
                                        <span class="text-blue-600 dark:text-blue-400">({{ $ujian->tanggal_ujian->diffForHumans() }})</span>
                                        @endif
                                    </p>
                                </div>

                                {{-- Bagian Kanan: Status dan Tombol Aksi --}}
                                <div class="flex items-center space-x-4">
                                    {{-- --- INI BLOK AKSI YANG SUDAH DIRAPIKAN --- --}}
                                    <a href="{{ route('ujian.show', $ujian) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Detail</a>

                                    @if(!$ujian->is_selesai)
                                    <form method="POST" action="{{ route('ujian.selesai', $ujian) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm text-green-600 dark:text-green-400 hover:underline">✓ Tandai Selesai</button>
                                    </form>
                                    @endif

                                    <a href="{{ route('ujian.edit', $ujian) }}" class="text-sm text-yellow-600 dark:text-yellow-400 hover:underline">Edit</a>

                                    <form method="POST" action="{{ route('ujian.destroy', $ujian) }}" onsubmit="return confirm('Anda yakin ingin menghapus ujian ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada data ujian yang cocok dengan filter ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>