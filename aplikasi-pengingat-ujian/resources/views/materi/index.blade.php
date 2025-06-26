<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Materi Pembelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ===== FORM PENCARIAN BARU ===== -->
            <div class="mb-6">
                <form action="{{ route('materi.index') }}" method="GET">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari nama mata pelajaran..." value="{{ request('search') }}" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Cari</button>
                    </div>
                </form>
            </div>
            <!-- ===== AKHIR FORM PENCARIAN ===== -->

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Daftar Materi per Mata Pelajaran</h3>
                    <div class="space-y-4">
                        @forelse ($mataPelajarans as $mapel)
                        <div class="border dark:border-gray-700 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg">{{ $mapel->nama_mapel }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $mapel->nama_dosen }}</p>
                            </div>
                            <div>
                                @if ($mapel->materi_path)
                                <a href="{{ Storage::url($mapel->materi_path) }}"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    Download Materi
                                </a>
                                @else
                                <span class="px-4 py-2 text-xs text-gray-400">Materi belum tersedia</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada materi yang cocok dengan pencarian Anda.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>